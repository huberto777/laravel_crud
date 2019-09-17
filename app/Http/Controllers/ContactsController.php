<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\Email;
use App\Contact;
use App\Http\Requests\ContactCreateRequest;

class ContactsController extends Controller
{
    public function formContact()
    {
        return view('contacts.form');
    }

    public function sendContact(ContactCreateRequest $request)
    {
        $contact = new Contact();
        $contact->email = $request->input('email');
        $contact->subject = $request->input('subject');
        $contact->message = $request->input('message');

        Mail::to('huberto777@op.pl')->send(new Email($contact));

        return redirect()->back()->with('message', 'mail został wysłany');
    }
}
