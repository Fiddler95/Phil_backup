<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 20/04/2018
 * Time: 17:20
 */
session_start();
include "connect.php";
include "functions.php";
include 'newPhilPapers.php';
if(!isset($_SESSION['name'])){
    header("Location: home.php");
}
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
            function load_tag_ajax(query)
            {
                $.ajax({
                    url:"fetch_tag_ajax.php",
                    method:"POST",
                    data:{query:query},
                    success:function(data)
                    {
                        $('#result').html(data);
                    }
                });
            }
            $('#search-bar').keyup(function(){
                var search = $(this).val();
                if(search != '')
                {
                    load_tag_ajax(search);
                }
                else
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
                    window.location = "show_results.php?tag="+tag;
                    return false;
                }
            });
        });
    </script>

</head>

<body>
<!-- creazione della barra di navigazione  -->
<div class="topnav">
    <a class="active" href="home_Private.php">Home</a>
    <a href="my_reviews.php">My Reviews</a>
    <a href="survey.php">Survey</a>
    <a href="#about">About</a>
    <a href="logout.php" style="float: right">Logout</a>
    <a href="profile.php" style="float: right">Profile</a>
</div>

<div class ="main_container">
    <div class="top_bar_img_container">
        <img class="img_search_bar" src="pics/phils_pic.jpg" alt="foo" />
        <form class="search-container" >
            <input type="text" autocomplete="off" id="search-bar" placeholder="Search">
        </form>
    </div>
    <div id="result"></div>
</div>

</body>
</html>

