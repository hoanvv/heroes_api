<?php

namespace App\Traits;
use Services_Twilio;

trait SMSTrait
{
    protected function sendNormalSMS($phoneNumber, $message)
    {
        $accountId = 'AC4a3cc712d39d67b557094d120e423d72';
        $token = '0ef10217b31a49f4449e8d219b7cd71b';
        $fromNumber = '+17162654424';

        $twilio = new Services_Twilio($accountId, $token);

        $sb = $twilio->account->messages->sendMessage(
            $fromNumber, // the text will be sent from your Twilio number
            $phoneNumber, // the phone number the text will be sent to
            $message // the body of the text message
        );

        echo $sb;
    }

    protected function sendVerifySMS($phoneNumber)
    {
        $verifyTwilioApiKey = "vkuNz5g1BziDekBkyjNKsKdvMzFtoZRa";

        $url = "https://api.authy.com/protected/json/phones/verification/start"
            . "?api_key={$verifyTwilioApiKey}"
            . "&via=sms"
            . "&country_code=84"
            . "&phone_number={$phoneNumber}";

        $isPost = true;

        $response = $this->curlRequest($isPost, $url);

        return $response;
    }

    protected function verifyCodeSent($phoneNumber, $verificationCode)
    {
        $verifyTwilioApiKey = "vkuNz5g1BziDekBkyjNKsKdvMzFtoZRa";

        $url = "https://api.authy.com/protected/json/phones/verification/check"
            . "?api_key={$verifyTwilioApiKey}"
            . "&country_code=84"
            . "&verification_code={$verificationCode}"
            . "&phone_number={$phoneNumber}";
        $isPost = false;

        $response = $this->curlRequest($isPost, $url);

        return $response;
    }

    private function curlRequest($isPost, $url)
    {
        $ch = curl_init();

        $curlConfig = array(
            CURLOPT_URL            => $url,
            CURLOPT_POST           => $isPost,
            CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $curlConfig);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}