<?php

$config = [
    "production" => false, // only if you're testing
    "defaultLang" => 'en', // supported languages: en, fr, es, de
    "siteURL" => 'http://localhost/up', // main url
    "uploadsDir" => 'uploads/', // where uploads go
    "maxFileSize" => 104857600, // file size limit
    "limitPerIP" => 60, // cooldown for an IP, in seconds
    "proxyAPI" => "https://api.techniknews.net/ipgeo", // api that checks if the ip is a proxy
    "proxiesAllowed" => false, // are proxies/vpns allowed?
    "allowedFiles" => [ 
        "txt", "jpg", "jpeg", "png", "gif", "webp",
    ],
    "api" => [
        "enabled" => true, // is the api enabled?
        "keyRequired" => false, // do you require people to use your key?
        "apiKey" => "" // put a key here
    ],
    "salting" => [
        "salt" => "thisisasecretsalt",
        'method' => "sha512",
        "length" => 10
    ] // gives link a string ex: https://sup.example.com/get?f=b45dd0514e
];




?>