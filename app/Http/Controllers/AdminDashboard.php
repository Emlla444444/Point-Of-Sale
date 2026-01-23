<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\PaymentHistory;
use App\Models\Payment;
use App\Models\User;
use App\Models\Order;

class AdminDashboard extends Controller
{
    //admin dashboard direction
    public function dashboard() {
        $orders = Order::whereIn('status',['pending','accepted'])
                        ->count();
        $rejections = Order::where('status','rejected')->count();
        $users = User::where('role','user')->count();
        $admins = User::whereIn('role',['admin','superadmin'])->count();
        $totalSell = Order::where('status','accepted')->sum('total_price');
        $contacts = Contact::count('id');
        $totalRecieve = PaymentHistory::sum('total_amount');
        $gapAmount = $totalRecieve - $totalSell;
        return view('admin.dashboard.home',compact('orders','rejections','users','totalSell','contacts','admins','totalRecieve','gapAmount'));
    }
}
