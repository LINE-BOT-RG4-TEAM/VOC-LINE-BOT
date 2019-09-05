<?php
    $CLIENT_ID = getenv("LINE_NOTIFY_CLIENT_ID");
    $payload = base64_decode($_GET['payload']);
    $redirect_uri = "https://voc-bot.herokuapp.com/notify-callback.php";

    $params = array(
        'response_type' => 'code',
        'client_id' => $CLIENT_ID,
        'redirect_uri' => $redirect_uri."/notify-callback.php",
        'scope' => 'notify',
        'state' => $payload
    );

    header("Location: https://notify-bot.line.me/oauth/authorize?".http_build_query($params));
    die();