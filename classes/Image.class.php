<?php
class Image{

  public static function UploadImage($image)
  {
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/media/uploads/";
    
    $target_file = $target_dir . basename($image["name"]);

    $upload_dir = base_url . "/media/uploads/" . basename($image["name"]);
    $uploadOk = 1;



    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {

      if (move_uploaded_file($image["tmp_name"], $target_file)) {
        //echo "The file ". htmlspecialchars( basename( $image["name"])). " has been uploaded.";
        return $upload_dir;
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
    }
    return $upload_dir;
  }
}
?>