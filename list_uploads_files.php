<?php
    $xlsxList = glob("./uploads-voc-files/*.xlsx");
    foreach($xlsxList as $file){
        echo "<p>".realpath($file)."</p><br/>";
    }