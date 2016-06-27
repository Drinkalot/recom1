<?php
  require_once("dbtools.inc.php");
  

  session_start();
  $login_user = $_SESSION["login_user"];
  

  $link = create_connection();
    
  if (!isset($_POST["album_id"]))
  {
    $album_id = $_GET["album_id"];
  														

    $sql = "SELECT name, owner FROM album where id = $album_id";
    $result = execute_sql($link, "album", $sql);
    $row = mysqli_fetch_object($result);
    $album_name = $row->name;
    $album_owner = $row->owner;
      

    mysqli_free_result($result);
		

    mysqli_close($link);
  
    if ($album_owner != $login_user)
    {
      echo "<script type='text/javascript'>";
      echo "alert('您不是相册的主人，无法修改相册名称。$album_owner');";
      echo "</script>";
    }
  }
  else
  {
    $album_id = $_POST["album_id"];
    $album_name = $_POST["album_name"];
    $sql = "UPDATE album SET name = '$album_name'
            WHERE id = $album_id AND owner = '$login_user'";
    execute_sql($link, "album", $sql);
  			

    mysqli_close($link);
    
    header("location:index.php");
  }
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>edit</title>
    <link rel="stylesheet" href="css/stylehome.css">
  </head>
  <body>
  <div id="d1">
    <div id="d2">
      <a id="po1" href="spark.html">SPARK</a>
      <a id="po5" href="login.html"><img src="img/登录.png" width="113" height="113"></a><br><br><br>
    </div>
  </div>
    <form class="add1" action="editAlbum.php" method="post">
      <table align="center">
        <tr> 
          <td> 
            name：
          </td>
          <td>
            <input type="text" name="album_name" size="15"
              value="<?php echo $album_name ?>">
            <input type="hidden" name="album_id" value="<?php echo $album_id ?>">
            <input type="submit" value="update"
              <?php if ($album_owner != $login_user) echo 'disabled' ?>>
          </td>
        </tr>
        <tr>
          <td colspan="2" align="center">
            <br><a href="index.php">home</a>
          </td>	
        </tr>
      </table>
    </form>
  </body>
</html>