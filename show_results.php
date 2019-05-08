<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 18/08/2018
 * Time: 19:39
 */
session_start();
include 'connect.php';
include 'functions.php';
if(!isset($_SESSION['name'])){
    header("Location: home.php");
}

$search = mysqli_real_escape_string($conn, $_GET["tag"]);
$search1 = "%".$search."%";

?>

<!DOCTYPE html>
<head>
    <link href="style.css" rel = "stylesheet" type = "text/css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
<!-- creazione della barra di navigazione  -->
<div class="topnav">
    <a class="active" href="home_Private.php">Home</a>
    <a href="my_reviews.php">My Reviews</a>
    <a href="survey.php">Survey</a>
    <a href="about.php">About Us</a>
    <a href="logout.php" style="float: right">Logout</a>
    <a href="profile.php" style="float: right">Profilo</a>
</div>

<div class ="main_container">
    <div id="spinner" class="spinner" style="display:none;">
        <img id="img-spinner" src="pics\spinner.GIF" alt="Loading"/>
    </div>
    <div id="mySidebar" class="sidebar">
        <a href="javascript:void(0)" style="z-index: 10000;" class="closebtn" onclick="closeNav()">×</a>
        <form>

            <div class="cd-filter-block">
                <h4>Video Category</h4>

                <div class="cd-filter-content">
                    <div class="cd-select cd-filters">
                        <select class="filter" name="filtroTipologia" id="filtroTipologia" onchange="filter_ajax()">
                            <option selected value="null">No filter</option>
                            <option value="University Lesson">University Lesson</option>
                            <option value="Non-University Lesson">Non-University Lesson</option>
                            <option value="Conference/Talk">Conference/Talk</option>
                            <option value="Introduction/Tutorial">Introduction/Tutorial</option>
                            <option value="Seminar">Seminar</option>
                            <option value="Cartoon">Cartoon</option>
                            <option value="Interview/Conversation">Interview/Conversation</option>
                            <option value="Documentary/Biography">Documentary/Biography</option>
                            <option value="Audio only">Audio only</option>
                        </select>
                    </div> <!-- cd-select -->
                </div> <!-- cd-filter-content -->

                <!-- <ul class="cd-filter-content cd-filters list">
                    <li>
                        <input class="filter" data-filter=".check1" type="checkbox" id="checkbox1">
                        <label class="checkbox-label" for="checkbox1">University Lesson</label>
                    </li>

                    <li>
                        <input class="filter" data-filter=".check2" type="checkbox" id="checkbox2">
                        <label class="checkbox-label" for="checkbox2">Non-University Lesson</label>
                    </li>

                    <li>
                        <input class="filter" data-filter=".check3" type="checkbox" id="checkbox3">
                        <label class="checkbox-label" for="checkbox3">Conference/Talk</label>
                    </li>

                    <li>
                        <input class="filter" data-filter=".check4" type="checkbox" id="checkbox4">
                        <label class="checkbox-label" for="checkbox4">Introduction/Tutorial</label>
                    </li>

                    <li>
                        <input class="filter" data-filter=".check5" type="checkbox" id="checkbox5">
                        <label class="checkbox-label" for="checkbox5">Seminar</label>
                    </li>
                    <li>
                        <input class="filter" data-filter=".check6" type="checkbox" id="checkbox6">
                        <label class="checkbox-label" for="checkbox6">Cartoon</label>
                    </li>

                    <li>
                        <input class="filter" data-filter=".check7" type="checkbox" id="checkbox7">
                        <label class="checkbox-label" for="checkbox7">Interview/Conversation</label>
                    </li>

                    <li>
                        <input class="filter" data-filter=".check8" type="checkbox" id="checkbox8">
                        <label class="checkbox-label" for="checkbox8">Documentary/Biography</label>
                    </li>

                    <li>
                        <input class="filter" data-filter=".check9" type="checkbox" id="checkbox9">
                        <label class="checkbox-label" for="checkbox9">Audio only</label>
                    </li>
                </ul> <!-- cd-filter-content -->
            </div> <!-- cd-filter-block -->

            <div class="cd-filter-block">
                <h4>Search for </h4>

                <div class="cd-filter-content">
                    <div class="cd-select cd-filters">
                        <select class="filter" name="filtroRicerca" id="filtroRicerca" onchange="filter_ajax()">
                            <option selected value="null">No filter</option>
                            <option value="argomento">Topic</option>
                            <option value="autori">Authors</option>
                            <option value="universita">University</option>
                        </select>
                    </div> <!-- cd-select -->
                </div> <!-- cd-filter-content -->
            </div> <!-- cd-filter-block -->

            <div class="cd-filter-block">
                <h4>Graphic Aid</h4>

                <ul class="cd-filter-content cd-filters list" onchange="filter_ajax()">
                    <li>
                        <input class="filter" value="n" type="radio" name="radioButton" id="noG" checked>
                        <label class="radio-label" for="noG">No</label>
                    </li>
                    <li>
                        <input class="filter" value="y" type="radio" name="radioButton" id="yesG">
                        <label class="radio-label" for="yesG">Yes</label>
                    </li>
                </ul> <!-- cd-filter-content -->
            </div> <!-- cd-filter-block -->
        </form>
    </div>

    <div id="videosContainer" class="GreyContainer">
        <?php

        /**
         * SQL CON UNION, UTILE IN FUTURO
         *             $sql = "SELECT `Url` FROM argomento WHERE Level_1 LIKE '$search' UNION SELECT `Url` FROM universita WHERE Nome LIKE '$search' UNION SELECT `Url` FROM speaker WHERE Nome LIKE '$search' UNION SELECT `Url` FROM autori WHERE Nome LIKE '$search' UNION SELECT `Url` FROM tags WHERE Tag LIKE '$search' GROUP BY Url";
         */
        $sql = "SELECT `Url` FROM argomento WHERE Level_1 LIKE '$search1' UNION SELECT `Url` FROM universita WHERE Nome LIKE '$search1' UNION SELECT `Url` FROM speaker WHERE Nome LIKE '$search1' UNION SELECT `Url` FROM autori WHERE Nome LIKE '$search1' GROUP BY Url";
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
        ?>
    </div>
</div>

<script>
    function openNav() {
        document.getElementById("mySidebar").style.width = "30%";
    }

    function closeNav() {
        document.getElementById("mySidebar").style.width = "0";
    }

    function filter_ajax() {
        var primo = document.getElementById("filtroTipologia").value;
        var secondo = document.getElementById("filtroRicerca").value;
        var terzo = document.querySelector('input[name="radioButton"]:checked').value;
        var search = "<?php echo $search ?>";
        document.getElementById("videosContainer").innerHTML= "";
        $(document).ajaxStart(function(){
            $("#spinner").css("display", "block");
        });
        $(document).ajaxComplete(function(){
            $("#spinner").css("display", "none");
        });
        $.ajax({
            url:"search_video_ajax1.php",
            method:"POST",
            data:{primo:primo, secondo:secondo, terzo:terzo, search: search},
            success:function(data)
            {
                $('#videosContainer').html(data);
            }
        });
    }
</script>
</body>
</html>
