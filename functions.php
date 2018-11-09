<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 19/05/2018
 * Time: 16:23
 */

include "connect.php";
include "fields.php";

function pop_select($options,$field,$result)
{
    /**
     * La funzione accetta come parametri la lista delle opzioni disponibili
     * per la select e i campi da mostrare, entrambe ricevute dal file fields.php,
     * e il risultato della query sui precedenti questionari se esistono.
     * Tramite quest'ultimo controlla se sono già state inserite delle options
     * in un questionario precedente e se è cosi le mette come selezionate.
     */
    echo "<table width='100%'>";
    foreach($field as $id => $name )
    {
        $row1 = $result->fetch_assoc();
            echo "<tr>";
                echo "<td style=\"text-align:left;\">";
                    echo "<p style=\"font-size: large\">".$name."</p>";
                echo"</td>";
                echo"<td style=\"text-align:right;\" >";
                    echo"<select required id=". $id." name=". $id ." class=\"survey_select\">";
                        echo"<option disabled selected value> -- select an option -- </option>";
                        foreach($options as $key => $value) {
                            echo "<option value=".$key." "?>
                            <?php if($row1['Level'] == $key and $result->num_rows > 0)
                            {?>
                                selected="selected"<?php
                            }

                            echo ">".$value."</option>";
                        };
                    echo"</select><br>";
                echo"</td>";
            echo"</tr>";
    }
    echo "</table>";
}

function take_url_meta($conn)
{
    $sql = "SELECT url,yt_meta FROM videos WHERE 1 LIMIT 25";
    $result = mysqli_query($conn, $sql);
    $p = 0;
    if(mysqli_num_rows($result) >0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $trimmed_url = trim($row["url"]);
            $meta = $row["yt_meta"];
            $sq11 = "INSERT INTO `groups_of_videos`(`Group_id`, `Url`, `Metadata`) VALUES (0,'$trimmed_url','$meta')";
            if (mysqli_query($conn, $sq11)) {
                echo $p;
                $p++;
            }
        }
    }
    else
    {
        echo "error";
    }
}

function get_youtube($url){
    /**
     * funzione che dato in pasto un url valido, restituisce
     * il frame del video insieme ad alcuni metadati
     */
    $youtube = "http://www.youtube.com/oembed?url=". $url ."&format=json";

    $curl = curl_init($youtube);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $return = curl_exec($curl);
    curl_close($curl);
    return json_decode($return, true);

}

function create_new_Array_from_php_file($old_array){
    /**
     * crea un nuovo file php contenente l'array nuovo; l'ho usata per
     * ridurre le dimensioni dell'albero di philPapers
     */
    foreach ($old_array as $k =>$v) {
        if($v['depth']>2){
            unset($old_array[$k]);
        }
    }
    $results = var_export($old_array,true);
    file_put_contents('newPhilPapers.php', var_export($old_array, true));
}

function getYouTubeVideoID($url) {
    /**
     * funzione che, preso un url, restituisce il valore dell'ID
     * da utilizzare per richiamare api di google per i metadati
     */
    $queryString = parse_url($url, PHP_URL_QUERY);
    parse_str($queryString, $params);
    if (isset($params['v']) && strlen($params['v']) > 0) {
        return $params['v'];
    } else {
        return "";
    }
}

function display_vid_in_my_reviews ($result, $conn, $user)
{
    /**
     * Questa funzione prende come ingresso il risultato di una query che restituisce
     * vari url, e per ciascuno di essi genera un div "ContainerVideo" con il
     * frame relativo all'url, il titolo e il pulsante per effettuare la recensione
     */
    while($row = mysqli_fetch_assoc($result))
    {
        $video_url = trim($row['Url']);
        $api_key = 'AIzaSyDu_jGBX40owZ7t16ClQQ4sYJwO-KssnbU';
        $api_url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet%2CcontentDetails%2Cstatistics&id=' . getYouTubeVideoID($video_url) . '&key=' . $api_key;

        $data = json_decode(file_get_contents($api_url));
        // Accessing Video Info
        //futuro controllo sulle info del video, se vuote saltare il video e possibilmente eliminarlo da db
        if(!empty($data->items[0])) {
            echo "<div class='ContainerVideo'>";
            echo "<div class='videoHolder'><img src=\"" . $data->items[0]->snippet->thumbnails->medium->url . "\"></div>";
            echo "<div class='infoHolder'>";
            echo "<h2 class='yt_title'>" . $data->items[0]->snippet->title . "</h2>";
            echo "<p class='yt_description'>" . $data->items[0]->snippet->description . "</p>";
            $sql = "SELECT * FROM `reviews` WHERE `Url` = '$video_url' AND `Username` = '$user' ";
            $reviewed = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($reviewed);
            if ($count == 1) {
                echo "<div class='buttonHolder'>";
                echo " <button id='" . $video_url . "' class=\"reviewBtn\" style='float: left; background-color: #408b40' onClick=\"document.location.href='single_review.php?id=" . $video_url . "'\">Modify Review</button>";
                echo " <a id='Delete' class=\"reviewBtn\" style='float: left; background-color: red; margin-left: 10px;' href='delete_review.php?id=" . $video_url . "' onclick=\"return confirm('Are you sure you want to delete this review?')\"\">Delete Review</a>";
                echo "</div>";
            } else {
                echo "<div class='buttonHolder'>";
                echo " <button id='" . $video_url . "' class=\"reviewBtn\" style='float: left' onClick=\"document.location.href='single_review.php?id=" . $video_url . "'\">Review Video</button>";
                echo "</div>";
            }
            echo "</div>";
            echo "</div>";
        }
        else{
            echo "<div class='ContainerVideo'>Verificare Url video:&#x0a;".$video_url."</div>";
        }
    }
}

function display_vid_in_show_results ($result)
{
    /**
     * Questa funzione prende come ingresso il risultato di una query che restituisce
     * vari url, e per ciascuno di essi genera un div "ContainerVideo" con il
     * frame relativo all'url, il titolo e il pulsante per effettuare la recensione
     */
    while($row = mysqli_fetch_assoc($result))
    {
        $video_url = trim($row['Url']);
        $api_key = 'AIzaSyDu_jGBX40owZ7t16ClQQ4sYJwO-KssnbU';
        $api_url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet%2CcontentDetails%2Cstatistics&id=' . getYouTubeVideoID($video_url) . '&key=' . $api_key;

        $data = json_decode(file_get_contents($api_url));
        // Accessing Video Info

        if(!empty($data->items[0])){
            echo "<div class='ContainerVideo'>";
            echo "<div class='videoHolder'><img src=\"".$data->items[0]->snippet->thumbnails->medium->url."\"></div>";
            echo "<div class='infoHolder'>";
            echo"<h2 class='yt_title'>".$data->items[0]->snippet->title."</h2>";
            echo"<p class='yt_description'>".$data->items[0]->snippet->description."</p>";

            echo "<div class='buttonHolder'>";
            echo " <button id='".$video_url."' class=\"reviewBtn\" style='float: left; background-color: #408b40' onClick=\"window.open('$video_url.')\">Watch it on Youtube</button>";
            echo "</div>";

            echo"</div>";
            echo "</div>";
        }
        else{
            echo "<div class='ContainerVideo'>Verificare Url video:&#x0a;".$video_url."</div>";
        }
    }
}

function display_vid_in_profile ($result)
{
    /**
     * Questa funzione prende come ingresso il risultato di una query che restituisce
     * vari url, e per ciascuno di essi genera un div "ContainerVideo" con il
     * frame relativo all'url, il titolo e il pulsante per effettuare la recensione
     */
    while($row = mysqli_fetch_assoc($result))
    {
        $video_url = trim($row['Url']);
        $api_key = 'AIzaSyDu_jGBX40owZ7t16ClQQ4sYJwO-KssnbU';
        $api_url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet%2CcontentDetails%2Cstatistics&id=' . getYouTubeVideoID($video_url) . '&key=' . $api_key;

        $data = json_decode(file_get_contents($api_url));
        // Accessing Video Info

        if(!empty($data->items[0])){
            echo "<div class='ContainerVideo'>";
            echo "<div class='videoHolder'><img src=\"".$data->items[0]->snippet->thumbnails->medium->url."\"></div>";
            echo "<div class='infoHolder'>";
            echo"<h2 class='yt_title'>".$data->items[0]->snippet->title."</h2>";
            echo"<p class='yt_description'>".$data->items[0]->snippet->description."</p>";

            echo "<div class='buttonHolder'>";
            echo " <button id='" . $video_url . "' class=\"reviewBtn\" style='float: left; background-color: #408b40' onClick=\"document.location.href='single_review.php?id=" . $video_url . "'\">Modify Review</button>";
            echo " <a id='Delete' class=\"reviewBtn\" style='float: left; background-color: red; margin-left: 10px;' href='delete_review.php?id=" . $video_url . "' onclick=\"return confirm('Are you sure you want to delete this review?')\"\">Delete Review</a>";
            echo "</div>";

            echo"</div>";
            echo "</div>";
        }
        else{
            echo "<div class='ContainerVideo'>Verificare Url video:&#x0a;".$video_url."</div>";
        }
    }
}


function display_single_video($url)
{
    /**
     * funzione che preso in input l'url del video, restituisce un div contenente tale video,
     * titolo, descrizione e altre info, insieme al link per visualizzare quest'ultimo su Youtube
     */
    $video_url = trim($url);
    $api_key = 'AIzaSyDu_jGBX40owZ7t16ClQQ4sYJwO-KssnbU';
    $api_url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet%2CcontentDetails%2Cstatistics%2Cplayer&id=' . getYouTubeVideoID($video_url) . '&key=' . $api_key;

    $data = json_decode(file_get_contents($api_url));

    echo "<div id='single_video_in_review' style='height: 290px;background-color: white; border-radius: 10px; padding: 1vw'>";
        echo "<div class='videoHolder'>".$data->items[0]->player->embedHtml."</div>";
        echo "<div class='infoHolder'>";
            echo"<h2>".$data->items[0]->snippet->title."</h2>";
            echo"<p>".$data->items[0]->snippet->description."</p>";
            echo '<strong>Duration: </strong>' . $data->items[0]->contentDetails->duration . '<br>';
            echo '<strong>Views: </strong>' . $data->items[0]->statistics->viewCount . '<br>';
            echo '<strong>Watch it on Youtube: </strong>' . '<a href="'. $video_url .'" target="_blank">'. $video_url .'</a>' . '<br>';
        echo "</div>";
    echo "</div>";
}

function display_campiSoggettivi($data){
    include "fields.php";
    $opzioni = array();
    foreach($campiSoggettivi as $name => $text ) {
        ?><div id="<?php echo $name ?>" class="field_of_review" <?php if($name=="Quality")echo "style=\"border-bottom: 2px cornflowerblue solid \""?> >
                <img class="help_icon" onclick="document.getElementById('suggestions').style.display='block'; document.getElementById('content').innerHTML= '<?php echo html_entity_decode($help_text["$name"]); ?>';" src="pics/help_icon.png"/>
                <strong><?php echo $name ?>: </strong>
                <p><?php echo $text ?></p>
                <select name="<?php echo $name ?>" required style="width: 35vw">
                    <option disabled selected value> -- select an option -- </option>
                    <?php
                        if($name==="Consistency"){
                            $opzioni=$opzioni_consistency;
                        }
                        elseif ($name==="Difficulty"){
                            $opzioni=$opzioni_Difficulty;
                        }
                        elseif ($name==="Quality"){
                            $opzioni=$opzioni_Quality;
                        }
                        else{
                            $opzioni=$opzioni_campiSoggettivi;
                        }
                        foreach($opzioni as $key1 => $value1 ) {?>
                        <option value="<?php echo $key1 ?>"<?php if(isset($data[$name]) AND $data[$name]==$key1) echo "selected = \"selected\""?>>
                        <?php echo $value1 ?>
                        </option><?php } ?>
                </select>
        </div>
     <?php }
}


function retrieveData($user, $url, $conn){
    /**
     * questa funzione ricerca in database tutti i dati relativi a una determinata review e
     * li restituisce in un array associativo
     */
    $DataArrayAssoc= array();
    //recupero la tipologia principale e secondaria del video
    $sql = "SELECT Principale,Secondaria FROM tipologia_video WHERE User = '$user' AND Url = '$url'";
    $result = mysqli_query($conn,$sql);
    if (isset($result))
    {
        $row = $result->fetch_assoc();
        $DataArrayAssoc["Principale"] = $row["Principale"];
        $DataArrayAssoc["Secondaria"] = $row["Secondaria"];
    }

    //recupero gli autori trattati nel video
    $sql = "SELECT Nome FROM autori WHERE User = '$user' AND Url = '$url'";
    $result = mysqli_query($conn,$sql);
    $autori_in_database = array();
    while(($row =  mysqli_fetch_assoc($result))) {
        $autori_in_database[] = $row['Nome'];
    }
    $DataArrayAssoc["Autori"] = $autori_in_database;

    //recupero gli speakers trattati nel video
    $sql = "SELECT Nome FROM speaker WHERE User = '$user' AND Url = '$url'";
    $result = mysqli_query($conn,$sql);
    $speakers_in_database = array();
    while(($row =  mysqli_fetch_assoc($result))) {
        $speakers_in_database[] = $row['Nome'];
    }
    $DataArrayAssoc["Speaker"] = $speakers_in_database;

    //recupero le università coinvolte nel video
    $sql = "SELECT Nome FROM universita WHERE User = '$user' AND Url = '$url'";
    $result = mysqli_query($conn,$sql);
    $uni_in_database = array();
    while(($row =  mysqli_fetch_assoc($result))) {
        $uni_in_database[] = $row['Nome'];
    }
    $DataArrayAssoc["Universita"] = $uni_in_database;

    //recupero gli argomenti del video
    $sql = "SELECT Level_1,Level_2,Level_3 FROM argomento WHERE User = '$user' AND Url = '$url'";
    $result = mysqli_query($conn,$sql);
    if (isset($result))
    {
        $row = $result->fetch_assoc();
        $DataArrayAssoc["Level_1"] = $row["Level_1"];
        $DataArrayAssoc["Level_2"] = $row["Level_2"];
        $DataArrayAssoc["Level_3"] = $row["Level_3"];
    }

    //recupero la classificazione storico/geografica del video
    $sql = "SELECT Level_1,Level_2 FROM arg_stogeo WHERE User = '$user' AND Url = '$url'";
    $result = mysqli_query($conn,$sql);
    if (isset($result))
    {
        $row = $result->fetch_assoc();
        $DataArrayAssoc["h_Level_1"] = $row["Level_1"];
        $DataArrayAssoc["h_Level_2"] = $row["Level_2"];
    }

    //recupero i voti dei campi soggettivi del video
    $sql = "SELECT Singolo_campo, Voto FROM campi_soggettivi WHERE User = '$user' AND Url = '$url'";
    $result = mysqli_query($conn,$sql);
    while(($row =  mysqli_fetch_assoc($result))) {
        $campo = $row["Singolo_campo"];
        $DataArrayAssoc[$campo] = $row["Voto"];
    }

    //recupero i voti dei campi grafici del video
    $sql = "SELECT Singolo_campo, Voto FROM campi_grafici WHERE User = '$user' AND Url = '$url'";
    $result = mysqli_query($conn,$sql);
    $count = mysqli_num_rows($result);
    if($count>=1){
        $DataArrayAssoc["onoffswitch"] = true;
        while(($row =  mysqli_fetch_assoc($result))) {
            $campo = $row["Singolo_campo"];
            $DataArrayAssoc[$campo] = $row["Voto"];
        }
    }

    //recupero gli elementi non presenti nelle liste
    $sql = "SELECT Type, Value FROM unlisted WHERE User = '$user' AND Url = '$url'";
    $result = mysqli_query($conn,$sql);
    $unlisted_auth = array();
    $unlisted_spe = array();
    $unlisted_uni = array();
    while(($row =  mysqli_fetch_assoc($result))) {
        switch ($row["Type"]) {
            case 'autore':
                $unlisted_auth[] = $row['Value'];
                break;
            case 'speaker':
                $unlisted_spe[] = $row['Value'];
                break;
            case 'uni':
                $unlisted_uni[] = $row['Value'];
                break;
        }
    }
    if(!empty($unlisted_auth)){
        $unlisted_auth=implode(", ",$unlisted_auth);
        $DataArrayAssoc["Autori_UL"] = $unlisted_auth;
    }
    if(!empty($unlisted_spe)){
        $unlisted_spe=implode(", ",$unlisted_spe);
        $DataArrayAssoc["Speaker_UL"] = $unlisted_spe;
    }
    if(!empty($unlisted_uni)){
        $unlisted_uni=implode(", ",$unlisted_uni);
        $DataArrayAssoc["Universita_UL"] = $unlisted_uni;
    }

    //recupero i tag liberi del video
    $sql = "SELECT `Tag` FROM `tags` WHERE `Free-tag`=1";
    $result = mysqli_query($conn,$sql);
    $unlisted_tag = array();
    while(($row =  mysqli_fetch_assoc($result))) {
        $unlisted_tag[] = $row['Tag'];
    }
    if(!empty($unlisted_tag)){
        $unlisted_tag=implode(", ",$unlisted_tag);
        $DataArrayAssoc["Unlisted_tag"] = $unlisted_tag;
    }

return $DataArrayAssoc;
}
//funzione per il controllo dei valori dei campi grafici
function check($key,$name,$data){
    if(isset($data[$name]) AND $key==$data[$name]) echo "selected";
}

function calc_avg($campiSoggettivi,$campiGrafici,$url,$conn, $scelta){
    //here functions to modify database video marks
    foreach($campiSoggettivi as $campo=> $testo) {
        $sql = "SELECT SUM(Voto_pesato) as sum_voto, SUM(Peso) as sum_peso FROM campi_soggettivi WHERE Url = '$url' AND Singolo_campo = '$campo'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $totV = $row['sum_voto'];
        $totP = $row['sum_peso'];
        if ($totP==0){
            $avg=0;
        }
        else{
            $avg = $totV/$totP;
        }

        $sql = "SELECT * FROM voti_soggettivi WHERE Url = '$url' AND Singolo_campo = '$campo'";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);
        if ($count == 1) {
            /**se ho trovato un riscontro, vado a sovrascrivere i dati;
             */
            $sql = " UPDATE voti_soggettivi SET `Voto`= '$avg' WHERE Url = '$url' AND Singolo_campo = '$campo'";
            $result1 = mysqli_query($conn, $sql);

        } else {
            //è la prima volta che compilo il campo
            $sql = " INSERT INTO voti_soggettivi (Singolo_campo, Voto, Url) VALUES ('$campo','$avg', '$url')";
            $result1 = mysqli_query($conn, $sql);
        }
    }
    $sentinel = 0;
    foreach ($campiGrafici as $campo) {
        $sql = "SELECT AVG(Voto) as average_voto FROM campi_grafici WHERE Url = '$url' AND Singolo_campo = '$campo'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $avg = $row['average_voto'];

        $sql = "SELECT * FROM voti_grafici WHERE Url = '$url' AND Singolo_campo = '$campo'";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);
        if ($count == 1) {
            /**se ho trovato un riscontro, vado a sovrascrivere i dati;
             */
            $sql = " UPDATE voti_grafici SET `Voto`= '$avg' WHERE Url = '$url' AND Singolo_campo = '$campo'";
            $result1 = mysqli_query($conn, $sql);
            $sentinel = 1;

        } else {
            //è la prima volta che compilo il campo
            $sql = " INSERT INTO voti_grafici (Singolo_campo, Voto, Url) VALUES ('$campo','$avg', '$url')";
            $result1 = mysqli_query($conn, $sql);
            $sentinel = 1;
        }

        /**
         * Modificare la parte qui sotto in quanto causa una divisione per 0
         * possibile soluzione--> chiamare la avg in una pagina successiva alla cancellazione
         * e eliminare sta boiata della flag
         *
         */

    }

    if ($sentinel == 1 AND $scelta == 1)
    {
        $message = "Classificazione completata con successo";
        echo "<script type='text/javascript'>
                        alert('$message');
                        window.location.replace(\"my_reviews.php\");</script>";
    }
    elseif ($sentinel == 1 AND $scelta == 0){
        $message = "Rimozione classificazione completata con successo";
        echo "<script type='text/javascript'>
                        alert('$message');
                        window.location.replace(\"my_reviews.php\");</script>";
    }
    else
    {
        echo $message = "Potrebbe essersi verificato un errore, ricontrolla il questionario ".mysqli_error($conn);
    }
}

function generate_pwd($length) {
    $pool = array_merge(range(0,9), range('a', 'z'),range('A', 'Z'));
    $key='';
    for($i=0; $i < $length; $i++) {
        $key .= $pool[mt_rand(0, count($pool) - 1)];
    }
    return $key;
}

