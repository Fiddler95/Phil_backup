<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 01/11/2018
 * Time: 17:18
 */
include 'connect.php';
session_start();

if(!isset($_SESSION['name']))
{
    header("Location: home.php");
}

$user = $_SESSION['name'];
if(isset($_POST["o_pwd"]) and isset($_POST["n_pwd"]) and isset($_POST["c_pwd"])){
    $oldpwd = mysqli_real_escape_string($conn,$_POST["o_pwd"]);
    $newpwd = mysqli_real_escape_string($conn,$_POST["n_pwd"]);
    $confirmpwd = mysqli_real_escape_string($conn,$_POST["c_pwd"]);

    $sql = "SELECT * FROM users WHERE Username = '$user'";
    $result = mysqli_query($conn,$sql);
    $count = mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);

    if($count == 1 AND password_verify($oldpwd,$row['Password'])){
        $password_hash = password_hash(trim($confirmpwd),PASSWORD_DEFAULT);
        if(strcmp($newpwd,$confirmpwd)=== 0){
            $sql = " UPDATE users SET `Password`= '$password_hash' WHERE Username = '$user'";
            if(mysqli_query($conn, $sql)){
                $message="Password modified correctly!";
            }
            else{
                $message="Unknown error in password modification!";
            }
        }
        else{
            $message="Passwords do not match!";
        }
    }
    else{
        $message="The old password you have submitted is wrong!";
    }
    echo "<script type='text/javascript'>
                        alert('$message');
                        window.location.replace(\"profile.php\");</script>";
}
