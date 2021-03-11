<?php
  session_start();
  function get_csrf_token() 
  {
    $TOKEN_LENGTH = 16;
    $bytes = openssl_random_pseudo_bytes($TOKEN_LENGTH);
    return bin2hex($bytes);
  }

  if (empty($_SESSION['token']) ||$_POST['token'] != $_SESSION['token']) 
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
    $pro_code=$post['code'];
    $pro_name=$post['name'];
    $pro_price=$post['price'];
    $pro_gazou_name_old=$_POST['gazou_name_old'];
    $pro_gazou_name=$_POST['gazou_name'];

    require('../db/dbconnect.php');

    $sql='UPDATE mst_product SET name=?,price=?,gazou=? WHERE code=?';
    $stmt = $dbh->prepare($sql);
    $data[]=$pro_name;
    $data[]=$pro_price;
    $data[]=$pro_gazou_name;
    $data[]=$pro_code;
    $stmt->execute($data);

    $dbh = null;

    if($pro_gazou_name_old!=$pro_gazou_name)
    {
      if($pro_gazou_name_old!='')
        {
          unlink('./gazou/'.$pro_gazou_name_old);
        }
    }

    print '修正しました。<br/>';

  }
  catch (Exception $e)
  {
    print 'ただいま障害により情報が送信できなくなっています。大変ご迷惑をおかけしております。';
    exit();
  }

  ?>

  <a href="pro_list.php">戻る</a>
  
  </body>
</html>