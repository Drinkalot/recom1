<!doctype html>
<html>
  <head>
    <title>show</title>
    <meta charset="utf-8">
  </head>	
  <body>
    <?php
      require_once("dbtools.inc.php");
      $album_id = $_GET["album"];
      $photo_id = $_GET["photo"];
      

      $link = create_connection();
      

      $sql = "SELECT name FROM album WHERE id = $album_id";
      $result = execute_sql($link, "album", $sql);
      $album_name = mysqli_fetch_object($result)->name;
      
      echo "<p align='center'>$album_name</p>";
      

      $sql = "SELECT filename, comment FROM photo WHERE id = $photo_id";
      $result = execute_sql($link, "album", $sql);
      $row = mysqli_fetch_object($result);
      $file_name = $row->filename;
      $comment = $row->comment;
      
      echo "<p align='center'><img src='Photo/$file_name'
            style='border-style:solid;border-width:1px'></p>";
      echo "<p align='center'>$comment</p>";
		  

      $sql = "SELECT a.id, a.filename FROM (SELECT id, filename FROM photo 
              WHERE album_id = $album_id AND (id <= $photo_id)
              ORDER BY id desc limit 3) a ORDER BY a.id";
      $result = execute_sql($link, "album", $sql);
      
      echo "<hr><p align='center'>";
      while ($row = mysqli_fetch_assoc($result))
      {
      	if ($row["id"] == $photo_id)
      	{
      	  echo "<img src='Thumbnail/" . $row["filename"] .
      	       "' style='border-style:solid;border-color: Red;border-width:2px'>　";
      	}
      	else
      	{
      	  echo "<a href='photoDetail.php?album=$album_id&photo=" . $row["id"] .
      	       "'><img src='Thumbnail/" . $row["filename"] .
      	       "' style='border-style:solid;border-color:Black;border-width:1px'></a>　";
      	}
      }
      
      $record_to_get = 5 - mysqli_num_rows($result);
      $sql = "SELECT id, filename FROM photo WHERE album_id = $album_id AND (id > $photo_id)
              ORDER BY id limit $record_to_get";
      $result = execute_sql($link, "album", $sql);
      
      while ($row = mysqli_fetch_assoc($result))
      {
      	echo "<a href='photoDetail.php?album=$album_id&photo=" . $row["id"] .
      	     "'><img src='Thumbnail/" . $row["filename"] .
      	     "' style='border-style:solid;border-color:Black;border-width:1px'></a>　";
      }
      
      echo "</p>";
		  		

      mysqli_free_result($result);
      mysqli_close($link);
    ?>
    <p align="center">
      <a href="index.php">home</a>
      <a href="showAlbum.php?album_id=<?php echo $album_id ?>"><?php echo $album_name ?>
    </p>
  </body>                                                                                 
</html>