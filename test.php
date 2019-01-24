<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 22/12/2018
 * Time: 17:59
 */

session_start();
include "connect.php";
include "functions.php";
include "fields.php";
$super = 'n3llo';
if(!isset($_SESSION['name']) or $_SESSION['name']!== $super){
    header("Location: home.php");
}

$sql = "SELECT `Group_id` FROM `groups_of_users` WHERE `User` = '$super'";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) >0)
{
    $row = mysqli_fetch_assoc($result);
    $groupId = $row['Group_id'];

    $sql = "SELECT `Url` FROM `videos` WHERE `Group_id` = '$groupId' LIMIT 16";
    $resultUrl = mysqli_query($conn, $sql);
    if(mysqli_num_rows($resultUrl) >0) {
        while($row = mysqli_fetch_assoc($resultUrl))
        {
            echo "Url originale = {$row['Url']}";
            $video_url = trim($row['Url']);
            echo "<br>";
            echo "Url trimmato = $video_url";
            echo "<br>";
            $cicca = getYouTubeVideoID($video_url);
            echo "Url ulteriormente trimmato = $cicca";
            echo "<br>";
            $video_url = explode("&", $video_url);
            echo "Url trimmato come vorrei = {$video_url[0]}";
            echo "<br>";
            $api_key = 'AIzaSyDu_jGBX40owZ7t16ClQQ4sYJwO-KssnbU';
            $api_url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet%2CcontentDetails%2Cstatistics&id=' . getYouTubeVideoID($video_url) . '&key=' . $api_key;

            $data = json_decode(file_get_contents($api_url));
            // Accessing Video Info
            //futuro controllo sulle info del video, se vuote saltare il video e possibilmente eliminarlo da db
            echo "<h2>" . $data->items[0]->snippet->title . "</h2>";
            echo "<br>"; echo "<br>";echo "<br>"; echo "<br>";


        }
    }
    else {
        echo "non sono presenti video in questo gruppo";
    }
}
else{
    echo "Username non corrispondente a nessun gruppo";
}