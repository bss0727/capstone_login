<?php

include('db.php');

if(isset($_POST['user_id']) && isset($_POST['user_nick']) && isset($_POST['pass1']) && isset($_POST['pass2']))
{
  $user_id = mysqli_real_escape_string($db, $_POST['user_id']);
  $user_nick = mysqli_real_escape_string($db, $_POST['user_nick']);
  $pass1 = mysqli_real_escape_string($db, $_POST['pass1']);
  $pass2 = mysqli_real_escape_string($db, $_POST['pass2']);

  if(empty($user_id))
  {
    header("location: register_view.php?error=아이디가 비어있습니다");
    exit();
  }
  else if(empty($user_nick))
  {
    header("location: register_view.php?error=닉네임이 비어있습니다");
    exit();
  }
  else if(empty($pass1))
  {
    header("location: register_view.php?error=비밀번호가 비어있습니다");
    exit();
  }
  else if(empty($pass2))
  {
    header("location: register_view.php?error=비밀번호(확인)가 비어있습니다");
    exit();
  }
  else if($pass1 !== $pass2)
  {
    header("location: register_view.php?error=비밀번호가 일치하지 않습니다");
    exit();
  }
  else
  {
    $pass1 = password_hash($pass1, PASSWORD_DEFAULT);
    $sql_same = "SELECT * FROM member where mb_id = '$user_id' and mb_nick = '$user_nick'";
    $order = mysqli_query($db, $sql_same);

    if(mysqli_num_rows($order) > 0)
    {
      header("location: register_view.php?error=아이디 또는 닉네임이 이미 존재합니다");
      exit();
    }
    else
    {
      $sql_save = "insert into member(mb_id, mb_nick, password) values('$user_id','$user_nick','$pass1')";
      $result = mysqli_query($db, $sql_save);

      if($result)
      {
        header("location: register_view.php?success=성공적으로 회원가입 되었습니다");
        exit();
      }
      else
      {
        header("location: register_view.php?error=회원가입에 실패하였습니다");
        exit();
      }
    }
  }
}
else
{
  header("location: register_view.php?error=가입에 실패하였습니다");
  exit();
}



?>