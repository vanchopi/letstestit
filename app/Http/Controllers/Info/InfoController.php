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

        $to = env('MAIL_MAIN_HOST');
        $subject = 'Сообщение с сайта: ' . env('CLIENT_URL');
        $message = 'От: ' . $request->name . "\r\n" . 
        		   'E-mail: ' . $request->email . "\r\n" . 
        		   'Сообщение: ' . $request->message;
	    $headers =  'From: webmaster@letstestit.ru'       . "\r\n" .
	                'Reply-To: webmaster@letstestit.ru' . "\r\n" .
	                'X-Mailer: PHP/' . phpversion();
	    $send = mail($to, $subject, $message, $headers);
        $status = '';
        if($send){
            $status = 'success';
            $info = Info::create($request->all());
        }else{
            $status = 'error';
        }
        return  $result = [
        			"status" => $status,
                    "send" => $send,
        		];
    }
}