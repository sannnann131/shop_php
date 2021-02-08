<?php
  session_start();
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
    require('../db/dbconnect.php');

    $post=sanitize($_POST);
    $staff_name=$post['name'];
    $staff_pass=$post['pass'];

    $sql='INSERT INTO mst_staff (name,password) VALUES (?,?)';
    $stmt = $dbh->prepare($sql);
    $data[]=$staff_name;
    $data[]=$staff_pass;
    $stmt->execute($data);

    $dbh = null;

    print $staff_name;
    print 'さんを追加しました。<br/>';

  }
  catch (Exception $e)
  {
    print 'ただいま障害により情報が送信できなくなっています。大変ご迷惑をおかけしております。';
    exit();
  }

  ?>

  <a href="staff_list.php">戻る</a>
  
  </body>
</html>