<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 20/04/2018
 * Time: 21:28
 */
if(isset($_SESSION['name'])){
    header("Location: home_Private.php");
}
if(isset($_COOKIE["mycookie"])){								//se esiste un cookie "mycookie" confronto tutti gli username nel database
    include 'connect.php';										//con l'username criptato contenuto nella cookie value.
    $sql = "SELECT Username FROM users";
    $result = mysqli_query($conn,$sql);

    while($row = mysqli_fetch_assoc($result)) {
        $usr = $row["Username"];
        if(password_verify($usr,$_COOKIE["mycookie"])){			//se i due valori combaciano viene assegnato a Session[name] il nome dell'utente
            $_SESSION['name'] = $usr;							//trovato.
            header("Location: home_Private.php");
        }
    }
}
?>