<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 20/04/2018
 * Time: 15:51
 */

include 'connect.php';

$mail = $_GET["email"];
$username = $_GET['user'];
$password = $_GET['pwd'];
$name = $_GET["name"];
$surname = $_GET["surname"];

if(isset($mail) && isset($username) && isset($password) && isset($name) && isset($surname)){

    $mymail = mysqli_real_escape_string($conn,$mail);
    $myusername = mysqli_real_escape_string($conn,$username);
    $mypassword = mysqli_real_escape_string($conn,$password);
    $myname = mysqli_real_escape_string($conn,$name);
    $mysurname = mysqli_real_escape_string($conn,$surname);

    $password_hash = password_hash(trim($mypassword),PASSWORD_DEFAULT);

    $sql = "SELECT Username FROM users WHERE Username = '$myusername'";					//utilizzo due variabili flag per individuare se l'username o la mail
    $result = mysqli_query($conn,$sql);													//sono già stati utilizzati.
    $count = mysqli_num_rows($result);
    $usrFlag = 0;
    if($count == 0){
        $usrFlag = 1;
    }


    $sql = "SELECT Email FROM users WHERE Email = '$mymail'";
    $result = mysqli_query($conn,$sql);
    $count = mysqli_num_rows($result);
    $mailFlag = 0;
    if($count == 0){
        $mailFlag = 1;
    }

    if($usrFlag == 1 && $mailFlag == 1) {													//se username e mail sono unici, procedo con la registrazione

        $sql = "INSERT INTO users (Name, Surname, Username, Password, Email) VALUES ('$myname', '$mysurname', '$myusername','$password_hash','$mymail')";
        if (mysqli_query($conn, $sql)) {													//carico i dati nel database
            $message = "You have successfully verified your email";
            echo "<script type='text/javascript'>
		alert('$message');
	    window.location.replace(\"home_Private.php\");
      </script>";
        }
        else {
            echo $message = "Errore, ".mysqli_error($conn);
        }
    }
    else{
        if($usrFlag == 0){
            $message = "Errore, username già in uso.";
        }else if($mailFlag == 0){
            $message = "Errore, mail già in uso.";
        }
    }

    echo "<script type='text/javascript'>
		alert('$message');
	    window.location.replace(\"home.php\");
      </script>";

}


?>

