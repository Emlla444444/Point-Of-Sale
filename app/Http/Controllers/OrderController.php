<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\PaymentHistory;
use App\Models\Order;

class OrderController extends Controller
{
    //order list
    public function list() {
        $orderList = Order::when(request('searchKey'),function($query){
                                $query->where('orders.order_code','like','%'.request('searchKey').'%');
                            }) //use query to work duet outside of the function
                            ->select('orders.status','orders.order_code','orders.created_at','orders.user_id','users.name as customer_name')
                            ->leftJoin('users','orders.user_id','users.id')
                            ->groupBy('orders.order_code')
                            ->orderBy('created_at','desc')
                            ->paginate(5);
        return view('admin.order.list',compact('orderList'));
    }

    //order detail
    public function detail($order_code) {
        $CustomerData = Order::select('orders.order_code','orders.created_at','orders.total_price','users.name','users.phone','users.address')
                        ->leftJoin('users','orders.user_id','users.id')
                        ->where('orders.order_code',$order_code)
                        ->get();

        $totalPrice = 5000;
        foreach($CustomerData as $price)
        {
            $totalPrice += $price['total_price'];
        }

        $paymentData = PaymentHistory::select('payment_histories.phone','payment_histories.created_at','payments.account_type','payment_histories.payslip_image')
                                        ->leftJoin('payments','payment_histories.payment_method','payments.id')
                                        ->where('payment_histories.order_code',$order_code)
                                        ->first();

        $productData = Product::select('products.name','products.image','products.stock','products.price','orders.count','orders.total_price','products.id','orders.count','orders.status')
                                ->leftJoin('orders','products.id','orders.product_id')
                                ->where('orders.order_code',$order_code)
                                ->get();

        $productStock = true;
        foreach($productData as $item){
            if($item->count > $item->stock){
                $productStock = false;
            }
        }

        return view('admin.order.detail',compact('CustomerData','totalPrice','paymentData','productData','productStock'));
    }

    //order reject
    public function reject(Request $request) {
        Order::where('order_code',$request['order-code'])
                ->update([
                    'status' => 'rejected'
                ]);
        return response()->json([
            'status' => 200 ,
            'message' => 'order rejected'
        ]);
    }

    //order accept
    public function accept(Request $request){
        Order::where('order_code',$request['orderCode'])
                ->update([
                    'status' => 'accepted'
                ]);

        foreach($request['orderInfo'] as $item){
            Product::where('id',$item['productId'])->decrement('stock',$item['orderCount']);
        }

        return response()->json([
            'status' => 200 ,
            'message' => 'order accepted'
        ]);
    }

    //order only list (accept & pending)
    public function orderList(){
        $orders = Order::when(request('searchKey'),function($query){
                            $query->where('orders.order_code','like','%'.request('searchKey').'%');
                        }) //use query to work duet outside of the function
                        ->leftJoin('users','orders.user_id','users.id')
                        ->whereIn('orders.status',['accepted','pending'])
                        ->groupBy('orders.order_code')
                        ->orderBy('orders.created_at','desc')
                        ->paginate(5);
        return view('admin.order.orderOnlyList',compact('orders'));
    }

    //order reject list
    public function rejectList(){
        $orders = Order::when(request('searchKey'),function($query){
                            $query->where('orders.order_code','like','%'.request('searchKey').'%');
                        }) //use query to work duet outside of the function
                        ->leftJoin('users','orders.user_id','users.id')
                        ->where('orders.status','rejected')
                        ->groupBy('orders.order_code')
                        ->orderBy('orders.created_at','desc')
                        ->paginate(5);
        return view('admin.order.rejectOnlyList',compact('orders'));
    }

    //sale information
    public function saleInfo() {
        $sales = Order::when(request('searchKey'),function($query){
                            $query->where('order_code','like','%'.request('searchKey').'%');
                        }) //use query to work duet outside of the function
                        ->select('created_at','total_price','order_code')
                        ->where('status','accepted')
                        ->orderBy('created_at','desc')
                        ->get();

        $total = 0;
        foreach ($sales as $item) {
            $total += $item['total_price'];
        }

        return view('admin.sale.saleInfo',compact('sales','total'));
    }
}
