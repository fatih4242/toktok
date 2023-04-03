<?php

class Video
{
    static function  UploadVideo($video_file){
        $allowedExts = array("jpg", "jpeg", "gif", "png", "mp3", "mp4", "wma");
        $extension = pathinfo($video_file['name'], PATHINFO_EXTENSION);

        if ((($video_file["type"] == "video/mp4")
                || ($video_file["type"] == "audio/mp3")
                || ($video_file["type"] == "audio/wma")
                || ($video_file["type"] == "image/pjpeg")
                || ($video_file["type"] == "image/gif")
                || ($video_file["type"] == "image/jpeg"))

            && in_array($extension, $allowedExts))
        {
            if ($video_file["error"] > 0){
                echo "Return Code: " . $video_file["error"] . "<br />";
            }
            else {

                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/media/uploads/" . $video_file["name"];
                move_uploaded_file($video_file["tmp_name"], $uploadDir);
                $uploadDir = base_url . "/media/uploads/" . $video_file["name"];
                return $uploadDir;

            }
        }
        else { echo "Invalid file"; }
    }


}