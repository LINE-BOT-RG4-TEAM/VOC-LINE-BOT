<?php
  require('./libs/database/connect-db.php');
  $insert_comment = "INSERT INTO tbl_test_log(comment, insert_time) VALUES('corn_job_1', NOW())";
  mysqli_query($conn, $insert_comment);