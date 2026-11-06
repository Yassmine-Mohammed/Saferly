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
    $trip_id = filter_var($_GET['trip_id'], FILTER_VALIDATE_INT);
    if ($trip_id === false || $trip_id <= 0) {
        http_response_code(400);
        exit("Invalid trip ID.");
    }

    // استخدام INSERT IGNORE لمنع تكرار الإيرور لو الرحلة مضافة مسبقاً
    $stmt = mysqli_prepare($con, "INSERT IGNORE INTO favorites (user_id, trip_id) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $trip_id);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($result) {
        echo "<script>alert('Added to favorites successfully! ❤️'); window.location.href='../index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>