<?php
  require_once("dbtools.inc.php");
  

  $account = $_POST["account"];
  $password = $_POST["password"];
  $email = $_POST["email"]; 


  $link = create_connection();
			

  $sql = "SELECT * FROM user Where account = '$account'";
  $result = execute_sql($link, "album", $sql);


  if (mysqli_num_rows($result) != 0)
  {

    mysqli_free_result($result);
		

    echo "<script type='text/javascript'>";
    echo "alert('您所指定的账号已经有人使用，请使用其它账号');";
    echo "history.back();";
    echo "</script>";
  }
	

  else
  {

    mysqli_free_result($result);
		

    $sql = "INSERT INTO user (account, password,
            email) VALUES ('$account', '$password','$email')";

    $result = execute_sql($link, "album", $sql);
  }
	

  mysqli_close($link);
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Successed</title>
    <link rel="stylesheet" href="css/style1.css">
  </head>
  <body>
  <header id="header1">
    <h1><a href="spark.html">SPARK</a></h1>
  </header>

  <div id="lr">
    <div id="a1">
      <a  href="login.html">login </a>
      <a>  | </a>
      <a href="register.html">register</a>
    </div>
  </div>

  <div id="main">
    <div id="m1">
      <p align="center">register successed<br>
        account：<font color="#FF0000"><?php echo $account ?></font><br>
        password：<font color="#FF0000"><?php echo $password ?></font><br>
        click to <a href="login.html">login </a>
      </p>
    </div>
  </div>

  </body>
</html>