<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 20/04/2018
 * Time: 15:39
 */

$servername = "160.153.155.3";
$username = "dynamo";
$password = "1226Hp3181";
$db_name = "db_philvideos";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $db_name);

// Check connection
if (!$conn) {

        die("Connection failed: " . mysqli_connect_error());
}
?>