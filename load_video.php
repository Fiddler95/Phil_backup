<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 19/05/2018
 * Time: 11:22
 */

//pagina da chiamare per la raccolta asincrona di più video nella pagina my_reviews.php
session_start();
include "connect.php";
include "functions.php";
if(!isset($_SESSION['name'])){
    header("Location: home.php");
}


$user = $_SESSION['name'];
$limit = $_POST['video_new_count'];
$sql = "SELECT `Group_id` FROM `groups_of_users` WHERE `User` = '$user'";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) >0)
{
    $row = mysqli_fetch_assoc($result);
    $groupId = $row['Group_id'];

    $sql = "SELECT `Url` FROM `videos` WHERE `Group_id` = ' $groupId' LIMIT $limit";
    $resultUrl = mysqli_query($conn, $sql);
    if(mysqli_num_rows($resultUrl) >0) {
        display_vid_in_my_reviews($resultUrl,$conn,$user);
    }
    else {
        echo "non sono presenti video in questo gruppo";
    }
}
else{
    echo "Username non corrispondente a nessun gruppo";
}