<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 28/04/2019
 * Time: 11:23
 */

include "connect.php";
include "functions.php";

$filtroTipologia = mysqli_real_escape_string($conn, $_POST["primo"]);
$filtroRicerca = mysqli_real_escape_string($conn, $_POST["secondo"]);
$filtroIsGraphic = mysqli_real_escape_string($conn, $_POST["terzo"]);
$search = mysqli_real_escape_string($conn, $_POST["search"]);
$search1 = "%".$search."%";
$flagT = false;
$flagR = false;
$flagG = false;

$sel = "SELECT tipologia_video.Url FROM $filtroRicerca INNER JOIN tipologia_video INNER JOIN voti_grafici ON ";

$test = "\'". $search."\'";
//$output = $filtroTipologia . " " . $filtroRicerca . " " . $filtroIsGraphic . " " . $search . " " . $search1 ;
//echo "<script type='text/javascript'>alert('$sel');</script>";

if($filtroTipologia === "null"){
    //non cerchiamo anche latipologia
    $flagT = false;
}
else{
    $flagT = true;
    $onT = "tipologia_video.Principale = \'". $filtroTipologia."\'";
    //echo "<script type='text/javascript'>alert('$onT');</script>";
}


if($filtroRicerca === "null"){
    //non cerchiamo anche la tipologia
    $flagR = false;
}else{
    $flagR = true;
    switch ($filtroRicerca){
        case "argomento":
            $onR = "argomento.Level_1 LIKE \'". $search."\'";
            break;
        case "autori":
            $onR = "autori.Nome LIKE \'". $search1."\'";
            break;
        case "universita":
            $onR = "universita.Nome LIKE \'". $search1."\'";
            break;
    }
    //echo "<script type='text/javascript'>alert('$onR');</script>";
}
if($filtroIsGraphic === "y"){
    $flagG = true;
    $onG = " AND tipologia_video.Url = voti_grafici.Url";
}
else{
    $flagG = false;
}

if(!$flagT and !$flagR and !$flagG){
    //se sono tutte deselezionate
    echo "<script type='text/javascript'>alert('tutte deselezionate');</script>";
    $sel = "SELECT `Url` FROM argomento WHERE Level_1 LIKE '$search1' UNION SELECT `Url` FROM universita WHERE Nome LIKE '$search1' UNION SELECT `Url` FROM speaker WHERE Nome LIKE '$search1' UNION SELECT `Url` FROM autori WHERE Nome LIKE '$search1' GROUP BY Url";
}
else if(!$flagT and !$flagR and $flagG){
    //se è selezionata solo la ricerca per grafica
    echo "<script type='text/javascript'>alert('solo la ricerca per grafica');</script>";
    $sel = "SELECT voti_grafici.Url
              FROM voti_grafici INNER JOIN (SELECT `Url`AS t FROM argomento WHERE Level_1 LIKE '$search1' UNION SELECT `Url` AS t FROM universita WHERE Nome LIKE '$search1' UNION SELECT `Url` AS t FROM speaker WHERE Nome LIKE '$search1' UNION SELECT `Url` AS t FROM autori WHERE Nome LIKE '$search1' GROUP BY t ) AS temp
                ON voti_grafici.Url = temp.t
              GROUP BY voti_grafici.Url";
}
else if($flagT and !$flagR and !$flagG){
    //se è selezionata solo la ricerca per tipologia
    echo "<script type='text/javascript'>alert('solo la ricerca per tipologia');</script>";
    $sel = "SELECT tipologia_video.Url
              FROM tipologia_video INNER JOIN  (SELECT `Url`AS t FROM argomento WHERE Level_1 LIKE '$search1' UNION SELECT `Url` AS t FROM universita WHERE Nome LIKE '$search1' UNION SELECT `Url` AS t FROM speaker WHERE Nome LIKE '$search1' UNION SELECT `Url` AS t FROM autori WHERE Nome LIKE '$search1' GROUP BY t ) AS temp
                ON tipologia_video.Url = temp.t AND tipologia_video.Principale = '$filtroTipologia'
              GROUP BY tipologia_video.Url";
}
else if($flagT and !$flagR and $flagG){
    //se è selezionata la ricerca per tipologia e grafica
    echo "<script type='text/javascript'>alert(' ricerca per tipologia e grafica');</script>";
    $sel = "SELECT tipologia_video.Url
              FROM tipologia_video INNER JOIN voti_grafici INNER JOIN  (SELECT `Url`AS t FROM argomento WHERE Level_1 LIKE '$search1' UNION SELECT `Url` AS t FROM universita WHERE Nome LIKE '$search1' UNION SELECT `Url` AS t FROM speaker WHERE Nome LIKE '$search1' UNION SELECT `Url` AS t FROM autori WHERE Nome LIKE '$search1' GROUP BY t ) AS temp
                ON tipologia_video.Url = temp.t AND voti_grafici.Url = temp.t AND tipologia_video.Principale = '$filtroTipologia'
              GROUP BY tipologia_video.Url";
}
else{
    //altri casi
    if($flagT){
        $sel .= $onT;
    }
    if($flagR){
        if($flagT)
            $sel .= " AND ";
        $sel .= $onR;
    }
    if($flagG){
        $sel .= $onG ;
    }

    $sel .= " AND tipologia_video.Url = ".$filtroRicerca.".Url GROUP BY tipologia_video.Url ";
}


echo "<script type='text/javascript'>alert('$sel');</script>";
$sel = stripslashes($sel);

$sql = $sel;
$resultUrl = mysqli_query($conn, $sql);

$voti = array();
while(($row =  mysqli_fetch_assoc($resultUrl))) {
    $url = $row["Url"];
    $sqls = "SELECT(( SELECT `Voto` FROM voti_soggettivi WHERE `Singolo_campo` = 'Entertainment' AND `Url` = '$url')+( SELECT `Voto` FROM voti_soggettivi WHERE `Singolo_campo` = 'Quality' AND `Url` = '$url')) as somma" ;
    $result = mysqli_query($conn, $sqls);
    $row1 =  mysqli_fetch_assoc($result);
    if($row1["somma"]>=3)
    {
        $voti[$url]=$row1["somma"];
    }
}

foreach($voti as $chiave => $voto ) {
    $video_url = trim($chiave);
    $api_key = 'AIzaSyDu_jGBX40owZ7t16ClQQ4sYJwO-KssnbU';
    $api_url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet%2CcontentDetails%2Cstatistics%2Cplayer&id=' . getYouTubeVideoID($chiave) . '&key=' . $api_key;

    $data = json_decode(file_get_contents($api_url));
    if (strpos($data->items[0]->snippet->title, $search) !== false) {
        $voti[$chiave]= $voti[$chiave]*2;
    }
}

arsort($voti);

if(mysqli_num_rows($resultUrl) >0) {
    display_vid_in_show_results($voti,$search);
}
else {
    echo "non sono presenti video relativi alla ricerca effettuata";
}
mysqli_close($conn);

?>
