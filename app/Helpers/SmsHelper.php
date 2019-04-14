<?php

namespace App\Helpers;

class SmsHelper
{
    private $senderId;
    private $authKey;
    private $password;

    public function __construct()
    {
        $this->senderId = env('REDSMS_SENDER');
        $this->authKey = env('REDSMS_AUTH_KEY');
        $this->password = env('REDSMS_PASSWORD');
    }

    public function sendOTP($recipient, $otp)
    {
        $message = urlencode("{$otp} is you Rera Agents verification code. Please DO NOT share this OTP with anyone to ensure account's security.");
        $url="http://login.redsms.in/API/SendMessage.ashx?user=$this->authKey&password=$this->password&phone=$recipient&text=$message&type=t&senderid=$this->senderId";
    
        // create a new cURL resource
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_HEADER, 0);
        $res = curl_exec($ch);
        curl_close($ch);
    }
}
