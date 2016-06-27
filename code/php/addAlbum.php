<?php
  if (isset($_POST["album_name"]))
  {
    require_once("dbtools.inc.php");
    $album_name = $_POST["album_name"];
  	

    session_start();
    $login_user = $_SESSION["login_user"];


    $link = create_connection();



    $sql = "SELECT ifnull(max(id), 0) + 1 AS album_id FROM album";
    $result = execute_sql($link, "album", $sql);
    $album_id = mysqli_fetch_object($result)->album_id;

    $sql = "INSERT INTO album(id, name, owner)
      VALUES($album_id, '$album_name', '$login_user')";

    execute_sql($link, "album", $sql);
  	

    mysqli_free_result($result);
    mysqli_close($link);
    
    header("location:showAlbum.php?album_id=$album_id");
  }
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>add</title>
    <link rel="stylesheet" href="css/stylehome.css">
  </head>
  <body>
  <div class="d1">
    <div id="d2">
      <a id="po1" href="spark.html">SPARK</a>

      <a id="po5" href="login.html"><img src="img/登录.png" width="113" height="113"></a><br><br><br>
    </div>
  </div>
    <form class="add1" action="addAlbum.php" method="post">
      <table align="center">
        <tr> 
          <td> 
            name：
          </td>
          <td>
            <input type="text" name="album_name" size="15">
            <input type="submit" value="add">
          </td>
        </tr>
        <tr>
          <td colspan="3" align="center">
            <br><a href="index.php">home</a>
          </td>	
        </tr>
      </table>
    </form>
  </body>
</html>