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
        
        if(isset($data['address_id'])){
            $address = CustomerAddress::where('id', $data['address_id'])->with('area')->first();
            $grandTotal = $data['grand_total'] + $address->area->delevery_charge;
            $data['grand_total'] = $grandTotal;
        }

        if(isset($data['delivery_charge'])){
            $data['grand_total'] = $data['sub_total'] + $data['delivery_charge'];
        }

        $data['order_date'] = Carbon::now();
        $data['order_id'] = '#'.rand(100000000000, 999999999999);
        $order = Order::create($data);
        $orderDetails = [];
        
        foreach($data['order_items'] as $item)
        {
            $orderDetails[] = [
                'order_id' => $order->id,
                'product_id' => $item['product']['id'],
                'quantity' => $item['selectSku']['selectQty'],
                'product_stock_id' => isset($item["selectSku"]["id"]) ?  $item["selectSku"]["id"] : NULL,
            ];

            if(isset($item["selectSku"]["id"])){
                $stock = ProductStock::where('id', $item["selectSku"]["id"])->first();
                $stock->stock = $stock->stock - $item["selectSku"]["selectQty"];
                $stock->save();
            }
        }

        OrderDetail::insert($orderDetails);

        return OrderShowResource::make($order );
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