<?php

define('APP_CONFIG',[
    "production" => false, // only if you're testing
    "defaultLang" => 'en', // supported languages: en, fr, es, de
    "siteURL" => 'http://localhost/sip1', // main url
    "uploadsDir" => 'uploads/', // where uploads go
    "maxFileSize" => 104857600, // file size limit
    "limitPerIP" => 60, // cooldown for an IP, in seconds
    "allowedFiles" => [ 
        "txt", "jpg", "jpeg","mpv","mp4", "png", "gif", "webp",
    ],
    "api" => [
        "enabled" => true, // is the api enabled?
        "keyRequired" => false, // do you require people to use your key?
        "apiKey" => "" // put a key here
    ],
    "db" => [
	"host" => "localhost",
	"user" => "root",
	"pass" => "",
	"name" => "up",
	"port" => 3306
    ],
    "hashing" => [
        'method' => "sha512",
        "length" => 10
    ]
]);



?>
