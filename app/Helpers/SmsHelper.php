<?php

namespace App\Helpers;

class SmsHelper
{
    private $senderId;
    private $authKey;
    private $password;

    public function __construct()
    {
        $this->senderId = env('SMS_SENDER');
        $this->authKey = env('SMS_AUTH_KEY');
        $this->password = env('SMS_PASSWORD');
    }

    public function sendOTP($recipient, $otp)
    {
        $message = urlencode("{$otp} is you Rera Agents verification code. Please DO NOT share this OTP with anyone to ensure account's security.");
        // $url="http://login.redsms.in/API/SendMessage.ashx?user=$this->authKey&password=$this->password&phone=$recipient&text=$message&type=t&senderid=$this->senderId";
        $url="https://api.msg91.com/api/sendhttp.php?mobiles=$recipient&authkey=$this->authKey&route=4&sender=$this->senderId&message=$message&country=91";
    
        // create a new cURL resource
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_HEADER, 0);
        $res = curl_exec($ch);
        curl_close($ch);
    }

    public function sendPassword($recipient, $otp)
    {
        $message = urlencode("Your RERA Agent OTP is {$otp}. Use this to login to your RERA Agents account. Please DO NOT share this OTP with anyone to ensure account's security.");
        $url="http://login.redsms.in/API/SendMessage.ashx?user=$this->authKey&password=$this->password&phone=$recipient&text=$message&type=t&senderid=$this->senderId";

        $url = "https://api.msg91.com/api/sendhttp.php?mobiles=$recipient&authkey=$this->authKey&route=4&sender=$this->senderId&message=$message&country=91";
        // create a new cURL resource
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_HEADER, 0);
        $res = curl_exec($ch);
        curl_close($ch);

    }
}
