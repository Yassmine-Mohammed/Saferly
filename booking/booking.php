<?php
session_start();
require_once "../config/db.php";

// جلب الـ user_id الصحيح
if (isset($_SESSION['user_id'])) {
    $user_id = intval($_SESSION['user_id']);
} else {
    $result_user = mysqli_query($con, "SELECT user_id FROM users LIMIT 1");
    if ($result_user && mysqli_num_rows($result_user) > 0) {
        $row_user = mysqli_fetch_assoc($result_user);
        $user_id = $row_user['user_id'];
    } else {
        $user_id = 1;
    }
}

$trip_id = isset($_GET['trip_id']) ? intval($_GET['trip_id']) : 0;

// عند تأكيد الحجز
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $trip_id > 0) {
    // محاولة الإدخال مع الأعمدة الأساسية الشائعة
    $sql = "INSERT INTO bookings (user_id, trip_id, booking_date) VALUES ('$user_id', '$trip_id', NOW())";
    
    if (mysqli_query($con, $sql)) {
        // التوجيه إلى صفحة الهوم بعد النجاح
        header("Location: ../search/index.php");
        exit();
    } else {
        // لو جدول البوكنج فيه أعمدة تانية إجبارية زي status أو total_price
        $sql_alt = "INSERT INTO bookings (user_id, trip_id) VALUES ('$user_id', '$trip_id')";
        if (mysqli_query($con, $sql_alt)) {
            // التوجيه إلى صفحة تفاصيل الرحلة بعد النجاح
            header("Location: trip_details.php?id=" . $trip_id);
            exit();
        } else {
            $error = "Database Error: " . mysqli_error($con);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Complete Booking</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="dark-theme">

<div class="custom-container" style="max-width: 600px; margin: 40px auto; background: #111; padding: 30px; border-radius: 8px; border: 1px solid #333;">
    <h2 style="color: #fff; border-bottom: 2px solid #ff8c00; padding-bottom: 10px;">Confirm Your Booking ✈️</h2>
    
    <?php if (isset($error)) { echo "<p style='color: #ff5252; margin-top: 15px; font-size: 0.9em;'>$error</p>"; } ?>

    <form method="POST" style="margin-top: 20px;">
        <p style="color: #ccc; margin-bottom: 20px;">Are you sure you want to complete the booking for this trip?</p>
        <button type="submit" class="book-btn" style="background: #ff8c00; color: #fff; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 1em;">Confirm Booking</button>
    </form>

    <a href="trip_details.php?id=<?php echo $trip_id; ?>" style="display: inline-block; margin-top: 20px; color: #ff8c00; text-decoration: underline;">Back to Trip Details</a>
</div>

</body>
</html>