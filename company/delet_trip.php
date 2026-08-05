<?php
/* company/delet_trip.php */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../config/db.php";

if (empty($_SESSION['company'])) {
    header("Location: ../auth/login.php");
    exit();
}

$company_id = (int) $_SESSION['company']['company_id'];
$trip_id    = (int) ($_GET['trip_id'] ?? 0);

if ($trip_id <= 0) {
    header("Location: dashboard.php?error=" . urlencode("Invalid trip."));
    exit();
}

/* -------- التأكد أن الرحلة تخص هذه الشركة قبل الحذف -------- */
$stmt = mysqli_prepare($con, "SELECT image FROM trips WHERE trip_id = ? AND company_id = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "ii", $trip_id, $company_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    mysqli_stmt_close($stmt);
    header("Location: dashboard.php?error=" . urlencode("Trip not found or access denied."));
    exit();
}

$trip = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

/* -------- الحذف (Prepared Statement) -------- */
$stmt = mysqli_prepare($con, "DELETE FROM trips WHERE trip_id = ? AND company_id = ?");
mysqli_stmt_bind_param($stmt, "ii", $trip_id, $company_id);

if (mysqli_stmt_execute($stmt)) {
    // حذف ملف الصورة المرتبطة بالرحلة من السيرفر إن وُجد
    if (!empty($trip['image'])) {
        $imagePath = "../assets/images/trips/" . $trip['image'];
        if (is_file($imagePath)) {
            @unlink($imagePath);
        }
    }
    mysqli_stmt_close($stmt);
    header("Location: dashboard.php?deleted=1");
    exit();
} else {
    mysqli_stmt_close($stmt);
    header("Location: dashboard.php?error=" . urlencode("Could not delete the trip."));
    exit();
}