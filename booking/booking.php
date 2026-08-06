<?php
session_start();
require "../config/db.php";

// جلب أول user_id موجود في الداتايز تلقائياً عشان ميحصلش إيرور
$user_result = mysqli_query($con, "SELECT user_id FROM users LIMIT 1");
if ($row_user = mysqli_fetch_assoc($user_result)) {
    $user_id = $row_user['user_id'];
} else {
    $user_id = 1; 
}

if (isset($_GET['trip_id'])) {
    $trip_id = intval($_GET['trip_id']);

    // استعلام إضافة الحجز //
    $sql = "INSERT INTO bookings (user_id, trip_id, booking_date, status) 
            VALUES ($user_id, $trip_id, NOW(), 'pending')";

    if (mysqli_query($con, $sql)) {
        echo "<script>
                alert('تم إرسال طلب الحجز بنجاح 🎉');
                window.location.href = '../trip_details.php?trip_id=$trip_id';
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