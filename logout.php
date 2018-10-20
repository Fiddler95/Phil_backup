<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 21/04/2018
 * Time: 09:37
 */

session_start();									//elimino il cookie(settando la value a "" e la data di "scadenza" al giorno precedente)
setcookie("mycookie", "", time() - 3600);
session_unset();									//cancello tutte le variabili di sessione e distruggo la sessione.
session_destroy();
header('Location: home.php');
?>