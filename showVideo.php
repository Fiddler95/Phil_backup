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
$search1 = "%".$search."%";
$url =  mysqli_real_escape_string($conn, $_GET["id"]);
$tipo =  mysqli_real_escape_string($conn, $_GET["tipo"]);
$user= $_SESSION['name'];
$api_key = 'AIzaSyDu_jGBX40owZ7t16ClQQ4sYJwO-KssnbU';

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
    <a class="active" href="home_Private.php">Home</a>
    <a href="my_reviews.php">My Reviews</a>
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

        /**
         * POSSIBILE CONVERSIONE DI QUESTA PARTE SOTTO IN UNA CHIAMATA AJAX PER CARICARE I CORRELATI IN MANIERA ASINCRONA
         */

        echo "<div id=\"correlatiRicerca\" class=\"correlatiContainer\">";
        echo "<p>Other videos</p>";
        $ricerca = "SELECT `Url` FROM argomento WHERE Level_1 LIKE '$search1' UNION SELECT `Url` FROM universita WHERE Nome LIKE '$search1' UNION SELECT `Url` FROM speaker WHERE Nome LIKE '$search1' UNION SELECT `Url` FROM autori WHERE Nome LIKE '$search1' GROUP BY Url LIMIT 10";
        $sql = stripslashes($ricerca);
        $resultUrl = mysqli_query($conn, $sql) or die("Error in query for ricerca correlati");

        while($row = mysqli_fetch_assoc($resultUrl)) {

            $video_url = trim($row['Url']);
            $api_url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet%2CcontentDetails%2Cstatistics&id=' . getYouTubeVideoID($video_url) . '&key=' . $api_key;

            $data = json_decode(file_get_contents($api_url));
            // Accessing Video Info

            if(!empty($data->items[0]) and $video_url!=$url){
                echo "<div class='suggestedVideoContainer'>";
                echo "<div class='suggestedVideoHolder'><img src='". $data->items[0]->snippet->thumbnails->medium->url ."'></div>";
                echo "<p>".$data->items[0]->snippet->title."</p>";
                echo "</div>";
            }
        }
        echo "</div>";

        if(strlen($tipo)>0){
            echo "<div id=\"correlatiTipologia\" class=\"correlatiContainer\">";
            echo "<p>Correlati Tipologia</p>";
            $correlatiTipo = "SELECT tipologia_video.Url, voti_soggettivi.Voto FROM tipologia_video INNER JOIN  voti_soggettivi ON tipologia_video.Principale = '$tipo' AND voti_soggettivi.Singolo_campo = 'Quality' AND voti_soggettivi.Voto > 3 AND tipologia_video.Url = voti_soggettivi.Url GROUP BY tipologia_video.Url ORDER BY voti_soggettivi.Voto LIMIT 10 ";
            $sql1 = stripslashes($correlatiTipo);
            $resultUrl1 = mysqli_query($conn, $sql1) or die("Error in query for tipologia correlati");

            while($row = mysqli_fetch_assoc($resultUrl1)) {

                $video_url = trim($row['Url']);
                $api_url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet%2CcontentDetails%2Cstatistics&id=' . getYouTubeVideoID($video_url) . '&key=' . $api_key;

                $data = json_decode(file_get_contents($api_url));
                // Accessing Video Info

                if(!empty($data->items[0]) and $video_url!=$url){
                    echo "<div class='suggestedVideoContainer'>";
                    echo "<div class='suggestedVideoHolder'><img src='". $data->items[0]->snippet->thumbnails->medium->url ."'></div>";
                    echo "<p>".$data->items[0]->snippet->title."</p>";
                    echo "</div>";
                }
            }
            echo "</div>";
        }

        ?>
    </div>
</body>
</html>
