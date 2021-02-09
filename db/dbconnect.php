<?php
  $dsn='mysql:dbname=getenv('DB_NAME');host=getenv('DB_HOSTNAME');charset=utf8';
  $user=getenv('DB_USERNAME');
  $password=getenv('DB_PASSWORD');
  $dbh=new PDO($dsn, $user, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
?>