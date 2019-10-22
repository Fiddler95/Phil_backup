<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 18/08/2018
 * Time: 19:39
 */
session_start();
include "connect.php";
include "functions.php";
if(!isset($_SESSION['name'])){
    header("Location: home.php");
}

$user = $_SESSION['name'];
/**
$sql = "SELECT url FROM videos";
$result = mysqli_query($conn,$sql);
$api_key = 'AIzaSyDu_jGBX40owZ7t16ClQQ4sYJwO-KssnbU';

while($row =  mysqli_fetch_assoc($result)){
    $video_url = trim($row['url']);
    $url_db = $row['url'];
    $api_url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet%2CcontentDetails%2Cstatistics%2Cplayer&id=' . getYouTubeVideoID($video_url) . '&key=' . $api_key;
    $data = json_decode(file_get_contents($api_url));
    $durata = $data->items[0]->contentDetails->duration;
    preg_match_all('!\d+!', $durata, $matches);
    $var = implode(' ', $matches[0]);
    $pieces = explode(" ", $var);
    $minuti = $pieces[0];
    $secondi = $pieces[1];
    $sql = " INSERT INTO durata_video (Url,Durata) VALUES ('$url_db','$minuti')";
    $result1 = mysqli_query($conn, $sql);
}
*/
?>

