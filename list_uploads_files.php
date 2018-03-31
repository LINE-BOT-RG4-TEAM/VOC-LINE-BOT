<?php
    $xlsxList = glob("../*.*");
    foreach($xlsxList as $file){
        echo "<p>".realpath($file)."</p>";
    }