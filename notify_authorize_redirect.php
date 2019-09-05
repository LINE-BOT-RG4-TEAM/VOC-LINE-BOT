<?php
    $CLIENT_ID = getenv("LINE_NOTIFY_CLIENT_ID");
    $payload = base64_decode($_GET['payload']);
    $redirect_uri = getenv("LINE_NOTIFY_REDIRECT_URI");
    $authorize_notify_uri = getenv("LINE_NOTIFY_AUTHORIZE_URI");

    $params = array(
        'response_type' => 'code',
        'client_id' => $CLIENT_ID,
        'redirect_uri' => $redirect_uri,
        'scope' => 'notify',
        'state' => $payload
    );

    header("Location: $authorize_notify_uri?".http_build_query($params));
    die();