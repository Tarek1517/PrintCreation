<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $data = array();
        $data['totalSale'] =  Order::sum('grand_total');
        $data['totalSaleToday'] = Order::whereDate('created_at', Carbon::today())->sum('grand_total');
        $data['totalProducts'] = Product::count();
        $data['totalCustomer'] = User::count();
        $data['pendingOrder'] = Order::where('order_status', 'pending')->count(); 
        $data['cancelOrder'] = Order::where('order_status', 'cancel')->count(); 
            $data['recentOrder'] = Order::query()->with('customer')->latest()->take(10)->get();
        // $data['topProducts'] = OrderDetail::select('products.*', DB::raw('SUM(order_details.quantity) as total_quantity'))
        //                         ->join('products', 'order_details.product_id', '=', 'products.id')
        //                         ->groupBy('products.id')
        //                         ->orderBy('total_quantity', 'desc')
        //                         ->take(10) 
        //                         ->get();

        // $saleData = Order::select(
        //         DB::raw('MONTH(created_at) as month'),
        //         DB::raw('SUM(grand_total) as total_sales')
        //     )
        //     ->groupBy('month')
        //     ->orderBy('month')
        //     ->get()
        //     ->mapWithKeys(function ($item) {
        //         return [$item->month => $item->total_sales];
        //     });
        //     $salesArray = array_fill(1, 12, 0);
        //     foreach ($saleData as $month => $totalSales) {
        //         $salesArray[$month] = $totalSales;
        //     }
        //     $salesArray = array_values($salesArray);

                return response()->json([
                    // 'saleData' => $salesArray,
                    'data' => $data
                ]);
    }
}