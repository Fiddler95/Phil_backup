<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 20/05/2018
 * Time: 16:41
 */
session_start();
include "connect.php";
include "functions.php";
include 'newPhilPapers.php';
include 'fields.php';
if(!isset($_SESSION['name'])){
    header("Location: home.php");
}

$url = $_GET["id"];
$is_Super = $_GET["super"];
if($is_Super != ""){
    $user= $is_Super;
}
else{
    $user= $_SESSION['name'];
}
$uni="Universita[]";
$spe="Speaker[]";
$aut="Autori[]";

//recupero i primi nodi da phil papers
$id = array();//array che contiene gli id delle categorie selezionate
$name = array();//array che contiene i nomi delle categorie selezionate
foreach ($newPhils as $k =>$v) {
    if($v['depth']==1){
        array_push($name,$v['name']);
        array_push($id,$v['id']);
    }
}
$assArray = array_combine($id, $name);

//recupero i nodi storici da phil papers
$id = array();//array che contiene gli id delle categorie selezionate
$name = array();//array che contiene i nomi delle categorie selezionate
foreach ($newPhils as $k =>$v) {
    if($v['depth']==5){
        array_push($name,$v['name']);
        array_push($id,$v['id']);
    }
}
$h_assArray = array_combine($id, $name);

//NB--> CHIAMATA DELLA FUNZIONE RETRIEVE
$data = retrieveData($user,$url,$conn);
//recupero gli id degli argomenti tematici e stogeo salvati in database
if(isset($data["Level_1"],$data["h_Level_1"])){
    $id_level_1= null;
    $id_level_2= null;
    $id_level_3= null;
    $id_h_level_1= null;
    $id_h_level_2= null;
    foreach ($newPhils as $k =>$v) {
        if($v['name']==$data["Level_1"]){
            $id_level_1 = $v['id'];
        }
        elseif ($v['name']==$data["Level_2"]){
            $id_level_2 = $v['id'];
        }
        elseif ($v['name']==$data["Level_3"]){
            $id_level_3 = $v['id'];
        }
        elseif ($v['name']==$data["h_Level_1"]){
            $id_h_level_1 = $v['id'];
        }
        elseif ($v['name']==$data["h_Level_2"]){
            $id_h_level_2 = $v['id'];
        }
    }
    $lvl_2 = array();//array che contiene il livello 2 dell'argomento tematico
    $id2 = array();//array che contiene gli id delle categorie del livello 2
    $name2 = array();//array che contiene i nomi delle categorie del livello 2

    $lvl_3 = array();//array che contiene il livello 3 dell'argomento tematico
    $id3 = array();//array che contiene gli id delle categorie del livello 3
    $name3 = array();//array che contiene i nomi delle categorie del livello 3

    $h_lvl_2 = array();//array che contiene il livello 2 dell'argomento storico/geografico
    $idh2 = array();//array che contiene gli id delle categorie del livello 2
    $nameh2 = array();//array che contiene i nomi delle categorie del livello 2

    foreach ($newPhils as $k =>$v) {
        if($v['parent']==$id_level_1){
            array_push($name2,$v['name']);
            array_push($id2,$v['id']);
        }
        elseif ($v['parent']==$id_level_2){
            array_push($name3,$v['name']);
            array_push($id3,$v['id']);
        }
        elseif ($v['parent']==$id_h_level_1){
            array_push($nameh2,$v['name']);
            array_push($idh2,$v['id']);
        }
    }

    $lvl_2 = array_combine($id2, $name2);
    $lvl_3 = array_combine($id3, $name3);
    $h_lvl_2 = array_combine($idh2, $nameh2);
}

?>
<!DOCTYPE html>
<html>
<head>
    <link href="style.css" rel = "stylesheet" type = "text/css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script >
        $(document).ready(function () {
            $('#level_1').change(function () {
                var id = $(this).val();
                var target = '#level_2';
                $.ajax({
                    url:"create_sub_lvl.php",
                    method:"POST",
                    data:{id:id,target:target},
                    success:function (data) {
                        $('#level_2').html(data);
                    }
                });
            });

        });
    </script>
    <script >
        $(document).ready(function () {
            $('#level_2').change(function () {
                var id = $(this).val();
                var target = '#level_3';
                $.ajax({
                    url:"create_sub_lvl.php",
                    method:"POST",
                    data:{id:id,target:target},
                    success:function (data) {
                        $('#level_3').html(data);
                    }
                });
            });

        });
    </script>
    <script >
        $(document).ready(function () {
            $('#h_level_1').change(function () {
                var id = $(this).val();
                var target = '#h_level_2';
                $.ajax({
                    url:"create_sub_lvl.php",
                    method:"POST",
                    data:{id:id,target:target},
                    success:function (data) {
                        $('#h_level_2').html(data);
                    }
                });
            });

        });
    </script>
    <script>
        /**
         * funzione per evitare che HTML5 reindirizzi la pagina sul form
         * non compilato ma lo lasci coperto dalla navbar
         */
        var delay = 0;
        var offset = 150;
        document.addEventListener('invalid', function(e){
            $(e.target).addClass("invalid");
            $('html, body').animate({scrollTop: $($(".invalid")[0]).offset().top - offset }, delay);
        }, true);
        document.addEventListener('change', function(e){
            $(e.target).removeClass("invalid")
        }, true);
    </script>

    <script>
        /*
            Funzione che previene l'invio del form sull'enter
         */
        $(document).ready(function() {
            $(window).keydown(function(event){
                if(event.keyCode === 13){
                    event.preventDefault();
                    return false;
                }
            });
        });
    </script>
</head>


<body>
<!-- creazione della barra di navigazione  -->
<div class="topnav">
    <a  href="home_Private.php">Home</a>
    <a class="active" href="my_reviews.php">My Reviews</a>
    <a href="survey.php">Survey</a>
    <a href="about.php">About Us</a>
    <a href="logout.php" style="float: right">Logout</a>
    <a href="profile.php" style="float: right">Profile</a>
</div>

<div id="suggestions" class="modal">
    <!-- Modal Content -->
    <form class="modal-info-content animate">
        <div class="containerForm">
            <span onclick="document.getElementById('suggestions').style.display='none';document.body.style.overflowY = 'auto';" class="close" title="Chiudi">&times;</span>
            <p id="title" style="font-size: larger; margin-top: 0"><b>Info-Box</b></p>
            <p id="content">Errore nel caricamento del testo</p>
        </div>
    </form>
</div>

<div class ="main_container">
    <div id="spinner" class="spinner" style="display:none;">
        <img id="img-spinner" src="pics/spinner.gif" alt="Loading"/>
    </div>
    <div id="reviewContainer" class="GreyContainer">
        <?php
           display_single_video($url);
        ?>
        <form action="send_review.php" method="post">
            <input type="text" name="Url" value="<?php echo $url ?>" style="display: none">
            <input type="text" name="is_Super" value="<?php echo $is_Super ?>" style="display: none">
            <div id="Tipologia" class="field_of_review">
                <strong>Typology: </strong>
                <p>Select the main typology for the video and the secondary one, if you think it is necessary</p>
                <p style="margin: 0px; padding: 0px">
                    <label for="Principale" style="margin-left: 50px ">Main:</label>
                    <select required name="Principale" class="smallSelect">
                        <option disabled selected value> -- select an option -- </option>
                        <?php foreach($tipologiaOptions as $key => $value){
                            if($value == $data["Principale"])
                                echo"<option value='". $value ."' selected = \"selected\">".$value."</option>";
                            else
                                echo"<option value='". $value ."'>".$value."</option>";
                        }?>
                    </select>
                    <label for="Secondaria" style="margin-left: 50px ">Secondary:</label>
                    <select name="Secondaria" class="smallSelect">
                        <option disabled selected value> -- select an option -- </option>
                        <?php foreach($tipologiaOptions as $key => $value){
                            if($value == $data["Secondaria"])
                                echo"<option value='". $value ."' selected = \"selected\">".$value."</option>";
                            else
                                echo"<option value='". $value ."'>".$value."</option>";
                        }?>
                    </select></p>
            </div>

            <div id="Autori" class="field_of_review">
                <strong>Authors: </strong>
                <p>If a video is ON an author, click on his or her name (and if not present, put it in the slot here). IF the video concerns ALSO other authors, put their names only in the "tag" slot below</p>

                <table>
                    <tr>
                        <td>
                            <fieldset style='overflow: auto; height: 20vh; width: 35vw; border-style: none'>
                                <?php foreach($authors_list as $key => $value){
                                    if(in_array($value,$data["Autori"])){
                                        echo"<input type=\"checkbox\" name=". $aut ." value='". $value ."' checked=\"checked\"> ".$value."<br>";
                                    }
                                    else{
                                        echo"<input type=\"checkbox\" name=". $aut ." value='". $value ."'> ".$value."<br>";
                                    }

                                }?>
                        </td>
                        <td>
                            <textarea id="unlisted_athors" name="unlisted_athors" style="width: 30vw;height: 20vh; float: left; overflow: hidden" placeholder="Insert here the authors that are not in the list.&#x0a;If you need to insert more than one name, please separate each name with a comma as in the example below:&#x0a;&#x0a;Socrate, Platone, Aristotele "><?php if (array_key_exists('Autori_UL', $data)) {echo $data["Autori_UL"];}?></textarea>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="Speaker" class="field_of_review">
                <strong>Speaker: </strong>
                <p>Select the speaker from the list provided, if he is known</p>

                <table>
                    <tr>
                        <td>
                            <fieldset style='overflow: auto; height: 20vh; width: 35vw; border-style: none'>
                                <?php foreach($speakers_list as $key => $value){
                                    if(in_array($value,$data["Speaker"])){
                                        echo"<input type=\"checkbox\" name=". $spe ." value='". $value ."' checked=\"checked\"> ".$value."<br>";
                                    }
                                    else{
                                        echo"<input type=\"checkbox\" name=". $spe ." value='". $value ."'> ".$value."<br>";
                                    }
                                }?>
                        </td>
                        <td>
                            <textarea id="unlisted_speakes" name="unlisted_speakes" style="width: 30vw;height: 20vh; float: left; overflow: hidden" placeholder="Insert here the speakers that are not in the list.&#x0a;If you need to insert more than one name, please separate each name with a comma as in the example below:&#x0a;&#x0a;Bryan Magee, John Searle "><?php if (array_key_exists('Speaker_UL', $data)) {echo $data["Speaker_UL"];}?></textarea>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="Universita" class="field_of_review">
                <img class="help_icon" onclick="document.getElementById('suggestions').style.display='block'; document.getElementById('content').innerHTML= '<?php echo html_entity_decode($uni_help_text); ?>';" src="pics/help_icon.png"/>
                <strong>University: </strong>
                <p>Select the university from the list provided; if it is not present, insert it using the names you find at this <a href="https://univ.cc/" target="_blank">link</a></p>

                <table>
                    <tr>
                        <td>
                            <fieldset style='overflow: auto; height: 20vh; width: 35vw; border-style: none'>
                                <?php foreach($universities_list as $key => $value){
                                    if(in_array($value,$data["Universita"])){
                                        echo"<input type=\"checkbox\" name=". $uni ." value='". $value ."' checked=\"checked\"> ".$value."<br>";
                                    }
                                    else{
                                        echo"<input type=\"checkbox\" name=". $uni ." value='". $value ."'> ".$value."<br>";
                                    }
                                }?>
                        </td>
                        <td>
                            <textarea id="unlisted_uni" name="unlisted_uni" style="width: 30vw;height: 20vh; float: left; overflow: hidden" placeholder="Insert here the Universities that are not in the list.&#x0a;If you need to insert more than one, please separate each University with a comma as in the example below:&#x0a;&#x0a;University of Genoa, University of Florence "><?php if (array_key_exists('Universita_UL', $data)) {echo $data["Universita_UL"];}?></textarea>
                        </td>
                    </tr>
                </table>
            </div>

            <div id="Argomento" class="field_of_review">
                <img class="help_icon" onclick="document.getElementById('suggestions').style.display='block'; document.getElementById('content').innerHTML= '<?php echo html_entity_decode($thematic_help_text); ?>';" src="pics/help_icon.png"/>
                <strong>Thematic Topic: </strong>
                <p>Select the main thematic topic covered in the video. Specify a general category and a more detailed one to better classify the video</p>
                <p style="margin: 0px; padding: 0px">
                    <label for="level_1" style="margin-left: 50px ">General:</label>
                    <select required name="level_1" id="level_1" class="smallSelect">
                        <option disabled selected value> -- select an option -- </option>
                        <?php
                        $_POST["Url"]= $url;

                        foreach($assArray as $key => $value){
                            if($value == $data["Level_1"]){
                                echo"<option value=". $key ." selected = \"selected\">".$value."</option>";
                            }
                            else{
                                echo"<option value=". $key .">".$value."</option>";
                            }
                        }?>
                    </select>
                    <label for="level_2" style="margin-left: 50px ">Detail:</label>
                    <select required name="level_2" id="level_2" class="smallSelect">
                        <option disabled selected value> -- select general topic -- </option>
                        <?php
                        if(isset($lvl_2)) {
                            foreach ($lvl_2 as $key => $value) {
                                if($value == $data["Level_2"]){
                                    echo"<option value=". $key ." selected = \"selected\">".$value."</option>";
                                }
                                else{
                                    echo"<option value=". $key .">".$value."</option>";
                                }
                            }
                        }?>
                    </select></p>
            </div>
            <div id="Tags" class="field_of_review">
                <img class="help_icon" onclick="document.getElementById('suggestions').style.display='block'; document.getElementById('content').innerHTML= '<?php echo html_entity_decode($tags_help_text); ?>';" src="pics/help_icon.png"/>
                <strong>Tags: </strong>
                <p>Select a specific topic, if any, and at least 5 tags to better classify the video, starting from titles of books related to the topic / author.</p>

                <table>
                    <tr>
                        <td>
                            <label for="level_3" style="margin-left: 50px ">Specific:</label>
                            <select required name="level_3" id="level_3" class="smallSelect" style="width: 25vw">
                                <option disabled selected value> -- select detailed topic -- </option>
                                <?php
                                if(isset($lvl_3)) {
                                    foreach ($lvl_3 as $key => $value) {
                                        if($value == $data["Level_3"]){
                                            echo"<option value=". $key ." selected = \"selected\">".$value."</option>";
                                        }
                                        else{
                                            echo"<option value=". $key .">".$value."</option>";
                                        }
                                    }
                                }?>
                            </select>
                        </td>
                        <td>
                            <textarea id="free-tags" name="free-tags" style="width: 30vw;height: 20vh; float: left; overflow: hidden" placeholder="Insert least 5 tags, each one separated from the others with a comma as in the example below:&#x0a;&#x0a;Philosophical investigations, Metaphysics, Discourse on the method"><?php if (array_key_exists('Unlisted_tag', $data)) {echo $data["Unlisted_tag"];}?></textarea>
                        </td>
                    </tr>
                </table>
            </div>

            <div id="Storico" class="field_of_review" style="border-bottom: 2px cornflowerblue solid ">
                <strong>Historical / Geographical Scope: </strong>
                <p>Select the Historical / Geographical scope covered in the video. Specify a general category and a more detailed one to better classify the video</p>
                <p style="margin: 0px; padding: 0px">
                    <label for="h_level_1" style="margin-left: 50px ">General:</label>
                    <select required name="h_level_1" id="h_level_1" class="smallSelect">
                        <option disabled selected value> -- select an option -- </option>
                        <?php
                        foreach($h_assArray as $key => $value){
                            if($value == $data["h_Level_1"]){
                                echo"<option value=". $key ." selected = \"selected\">".$value."</option>";
                            }
                            else{
                                echo"<option value=". $key .">".$value."</option>";
                            }
                        }?>
                    </select>
                    <label for="h_level_2" style="margin-left: 50px ">Detail:</label>
                    <select name="h_level_2" id="h_level_2" class="smallSelect">
                        <option disabled selected value> -- select general topic -- </option>
                        <?php
                        if(isset($h_lvl_2)) {
                            foreach ($h_lvl_2 as $key => $value) {
                                if($value == $data["h_Level_2"]){
                                    echo"<option value=". $key ." selected = \"selected\">".$value."</option>";
                                }
                                else{
                                    echo"<option value=". $key .">".$value."</option>";
                                }
                            }
                        }?>
                    </select></p>
            </div>

            <div class="field_of_review">
                <p style="font-weight: bold; font-style: italic ">In this part, we ask you to answer "from your point of view". Don't worry if you don't think to have sufficient knowledge to judge the quality or the difficulty of the content: YOUniversity will relativize your answer to your level of education.</p>
            </div>
            <?php display_campiSoggettivi($data); ?>

            <div id="isGraphic" class="field_of_review">
                    <strong>Does the video have graphic content? </strong>
                    <p style="font-style: italic">For graphic content, we mean animation, graphics, slides, or any visual aid used for the explanation. Rule out video podcast with still image, live recordings of live conferences, anywhere the visual part doesn't help the explanation. Instead, if there is a live conference that use sistematically images or projected slides, you can say that there is graphic content.</p>
                    <div class="onoffswitch">
                        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" <?php if(isset($data["onoffswitch"])) echo "checked"?> onclick="graphicPart()">
                        <label class="onoffswitch-label" for="myonoffswitch" >
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
            </div>

            <div id="graphicSection" class="field_of_review" <?php if(isset($data["onoffswitch"])){echo "style=\"display: block; padding: 0 0\"";} else {echo "style=\"display: none; padding: 0 0\"";} ?>>
                <div id="G_qualità" class="field_of_review">
                    <img class="help_icon" onclick="document.getElementById('suggestions').style.display='block'; document.getElementById('content').innerHTML= '<?php echo html_entity_decode($visual_quality_help_text); ?>';" src="pics/help_icon.png"/>
                    <strong>Quality of the graphic presentation: </strong>
                        <select name="G_qualità" style="width: 35vw">
                            <option disabled selected value> -- select an option -- </option>
                            <option value=0 <?php check(0,'G_qualità',$data)?>>Bad</option>
                            <option value=1 <?php check(1,'G_qualità',$data)?>>Discrete</option>
                            <option value=2 <?php check(2,'G_qualità',$data)?>>Good</option>
                            <option value=3 <?php check(3,'G_qualità',$data)?>>Great</option>
                        </select>
                </div>

                <div id="G_semplicità" class="field_of_review">
                    <img class="help_icon" onclick="document.getElementById('suggestions').style.display='block'; document.getElementById('content').innerHTML= '<?php echo html_entity_decode($visual_simplicity_help_text); ?>';" src="pics/help_icon.png"/>
                    <strong>Simplicity of the graphic presentation: </strong>
                    <select name="G_semplicità" style="width: 35vw">
                        <option disabled selected value> -- select an option -- </option>
                        <option value=0 <?php check(0,'G_semplicità',$data)?>>Bad</option>
                        <option value=1 <?php check(1,'G_semplicità',$data)?>>Discrete</option>
                        <option value=2 <?php check(2,'G_semplicità',$data)?>>Good</option>
                        <option value=3 <?php check(3,'G_semplicità',$data)?>>Great</option>
                    </select>
                </div>

                <div id="G_supporto" class="field_of_review">
                    <strong>Do the images help understanding the video?</strong>
                    <select name="G_supporto" style="width: 35vw">
                        <option disabled selected value> -- select an option -- </option>
                        <option value=0 <?php check(0,'G_supporto',$data)?>>Not at all, the images show only the speaker or written words</option>
                        <option value=1 <?php check(1,'G_supporto',$data)?>>A little, there are some visual references (photos, documents, etc.)</option>
                        <option value=2 <?php check(2,'G_supporto',$data)?>>Quite, the images are used to support the explanation</option>
                        <option value=3 <?php check(3,'G_supporto',$data)?>>Very much, the explanation is in constant connection with the video (graphics, animations, etc.)</option>
                    </select>
                </div>

                <div id="G_coerenza" class="field_of_review">
                    <strong>Do the images refer faithfully to the words being written / uttered in this video?</strong>
                    <select name="G_coerenza" style="width: 35vw">
                        <option disabled selected value> -- select an option -- </option>
                        <option value=0 <?php check(0,'G_coerenza',$data)?>>Not at all</option>
                        <option value=1 <?php check(1,'G_coerenza',$data)?>>A little</option>
                        <option value=2 <?php check(2,'G_coerenza',$data)?>>Quite</option>
                        <option value=3 <?php check(3,'G_coerenza',$data)?>>Very much</option>
                    </select>
                </div>


            </div>

            <button class="submitBtn" type="submit">Submit</button>
        </form>
    </div>

</body>



<script>
    function graphicPart()
    {
        if(document.getElementById("graphicSection").style.display==="block")
        {
            document.getElementById("graphicSection").style.display="none";
        }
        else if(document.getElementById("graphicSection").style.display==="none")
        {
            document.getElementById("graphicSection").style.display="block";
        }
        else alert("Hello! non sono entrato nell'if");

    }
</script>
</html>
