<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 24/08/2018
 * Time: 17:18
 */

session_start();
include "connect.php";
include "functions.php";
if(!isset($_SESSION['name'])){
    header("Location: home.php");
}

$user= $_SESSION['name'];
$sql = "SELECT * FROM users WHERE Username = '$user'";
$result = mysqli_query($conn,$sql);
$row =  mysqli_fetch_assoc($result);

$sql1 = "SELECT Url FROM reviews WHERE Username = '$user' ORDER BY `Date`";
$result1 = mysqli_query($conn,$sql1);
$count = mysqli_num_rows($result1);
?>
<!DOCTYPE html>
<html>
<head>
    <link href="style.css" rel = "stylesheet" type = "text/css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script>
        //funzione per il form modale di inserimento dati
        // Get the modal
        var modal = document.getElementById('edit_form');

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</head>


<body>
<!-- creazione della barra di navigazione  -->
<div class="topnav">
    <a href="home_Private.php">Home</a>
    <a href="my_reviews.php">My Reviews</a>
    <a href="survey.php">Survey</a>
    <a href="#about">About</a>
    <a href="logout.php" style="float: right">Logout</a>
    <a class="active" href="profile.php" style="float: right">Profile</a>
</div>

<!-- form modale di login, presente solo nella pagina home pubblica-->
<div id="edit_form" class="modal">

    <!-- Modal Content -->
    <form class="modal-content animate" action="pwd_modify.php" method="post">
        <div class="imgcontainer"><img src="pics/avatar.png" alt="Avatar" class="avatar">
            <span onclick="document.getElementById('edit_form').style.display='none';document.body.style.overflowY = 'auto';" class="close" title="Chiudi">&times;</span>
        </div>
        <div class="containerForm">
            <h1 class="textTitle"><b>Modify your information</b></h1>
            <input type="password" placeholder="Old Password" name="o_pwd" required>
            <input type="password" placeholder="New Password" name="n_pwd" required>
            <input type="password" placeholder="Confirm Password" name="c_pwd" required>
            <button class="submitBtn" type="submit">Edit</button>
            <br>
        </div>
    </form>
</div>

<div class ="main_container">

    <div id="ProfileContainer" class="GreyContainer">
        <table>
            <tr>
                <td class="small_col">
                    <div class="card">
                        <img class="profile_pic" src="pics\profiles\Default_male.png" alt="John" style="width:100%">
                        <h1><?php echo $row['Name']."  ".$row['Surname'];?></h1>
                        <p class="title"><?php echo $row['Username'];?></p>
                        <p>Università degli Studi di Genova</p>
                        <p><button class="btnEditProfile" onclick="document.getElementById('edit_form').style.display='block';document.body.style.overflow= 'hidden';">Edit</button></p>
                    </div>
                </td>
                <td class="big_col">
                    <h1 class="h1_top_left">My reviews so far</h1>
                    <?php
                        if($count>0){
                            display_vid_in_profile($result1);
                        }
                        else{
                            echo "You have not reviewed any video yet";
                        }
                    ?>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>