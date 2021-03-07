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

    require_once('../common/common.php');

    $post=sanitize($_POST);
    $staff_code=$post['code'];
    $staff_name=$post['name'];
    $staff_pass=$post['pass'];
    $staff_pass2=$post['pass2'];

    $okflg=true;

    if($staff_name=='')
      {
        print 'スタッフ名が入力されていません。<br/>';
        $okflg=false;
      }
    else
      {
        print 'スタッフ名：';
        print $staff_name;
        print '<br/>';
      }

    if(preg_match('/\A[a-z\d]{6,12}+\z/i',$staff_pass)==0)
      {
        print 'パスワードは6桁以上、12桁以下でお願いします。<br/>';
        $okflg=false;
      }

    if($staff_pass!=$staff_pass2)
      {
        print 'パスワードが一致しません。<br/>';
        $okflg=false;
      }


    if($okflg==true)
      {
        $staff_pass=md5($staff_pass);
        print '<form method="post" action="staff_edit_done.php">';
        print '<input type="hidden" name="code" value="'.$staff_code.'">';
        print '<input type="hidden" name="name" value="'.$staff_name.'">';
        print '<input type="hidden" name="pass" value="'.$staff_pass.'">';
        print '<br/>';
        print '<input type="button" onclick="history.back()" value="戻る">';
        print '<input type="submit" value="ＯＫ">';
        print '</form>';
      }
    else
      {
        print '<form>';
        print '<input type="button" onclick="history.back()" value="戻る">';
        print '</form>';
      }

  ?>

  </body>
</html>