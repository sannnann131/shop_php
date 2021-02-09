<?php
  $dsn='mysql:dbname=heroku_55204781f5f56d5;host=us-cdbr-east-03.cleardb.com;charset=utf8';
  $user=getenv('DB_USERNAME');
  $password=getenv('DB_PASSWORD');
  $dbh=new PDO($dsn, $user, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
?>