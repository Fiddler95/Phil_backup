<pre>
<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 09/04/2018
 * Time: 11:35
 *
 *
 */

include "connect.php";
include "fields.php";
include "functions.php";
include "newPhilPapers.php";
session_start();

if(!isset($_SESSION['name']))
    {
        header("Location: home.php");
    }

$user = $_SESSION['name'];

$sql = "SELECT Knowledge_lvl FROM `users` WHERE Username = '$user'";
$result = mysqli_query($conn, $sql) or die("failed to retrieve level from users table");
$row = mysqli_fetch_assoc($result);
$lvlStud = $row["Knowledge_lvl"];

//recupero il questionario di filosofia già compilato se esiste
$sql = "SELECT * FROM `survey_phil` WHERE Username = '$user'";
$resultP = mysqli_query($conn, $sql);

//recupero il questionario generale già compilato se esiste
$sql = "SELECT * FROM `survey_general` WHERE Username = '$user'";
$resultG = mysqli_query($conn, $sql);

//recupero dall'albero di philpapers gli id e nomi degli argomenti del primo nodo
$id= array();
$filName= array();
foreach ($newPhils as $k =>$v) {
    if($v['depth']==1){
        array_push($filName,$v['name']);
        array_push($id,$v['id']);
    }
}
$philFields = array_combine($id,$filName);
//print_r($philFields);
?>
</pre>


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
            <a href="home_private.php">Home</a>
            <a href="my_reviews.php">My Reviews</a>
            <a class="active" href="survey.php">Survey</a>
            <a href="#about">About</a>
            <a href="logout.php" style="float: right">Logout</a>
            <a href="profile.php" style="float: right">Profile</a>
        </div>

        <div class ="main_container">

            <div id="SurveyContainer" class="GreyContainer " style="display:block" >
                <form action="send_survey.php" method="post" >
                    <div class="survey_category">
                        <table width="100%">
                            <tr>
                                <td style="text-align:left;">
                                    <h3>Select your level of Education </h3>
                                </td>
                                <td style="text-align:right;">
                                    <select id="LivelloStudi" name="LivelloStudi" class="survey_select">
                                        <option disabled selected value> -- select an option -- </option>
                                        <option value=1 <?php if($lvlStud==1) echo "selected=\"selected\"" ?> >Elementary School</option>
                                        <option value=2 <?php if($lvlStud==2) echo "selected=\"selected\"" ?> >High School</option>
                                        <option value=3 <?php if($lvlStud==3) echo "selected=\"selected\"" ?> >Bachelor's Degree</option>
                                        <option value=4 <?php if($lvlStud==4) echo "selected=\"selected\"" ?> >Master's Degree</option>
                                        <option value=5 <?php if($lvlStud==5) echo "selected=\"selected\"" ?> >Doctoral Student </option>
                                        <option value=6 <?php if($lvlStud==6) echo "selected=\"selected\"" ?> >PhD/Researcher/Professor</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div><br>

                    <div class="survey_category">
                        <?php pop_select($philOptions,$philFields,$resultP);?>
                    </div><br>

                    <?php pop_select($genOptions,$generalFields,$resultG); ?>

                    <button class="submitBtn" type="submit">Submit</button>
                </form>

            </div>

        </div>

    </body>

</html>