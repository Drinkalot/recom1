<!doctype html>
<html>
  <head>
    <title>home</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/stylehome.css">
    <script type="text/javascript">
      function DeleteAlbum(album_id)
      {
        if (confirm("请确认是否删除此相册？"))
          location.href = "delAlbum.php?album_id=" + album_id;
      }
    </script>
  </head>	
  <body>

  <div id="d1">
    <div id="d2">
      <a id="po1" href="index.php">SPARK</a>
      <a id="po5" href="login.html"><img src="img/登录.png" width="113" height="113"></a><br><br><br>
    </div>
  </div>

    <?php
      require_once("dbtools.inc.php");
      

      session_start();
	  if (isset($_SESSION["login_user"]))
	  {
        $login_user = $_SESSION["login_user"];
        $login_name = $_SESSION["login_name"];
	  }
					

      $link = create_connection();
														

      $sql = "SELECT id, name, owner FROM album order by name";
      $album_result = execute_sql($link, "album", $sql);
      

      $total_album = mysqli_num_rows($album_result);
      
      echo "<p align='center'>$total_album Albums</p>";
      echo "<table border='0' align='center'>";


      $album_per_row = 5;
      					

      $i = 1;
      while ($row = mysqli_fetch_assoc($album_result))
      {

      	$album_id = $row["id"];
      	$album_name = $row["name"];
      	$album_owner = $row["owner"];
      	
      	$sql = "SELECT filename FROM photo WHERE album_id = $album_id";
      	$photo_result = execute_sql($link, "album", $sql);
      	

      	$total_photo = mysqli_num_rows($photo_result);
      	

      	if ($total_photo > 0)
          $cover_photo = mysqli_fetch_object($photo_result)->filename;
      	else
      	  $cover_photo = "None.png";
      	

      	mysqli_free_result($photo_result);
      	
        if ($i % $album_per_row == 1)
          echo "<tr align='center' valign='top'>";
          
        echo "<td width='160px'>
              <a href='showAlbum.php?album_id=$album_id'>
              <img src='Thumbnail/$cover_photo' style='border-color:Black;border-width:1px'>
              <br>$album_name</a><br>$total_photo Pictures";
        
        if (isset($login_user) && $album_owner == $login_user)
        {
          echo "<br><a href='editAlbum.php?album_id=$album_id'>edit</a>
                <a href='#' onclick='DeleteAlbum($album_id)'>delete</a>";
        }
        
        echo "<p></td>";
        
        if ($i % $album_per_row == 0 || $i == $total_album)
          echo "</tr>";
               
        $i++;
      }
      
      echo "</table>" ;
											  		

      mysqli_free_result($album_result);
      mysqli_close($link);
      
      echo "<hr><p align='center'>";
      
      //若 isset($login_name) 傳回 false，表示使用者尚未登入系統
      if (!isset($login_name))
        echo "<a href='login.html'>login</a>";
      else
      {
        echo "<a href='addAlbum.php'>add</a>
              <a href='logout.php'>logout</a>";
      }
    ?>

  </body>
</html>