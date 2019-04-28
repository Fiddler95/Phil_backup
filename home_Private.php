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

$user = $_SESSION['name'];

//recupero il livello di studi dell'utente

$sql = "SELECT Knowledge_lvl FROM users WHERE Username = '$user'";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result);
$level = $row['Knowledge_lvl'];
if (is_null($level)){
    $control = "block";
}
else{
    $control = "none";
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
                    //var filtro = $("select#Filter option:selected").val();
                    window.location = "show_results.php?tag="+tag;//+"&filter="+filtro;
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
    <a href="about.php">About Us</a>
    <a href="logout.php" style="float: right">Logout</a>
    <a href="profile.php" style="float: right">Profile</a>
</div>

<div id="Survey_alert" class="modal" style="display: <?php echo $control ?>; overflow: auto">
    <!-- Modal Content -->
    <form class="modal-info-content animate">
        <div class="containerForm" style="height: fit-content">
            <span onclick="document.getElementById('Survey_alert').style.display='none';document.body.style.overflowY = 'auto';" class="close" title="Chiudi">&times;</span>
            <p id="title" style="font-size: larger; margin-top: 0"><b>Please Complete the Survey</b></p>
            <p id="content">Hello <?php echo $user ?> and welcome to our platform.<br> In order to give you the best experience possible on Philvideos we highly recommend that you complete the survey on your level of knowledge that you can find at clicking at the botton below.</p>
            <a href="survey.php" style="color: black">Complete Your Survey</a>
        </div>
    </form>
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
<div class="footer">If you need help write a mail at the address <strong>m.borinato@yahoo.it</strong></div>
</body>
</html>

