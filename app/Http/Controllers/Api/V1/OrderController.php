<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\InquiryRequest;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Resources\V1\Order\OrderListResource;
use App\Http\Resources\V1\Order\OrderShowResource;
use App\Http\Requests\V1\OrderStoreRequest;
use App\Models\OrderDetail;
use App\Models\CustomerAddress;
use App\Models\OrderRequest;
use App\Models\ProductStock;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Stripe\Stripe;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::query()
            ->with(['orderDetails', 'orderDetails.product', 'customer'])
            ->latest()
            ->paginate(40);
        return OrderListResource::collection($orders);
    }

    public function customerOrder(Request $request)
    {
        $orders = Order::query()->where('user_id', $request->user_id)->with('orderDetails','orderDetails.product')->get();

        return OrderListResource::collection($orders);
    }

    public function showCustomerOrder($id)
    {
        $order =  Order::where('id', $id)->with('customer', 'orderDetails', 'orderDetails.product', 'orderDetails.stock', 'address', 'address.area')->first();

        return OrderShowResource::make($order);
    }

   
    public function store(OrderStoreRequest $request)
	{
		$data = $request->validated();
		Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

		try {
			$lineItems = [];
			foreach ($data['order_items'] as $item) {
				$lineItems[] = [
					'price_data' => [
						'currency' => $data['currency'] ?? 'usd', 
						'unit_amount' => $item['product']['price'] * 100, 
						'product_data' => [
							'name' => $item['product']['title'],
						],
					],
					'quantity' => $item['selectSku']['selectQty'], // Use the requested quantity
				];
			}
			$session = \Stripe\Checkout\Session::create([
				'line_items' => $lineItems,
				'mode' => 'payment',
				'success_url' => env('FRONTEND_URL') . '/order-success?session_id={CHECKOUT_SESSION_ID}',
				'cancel_url' => env('FRONTEND_URL') . '/order-cancel?session_id={CHECKOUT_SESSION_ID}',
			]);
		}catch (\Exception $e) {
			return response()->json(['error' => 'Stripe error: ' . $e->getMessage()], 500);
		}
		DB::beginTransaction();
		try {
			// Save address
			$address = CustomerAddress::create([
				'shipping_area_id' => $data['shipping_area_id'],
				'user_id' => $data['user_id'],
				'country' => $data['country'],
				'city' => $data['city'],
				'address' => $data['address'],
			]);

			// Create order
			$data['address_id'] = $address->id;
			$data['grand_total'] = $data['sub_total'] + ($data['delivery_charge'] ?? 0);
			$data['payment_status'] = 'paid';
			$data['order_date'] = Carbon::now();
			$data['order_code'] = '#' . strtoupper(uniqid());
			$order = Order::create($data);

			// Save order details and update stocks
			$orderDetails = [];
			
			$stockIds = array_column($data['order_items'], 'selectSku.id');
			if($stockIds){
				$stocks = ProductStock::whereIn('id', $stockIds)->get()->keyBy('id');
			}
			
			foreach ($data['order_items'] as $item) {
				$orderDetails[] = [
					'order_id' => $order->id,
					'product_id' => $item['product']['id'],
					'quantity' => $item['selectSku']['selectQty'],
					'attachment' => json_encode($item['attachments']),
					'product_stock_id' => $item['selectSku']['id'] ?? null,
				];
				if($stockIds){
					if (isset($stocks[$item['selectSku']['id']])) {
						$stock = $stocks[$item['selectSku']['id']];
						if ($stock->stock < $item['selectSku']['selectQty']) {
							throw new \Exception('Insufficient stock for product ' . $item['product']['id']);
						}
						$stock->stock -= $item['selectSku']['selectQty'];
						$stock->save();
					}
				}
			}
			OrderDetail::insert($orderDetails);
			DB::commit();
			return response()->json([
				'id' => $session->id,
				'url' => $session->url,
			]);
		} catch (\Exception $e) {
			DB::rollBack();
			return response()->json(['error' => 'Order creation failed: ' . $e->getMessage()], 500);
		}
	}


    public function show(string $id)
    {
        $order = Order::query()->where('id', $id)->with('orderDetails', 'orderDetails.product', 'orderDetails.stock', 'address', 'address.area', 'customer')->first();

        return OrderShowResource::make($order);
    }


    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        if($request->order_status !== null){
            $order->update([
                'order_status' => $request->order_status
            ]);
        }
        if($request->payment_status !== null){
            $order->update([
                'payment_status' => $request->payment_status
            ]);
        }
        
        return Response::HTTP_OK;
    }

    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        if($order){
            $order->orderDetails()->delete();
            $order->delete();
            return Response::HTTP_OK;
        }
    }

    public function saveOrderRequest(InquiryRequest $request) 
    {
        OrderRequest::query()->create($request->validated());

        return Response::HTTP_OK;
    }

    public function allRequest(): JsonResponse
    {
        $request = OrderRequest::query()->latest()->get();

        return response()->json($request);
    }

    public function deleteRequest($id)
    {
        $request = OrderRequest::findOrFail($id);
        $request->delete();

        return Response::HTTP_OK;
    }
}