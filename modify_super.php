<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 02/10/2019
 * Time: 09:46
 */

session_start();
include "connect.php";
include "functions.php";
include 'newPhilPapers.php';
include 'fields.php';
if(!isset($_SESSION['name'])){
    header("Location: home.php");
}

$url =  mysqli_real_escape_string($conn, $_GET["id"]);
$sql = "SELECT * FROM reviews WHERE URL = '$url'";
$resultUrl = mysqli_query($conn, $sql);
while($row = mysqli_fetch_assoc($resultUrl)) {
    echo "Recensione effettuata da: ";
    print_r($row['Username']);
    $video_url = trim($row['Url']);
    echo " <button id='" . $video_url . "' class=\"reviewBtn\" style='background-color: #408b40' onClick=\"document.location.href='single_review.php?id=" . $video_url . "&super=" . $row['Username'] . "'\">Modify Review</button>";
    echo "<br>";
}