<?php

namespace App\Http\Controllers;

use App\Traits\SMSTrait;
use Illuminate\Http\Request;
use QrCode;
use Illuminate\Support\Facades\Storage;

class SMSController extends Controller
{
    use SMSTrait;

    public function index($phoneNumber)
    {
        $rs = $this->sendVerifySMS($phoneNumber);
        echo $rs;
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
