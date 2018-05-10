<?php
    require('./libs/utils/bot_utils.php');
    
    // Get POST body content
    $content = file_get_contents('php://input');
    // Parse JSON
    $events = json_decode($content, true);
    // Validate parsed JSON data

    if (!is_null($events['events'])) {
        // Loop through each event
        foreach ($events['events'] as $event) {
            // Reply only when message sent is in 'text' format
            if ($event['type'] == 'message' && $event['message']['type'] == 'text') {

                // Get text sent
                $text = $event['message']['text'];
                $user_id = $event['source']['userId'];
                if(correctCode($text, $user_id)){
                    continue;
                }
                
                // authen user 
                if(!hasPermission($user_id)){
                    continue;
                }
                // is join group ?
                // check command
                // return result
            }
        }
    }

