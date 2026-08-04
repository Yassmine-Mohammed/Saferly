<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
$con = mysqli_connect(
        "localhost",
        "root",
        "",
        "db62040",
        3306
    );

    mysqli_set_charset($con, "utf8mb4");

} catch (mysqli_sql_exception $e) {

    die($e->getMessage());


    die($e->getMessage());
}