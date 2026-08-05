<?php
session_start();
require "../config/db.php";

// جلب الـ user_id تلقائياً عشان ميحصلش إيرور لو السيشن فاضية
$user_result = mysqli_query($con, "SELECT user_id FROM users LIMIT 1");
if ($row_user = mysqli_fetch_assoc($user_result)) {
    $user_id = $row_user['user_id'];
} else {
    $user_id = 1; 
}

if (isset($_GET['trip_id'])) {
    $trip_id = $_GET['trip_id'];

    // استخدام INSERT IGNORE لمنع تكرار الإيرور لو الرحلة مضافة مسبقاً
    $sql = "INSERT IGNORE INTO favorites (user_id, trip_id) VALUES ($user_id, $trip_id)";

    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Added to favorites successfully! ❤️'); window.location.href='../index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>