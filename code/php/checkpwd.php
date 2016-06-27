<?php
  require_once("dbtools.inc.php");
  header("Content-type: text/html; charset=utf-8");
	
  //取得表單資料
  $account = $_POST["account"]; 	
  $password = $_POST["password"];


  $link = create_connection();

  $sql = "SELECT * FROM user Where account = '$account' AND password = '$password'";
  $result = execute_sql($link, "album", $sql);


  if (mysqli_num_rows($result) == 0)
  {

    mysqli_free_result($result);
	

    mysqli_close($link);
		

    echo "<script type='text/javascript'>";
    echo "alert('账号或密码错误，请查明后再登录');";
    echo "history.back();";
    echo "</script>";
  }

  else
  {

   // $id = mysqli_fetch_object($result)->id;
    session_start();
    $row = mysqli_fetch_object($result);
    $_SESSION["login_user"] = $row->account;
    $_SESSION["login_name"] = $row->name;

    mysqli_free_result($result);
		

    mysqli_close($link);

    //setcookie("id", $id);
   // setcookie("passed", "TRUE");
    header("location:index.php");
  }
?>