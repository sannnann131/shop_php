<?php
  $dbname=getenv('DB_NAME');
  $dbhost=getenv('DB_HOSTNAME');
  $user=getenv('DB_USERNAME');
  $password=getenv('DB_PASSWORD');
  $dsn='mysql:dbname={$dbname};host={$dbhost};charset=utf8';
  $dbh=new PDO($dsn, $user, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
?>