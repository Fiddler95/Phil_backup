<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 27/04/2019
 * Time: 15:45
 */

include "connect.php";
include "functions.php";
$output = ' ';
$default = "bratta";

$filtroTipologia = mysqli_real_escape_string($conn, $_POST["primo"]);
$filtroRicerca = mysqli_real_escape_string($conn, $_POST["secondo"]);
$filtroIsGraphic = mysqli_real_escape_string($conn, $_POST["terzo"]);
$search = mysqli_real_escape_string($conn, $_POST["search"]);
$search1 = "%".$search."%";

//$output = $filtroTipologia . " " . $filtroRicerca . " " . $filtroIsGraphic . " " . $search1 ;
//echo "<script type='text/javascript'>alert('$output');</script>";

if($filtroIsGraphic === "b"){
    //se filtro settato su both
    if($filtroTipologia==="null"){
        //se non è settato il filtro sulla tipologia dei video
        if($filtroRicerca === "null"){
            //se non ci sono filtri sulla ricerca la query è quella base

            $sql = "SELECT `Url` FROM argomento WHERE Level_1 LIKE '$search1' UNION SELECT `Url` FROM universita WHERE Nome LIKE '$search1' UNION SELECT `Url` FROM speaker WHERE Nome LIKE '$search1' UNION SELECT `Url` FROM autori WHERE Nome LIKE '$search1' GROUP BY Url";
            $resultUrl = mysqli_query($conn, $sql);
            echo "<script type='text/javascript'>alert('$sql');</script>";
        }
        elseif($filtroRicerca === "argomento"){
            //se si cerca per argomento ho una query specifica
            $sql = "SELECT `Url` FROM argomento WHERE Level_1 LIKE '$search1' GROUP BY Url";
            $resultUrl = mysqli_query($conn, $sql);
        }
        else{
            //query unica per autori e università visto che hanno il campo nome in comune
            $filtroR = "\'". $filtroRicerca ."\'";
            $sql = "SELECT `Url` FROM '$filtroR' WHERE Nome LIKE '$search1' GROUP BY Url";
            $resultUrl = mysqli_query($conn, $sql);
        }
    }
}
elseif($filtroIsGraphic === "y"){
    //se filtro settato su yes
    echo "<script type='text/javascript'>alert('$default');</script>";
}
else{
    //se filtro settato su no
    echo "<script type='text/javascript'>alert('$default');</script>";
}
//$sql = "SELECT `Url` FROM argomento WHERE Level_1 LIKE '$search1' UNION SELECT `Url` FROM universita WHERE Nome LIKE '$search1' UNION SELECT `Url` FROM speaker WHERE Nome LIKE '$search1' UNION SELECT `Url` FROM autori WHERE Nome LIKE '$search1' GROUP BY Url";
//$resultUrl = mysqli_query($conn, $sql);

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

    $output .= display_vid_in_show_results($voti,$search);
    echo $output;
}
else {
    echo "non sono presenti video relativi alla ricerca effettuata";
}
?>