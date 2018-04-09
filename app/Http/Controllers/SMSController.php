<?php

namespace App\Http\Controllers;

use App\Traits\FirebaseConnection;
use App\Traits\SMSTrait;
use Illuminate\Http\Request;
use QrCode;
use Illuminate\Support\Facades\Storage;
use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;

class SMSController extends Controller
{
    use SMSTrait;
    use FirebaseConnection;

    public function index($phoneNumber)
    {
            $path = 'request-ship/1';
            $data = 'null';
//            $this->deleteData($path);
//            $this->saveData($path, $data);
            $this->setNull($path);
//        return $this->sendVerifySMS('+840984617351');
//        $response = $this->sendNormalSMS("0984617351", "Hoan Dep Trai");
//        $responseObject = json_decode($response);
//        dd($responseObject->message);
//        $accountId = 'AC4a3cc712d39d67b557094d120e423d72';
//        $token = '0ef10217b31a49f4449e8d219b7cd71b';
//        $fromNumber = '+17162654424';
//        $number = '+840984617351';
//
//        $client = new Client($accountId, $token);
//
//        // Use the client to do fun stuff like send text messages!
//        try {
//            $sb = $client->messages->create(
//            // the number you'd like to send the message to
//                $number,
//                array(
//                    // A Twilio phone number you purchased at twilio.com/console
//                    'from' => $fromNumber,
//                    // the body of the text message you'd like to send
//                    'body' => 'Hey Jenny! Good luck on the bar exam!'
//                )
//            );
//        } catch (RestException $e) {
//            $statusCode = $e->getStatusCode();
//            $message = array(
//                'success' => false,
//                'message' => $e->getMessage(),
//                'code' => $statusCode
//            );
//            return response()->json($message, $statusCode);
//
//        }
//
//        $message = array(
//            'success' => true,
//            'message' => "This message is sent successfully",
//            'code' => 200
//        );
//        return response()->json($message, 200);
    }

    public function verifyCode($phoneNumber, $verificationCode)
    {
        $rs = $this->verifyCodeSent($phoneNumber, $verificationCode);
        echo $rs;
    }

    public function createQR()
    {
        $data = QrCode::format('png')->generate('Make me into a QrCode!');
        $contents = Storage::put('file1.png', $data);
        echo 1;
//        $contents = Storage::disk('public')->put('file.png', $data);
//        $contents = Storage::get('file.png');
//        $url = asset('file.png');
//        echo ("<img src='{$url}'>");
    }
}
