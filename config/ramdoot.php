<?php

return [
   
    /*
    |--------------------------------------------------------------------------
    | SMS configration
    |--------------------------------------------------------------------------
    */
    "sms" => [
        "user" => env("SMS_USER", "smitthakkar"),
        "password" => env("SMS_PASSWORD", "36319493"),
        "sender_id" => env("SMS_SENDER_ID", "ORNSKN"),
        "channel" => env("SMS_CHANNEL", "Trans"),
    ],

    /*
    |--------------------------------------------------------------------------
    | Fail Emails goes to
    |--------------------------------------------------------------------------
    */
    "appurl" => "https://www.ramdootedu.world",
];
