<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminProfileController extends Controller
{
    //profile detail
    public function detail() {
        return view('admin.profile.detail');
    }

    //edit profile
    public function edit() {
        return view('admin.profile.edit');
    }

    //update profile
    public function update(Request $request , $id) {
        $this->profileValidation($request);
        $data = $this->profileData($request);
        if($request->hasFile('image')){
            if(file_exists(public_path('profileImage/'.auth()->user()->profile))){
                unlink(public_path('profileImage/'.auth()->user()->profile));
            }
            $newImage = uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $request->image->move(public_path('profileImage/'),$newImage); // at pj
            $data['profile'] = $newImage; // at db
        }
        User::where('id',$id)->update($data);
        return to_route('profile#detail');
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
    public function changePassword() {
        return view('admin.profile.changePassword');
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

    //password change validation
    private function passwordChangeValidate($request) {
        $request->validate([
        'oldPassword' => 'required' ,
        'newPassword' => 'required|min:8|max:16' ,
        'confirmPassword' => 'required|same:newPassword' ,
        ]);
    }

    //admin creation page
    public function addAdmin() {
        return view('admin.profile.addAdmin');
    }

    //admin creation
    public function adminCreate(Request $request) {
        $this->adminAccValidation($request);
        User::create([
            'name' => $request->name ,
            'email' => $request->email ,
            'password' => Hash::make($request->password) ,
            'role' => 'admin' ,
            'provider' => 'simple' ,
        ]);
        return back()->with(['success'=>'added admin']);
    }

    //adminacc validation check
    private function adminAccValidation($request) {
        $request->validate([
            'name' => 'required|min:1|max:30' ,
            'email' => 'required|email|unique:users,email' ,
            'password' => 'required|min:1|max:30' ,
            'confirmPassword' => 'required|min:1|max:30|same:password' ,
        ]);
    }

    //admin list page
    public function accountList($accountType) {
        $accounts = User::select('id','name','email','address','phone','role','created_at','provider');
        if($accountType == 'admin') {
            $accounts = $accounts->whereIn('role',['admin','superAdmin']);
        }else{
            $accounts = $accounts->where('role',['user']);
        }

        if(request('searchKey')) {
            $key = request('searchKey');
            $accounts->where(function($query) use($key){
                $query->whereAny(['name','email','address','phone','role'],'like','%'.$key.'%');
            });
        }

        $accounts = $accounts->get();
        return view($accountType == 'admin' ? 'admin.profile.adminListPage' : 'admin.profile.userListPage',compact('accounts'));
    }

    //delete admin
    public function adminDelete($id) {
        User::where('id',$id)->delete();
        return back();
    }

    //admin acc detail
    public function adminAccDetail($id) {
        $data = User::where('id',$id)->get();
        return view('admin.profile.adminAccDetail',compact('data'));
    }

    //user acc detail
    public function userAccDetail($id) {
        $data = User::where('id',$id)->get();
        return view('admin.profile.userAccDetail',compact('data'));
    }
}
