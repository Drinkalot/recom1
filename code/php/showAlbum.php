<!doctype html>
<html>
  <head>
  	<title>show</title>
    <link rel="stylesheet" href="css/stylehome.css">
    <meta charset="utf-8">
    <script type="text/javascript">
      function DeletePhoto(album_id, photo_id)
      {
        if (confirm("请确认是否删除此相片？"))
          location.href = "delPhoto.php?album_id=" + album_id + "&photo_id=" + photo_id;
      }
    </script>
  </head>	
  <body>

  <div id="d1">
    <div id="d2">
      <a id="po1" href="spark.html">SPARK</a>

      <a id="po5" href="login.html"><img src="img/登录.png" width="113" height="113"></a><br><br><br>
    </div>
  </div>

    <?php 
      require_once("dbtools.inc.php");
      $album_id = $_GET["album_id"]; 
      

	    $login_user = "";
	    session_start();
	    if (isset($_SESSION["login_user"]))
        $login_user = $_SESSION["login_user"];
      

      $link = create_connection();


      $sql = "SELECT name, owner FROM album WHERE id = $album_id";
      $result = execute_sql($link, "album", $sql);
      $row = mysqli_fetch_object($result);
      $album_name = $row->name;
      $album_owner = $row->owner;
      
      echo "<p align='center'>$album_name</p>";
													

      $sql = "SELECT id, name, filename FROM photo WHERE album_id = $album_id";
      $result = execute_sql($link, "album", $sql);
	    $total_photo = mysqli_num_rows($result);
	  
      echo "<table border='0' align='center'>";


      $photo_per_row = 5;
      					

      $i = 1;
      while ($row = mysqli_fetch_assoc($result))
      {
      	$photo_id = $row["id"];
      	$photo_name = $row["name"];
      	$file_name = $row["filename"];
      	
        if ($i % $photo_per_row == 1)
          echo "<tr align='center'>";
        
        echo "<td width='160px'><a href='photoDetail.php?album=$album_id&photo=$photo_id'>
              <img src='Thumbnail/$file_name' style='border-color:Black;border-width:1px'>
              <br>$photo_name</a>";
        
        if ($album_owner == $login_user)
          echo "<br><a href='editPhoto.php?photo_id=$photo_id'>edit</a>
               <a href='#' onclick='DeletePhoto($album_id, $photo_id)'>delete</a>";
          
        echo "<p></td>";
        
        if ($i % $photo_per_row == 0 || $i == $total_photo)
          echo "</tr>";
        
        $i++;
      }
      
      echo "</table>" ;
											  		

      mysqli_free_result($result);
      mysqli_close($link);
      
      echo "<hr><p align='center'>";
      if ($album_owner == $login_user)
        echo "<a href='uploadPhoto.php?album_id=$album_id'>upload</a> ";
    ?>
    <a href='index.php'>home</a>
  </body>                                                                                 
</html>