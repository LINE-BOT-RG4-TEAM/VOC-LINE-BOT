<?php
    $access_token = "QPUPUnMzGhO//A8J2Qi1nmBXgEW89hciaaxNExeLVgxa8cjYtvnF9TZQF3TEjEOVA5HhS6dTRT2Tp4F0I3JhC0QWrQdmlBiL/6bhuazJI/juOxmvFx31NX7RWv9z19gbUZAdPIEuAURaHPy7TnDNkQdB04t89/1O/w1cDnyilFU=";
    $url = 'https://api.line.me/v2/bot/profile/Ue54dbf2403fa87a5a6f18e6ca93db99d';
    $headers = array('Authorization: Bearer ' . $access_token);
    // $ch = curl_init($url);
    // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // // curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    // $result = curl_exec($ch);
    // print_r($result);
    // curl_close($ch);

    $ssl = stripos($url,'https://') === 0 ? true : false;
    $timeout = 10;
    $curlObj = curl_init();
    $options = [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_FOLLOWLOCATION => 1,
        CURLOPT_AUTOREFERER => 1,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)',
        CURLOPT_TIMEOUT => $timeout,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_0,
        CURLOPT_HTTPHEADER => ['Expect:'],
        CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
        CURLOPT_HTTPHEADER => $headers
    ];
    if ($ssl) {
        //support https
        $options[CURLOPT_SSL_VERIFYHOST] = false;
        $options[CURLOPT_SSL_VERIFYPEER] = false;
    }
    curl_setopt_array($curlObj, $options);
    $returnData = curl_exec($curlObj);
    if (curl_errno($curlObj)) {
        //error message
        $returnData = curl_error($curlObj);
    }
    $returnData = json_decode($returnData,true);
    curl_close($curlObj);
    $displayName = $returnData['displayName'];
    // print_r($returnData);
    echo "<img src='".$returnData['pictureUrl']."'/>";