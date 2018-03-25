<?php

namespace App\Http\Controllers;

use App\Traits\SMSTrait;
use Illuminate\Http\Request;
use QrCode;
use Illuminate\Support\Facades\Storage;
use Services_Twilio;

class SMSController extends Controller
{
    use SMSTrait;

    public function index($phoneNumber)
    {
//        $rs = $this->sendVerifySMS($phoneNumber);
//        echo $rs;
        $accountId = 'AC4a3cc712d39d67b557094d120e423d72';
        $token = '0ef10217b31a49f4449e8d219b7cd71b';
        $fromNumber = '+17162654424';
        $number = '+84984617351';
        $message = 'Pink Elephants and Happy Rainbows';
//        $twilio = new Aloha\Twilio\Twilio($accountId, $token, $fromNumber);
//        $twilio = new Twilio($accountId, $token, $fromNumber);
        $twilio = new Services_Twilio($accountId, $token);

//        $twilio->message('+84984617351', 'Pink Elephants and Happy Rainbows');
        $sb = $twilio->account->messages->sendMessage(
            $fromNumber, // the text will be sent from your Twilio number
            $number, // the phone number the text will be sent to
            $message // the body of the text message
        );

        echo $sb;
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
