<pre>
<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 13/07/2018
 * Time: 23:02
 */

include "philpapers.array.php";
$old_array = $philpapers_categories;
$counter = 0;
foreach ($old_array as $k =>$v) {
    if( strpos( $v['name'], "Misc" ) !== false){
        print_r($old_array["$k"]) ;
        echo "<br>";
    }
}
echo $counter;
echo count($old_array);
//$results = var_export($old_array,true);
//file_put_contents('philpapers.array.php', var_export($old_array, true));
//print_r("$old_array");
?>
</pre>