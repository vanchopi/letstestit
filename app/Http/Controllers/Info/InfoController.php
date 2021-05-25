<?php

namespace App\Http\Controllers\Info;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Info;
//use Mail;

class InfoController extends Controller
{    
    protected function sendedFormData(Request $request)
    {
        //Mail::to("vanchopi@yahoo.com")->send('opa na');
        $to = 'vanchopi93@yandex.com';
        $subject = 'Сообщение с сайта: ' . env('CLIENT_URL');
        $message = 'От: ' . $request->name . "\r\n" . 
        		   'E-mail: ' . $request->email . "\r\n" . 
        		   'Сообщение: ' . $request->message;
	    $headers =  'From: webmaster@letstestit.ru'       . "\r\n" .
	                'Reply-To: webmaster@letstestit.ru' . "\r\n" .
	                'X-Mailer: PHP/' . phpversion();
	    mail($to, $subject, $message, $headers);
        return  $result = [
        			"status" => 'success'
        		];
    }
}