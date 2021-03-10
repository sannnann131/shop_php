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
      function get_csrf_token() 
      {
        $TOKEN_LENGTH = 16;
        $bytes = openssl_random_pseudo_bytes($TOKEN_LENGTH);
        return bin2hex($bytes);
      }
      $_SESSION['token'] = get_csrf_token();

     require_once('../common/common.php');

    $post=sanitize($_POST);
    $pro_code=$post['code'];
    $pro_name=$post['name'];
    $pro_price=$post['price'];
    $pro_gazou_name_old=$post['gazou_name_old'];
    $pro_gazou=$_FILES['gazou'];

    $okflg=true;

    if($pro_name=='')
      {
        print '商品名が入力されていません。<br/>';
        $okflg=false;
      }
    else
      {
        print '商品：';
        print $pro_name;
        print '<br/>';
      }

    if(preg_match('/\A[0-9]+\z/',$pro_price)==0)
      {
        print '商品の値段を半角数字のみで記載してください。<br/>';
        $okflg=false;
      }
      else
      {
        print '価格：';
        print $pro_price;
        print '円<br/>';
      }

      if($pro_gazou['size']>0)
      {
        if($pro_gazou['size']>1000000)
        {
          print '画像が大きすぎます';
          $okflg=false;
        }
        else
        {
          move_uploaded_file($pro_gazou['tmp_name'],'./gazou/'.$pro_gazou['name']);
          print '<img src="./gazou/'.$pro_gazou['name'].'">';
          print '<br/>';
        }
      }


    if($okflg==true)
      {
        print '上記のように変更します。<br/>';
        print '<form method="post" action="pro_edit_done.php">';
        print '<input type="hidden" name="code" value="'.$pro_code.'">';
        print '<input type="hidden" name="name" value="'.$pro_name.'">';
        print '<input type="hidden" name="price" value="'.$pro_price.'">';
        print '<input type="hidden" name="gazou_name_old" value="'.$pro_gazou_name_old.'">';
        print '<input type="hidden" name="gazou_name" value="'.$pro_gazou['name'].'">';
        print '<input type="hidden" name="token" value="'.$_SESSION['token'].'">';
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