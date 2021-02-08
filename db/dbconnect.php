<?php
$db = parse_url($_SERVER['CLEARDB_DATABASE_URL']);
$dsn = "mysql:host={$db['host']};dbname={$db['dbname']};charset=utf8";
$user = $db['user'];
$password = $db['pass'];
$dbh=new PDO($dsn, $user, $password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
?>