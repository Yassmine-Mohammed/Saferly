<?php
session_start();
require_once "../config/db.php";

// معرف المستخدم (مؤقتاً 1 لتجربة الحجز حتى ربط الـ Session)
$user_id = $_SESSION['user_id'] ?? 1;

if (isset($_GET['trip_id'])) {
    $trip_id = intval($_GET['trip_id']);
    
    // استعلام إضافة الحجز
    $sql = "INSERT INTO bookings (user_id, trip_id, booking_date, status) 
            VALUES ('$user_id', '$trip_id', NOW(), 'pending')";
    
    if (mysqli_query($con, $sql)) {
        echo "<script>
                alert('🎉 تم إرسال طلب الحجز بنجاح!');
                window.location.href = '../trip_details.php?id=$trip_id';
              </script>";
    } else {
        echo "خطأ في تنفيذ الحجز: " . mysqli_error($con);
    }
} else {
    echo "<script>
            window.location.href = '../index.php';
          </script>";
    exit();
}
?>