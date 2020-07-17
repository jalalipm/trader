<?php

namespace App\Helpers\Sms;

// use SmsIR_VerificationCode;

// use SmsIR_VerificationCode;
date_default_timezone_set("Asia/Tehran");

include_once("SmsIR_VerificationCode.php");


class Smsir
{
    static function send_verification($code, $cell_phone)
    {
        try {

            $APIKey = "b467d1c5d8711f54ce55d1c6";
            $SecretKey = "Separesh@1397!@#";
            $SmsIR_VerificationCode = new SmsIR_VerificationCode($APIKey, $SecretKey);
            $VerificationCode = $SmsIR_VerificationCode->VerificationCode($code, $cell_phone);
        } catch (\Exception $e) {
            echo 'Error VerificationCode : ' . $e->getMessage();
        }
    }
}
