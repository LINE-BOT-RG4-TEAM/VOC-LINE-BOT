<?php
    // $xlsxList = glob("../*.*");
    // foreach($xlsxList as $file){
    //     echo "<p>".realpath($file)."</p>";
    // }

    $dir    = '/';
    $files1 = scandir($dir);
    echo '/<br/>';
    print_r($files1);

    $dir = './';
    $files1 = scandir($dir);
    echo './<br/>';
    print_r($files1);

    $dir = '../';
    $files1 = scandir($dir);
    echo '../<br/>';
    print_r($files1);