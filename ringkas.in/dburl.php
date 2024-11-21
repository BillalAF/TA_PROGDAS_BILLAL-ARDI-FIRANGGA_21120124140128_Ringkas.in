<?php
$db_host ='localhost';
$db_user ='root';
$db_name ='bismillahta';
$db_password ='';

$connection = new mysqli($db_host, $db_user, $db_password, $db_name);

if ($connection->connect_error) {
    die('koneksi gagal:'. $connection->connect_error);
}
?>