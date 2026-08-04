<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $con = mysqli_connect(
        "db62034.public.databaseasp.net",
        "db62040",
        "Yk3@?6Em2h-W",
        "db62040",
        3306
    );

    mysqli_set_charset($con, "utf8mb4");

} catch (mysqli_sql_exception $e) {
<<<<<<< HEAD
=======

>>>>>>> 24cb34c22728456cd2a20e344201437e7efcbd91
    die($e->getMessage());
}