<?php

namespace App\Traits;

trait SMSTrait
{
//    protected function sendNormalSMS($phoneNumber, $message)
//    {
//        $sid = "AC4a3cc712d39d67b557094d120e423d72";
//        $token = "0ef10217b31a49f4449e8d219b7cd71b";
//        $client = new Client($sid, $token);
//
//        try {
//            $client->messages->create(
//                $phoneNumber,
//                array(
//                    'from' => '+17162654424',
//                    'body' => $message
//                )
//            );
//        } catch (Exception $e) {
//            //Log::error($e->getMessage());
//        }
//    }

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