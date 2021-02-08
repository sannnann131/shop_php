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
    $staff_code=$_POST['code'];
    require('../db/dbconnect.php');

    $sql='DELETE FROM mst_staff WHERE code=?';
    $stmt = $dbh->prepare($sql);
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

  削除しました<br/>
  <br/>
  <a href="staff_list.php">戻る</a>
  
  </body>
</html>