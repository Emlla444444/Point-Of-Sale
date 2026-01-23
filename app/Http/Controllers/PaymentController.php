<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    //payment list
    public function list() {
        $payments = Payment::when(request('searchKey'),function($query){
            $query->where('account_name','like','%'.request('searchKey').'%');
        }) //use query to work duet outside of the function
        ->orderBy('created_at','desc')
        ->paginate(5);
        $paymentCount = count($payments->toArray());
        return view('admin.payment.list',compact('payments','paymentCount'));
    }

    //pay
    public function pay(Request $request) {
        $this->paymentValidation($request);
        Payment::create([
            'account_name' => $request->accountName ,
            'account_number' => $request->accountNumber ,
            'account_type' => $request->accountType
        ]);
        return back()->with(['success'=>'payment added']);
    }

    //delete payment
    public function delete($id) {
        Payment::destroy($id);
        return back();
    }

    //edit payment
    public function edit($id) {
        $payment = Payment::find($id);
        return view('admin.payment.edit',compact('payment'));
    }

    //update payment
    public function update($id,Request $request) {
        $this->paymentValidation($request);
        Payment::where('id',$id)->update([
            'account_name' => $request->accountName ,
            'account_number' => $request->accountNumber ,
            'account_type' => $request->accountType
        ]);
        return back()->with(['success'=>'updated']);
    }

    //validation check
    private function paymentValidation($request) {
        $data = [
            'accountName' => 'required|min:2|max:30|unique:payments,account_name,'.$request->id ,
            'accountNumber' => 'required|integer|min:11|unique:payments,account_number,' . $request->id ,
            'accountType' => 'required|min:3|max:20'
        ];
        $request->validate($data);
    }
}
