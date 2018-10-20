<pre>
<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 12/08/2018
 * Time: 11:11
 *
 * $arg1 = $_GET['arg1'];
$arg2 = $_GET['arg2'];
$return = (int)$arg1 + (int)$arg2;
echo $return;
 *
 */
include 'connect.php';
session_start();
$user = $_SESSION['name'];
print_r($_POST);
?>
</pre>

