<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    //contact page
    public function contactPage() {
        return view('user.contact_us.contact');
    }

    //contact
    public function contact(Request $request) {
        $request->validate([
            'Name' => 'required' ,
            'Email' => 'required|email' ,
            'Title' => 'required' ,
            'Message' => 'required' ,
        ]);
        Contact::create([
            'user_id' => auth()->user()->id ,
            'user_name' => $request->Name ,
            'user_email' => $request->Email ,
            'title' => $request->Title ,
            'message' => $request->Message
        ]);

        return back()->with(['success'=>'sent!']);

    }

    //contact list
    public function listPage() {
        $contacts = Contact::select('contacts.title','contacts.message','contacts.user_email','users.phone','users.profile')
                            ->leftJoin('users','contacts.user_id','users.id')
                            ->orderBy('contacts.created_at','desc')
                            ->paginate(5);
        return view('admin.contact.list',compact('contacts'));
    }
}
