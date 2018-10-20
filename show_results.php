<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 18/08/2018
 * Time: 19:39
 */
session_start();
include 'connect.php';
include 'functions.php';
if(!isset($_SESSION['name'])){
    header("Location: home.php");
}
$tag = $_GET["tag"];

?>

<!DOCTYPE html>
<head>
    <link href="style.css" rel = "stylesheet" type = "text/css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
<!-- creazione della barra di navigazione  -->
<div class="topnav">
    <a class="active" href="home_Private.php">Home</a>
    <a href="my_reviews.php">My Reviews</a>
    <a href="survey.php">Survey</a>
    <a href="#about">About</a>
    <a href="logout.php" style="float: right">Logout</a>
    <a href="profile.php" style="float: right">Profilo</a>
</div>
<br>
<div class ="main_container">
    <div id="videosContainer" class="GreyContainer">
        <?php
        $sql = "SELECT `Url` FROM `tags` WHERE `tag` = '$tag' GROUP BY Url";
        $resultUrl = mysqli_query($conn, $sql);
        if(mysqli_num_rows($resultUrl) >0) {
            display_vid_in_show_results($resultUrl);
        }
        else {
            echo "non sono presenti video relativi alla ricerca effettuata";
        }
        ?>
    </div>
</div>

</body>
</html>
