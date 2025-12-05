<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\InquiryRequest;
use Illuminate\Http\Request;
use App\Mail\InquiryMessage;
use Illuminate\Http\Response;
use function App\Http\Helpers\getSetting;
use Illuminate\Support\Facades\Mail;



class InquiryController extends Controller
{
    public function index(InquiryRequest $request)
    {
        $data = $request->validated();
        if((getSetting('inquiry_mail'))){
            Mail::to(getSetting('inquiry_mail'))->send(new InquiryMessage($data['name'], $data['phone'], $data['email'], $data['delivery_location'], $data['products']));
        }else{
            Mail::to(env('INQUIRY_RECEIVE_MAIL'))->send(new InquiryMessage($data['name'], $data['phone'], $data['email'], $data['delivery_location'], $data['products']));
        }
        
        return Response::HTTP_OK;
    }

    public function sendInquiry()
    {
        return inertia('Frontend/Inquiry');
    }
}