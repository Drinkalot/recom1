<?php
  require_once("dbtools.inc.php");
  
  //建立连接
  $link = create_connection();
	  
  if (!isset($_POST["album_id"]))
  {
    $album_id = $_GET["album_id"];
	           
    //取得相册信息
    $sql = "SELECT name, owner FROM album WHERE id = $album_id";
    $result = execute_sql($link, "album", $sql);
    $row = mysqli_fetch_object($result);
    $album_name = $row->name;
    $album_owner = $row->owner;
	  

    mysqli_free_result($result);
  }
  else
  {
  	$album_id = $_POST["album_id"];
  	$album_owner = $_POST["album_owner"];

  	session_start();
    $login_user = $_SESSION["login_user"];

    if (isset($login_user) && $album_owner == $login_user)	
    {
      for ($i = 0; $i <= 3; $i++)
      {
        if ($_FILES["myfile"]["name"][$i] != "")
        {
          $src_file = $_FILES["myfile"]["tmp_name"][$i];
          $src_file_name = $_FILES["myfile"]["name"][$i];
          $src_ext = strtolower(strrchr($_FILES["myfile"]["name"][$i], "."));
          $desc_file_name = uniqid() . ".jpg";
	
          $photo_file_name = "./Photo/$desc_file_name";
          $thumbnail_file_name = "./Thumbnail/$desc_file_name";
	
          resize_photo($src_file, $src_ext, $photo_file_name, 600);
          resize_photo($src_file, $src_ext, $thumbnail_file_name, 150);
          $d=rand(1,10000);
          $sql = "insert into photo(id,name, filename, album_id) values('$d','$src_file_name', '$desc_file_name', $album_id)";
          execute_sql($link, "album", $sql);
        }
      }
    }


    mysqli_close($link);
  
    header("location:showAlbum.php?album_id=$album_id");
  }
  
  function resize_photo($src_file, $src_ext, $dest_name, $max_size)
  {
  	switch ($src_ext)
  	{
  	  case ".jpg":
  	    $src = imagecreatefromjpeg($src_file);
  	    break;
  	  case ".png":
  	    $src = imagecreatefrompng($src_file);
  	    break;
  	  case ".gif":
  	    $src = imagecreatefromgif($src_file);
  	    break;
  	}

    $src_w = imagesx($src);
    $src_h = imagesy($src);
	  

    if($src_w > $src_h)
    {
      $thumb_w = $max_size;
      $thumb_h = intval($src_h / $src_w * $thumb_w);
    }
    else
    {
      $thumb_h = $max_size;
      $thumb_w = intval($src_w / $src_h * $thumb_h);
    }
	  
    $thumb = imagecreatetruecolor($thumb_w, $thumb_h);
	

    imagecopyresized($thumb, $src, 0, 0, 0, 0, $thumb_w, $thumb_h, $src_w, $src_h);
	   

    imagejpeg($thumb, $dest_name, 100);


    imagedestroy($src);
    imagedestroy($thumb); 
  }
?>
<!doctype html>
<html>
  <head>
    <title>upload</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/stylehome.css">
  </head>
  <body>
  <div id="d1">
    <div id="d2">
      <a id="po1" href="spark.html">SPARK</a>

      <a id="po5" href="login.html"><img src="img/登录.png" width="113" height="113"></a><br><br><br>
    </div>
  </div>
	 <p align = "center">
	  <?php echo $album_name ?>
	 </P>
        <form method="post" action="uploadPhoto.php" enctype="multipart/form-data">
         <p align="center">
		  <input type="file" name="myfile[]" size="50"><br>
	      <input type="hidden" name="album_id" value="<?php echo $album_id ?>">
	      <input type="hidden" name="album_owner" value="<?php echo $album_owner ?>">
	      <input type="submit" value="上传">
	      <input type="reset" value="重新设置">
		 </p>
	    </form>
     <p align = "center"> 
	  <a href="showAlbum.php?album_id=<?php echo $album_id ?>">
        Back <?php echo $album_name ?></a>
	 </p>
  </body>
</html>