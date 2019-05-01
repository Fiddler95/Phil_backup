<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 18/08/2018
 * Time: 19:39
 */

$text = "bello, brutto , giallo , 'pinocchio', hhiihoi, \"ggggggg\"";
$free_tags = explode(",", $text);
$free_tags = array_map('trim', $free_tags);

//taglia virgolette doppie e semplici
$one=(integer)1;
$items = '';
foreach ($free_tags as $tag){
    $find = array("\"","'");
    $tag = str_replace($find,"",$tag);
    var_dump($tag);
}

?>

<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

</body>
</html>