<?php
    function siteURL(){
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domainName = $_SERVER['HTTP_HOST'].'/';
        return $protocol.$domainName;
    }

    $CLIENT_ID = getenv("LINE_NOTIFY_CLIENT_ID");

    $payload = base64_decode($_GET['payload']);

    $params = array(
        'response_type' => 'code',
        'client_id' => $CLIENT_ID,
        'redirect_uri' => siteURL()."/notify-callback.php",
        'scope' => 'notify',
        'state' => $payload
    );

    header("Location: https://notify-bot.line.me/oauth/authorize?".http_build_query($params));
    die();