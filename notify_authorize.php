<?php
    function siteURL(){
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domainName = $_SERVER['HTTP_HOST'].'/';
        return $protocol.$domainName;
    }

    define('CLIENT_ID', 'ZaX42diNJkghT2thIarkiF');
    define('CLIENT_SECRET', '0ih0cztiJ1ZDXDe8pMkSlCzH7bVTpSvpj9BYRAoCX9K');
    define('SITE_URL', siteURL());
    $authorizeURL = "https://notify-bot.line.me/oauth/authorize";
    
    // get pea_code from
    $state = base64_decode($_GET['state']);

    $params = array(
        'response_type' => 'code',
        'client_id' => CLIENT_ID,
        'redirect_uri' => SITE_URL."callback.php",
        'scope' => 'notify',
        'state' => $state
    );
    // Redirect the user to Github's authorization page
    header('Location: ' . $authorizeURL . '?' . http_build_query($params));
    die();