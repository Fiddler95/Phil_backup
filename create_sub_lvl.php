<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 09/08/2018
 * Time: 18:49

File per la funzione di caricamento asincrono dei rami secondari dell'albero "argomenti"
 */
session_start();
include "connect.php";
include "functions.php";
include "newPhilPapers.php";
if(!isset($_SESSION['name'])){
    header("Location: home.php");
}
$user = $_SESSION['name'];
$output = '';
$father = $_POST['id'];
$target =  $_POST['target'];
$id = array();//array che contiene gli id delle categorie selezionate
$name = array();//array che contiene i nomi delle categorie selezionate
foreach ($newPhils as $k =>$v) {
    if($v['parent']==$father){
        array_push($name,$v['name']);
        array_push($id,$v['id']);
    }
}
$assArray = array_combine($id, $name);


// .= è un operatore di concatenazione
$output .= '<select name="'.$target.'" id="'.$target.'" class="smallSelect">
            <option disabled selected value> -- select topic -- </option>';

foreach($assArray as $key => $value){
    $output .='<option value="'. $key .'">'.$value.'</option>"';
}
$output .='</select>';
echo $output;
?>