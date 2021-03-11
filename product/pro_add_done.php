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
    $pro_name=$post['name'];
    $pro_price=$post['price'];
    $pro_gazou_name=$post['gazou_name'];
    
    require('../db/dbconnect.php');

    $sql='INSERT INTO mst_product (name,price,gazou) VALUES (?,?,?)';
    $stmt = $dbh->prepare($sql);
    $data[]=$pro_name;
    $data[]=$pro_price;
    $data[]=$pro_gazou_name;
    $stmt->execute($data);

    $dbh = null;

    print $pro_name;
    print 'を追加しました。<br/>';

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