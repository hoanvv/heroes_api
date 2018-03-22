<?php

namespace App\Http\Controllers;

use App\Traits\SMSTrait;
use Illuminate\Http\Request;

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
}
