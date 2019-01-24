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

        if($usrFlag == 1 && $mailFlag == 1) {

            $sql = "INSERT INTO users (Name, Surname, Username, Password, Email) VALUES ('$myname', '$mysurname', '$myusername','$password_hash','$mymail')";
            if (mysqli_query($conn, $sql)) {            //carico i dati nel database

                $sql1 = "SELECT Group_id FROM groups_of_users GROUP BY Group_id ORDER BY COUNT(User) LIMIT 1";
                $result1 = mysqli_query($conn, $sql1);

                if ($result1->num_rows > 0) {
                    $row = mysqli_fetch_assoc($result1);
                    $target = $row["Group_id"];

                    $sql2 = "INSERT INTO `groups_of_users`(`Group_id`, `User`) VALUES ('$target','$myusername')";
                    if (mysqli_query($conn, $sql2)) {
                        $message = "You have successfully verified your email";
                    } else {
                        $message = "Error in inserting user in group table";
                    }
                } else {
                    $message = "Error in retrieving group_id in group table";
                }
            } else {
                $message = "Error in inserting user in user table, " . mysqli_error($conn);
            }
        }
        else{
            if($usrFlag == 0){
                $message = "Errore, username già in uso.";
            }
            else if($mailFlag == 0){
                $message = "Errore, mail già in uso.";
            }
        }
    }
    else{
        $message = "Error in verifying user email ";
    }


    echo "<script type='text/javascript'>
        alert('$message');
        window.location.replace(\"home.php\");
     </script>";
?>

