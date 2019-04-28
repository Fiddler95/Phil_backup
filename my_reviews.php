<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 09/04/2018
 * Time: 10:17
 */
session_start();

include "connect.php";
include "functions.php";
if(!isset($_SESSION['name'])){
    header("Location: home.php");
}
$user = $_SESSION['name'];

?>

<!DOCTYPE html>
<html>
    <head>
        <link href="style.css" rel = "stylesheet" type = "text/css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                var video_count=7;
                $(document).ajaxStart(function(){
                    $("#spinner").css("display", "block");
                });
                $(document).ajaxComplete(function(){
                    $("#spinner").css("display", "none");
                });
                $("#loadBtn").click(function() {
                    video_count = video_count + 7;
                    $("#videosContainer").load("load_video.php", {
                        video_new_count: video_count
                    });
                });
            });

        </script>
    </head>

    <body>
    <!-- creazione della barra di navigazione  -->
        <div class="topnav">
            <a href="home.php">Home</a>
            <a class="active" href="my_reviews.php">My Reviews</a>
            <a href="survey.php">Survey</a>
            <a href="about.php">About Us</a>
            <a href="logout.php" style="float: right">Logout</a>
            <a href="profile.php" style="float: right">Profile</a>
        </div>

        <div class ="main_container">
            <div id="spinner" class="spinner" style="display:none;">
                <img id="img-spinner" src="pics\spinner.GIF" alt="Loading"/>
            </div>
            <div id="videosContainer" class="GreyContainer">
            <?php
                $sql = "SELECT `Group_id` FROM `groups_of_users` WHERE `User` = '$user'";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result) >0)
                {
                    $row = mysqli_fetch_assoc($result);
                    $groupId = $row['Group_id'];

                    $sql = "SELECT `Url` FROM `videos` WHERE `Group_id` = '$groupId' LIMIT 7";
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
            ?>
            </div>
            <br>
            <button id="loadBtn" class="submitBtn">Load more videos</button>
        </div>

    </body>
</html>
