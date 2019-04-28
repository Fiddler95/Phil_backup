<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 08/04/2019
 * Time: 10:15
 */

session_start();
include "connect.php";
include "functions.php";
include 'newPhilPapers.php';
include 'fields.php';
if(!isset($_SESSION['name'])){
    header("Location: home.php");
}


$search = mysqli_real_escape_string($conn, $_GET["search"]);
$url = $_GET["id"];
$user= $_SESSION['name'];

?>
<!DOCTYPE html>
<html>
<head>
    <link href="style.css" rel = "stylesheet" type = "text/css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script>
        /**
         * funzione per evitare che HTML5 reindirizzi la pagina sul form
         * non compilato ma lo lasci coperto dalla navbar
         */
        var delay = 0;
        var offset = 150;
        document.addEventListener('invalid', function(e){
            $(e.target).addClass("invalid");
            $('html, body').animate({scrollTop: $($(".invalid")[0]).offset().top - offset }, delay);
        }, true);
        document.addEventListener('change', function(e){
            $(e.target).removeClass("invalid")
        }, true);
    </script>

</head>


<body>
<!-- creazione della barra di navigazione  -->
<div class="topnav">
    <a  href="home_Private.php">Home</a>
    <a class="active" href="my_reviews.php">My Reviews</a>
    <a href="survey.php">Survey</a>
    <a href="about.php">About Us</a>
    <a href="logout.php" style="float: right">Logout</a>
    <a href="profile.php" style="float: right">Profile</a>
</div>

<div id="suggestions" class="modal">
    <!-- Modal Content -->
    <form class="modal-info-content animate">
        <div class="containerForm">
            <span onclick="document.getElementById('suggestions').style.display='none';document.body.style.overflowY = 'auto';" class="close" title="Chiudi">&times;</span>
            <p id="title" style="font-size: larger; margin-top: 0"><b>Info-Box</b></p>
            <p id="content">Errore nel caricamento del testo</p>
        </div>
    </form>
</div>

<div class ="main_container">
    <div id="spinner" class="spinner" style="display:none;">
        <img id="img-spinner" src="pics/spinner.gif" alt="Loading"/>
    </div>
    <div id="reviewContainer" class="GreyContainer">
        <?php
           display_single_video_in_result($url, $search);
        ?>
    </div>
    <div id="Suggerimenti">
        <?php

        ?>
    </div>
</body>
</html>
