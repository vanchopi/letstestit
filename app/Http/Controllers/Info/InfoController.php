<?php

namespace App\Http\Controllers\Info;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Info;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//use Mail;

class InfoController extends Controller
{    
    protected function sendedFormData(Request $request)
    {
        //Mail::to("vanchopi@yahoo.com")->send('opa na');

     //    $to = env('MAIL_MAIN_HOST');
     //    $subject = 'Сообщение с сайта: ' . env('CLIENT_URL');
     //    $message = 'От: ' . $request->name . "\r\n" . 
     //    		   'E-mail: ' . $request->email . "\r\n" . 
     //    		   'Сообщение: ' . $request->message;
	    // $headers =  'From: webmaster@letstestit.ru'       . "\r\n" .
	    //             'Reply-To: webmaster@letstestit.ru' . "\r\n" .
	    //             'X-Mailer: PHP/' . phpversion();
	    // $send = mail($to, $subject, $message, $headers);
     //    $status = '';
     //    if($send){
     //        $status = 'success';
     //        $info = Info::create($request->all());
     //    }else{
     //        $status = 'error';
     //    }



     //    return  $result = [
     //    			"status" => $status,
     //                "send" => $send,
     //                "info"=> $to . ' ' . $subject,
     //    		];


        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);     // Passing `true` enables exceptions
        $status = '';    
        $send = false;
        $error = '';
        try {

            // Email server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';             //  smtp host
            $mail->SMTPAuth = true;
            $mail->Username = env('EMAIL_USERNAME');   //  sender username
            $mail->Password = env('EMAIL_PASSWORD');       // sender password
            $mail->SMTPSecure = 'tls';                  // encryption - ssl/tls
            $mail->Port = 587;                          // port - 587/465

            $mail->setFrom($request->email, $request->name);
            $mail->addAddress(env('MAIL_MAIN_HOST'));
            // $mail->addCC($request->emailCc);
            // $mail->addBCC($request->emailBcc);

            $mail->addReplyTo($request->email, $request->name);

            // if(isset($_FILES['emailAttachments'])) {
            //     for ($i=0; $i < count($_FILES['emailAttachments']['tmp_name']); $i++) {
            //         $mail->addAttachment($_FILES['emailAttachments']['tmp_name'][$i], $_FILES['emailAttachments']['name'][$i]);
            //     }
            // }


            $mail->isHTML(true);                // Set email content format to HTML

            $mail->Subject = 'Сообщение с сайта: ' . env('CLIENT_URL');
            $mail->Body    = 'От: ' . $request->name . " || \r\n" . 
                             'E-mail: ' . $request->email . " || \r\n" .
                             'Сообщение: ' . $request->message;

            // $mail->AltBody = plain text version of email body;

            if( !$mail->send() ) {
                // return back()->with("failed", "Email not sent.")->withErrors($mail->ErrorInfo);
                $status = 'error';
                $send = false;
                $error = $mail->ErrorInfo;
            }else {
                // return back()->with("success", "Email has been sent.");
                $status = 'success';
                $info = Info::create($request->all());
                $send = true;
                $error = false;
            }

        } catch (Exception $e) {
             // return back()->with('error','Message could not be sent.');
            $status = 'error';
            $send = false;
            $error = 'exception' . $e;
        }

        return  $result = [
                    "status" => $status,
                    "send" => $send,
                    "info"=> env('CLIENT_URL'),
                    "error" => $error,
                ];

    }
}