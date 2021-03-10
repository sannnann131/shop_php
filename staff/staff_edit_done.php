<?php
  session_start();
  function get_csrf_token() 
  {
    $TOKEN_LENGTH = 16;
    $bytes = openssl_random_pseudo_bytes($TOKEN_LENGTH);
    return bin2hex($bytes);
  }

  if ($_POST['token'] != $_SESSION['token']) 
    {
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ../error.php');
    exit();
    }
  session_regenerate_id(true);
  if(isset($_SESSION['login'])==false)
  {
    print'ログインされていません<br/>';
    print '<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
    exit();
  }
  else
  {
    print $_SESSION['staff_name'];
    print 'さんログイン中<br/>';
    print '<br/>';
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>ショッピングサイト</title>
  </head>
  <body>

  <?php

  try 
  {
    require_once('../common/common.php');

    $post=sanitize($_POST);
    $staff_code=$post['code'];
    $staff_name=$post['name'];
    $staff_pass=$post['pass'];

    require('../db/dbconnect.php');

    $sql='UPDATE mst_staff SET name=?,password=? WHERE code=?';
    $stmt = $dbh->prepare($sql);
    $data[]=$staff_name;
    $data[]=$staff_pass;
    $data[]=$staff_code;
    $stmt->execute($data);

    $dbh = null;

  }
  catch (Exception $e)
  {
    print 'ただいま障害により情報が送信できなくなっています。大変ご迷惑をおかけしております。';
    exit();
  }

  ?>

  修正しました<br/>
  <br/>
  <a href="staff_list.php">戻る</a>
  
  </body>
</html>