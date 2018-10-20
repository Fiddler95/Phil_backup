<?php


/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 07/04/2018
 * Time: 17:44
 */
session_start();
include 'connect.php';
include 'autologin.php';
?>
<!DOCTYPE html>
<html>
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

        <script>
            //funzione per il form modale di inserimento dati
            // Get the modal
            var modal1 = document.getElementById('id01');
            var modal2 = document.getElementById('id02');

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal1) {
                    modal1.style.display = "none";
                }
                else if (event.target == modal2)
                {
                    modal2.style.display = "none";
                }
            }
        </script>
    </head>

    <body>
    <!-- creazione della barra di navigazione  -->
        <div class="topnav">
            <a class="active" href="home.php">Home</a>
            <button class="loginBtn" onclick="document.getElementById('id01').style.display='block';document.body.style.overflow= 'hidden';">Login</button>
        </div>

        <!-- form modale di login, presente solo nella pagina home pubblica-->
        <div id="id01" class="modal">

            <!-- Modal Content -->
            <form class="modal-content animate" action="login.php" method="post">
                <div class="imgcontainer"><img src="pics/avatar.png" alt="Avatar" class="avatar">
                     <span onclick="document.getElementById('id01').style.display='none';document.body.style.overflowY = 'auto';" class="close" title="Chiudi">&times;</span>
                </div>
                <div class="containerForm">
                    <h1 class="textTitle"><b>Enter your login information</b></h1>
                    <input type="text" placeholder="Username" name="uname" required>
                    <input type="password" placeholder="Password" name="psw" required>
                    <button class="submitBtn" type="submit">Login</button>
                    <br>
                    <br>
                    Are you new to Philvideos?
                    <a class="link" onClick="document.getElementById('id01').style.display='none';document.getElementById('id02').style.display='block'" >Register </a>
                    <br>
                    <input name="autologin" type="checkbox" value="1"/>
                    Remember Me
                    </br>
                </div>
            </form>
        </div>


        <div id="id02" class="modal">
            <form class="modal-content animate" action="mail.php" method="post" enctype="multipart/form-data">
                <div class="imgcontainer"><img src="pics/avatar.png" alt="Avatar" class="avatar">
                    <span onclick="document.getElementById('id02').style.display='none';document.body.style.overflowY = 'auto';" class="close" title="Chiudi">&times;</span>
                </div>
                <div class="containerForm">
                    <label><b>Insert your information:</b></label>
                    <input type="text" placeholder="Name" name="name" required>
                    <input type="text" placeholder="Surname" name="surname" required>
                    <input type="text" placeholder="Username" name="username" required>
                    <input type="email" placeholder="Mail" name="mail" required>
                    <br><br>
                    <button class="submitBtn" type="submit">Register</button>
                </div>

            </form>
        </div>

        <div class ="main_container">
            <div class="top_bar_img_container">
                <img class="img_search_bar" src="pics/phils_pic.jpg" alt="foo" />
                <form class="search-container" >
                    <!-- modificare l'id nel momento in cui anche la pagina pubblica venga resa funzionale -->
                    <input type="text" autocomplete="off" id="search-bar1" placeholder="Login o Register" readonly="readonly">
                </form>
            </div>
            <div id="result"></div>
        </div>
    </body>
</html>
