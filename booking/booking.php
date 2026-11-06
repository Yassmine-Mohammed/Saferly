<?php
session_start();
require "../config/db.php";

require_once"../includes/login_check.php";
checklogin();
$user_id = intval($_SESSION['user']['user_id']);
$trip_id = isset($_GET['trip_id']) ? intval($_GET['trip_id']) : 0;
if ($user_id <= 0) {
    http_response_code(400);
    exit("Invalid user ID.");
}
// عند تأكيد الحجز
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $trip_id > 0) {
    // محاولة الإدخال مع الأعمدة الأساسية الشائعة
    $stmt = mysqli_prepare($con, "INSERT INTO bookings (user_id, trip_id, booking_date) VALUES (?, ?, NOW())");
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $trip_id);
    $bookingCreated = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($bookingCreated) {
        // التوجيه إلى صفحة الهوم بعد النجاح
        header("Location: ../index.php");
        exit();
    } else {
        // لو جدول البوكنج فيه أعمدة تانية إجبارية زي status أو total_price
        $fallbackStmt = mysqli_prepare($con, "INSERT INTO bookings (user_id, trip_id) VALUES (?, ?)");
        mysqli_stmt_bind_param($fallbackStmt, "ii", $user_id, $trip_id);
        $fallbackBookingCreated = mysqli_stmt_execute($fallbackStmt);
        mysqli_stmt_close($fallbackStmt);
        if ($fallbackBookingCreated) {
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
    <?php require_once __DIR__ . '/../includes/functions.php'; ?>
    <link rel="icon" type="image/png" href="<?= htmlspecialchars(app_url('assets/images/SaferlyLogo.png'), ENT_QUOTES, 'UTF-8') ?>">
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