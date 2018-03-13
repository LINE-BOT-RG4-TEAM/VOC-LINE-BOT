<?php
    require('./libs/database/connect-db.php');

    $sql = "INSERT INTO tbl_log_notify(notify_timestamp) VALUES(now())";
    mysqli_query($conn, $sql);