<?php
  require_once("dbtools.inc.php");
  
  $album_id = $_GET["album_id"];
  $photo_id = $_GET["photo_id"];
  

  session_start();
  $login_user = $_SESSION["login_user"];
  

  $link = create_connection();
  

  $sql = "SELECT filename FROM photo WHERE id = $photo_id
          AND EXISTS(SELECT '*' FROM album WHERE id = $album_id AND owner = '$login_user')";
  $result = execute_sql($link, "album", $sql);
  
  $file_name = mysqli_fetch_object($result)->filename;
  $photo_path = realpath("./Photo/$file_name");
  $thumbnail_path = realpath("./Thumbnail/$file_name");
  
  if (file_exists($photo_path))
    unlink($photo_path);
      
  if (file_exists($thumbnail_path))
    unlink($thumbnail_path);

  $sql = "DELETE FROM photo WHERE id = $photo_id
          AND EXISTS(SELECT '*' FROM album WHERE id = $album_id AND owner = '$login_user')";
  execute_sql($link, "album", $sql);

  mysqli_free_result($result);
  mysqli_close($link);
  
  header("location:showAlbum.php?album_id=$album_id");
?>