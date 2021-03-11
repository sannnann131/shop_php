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
  if(isset($_SESSION['member_login'])==false)
  {
    print 'ログインされていません。<br />';
    print '<a href="shop_list.php">商品一覧へ</a>';
    exit();
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

  $onamae=$post['onamae'];
  $email=$post['email'];
  $postal1=$post['postal1'];
  $postal2=$post['postal2'];
  $address=$post['address'];
  $tel=$post['tel'];

  print $onamae.'様<br/>';
  print 'ご注文ありがとうございました。<br/>';
  print '商品は以下の住所に発送させていただきます。<br/>';
  print '郵便番号：';
  print $postal1.'-'.$postal2.'<br/>';
  print '住所：';
  print $address.'<br/>';
  print '電話番号：';
  print $tel.'<br/>';
  print '(注意)あくまでこれはダミーサイトです';

  $cart=$_SESSION['cart'];
  $kazu=$_SESSION['kazu'];
  $max=count($cart);

  require('../db/dbconnect.php');

  for($i=0;$i<$max;$i++)
  {
    $sql='SELECT name,price FROM mst_product WHERE code=?';
    $stmt=$dbh->prepare($sql);
    $data[0]=$cart[$i];
    $stmt->execute($data);

    $rec=$stmt->fetch(PDO::FETCH_ASSOC);

    $name=$rec['name'];
    $price=$rec['price'];
    $kakaku[]=$price;
    $suryo=$kazu[$i];
    $shokei=$price*$suryo;
  }

  $sql='LOCK TABLES dat_sales WRITE,dat_sales_product WRITE,dat_member WRITE';
  $stmt=$dbh->prepare($sql);
  $stmt->execute();


  $lastmembercode=$_SESSION['member_code'];

  $sql='INSERT INTO dat_sales (code_member,name,email,postal1,postal2,address,tel) VALUES (?,?,?,?,?,?,?)';
  $stmt=$dbh->prepare($sql);
  $data=array();
  $data[]=0;
  $data[]=$onamae;
  $data[]=$email;
  $data[]=$postal1;
  $data[]=$postal2;
  $data[]=$address;
  $data[]=$tel;
  $stmt->execute($data);

  $sql='SELECT LAST_INSERT_ID()';
  $stmt=$dbh->prepare($sql);
  $stmt->execute();
  $rec=$stmt->fetch(PDO::FETCH_ASSOC);
  $lastcode=$rec['LAST_INSERT_ID()'];

  for($i=0;$i<$max;$i++)
  {
    $sql='INSERT INTO dat_sales_product (code_sales,code_product,price,quantity) VALUES (?,?,?,?)';
    $stmt=$dbh->prepare($sql);
    $data=array();
    $data[]=$lastmembercode;
    $data[]=$cart[$i];
    $data[]=$kakaku[$i];
    $data[]=$kazu[$i];
    $stmt->execute($data);
  }

  $sql='UNLOCK TABLES';
  $stmt=$dbh->prepare($sql);
  $stmt->execute();

  $dbh=null;
}

  catch (Exception $e)
  {
    print 'ただいま障害により情報が送信できなくなっています。大変ご迷惑をおかけしております。';
    exit();
  }

?>

<?php
session_start();
$_SESSION=array();
if(isset($_COOKIE[session_name()])==true)
{
  setcookie(session_name(),'',time()-42000,'/');
}
session_destroy();
?>

  <br/>
  <a href="shop_list.php">商品画面へ</a>
  </body>
</html>