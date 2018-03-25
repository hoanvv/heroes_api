<?php

namespace App\Traits;
use Twilio\Rest\Client;
use Twilio\Exceptions\TwilioException;

trait SMSTrait
{
    protected function sendNormalSMS($phoneNumber, $message)
    {
        $accountId = 'AC4a3cc712d39d67b557094d120e423d72';
        $token = '0ef10217b31a49f4449e8d219b7cd71b';
        $fromNumber = '+17162654424';
        $phone = '+84' . $phoneNumber;

        $client = new Client($accountId, $token);

        // Use the client to do fun stuff like send text messages!
        try {
            $res = $client->messages->create(
            // the number you'd like to send the message to
                $phone,
                array(
                    // A Twilio phone number you purchased at twilio.com/console
                    'from' => $fromNumber,
                    // the body of the text message you'd like to send
                    'body' => $message
                )
            );
        } catch (TwilioException $e) {
            $statusCode = $e->getStatusCode();
            $message = array(
                'success' => false,
                'message' => $e->getMessage(),
                'code' => $statusCode
            );
            return json_encode($message);
        }

        $message = array(
            'success' => true,
            'message' => "This message is sent successfully",
            'code' => 200
        );
        return json_encode($message);
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