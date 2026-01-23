<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use App\Models\Order;
use Illuminate\Support\Facades\Session;
use App\Models\Payment;
use App\Models\Cart;
use App\Models\Rating;
use App\Models\Comment;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;

class UserController extends Controller
{
    //user page
    public function userHome() {
        $products = Product::select('products.id','products.name','products.image','products.price','products.description','products.created_at','categories.name as category_name')
                    ->leftJoin('categories','products.category_id','categories.id')
                    //gather the category gp as their id
                    ->when(request('categoryId'),function($query){
                        $categoryId = request('categoryId');
                        $query->where('products.category_id',$categoryId);
                    })
                    //when for search bar
                    ->when(request('searchKey'),function($query){
                        $key = request('searchKey');
                        $query->where('products.name','like','%'.$key.'%');
                    })
                    //when for min|max price
                    ->when(request('minPrice')||request('maxPrice'),function($query){
                        if(request('minPrice')){
                            $minPrice = request('minPrice');
                            $query->where('products.price','>=',$minPrice);
                        } elseif(request('maxPrice')){
                            $maxPrice = request('maxPrice');
                            $query->where('products.price','<=',$maxPrice);
                        }
                    })
                    //when for sorting
                    ->when(request('sortingType'),function($query){
                        $types = request('sortingType');
                        switch($types){
                            case 'nameAsc': $query->orderBy('products.name','asc'); break;
                            case 'nameDesc': $query->orderBy('products.name','desc'); break;
                            case 'priceAsc': $query->orderBy('products.price','asc'); break;
                            case 'priceDesc': $query->orderBy('products.price','desc'); break;
                            case 'timeAsc': $query->orderBy('products.created_at','asc'); break;
                            case 'timeDesc': $query->orderBy('products.created_at','desc'); break;
                        }
                    })
                    ->orderBy('products.created_at','desc')
                    ->get();
        $categories = Category::select('id','name')->get();

        return view('user.dashboard.home',compact('products','categories'));
    }

    //profile page
    public function profilePage() {
        return view('user.profile.editProfile');
    }

    //profile update
    public function profileUpdate(Request $request,$id) {
        $this->profileValidation($request);
        $data = $this->profileData($request);
        if($request->hasFile('image')) {
            if(file_exists(public_path('userProfile/'.auth()->user()->profile))) {
                unlink(public_path('userProfile/'.auth()->user()->profile));
            }
            $newImage = uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $request->image->move(public_path('userProfile/'),$newImage); // at pj
            $data['profile'] = $newImage; // at db
        }
        User::where('id',$id)->update($data);
        return back()->with(['success'=>'profile updated']);
    }

    //validation check
    private function profileValidation($request) {
        $request->validate([
            'name' => 'required' ,
            'email' => 'required|email|unique:users,email,'.$request->id ,
            'phone' => 'required|min:11' ,
            'address' => 'required' ,
        ]);
    }

    //profile data
    private function profileData($request) {
        return [
            'name' => $request->name ,
            'email' => $request->email ,
            'phone' => $request->phone ,
            'address' => $request->address ,
        ];
    }

    //password page
    public function passwordPage() {
        return view('user.profile.changePassword');
    }

    //password change validation
    private function passwordChangeValidate($request) {
        $request->validate([
        'oldPassword' => 'required' ,
        'newPassword' => 'required|min:8|max:16' ,
        'confirmPassword' => 'required|same:newPassword' ,
        ]);
    }

    //change password
    public function passwordChange(Request $request) {
        $this->passwordChangeValidate($request);
        $oldPassword = auth()->user()->password;
        $passwordStatus = Hash::check($request->oldPassword, $oldPassword);
        if($passwordStatus) {
            User::where('id',auth()->user()->id)->update([
                'password' => Hash::make($request->newPassword)
            ]);
            return back()->with(['success'=>'password changed']);
        }
        return back()->with(['fail'=>'failed change']);
    }

    //product detail page
    public function productDetail($id) {
        $product = Product::select('products.*','categories.name as category_name')
                            ->leftJoin('categories','products.category_id','categories.id')
                            ->where('products.id',$id)
                            ->first();

        $comments = Comment::select('comments.*','users.profile','users.name','comments.id as comment_id')
                             ->leftJoin('users','comments.user_id','users.id')
                             ->where('comments.product_id',$id)
                             ->orderBy('created_at','desc')
                             ->get();

        $rating = Rating::where('product_id',$id)
                          ->where('user_id',auth()->user()->id)
                          ->value('count');

        $avgRating = ceil(Rating::where('product_id',$id)->avg('count'));

        return view('user.product.productDetail',compact('product','comments','rating','avgRating'));
    }

    //comment
    public function comment(Request $request) {
        Comment::create([
            'user_id' => auth()->user()->id ,
            'product_id' => $request->productId ,
            'message' => $request->comment
        ]);
        return back();
    }

    //comment delete
    public function delete($id) {
        Comment::where('id',$id)->delete();
        return back();
    }

    //rating
    public function rating(Request $request) {
        Rating::UpdateOrCreate([
            'user_id' => auth()->user()->id ,
            'product_id' => $request->productId ,
        ],[
            'count' => $request->productRating
        ]);
        return back();
    }

    //cart page
    public function cartPage() {
        $cartItems = Cart::select('carts.user_id','carts.product_id','carts.quantity','carts.id as cart_id','products.name',      'products.price','products.image')
                           ->leftJoin('products','carts.product_id','products.id')
                           ->where('carts.user_id',auth()->user()->id)
                           ->get();
        return view('user.cart.list',compact('cartItems'));
    }

    //add cart
    public function addCart(Request $request) {
        Cart::create([
            'user_id' => $request->userId ,
            'product_id' => $request->productId ,
            'quantity' => $request->count
        ]);
        return back()->with(['success'=>'added']);
    }

    //delete cart
    public function deleteCart($id) {
        Cart::where('id',$id)->delete();
        return back();
    }

    //payment page
    public function paymentPage() {
        $payments = Payment::get();
        $orders = Session::get('tempCard');
        $total = 5000; // 5000 is deli fee
        foreach($orders as $item) {
            $total += $item['total_price'];
        }
        $orderCode = $orders[0]['order_code'];
        return view('user.payment.payment',compact('payments','orderCode','total'));
    }

    //temp cart
    public function tempCart(Request $request) {
        Session::put('tempCard',$request->all());
        return response()->json([
            'status' => 200 ,
            'message' => 'data received'
        ]);
    }

    //payment
    public function payment(Request $request) {
        $request->validate([
            'name' => 'required' ,
            'phone' => 'required|min:11' ,
            'address' => 'required' ,
            'paymentType' => 'required' ,
            'payslipImage' => 'required' ,
        ]);

        $order = Session::get('tempCard');
        $total = 5000; // 5000 is deli fee
        foreach($order as $item) {
            Order::create($item);
            $total += $item['total_price'];
        }

        $imgName = uniqid() . '_' . $request->file('payslipImage')->getClientOriginalName();
        $request->payslipImage->move(public_path('payslipImage/'),$imgName);

        PaymentHistory::create([
            'user_id' => auth()->user()->id ,
            'phone' => $request->phone ,
            'address' => $request->address ,
            'payslip_image' => $imgName ,
            'payment_method' => $request->paymentType ,
            'order_code' => $order[0]['order_code'] ,
            'total_amount' => $total
        ]);

        Cart::where('user_id',auth()->user()->id)->delete();

        return back()->with(['success'=>'ordered!']);

    }

    //order list page
    public function orderListPage() {
        $orderList = Order::select('order_code','status','created_at')
                            ->where('user_id',auth()->user()->id)
                            ->groupBy('order_code')
                            ->orderBy('created_at','desc')
                            ->get();
        return view('user.order.list',compact('orderList'));
    }
}
