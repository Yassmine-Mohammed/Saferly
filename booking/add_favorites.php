<?php
session_start();
require_once "../config/db.php";

require "../includes/login_check.php";
checklogin();

$user_id = intval($_SESSION['user']['user_id']);
$trip_id = isset($_GET['trip_id']) ? intval($_GET['trip_id']) : 0;
if ($user_id <= 0) {
    http_response_code(400);
    exit("Invalid user ID.");
}

$status = "error"; // الحالة الافتراضية

if ($trip_id > 0) {
    try {
        $stmt = mysqli_prepare($con, "INSERT IGNORE INTO favorites (user_id, trip_id) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, "ii", $user_id, $trip_id);
        mysqli_stmt_execute($stmt);

        // affected_rows بترجع 1 لو صف جديد اتضاف فعلاً، وترجع 0 لو كان موجود بالفعل وتجاهله
        if (mysqli_affected_rows($con) > 0) {
            echo "<script>alert('The trip was saved to Favorite List');</script>";
            $status = "added";
        } else {
            echo "<script>alert('The trip is already exists in your Favorite List');</script>";
            $status = "already_exists";
        }
        mysqli_stmt_close($stmt);
    } catch (mysqli_sql_exception $e) {
        if (isset($stmt) && $stmt instanceof mysqli_stmt) {
            mysqli_stmt_close($stmt);
        }
        error_log("Favorites insert error: " . $e->getMessage());
        $status = "error";
    }
}

header("Location: ../index.php?fav_status=" . $status);
exit();
?>