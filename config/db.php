<?php

$host = "db62040.databaseasp.net";
$user = "db62040";
$password = "Yk3@?6Em2h-W";
$database = "db62040";
$port = 3306;

$con = mysqli_connect($host, $user, $password, $database, $port);

if (!$con) {
    die("Connection Failed: " . mysqli_connect_error());
}

mysqli_set_charset($con, "utf8mb4");

?>