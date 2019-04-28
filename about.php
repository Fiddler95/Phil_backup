<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 15/03/2019
 * Time: 14:24
 */
session_start();
include "connect.php";
if(!isset($_SESSION['name'])){
    header("Location: home.php");
}

$user = $_SESSION['name'];

?>
<!DOCTYPE html>
<head>
    <link href="style.css" rel = "stylesheet" type = "text/css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script>
        /*
            Funzione per il caricamento asincrono dei suggerimenti
         */
        $(document).ready(function(){
            function load_tag_ajax(query,filter)
            {
                $.ajax({
                    url:"fetch_tag_ajax.php",
                    method:"POST",
                    data:{query:query,filter:filter},
                    success:function(data)
                    {
                        $('#result').html(data);
                    }
                });
            }

            $('#search-bar').keyup(function(){
                var search = $(this).val();
                var filter = $("select#Filter option:selected").val();
                if(search != '')
                {
                    load_tag_ajax(search,filter);
                }
                else//serve per ricaricare la barra vuota se cancello l'input
                {
                    $('#result').html('');
                }
            });
        });
    </script>

    <script type="text/javascript">
        /*
            Funzione di redirect alla pagina dei risultati se clicko enter
         */
        $(document).ready(function() {

            $('#search-bar').keydown(function(e) {
                if (e.which === 13) {
                    var tag = $(this).val();
                    var filtro = $("select#Filter option:selected").val();
                    window.location = "show_results.php?tag="+tag+"&filter="+filtro;
                    return false;
                }
            });
        });
    </script>

</head>

<body>
<!-- creazione della barra di navigazione  -->
<div class="topnav">
    <a href="home_Private.php">Home</a>
    <a href="my_reviews.php">My Reviews</a>
    <a href="survey.php">Survey</a>
    <a class="active" href="about.php">About Us</a>
    <a href="logout.php" style="float: right">Logout</a>
    <a href="profile.php" style="float: right">Profile</a>
</div>


<div class ="main_container">
    <div id="videosContainer" class="GreyContainer">
        <div class="top_bar_img_container">
            <img class="img_search_bar" src="pics/us.JPG" alt="foo" style="width: 35%; height: 20%; border-radius: 20%;" title="From left to right:&#xA Nicolò Metti, videomaker, ex student in philosophy (master)&#xA Marco Borinato, computer science student (master)&#xA Giambattista Genzone, tutor DSA &#xA Carlo Penco, Philosophy teacher ">
        </div>
        <div style="text-align:left; font-family: Cambria; line-height: 1.8;">

            <span style="font-weight: bold">“WE”</span><br>
                We are a small group, part of a bigger one: students and teachers of Genoa University who collaborate with us. We decided to begin this project to foster independent and autonomous capacities of research in students with the help of videos. Youtube is full of videos, but sometimes we need guidance, we need a filter. We would like to offer a filter: selected videos among thousands are classified with our ontology, in order to permit different strategies of research, based on individual preferences.<br>

                Our aim is to cover all areas of study, but we need time. We begun with Philosophy videos, on the ground that very nice and complex information is already at our disposal with philpapers.org, to which we connect our videos. But after that we are planning to cover, with the help of experts, other areas of Humanities.<br>

            <br><span style="font-weight: bold">“PHILVIDEOS”</span><br>
                Let us explain PHILVIDEOS: each video, after selection, is classified, on the one hand, with cognitive categories (area of study, specific content, and so on) and, on the other hand, with its general properties: clarity, efficacy, difficulty and so on. While you may enter the research bar with any name or topic, you may access a “sharp search” where we offer some more specific way of selecting what is needed. Subtitles are mostly provided by Youtube automatic translation (often in different languages). Each video is connected with information on published papers or books on the subject taken from PHILPAPERS.ORG. Although there are tons of information of this kind, philpapers is the richest and more reliable source of information for Philosophy, linking also to other internet souces (like Stanford Encyclopedia of Philosophy of Internet Encylclopedia of Philosophy).<br>

                We are just at the beginning of a big enterprise. For now…<br>

                Just click, watch and … learn!<br>

            <br>Carlo, Giamba, Marco, Nicolò,<br>

        </div>
    </div>
</div>

</body>
</html>
