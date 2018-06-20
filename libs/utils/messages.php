<?php

  function getBubbleMessages($conn){
    return array (
      'type' => 'flex',
      'altText' => 'This is a Flex Message',
      'contents' => 
      array (
        'type' => 'bubble',
        'styles' => 
        array (
          'footer' => 
          array (
            'separator' => true,
          ),
        ),
        'body' => 
        array (
          'type' => 'box',
          'layout' => 'vertical',
          'contents' => 
          array (
            0 => 
            array (
              'type' => 'text',
              'text' => 'DAILY ALERT',
              'weight' => 'bold',
              'color' => '#1DB446',
              'align' => 'center',
              'size' => 'md',
            ),
            1 => 
            array (
              'type' => 'text',
              'text' => 'รายงานเรื่องร้องเรียน ',
              'weight' => 'bold',
              'size' => 'xl',
              'align' => 'center',
              'margin' => 'md',
            ),
            2 => 
            array (
              'type' => 'text',
              'text' => 'ประจำวันที่ 18 มิถุนายน 2561',
              'size' => 'md',
              'color' => '#aaaaaa',
              'align' => 'center',
              'wrap' => true,
            ),
            3 => 
            array (
              'type' => 'separator',
              'margin' => 'xxl',
            ),
            4 => 
            array (
              'type' => 'box',
              'layout' => 'vertical',
              'margin' => 'xxl',
              'spacing' => 'sm',
              'contents' => 
              array (
                0 => 
                array (
                  'type' => 'box',
                  'layout' => 'horizontal',
                  'contents' => 
                  array (
                    0 => 
                    array (
                      'type' => 'text',
                      'text' => 'กฟต.1 (จ.เพชรบุรี)',
                      'size' => 'md',
                      'color' => '#555555',
                      'weight' => 'bold',
                      'flex' => 0,
                    ),
                    1 => 
                    array (
                      'type' => 'text',
                      'text' => '2 เรื่อง',
                      'size' => 'md',
                      'color' => '#111111',
                      'align' => 'end',
                    ),
                  ),
                ),
                1 => 
                array (
                  'type' => 'box',
                  'layout' => 'horizontal',
                  'contents' => 
                  array (
                    0 => 
                    array (
                      'type' => 'text',
                      'text' => 'กฟต.2 (จ.นครศรีธรรมราช)',
                      'size' => 'md',
                      'color' => '#555555',
                      'weight' => 'bold',
                      'flex' => 0,
                    ),
                    1 => 
                    array (
                      'type' => 'text',
                      'text' => '5 เรื่อง',
                      'size' => 'md',
                      'color' => '#111111',
                      'align' => 'end',
                    ),
                  ),
                ),
                2 => 
                array (
                  'type' => 'box',
                  'layout' => 'horizontal',
                  'contents' => 
                  array (
                    0 => 
                    array (
                      'type' => 'text',
                      'text' => 'กฟต.3 (จ.ยะลา)',
                      'size' => 'md',
                      'color' => '#555555',
                      'weight' => 'bold',
                      'flex' => 0,
                    ),
                    1 => 
                    array (
                      'type' => 'text',
                      'text' => '1 เรื่อง',
                      'size' => 'md',
                      'color' => '#111111',
                      'align' => 'end',
                    ),
                  ),
                ),
                3 => 
                array (
                  'type' => 'separator',
                  'margin' => 'xxl',
                ),
                4 => 
                array (
                  'type' => 'box',
                  'layout' => 'horizontal',
                  'margin' => 'xxl',
                  'contents' => 
                  array (
                    0 => 
                    array (
                      'type' => 'text',
                      'text' => 'รวมทั้งสิ้น',
                      'size' => 'md',
                      'weight' => 'bold',
                      'color' => '#555555',
                    ),
                    1 => 
                    array (
                      'type' => 'text',
                      'text' => '8 เรื่อง',
                      'size' => 'md',
                      'color' => '#111111',
                      'align' => 'end',
                    ),
                  ),
                ),
              ),
            ),
            5 => 
            array (
              'type' => 'separator',
              'margin' => 'xxl',
            ),
            6 => 
            array (
              'type' => 'button',
              'style' => 'primary',
              'action' => 
              array (
                'type' => 'uri',
                'label' => 'รายละเอียดเพิ่มเติม',
                'uri' => 'https://voc-bot.herokuapp.com/south.php?NUMBER=@10',
              ),
            ),
          ),
        ),
      ),
    );
  }