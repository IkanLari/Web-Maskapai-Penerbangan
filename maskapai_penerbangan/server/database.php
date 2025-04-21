<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database_name = "maskapai_penerbangan";

$db = mysqli_connect($hostname, $username, $password, $database_name);


if ($db->connect_error) {
    echo "Koneksi database error";
    die("error!");
}

?>