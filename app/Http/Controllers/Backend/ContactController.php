<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use function App\Http\Helpers\getSetting;

class ContactController extends Controller
{
    public function index(Request $request)
    {

        $name = $request->input('name');
        $phone = $request->input('phone');
        $email = $request->input('email');
        $message = $request->input('message');
        $companyName = $request->input('company_name');
        $companyDetail = $request->input('company_detail');
        $gmail = getSetting('inquire_mail');

        Mail::to($gmail)->send(new ContactMail($name, $phone, $email, $message, $companyName, $companyDetail));
    }
}
