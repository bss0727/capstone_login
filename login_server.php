<?php

include('db.php');

if(isset($_POST['user_id'])&& isset($_POST['pass1']))
{
  $user_id = mysqli_real_escape_string($db, $_POST['user_id']);
  $pass1 = mysqli_real_escape_string($db, $_POST['pass1']);

  if(empty($user_id))
  {
    header("location: login_view.php?error=아이디가 비어있습니다");
    exit();
  }
  else if(empty($pass1))
  {
    header("location: login_view.php?error=비밀번호가 비어있습니다");
    exit();
  }
  else
  {
    $sql = "select * from member where mb_id = '$user_id'";
    $result = mysqli_query($db, $sql);

    if(mysqli_num_rows($result) === 1)
    {
      $row = mysqli_fetch_assoc($result);
      $hash = $row['password'];

      if(password_verify($pass1, $hash))
      {
        header("location: mypage/mypage.php");
        exit();
      }
      else
      {
        header("location: login_view.php?error=로그인에 실패했습니다");
        exit();
      }
    }
    else
    {
      header("location: login_view.php?error=아이디 또는 비밀번호를 다시 확인해주십시오");
      exit();
    }
  }
}
else
{
  header("location: login_view.php?error=로그인 실패");
  exit();
}



?>