<?php

define('APP_LANG', [
    "languages" => ['en','es','de','zh','fr'],
    "en" => [
        "sitename" => "simple file uploader",
        "description" => "a simple uploader in PHP",
        "uploadtxt" => "upload your file here",
        "invalid_api_key" => "API key was not valid",
        "pickafile" => "pick a file to upload",
        "upload" => "upload",
        "api" => "api",
        "protect" => "protect file?",
        "about" => "about",
        "exp" => "leave empty if it never expires",
        "selectafile" => "select file", 
        "rate_limited" => "You need to wait until you can upload another file.",
        "not_found" => "This page was not found.",
        "not_allowed" => "No access.",
        "success_uploaded" => "Your file has been uploaded. URL: '%url%'",
        "failed_uploaded" => "There was a problem uploading your file. File: %file%",
        "max_size_reached" => "Your file is too big. Max size: %max_size%",
        "ip_proxy" => "Your IP has flagged as a proxy or VPN.",
        "file_not_found" => "File not found. File: %file%",
        "file_protected_invalid_key" => "Invalid key.",
        "file_protected_key_not_set" => "File: %file% requires a passphrase.",
        "file_expired" => "%file% expired on %date%",
        "file_invalid_extension" => "Your file '%file%' is an invalid extension.",
        "file_invalid_type" => "Your file '%file%' is an invalid type.",
        "no_file_provided" => "No file was provided."
    ]
]);

?>