<?php

include('core/loader.php');

header('X-Content-Type-Options: nosniff');
header('X-XSS-Protection: 1; mode=block');
header("X-Frame-Options: DENY");

$router = new \Bramus\Router\Router();

$router->get('/', function() {

    $l = isset($_GET['ln']) && in_array($_GET['ln'], APP_LANG['languages']) ? APP_LANG[$_GET['ln']] : APP_LANG[APP_CONFIG['defaultLang']];
    $page = [
        "%description%" => $l['description'],
        '%sitename%' => $l['sitename'],
        "%lang%" => isset($_GET['ln']) && in_array($_GET['ln'], APP_LANG['languages']) ? $_GET['ln'] : APP_CONFIG['defaultLang'],
        "%siteurl%" => APP_CONFIG['siteURL'],
        '%api%' => $l['api'],
        '%about%' => $l['about'],
        '%upload%' => $l['upload'],
        '%exp%' => $l['exp'],
        '%protect%' => $l['protect'],
        '%pickafile%' => $l['pickafile'],
        '%lastmod%' => filemtime('./public/main.js'),
        '%lastmodcss%' => filemtime('./public/style.css'),
        "%whitelisted%" => allowedFormat(),
        '%selectafile%' => $l['selectafile'],
        '%uploadtxt%' => $l['uploadtxt'],
        
    ];
    echo str_replace(array_keys($page), $page,file_get_contents('src/home.html'));
});

$router->get('/get', function() use($db) {
    $l = isset($_GET['ln']) && in_array($_GET['ln'], APP_LANG['languages']) ? APP_LANG[$_GET['ln']] : APP_LANG[APP_CONFIG['defaultLang']];

    // handle param
    if(!isset($_GET['f'])) {
        quit(500, $l['not_allowed']);
    }
        
    // handle filing
    $db->where("generatedFilename", $_GET['f']);
    $db->where("(exp <= ? OR exp = ?)", [time(), 0]);
    $file = $db->getOne("data");

    if(!$file) {
        quit(500, str_replace('%file%', $_GET['f'], $l['file_not_found']));
    }

    // handle protected
    if($file['protected']) {
        if(!isset($_GET['key']) || !password_verify($_GET['key'], $file['pwd'])) {
            quit(500, $l['not_allowed']);
        }
    }

    header('Content-type: ' . $file['mime']);
    header("Content-Disposition: inline; filename=\"".basename($file['generatedFilename'])."\";");
    header("Content-Length: ".filesize(APP_CONFIG['uploadsDir'].$file['generatedFilename']));
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private");
    header("Pragma: public");
    ob_clean();
    readfile(APP_CONFIG['uploadsDir'].$file['generatedFilename']);
    
});

$router->post('/upload', function() use($db) {
    // content type is json for outputs
    header("Content-Type: application/json");

    $repository = new PhpRepository;
    $time = time();
    $ip = getIp();
    $l = isset($_GET['ln']) && in_array($_GET['ln'], APP_LANG['languages']) ? APP_LANG[$_GET['ln']] : APP_LANG[APP_CONFIG['defaultLang']];

    // if the API is enabled, allow cors from anywhere
    if(APP_CONFIG['api']['enabled']) {
        header("Access-Control-Allow-Origin: *");
        if(APP_CONFIG['api']['keyRequired'] && !isset($_POST['key']) || $_POST['key'] != APP_CONFIG['api']['apiKey']) {  
            quit(500, $l['invalid_api_key']);
        }
    }
    else { 
        header("Access-Control-Allow-Origin: ". APP_CONFIG['siteURL']);
    }


    // ratelimit restriction
    $db->where("uploadIp", generateHash($ip));
    $db->orderBy("date", "DESC");
    $latest = $db->getOne("data", ["date"]);

    if($latest['date']+APP_CONFIG['limitPerIP'] > $time) {
        quit(429, $l['rate_limited']);
    }

    if (isset($_FILES['file']) && $_FILES['file']['error'] === 0) {

        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

        $filename = htmlspecialchars(strip_tags($_FILES['file']['name']));

        if($_FILES['file']['size'] > APP_CONFIG['maxFileSize']) {
            quit(500, str_replace("%max_size%", APP_CONFIG['maxFileSize'], $l['max_size_reached']));
        }

        if(!in_array($ext, APP_CONFIG['allowedFiles'])) {
            quit(500, str_replace("%file%", $filename, $l['file_invalid_extension']));
        }

        // make sure the file is what it says it is
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES['file']['tmp_name']);
        finfo_close($finfo);

        $pro = getRandomString(10);

        if ($repository->findType($ext) && $mime == $repository->findType($ext)) {
            $newFilename = generateHash($filename.$time).'.'.$ext;

            $c = $db->insert('data', [
                "ogFilename" => $filename,
                "generatedFilename" => $newFilename,
                "user_agent" => $_SERVER['HTTP_USER_AGENT'],
                "uploadIp" => generateHash($ip),
                "ext" => $ext,
                "protected" => isset($_POST['protect']) ? true : false,
                "exp" => empty($_POST['exp']) ? time() : strtotime($_POST['exp']),
                "pwd" => isset($_POST['protect']) ? password_hash($pro, PASSWORD_DEFAULT) : NULL,
                "mime" => $mime,
                "date"=> $time
            ]);

            $e = isset($_POST['protect']) ? '&key='.$pro :'';
            if ($c && move_uploaded_file($_FILES['file']['tmp_name'], APP_CONFIG['uploadsDir'] . $newFilename)) {
                quit(200, str_replace("%url%", APP_CONFIG['siteURL'] .'/get?f='.$newFilename.$e, $l['success_uploaded']));
            }
            else {
                quit(500, str_replace("%file%", $filename, $l['failed_uploaded']));
            }
        }
        else {
            quit(500, str_replace("%file%", $filename, $l['file_invalid_type']));
        }
    }
    else {
        quit(500, $l['no_file_provided']);
    }
});

$router->run();



?>
