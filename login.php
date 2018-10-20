<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 20/04/2018
 * Time: 15:39
 */

include 'connect.php';
if(isset($_POST["uname"]) && isset($_POST["psw"])){

    $myusername = mysqli_real_escape_string($conn,$_POST["uname"]);						//elimino caratteri speciali dalle stringhe in ingresso
    $mypassword = mysqli_real_escape_string($conn,$_POST["psw"]);
    $sql = "SELECT * FROM users WHERE Username = '$myusername'";						//prelevo i dati dell'utente specifico dalla tabella Users
    $result = mysqli_query($conn,$sql);
    $count = mysqli_num_rows($result);

    if($count == 1){																	//se c'è un solo username corrispondente nella tabella
        $row = mysqli_fetch_assoc($result);													//verifico che la password corrisponda a quella criptata nel database.

        if(password_verify($mypassword,$row['Password'])){
            session_start();
            if($_POST['autologin'] == 1){													//se è stato premuto il pulsante "remember me" creo un cookie, con
                $usr_hash = password_hash(trim($myusername),PASSWORD_DEFAULT);				//il nome utente criptato come valore, per l'autologin.
                setcookie("mycookie",$usr_hash, time() + (3600 * 24 * 30));
            }
            $_SESSION['name'] = $_POST["uname"];												//se le password corrispondono assegno alla sessione il nome utente
            header("Location: home_Private.php");												// e indirizzo alla pagina privata, altrimenti indirizzo alla pubblica.
            exit();
        }
        else{
            $message="Login unsuccesful";
            echo "<script> alert('$message'); </script>";
            include 'home.php';
        }
    }else{
        $message="Login unsuccesful";
        echo "<script> alert('$message'); </script>";
        include 'home.php';
    }
}
?>