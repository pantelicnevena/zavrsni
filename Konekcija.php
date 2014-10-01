<?php
/**
 * Created by PhpStorm.
 * User: Nevena
 * Date: 7/23/14
 * Time: 2:11 PM
 */

$mysql_server = "localhost";
$mysql_user = "root";
$mysql_password = "";
$mysql_db = "kafic";
$mysqli = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_db);
$db = $mysqli;


if ($mysqli->connect_errno) {
    printf("Konekcija neuspešna: %s\n", $mysqli->connect_error);
    exit();
}
$mysqli->set_charset("utf8");

?>