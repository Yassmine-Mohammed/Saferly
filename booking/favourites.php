<?php
session_start();
require "../config/db.php";

// التأكد من أن المستخدم مسجل دخول وعنده user_id في الـ Session
// (لو لسه مش عاملة نظام تسجيل دخول كامل، ممكن نحط رقم مستخدم تجريبي مؤقتاً زي 1)
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1; 

if (isset($_GET['trip_id'])) {
    $trip_id = $_GET['trip_id'];
    
    // إدخال الـ user_id مع الـ trip_id في جدول المفضلة
    $sql = "INSERT INTO favorites (user_id, trip_id) VALUES ($user_id, $trip_id)";
    
    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Added to favorites successfully! ❤️'); window.location.href='../index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>