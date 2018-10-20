<pre>
<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 12/06/2018
 * Time: 15:38
 *
 * Ogni volta che viene completata una classificazione il sistema aggiorna i dati relativi alle valutazioni dei video, modificando le medie.
 *
 *
 */

include 'connect.php';
include 'fields.php';
include 'newPhilPapers.php';
include 'functions.php';
session_start();
$user = $_SESSION['name'];
$url = $_POST['Url'];
//$title = $_POST['Title'];
/**
 * trovo il peso della valutazione dell'utente, basandomi sul suo livello di istruzione
 * e sul suo livello di conoscenza dell'argomento trattato nel video
 * Ad ora la pesatura consiste in 1-6 punti relativi al livello scolastico dell'utente
 * e un punteggio da 0 a 4 per la conoscenza sull'argomento specifico.
 * Una volta calcolato il peso, che è un valore che spazia da un minimo di 1 ad
 * un massimo di 10, esso è il coefficiente moltiplicativo associato al voto
 * fornito dall'utente. In parole povere un peso di 3 equivale a far "votare" l'utente 3 volte.
 * Possibile modifica dell'algoritmo in futuro.
 */
$sql = "SELECT Knowledge_lvl FROM users WHERE Username = '$user'";
$result = mysqli_query($conn, $sql) or die("livello conoscenza utente non trovato");
$row = mysqli_fetch_assoc($result);
$istruzione = $row['Knowledge_lvl'];
$id_argomento_trattato = $_POST['level_1'];
$sql = "SELECT `Level` FROM survey_phil WHERE Username = '$user' AND Phil_id = '$id_argomento_trattato'";
$result = mysqli_query($conn, $sql) or die("livello conoscenza utente non trovato");
$row = mysqli_fetch_assoc($result);
$conoscenza_argomento = $row['Level'];
$peso = $istruzione + $conoscenza_argomento;
$tags = array();

//inserisco la review nel database
if(isset($url) AND isset($user)){
    $sql = "SELECT * FROM reviews WHERE Username = '$user' AND Url = '$url'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    $newdate = date("Y-m-d");
    if ($count == 1) {
        /**se ho trovato un riscontro, vado a sovrascrivere i dati;
         */
        $sql = " UPDATE reviews SET `Date`= '$newdate' WHERE Username = '$user' AND Url = '$url'";
        $result1 = mysqli_query($conn, $sql);

    } else {
        //è la prima volta che eseguo una review su questo video
        $sql = " INSERT INTO reviews (Username, Url, Date) VALUES ('$user','$url','$newdate')";
        $result1 = mysqli_query($conn, $sql);
    }
}

if(isset($_POST['Principale'])) {
//salvo in database la tipologia di video
    $tags[]=$_POST['Principale'];
    $sql = "SELECT * FROM tipologia_video WHERE User = '$user' AND Url = '$url'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    $principale = $_POST['Principale'];
    if(isset($_POST['Secondaria'])){
        $secondaria = $_POST['Secondaria'];
        $tags[]=$_POST['Secondaria'];
    }
    else{
        $secondaria = null;
    }

    if ($count == 1) {
        /**se ho trovato un riscontro, vado a sovrascrivere i dati;
         */
        $sql = " UPDATE tipologia_video SET `Principale`= '$principale', `Secondaria`= '$secondaria'  WHERE User = '$user' AND Url = '$url'";
        $result1 = mysqli_query($conn, $sql);

    } else {
        //è la prima volta che compilo il campo
        $sql = " INSERT INTO tipologia_video (User, Principale, Secondaria, Url) VALUES ('$user','$principale','$secondaria', '$url')";
        $result1 = mysqli_query($conn, $sql);
    }
}
//salvo in database gli Autori
if(isset($_POST['Autori'])) {
    $sql = "DELETE FROM `autori` WHERE `User`= '$user' AND `Url`= '$url' ";
    $result = mysqli_query($conn, $sql);
    foreach ($_POST["Autori"] as $key => $val) {
        $tags[]=$val;
        $sql = "INSERT INTO `autori`(`Url`, `User`, `Nome`) VALUES ('$url', '$user', '$val')";
        $result = mysqli_query($conn, $sql);
    }
}
//salvo in database gli autori non presenti in lista
if(!empty($_POST['unlisted_athors'])){
    $sql = "DELETE FROM `unlisted` WHERE `User`= '$user' AND `Url`= '$url' AND `Type`= 'autore'";
    $result = mysqli_query($conn, $sql);
    $text = $_POST['unlisted_athors'];
    $unlisted_auth = explode(",", $text);
    $unlisted_auth = array_map('trim', $unlisted_auth);
    $items = '';
    foreach ($unlisted_auth as $ul_auth){
        $items .= '("'.$url.'","'.$user.'","autore","'.$ul_auth.'"),';
    }
    $items = substr($items,0,-1);
    $sql = "INSERT INTO unlisted (Url, User, Type, Value) VALUES ". $items;
    $result1 = mysqli_query($conn, $sql);
}

//salvo in database gli Speakers
if(isset($_POST['Speaker'])) {
    $sql = "DELETE FROM `speaker` WHERE `User`= '$user' AND `Url`= '$url' ";
    $result = mysqli_query($conn, $sql);
    foreach ($_POST["Speaker"] as $key => $val) {
        $tags[]=$val;
        $sql = "INSERT INTO `speaker`(`Url`, `User`, `Nome`) VALUES ('$url', '$user', '$val')";
        $result = mysqli_query($conn, $sql);
    }
}
//salvo in database gli speakers non presenti in lista
if(!empty($_POST['unlisted_speakes'])){
    $sql = "DELETE FROM `unlisted` WHERE `User`= '$user' AND `Url`= '$url' AND `Type`= 'speaker'";
    $result = mysqli_query($conn, $sql);
    $text = $_POST['unlisted_speakes'];
    $unlisted_spe = explode(",", $text);
    $unlisted_spe = array_map('trim', $unlisted_spe);
    $items = '';
    foreach ($unlisted_spe as $ul_auth){
        $items .= '("'.$url.'","'.$user.'","speaker","'.$ul_auth.'"),';
    }
    $items = substr($items,0,-1);
    $sql = "INSERT INTO unlisted (Url, User, Type, Value) VALUES ". $items;
    $result1 = mysqli_query($conn, $sql);
}

//salvo in database le Università
if(isset($_POST['Universita'])) {
    $sql = "DELETE FROM `universita` WHERE `User`= '$user' AND `Url`= '$url' ";
    $result = mysqli_query($conn, $sql);
    foreach ($_POST["Universita"] as $key => $val) {
        $tags[]=$val;
        $sql = "INSERT INTO `universita`(`Url`, `User`, `Nome`) VALUES ('$url', '$user', '$val')";
        $result = mysqli_query($conn, $sql);
    }
}
//salvo in database le università non presenti in lista
if(!empty($_POST['unlisted_uni'])){
    $sql = "DELETE FROM `unlisted` WHERE `User`= '$user' AND `Url`= '$url' AND `Type`= 'uni'";
    $result = mysqli_query($conn, $sql);
    $text = $_POST['unlisted_uni'];
    $unlisted_uni = explode(",", $text);
    $unlisted_uni = array_map('trim', $unlisted_uni);
    $items = '';
    foreach ($unlisted_uni as $ul_auth){
        $items .= '("'.$url.'","'.$user.'","uni","'.$ul_auth.'"),';
    }
    $items = substr($items,0,-1);
    $sql = "INSERT INTO unlisted (Url, User, Type, Value) VALUES ". $items;
    $result1 = mysqli_query($conn, $sql);
}

//salvo in database l'argomento del video
if(isset($_POST['level_1'],$_POST['level_2'])) {
    $sql = "SELECT * FROM argomento WHERE User = '$user' AND Url = '$url'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    $Level_1="";
    $Level_2="";
    $Level_3="";
    if(!isset($_POST['level_3'])){$_POST['level_3']=" ";$Level_3 = " ";};
    //recupero i nomi a partire dai relativi id di phil papers
    foreach ($newPhils as $k =>$v) {
        if($v['id']==$_POST['level_1']){
            $Level_1 = $v['name'];
        }
        elseif ($v['id']==$_POST['level_2']){
            $Level_2 = $v['name'];
        }
        elseif ($v['id']==$_POST['level_3']){
            $Level_3 = $v['name'];
        }
    }
    $tags[]=$Level_1;
    $tags[]=$Level_2;
    $tags[]=$Level_3;

    if ($count == 1) {
        /**se ho trovato un riscontro, vado a sovrascrivere i dati;
         */
        $sql = " UPDATE argomento SET `Level_1`= '$Level_1', `Level_2`= '$Level_2', `Level_3`= '$Level_3'  WHERE User = '$user' AND Url = '$url'";
        $result1 = mysqli_query($conn, $sql);

    } else {
        //è la prima volta che compilo il campo
        $sql = " INSERT INTO argomento (User, Level_1, Level_2, Level_3, Url) VALUES ('$user','$Level_1','$Level_2','$Level_3','$url')";
        $result1 = mysqli_query($conn, $sql);
    }
}
if(!empty($_POST['free-tags'])){
    $sql = "DELETE FROM `tags` WHERE `User`= '$user' AND `Url`= '$url' AND `Free-tag`= 1 ";
    $result = mysqli_query($conn, $sql) or die("Error connecting to mysql 1");
    if($result){
        $one=(integer)1;
        $text = $_POST['free-tags'];
        $free_tags = explode(",", $text);
        $free_tags = array_map('trim', $free_tags);
        $items = '';
        foreach ($free_tags as $tag){
            $items .= '("'.$url.'","'.$user.'","'.$tag.'","'.$one.'"),';
        }
        $items = substr($items,0,-1);

        $sql = "INSERT INTO `tags`(`Url`, `User`, `Tag`, `Free-tag`) VALUES". $items;
        $result = mysqli_query($conn, $sql) or die("Error connecting to mysql 1");
    }

}

//salvo in database l'argomento storico/geografico del video
if(isset($_POST['h_level_1'],$_POST['h_level_2'])) {
    $sql = "SELECT * FROM arg_stogeo WHERE User = '$user' AND Url = '$url'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    //recupero i nomi a partire dai relativi id di phil papers
    foreach ($newPhils as $k =>$v) {
        if($v['id']==$_POST['h_level_1']){
            $Level_1 = $v['name'];
            $tags[]=$Level_1;
        }
        elseif ($v['id']==$_POST['h_level_2']) {
            $Level_2 = $v['name'];
            $tags[]=$Level_2;
        }
    }
    if ($count == 1) {
        /**se ho trovato un riscontro, vado a sovrascrivere i dati;
         */
        $sql = " UPDATE arg_stogeo SET `Level_1`= '$Level_1', `Level_2`= '$Level_2' WHERE User = '$user' AND Url = '$url'";
        $result1 = mysqli_query($conn, $sql);

    } else {
        //è la prima volta che compilo il campo
        $sql = " INSERT INTO arg_stogeo (User, Level_1, Level_2, Url) VALUES ('$user','$Level_1','$Level_2','$url')";
        $result1 = mysqli_query($conn, $sql);
    }
}

if(!empty($tags)){
    $sql = "DELETE FROM `tags` WHERE User = '$user' AND Url = '$url' AND `Free-tag`= 0 ";
    $result1 = mysqli_query($conn, $sql);
    $items= '';
    foreach ($tags as $tag){
            $items .= '("'.$url.'","'.$user.'","'.$tag.'"),';
    }
    $items = substr($items,0,-1);
    $sql = "INSERT INTO tags (Url, User, Tag) VALUES ". $items;
    $result1 = mysqli_query($conn, $sql);
}







/**
 *PARTE SOGGETTIVA E GRAFICA, SOGGETTA A PESATURA
 */


//salvo in database i voti dei campi soggettivi del video
foreach ($campiSoggettivi as $name => $text) {
    if (isset($_POST[$name])) {
        $voto = $_POST[$name];
        $voto_pesato = $voto*$peso;
        $sql = "SELECT * FROM campi_soggettivi WHERE User = '$user' AND Url = '$url' AND Singolo_campo = '$name'";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);
        if ($count == 1) {
            /**se ho trovato un riscontro, vado a sovrascrivere i dati;
             */
            $sql = " UPDATE campi_soggettivi SET `Voto`= '$voto', `Voto_pesato`= '$voto_pesato', `Peso`= '$peso' WHERE User = '$user' AND Url = '$url' AND Singolo_campo = '$name'";
            $result1 = mysqli_query($conn, $sql);

        } else {
            //è la prima volta che compilo il campo
            $sql = " INSERT INTO campi_soggettivi (User, Singolo_campo, Voto, Url, Peso, Voto_pesato) VALUES ('$user','$name','$voto', '$url', '$peso', '$voto_pesato')";
            $result1 = mysqli_query($conn, $sql);
        }
    }
}
//salvo in database i voti dei campi grafici del video
if(isset($_POST["onoffswitch"])) {
    foreach ($campiGrafici as $name) {
        if (isset($_POST[$name])) {
            $voto = $_POST[$name];
            $sql = "SELECT * FROM campi_grafici WHERE User = '$user' AND Url = '$url' AND Singolo_campo = '$name'";
            $result = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($result);
            if ($count == 1) {
                /**se ho trovato un riscontro, vado a sovrascrivere i dati;
                 */
                $sql = " UPDATE campi_grafici SET `Voto`= '$voto' WHERE User = '$user' AND Url = '$url' AND Singolo_campo = '$name'";
                $result1 = mysqli_query($conn, $sql);

            } else {
                //è la prima volta che compilo il campo
                $sql = " INSERT INTO campi_grafici (User, Singolo_campo, Voto, Url) VALUES ('$user','$name','$voto', '$url')";
                $result1 = mysqli_query($conn, $sql);
            }
        }
    }
}
//modifico le medie salvate in database
calc_avg($campiSoggettivi, $campiGrafici, $url, $conn, 1);

?>
</pre>
