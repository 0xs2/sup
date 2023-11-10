<?php

function generateSaltedURL($salt, $method, $length, $raw) {
    return substr(hash($method, $raw).$salt, 0, $length);
}


function quit($code, $msg) {
    http_response_code($code);
    die(json_encode([
        "status" => $code,
        "msg" => $msg
    ], true));
}

function getIP() {
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
              $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
              $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    }
    else {
        $ip = $remote;
    }
    return $ip;
}

function checkProxy($url, $ip) {
    
    $ch = curl_init($url.'/'.$ip);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept-Encoding: gzip'));
    curl_setopt($ch, CURLOPT_USERAGENT, 'Your User-Agent');
    
    $response = curl_exec($ch);
        if ($response === false) {
       return true;
    }
    curl_close($ch);
    $jsonData = gzdecode($response);
    
    if ($jsonData === false) {
        return true;
    }
    $jsonArray = json_decode($jsonData, true);
    
    if ($jsonArray === null || $jsonArray['status'] != 'success' || $jsonArray['proxy']) {
        return true;
    }

    return false;
    }

    function getRandomString($n) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
      
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
      
        return $randomString;
    }
    
    

    function allowedFormat($list) {
        $dotPrefixedExtensions = array_map(function($ext) {
            return ".$ext";
        }, $list);
        return implode(', ', $dotPrefixedExtensions);
    }

    function unix(&$string) {
        $time =date("Y-m-d h:i:sa", $string);
        return $time;
    };
    


?>