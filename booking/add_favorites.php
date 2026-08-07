<?php
session_start();
require_once "../config/db.php";

// التأكد من تسجيل الدخول وجلب الـ user_id الحقيقي
if (!isset($_SESSION['user_id'])) {
    header("Location: ../search/index.php");
    exit();
}

$user_id = intval($_SESSION['user_id']);
$trip_id = isset($_GET['trip_id']) ? intval($_GET['trip_id']) : 0;

if ($trip_id > 0) {
    $check_sql = "SELECT * FROM favorites WHERE user_id = $user_id AND trip_id = $trip_id";
    $check_res = mysqli_query($con, $check_sql);

    if ($check_res && mysqli_num_rows($check_res) == 0) {
        $sql = "INSERT INTO favorites (user_id, trip_id) VALUES ('$user_id', '$trip_id')";
        mysqli_query($con, $sql);
    }
}

header("Location: favourites.php");
exit();
?>