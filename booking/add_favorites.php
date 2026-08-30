<?php
session_start();
require_once "../config/db.php";

require "../includes/login_check.php";
checklogin();

$user_id = intval($_SESSION['user']['user_id']);
$trip_id = isset($_GET['trip_id']) ? intval($_GET['trip_id']) : 0;

$status = "error"; // الحالة الافتراضية

if ($trip_id > 0) {
    try {
        $sql = "INSERT IGNORE INTO favorites (user_id, trip_id) VALUES ($user_id, $trip_id)";
        mysqli_query($con, $sql);

        // affected_rows بترجع 1 لو صف جديد اتضاف فعلاً، وترجع 0 لو كان موجود بالفعل وتجاهله
        if (mysqli_affected_rows($con) > 0) {
            echo "<script>alert('The trip was saved to Favorite List');</script>";
            $status = "added";
        } else {
            echo "<script>alert('The trip is already exists in your Favorite List');</script>";
            $status = "already_exists";
        }
    } catch (mysqli_sql_exception $e) {
        error_log("Favorites insert error: " . $e->getMessage());
        $status = "error";
    }
}

header("Location: ../search/index.php?fav_status=" . $status);
exit();
?>