<pre>
<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 08/07/2018
 * Time: 10:56
 */

include 'connect.php';
include 'fields.php';
include 'newPhilPapers.php';
include 'functions.php';
session_start();
$user = $_SESSION['name'];
$url = $_GET["id"];

foreach($tabelle_in_db as $nome_tab){
    $sql = "DELETE FROM `$nome_tab` WHERE `User`= '$user' AND `Url`= '$url' ";
    $result = mysqli_query($conn, $sql) or die("errore in eliminazione campi tabella $nome_tab");
}
$sql = "DELETE FROM `reviews` WHERE `Username`= '$user' AND `Url`= '$url' ";
$result = mysqli_query($conn, $sql) or die ("errore in eliminazione tabella reviews");
//modifico le medie salvate in database
calc_avg($campiSoggettivi, $campiGrafici, $url, $conn, 0);
?>
</pre>
