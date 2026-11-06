<?php
session_start();
require_once("../config/db.php");

require_once "../includes/login_check.php";
checkLogin();

$userId = filter_var($_SESSION['user']['user_id'] ?? null, FILTER_VALIDATE_INT);
if ($userId === false || $userId <= 0) {
    http_response_code(400);
    exit("Invalid user ID.");
}
//===========================
// Delete Profile
//===========================
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    
    // نمسح كل الصفوف المرتبطة بالمستخدم في الجداول التانية الأول
    // عشان مانكسرش foreign key لما نمسح المستخدم نفسه
    $deleteBookingsStmt = mysqli_prepare($con, "DELETE FROM bookings WHERE user_id = ?");
    mysqli_stmt_bind_param($deleteBookingsStmt, "i", $userId);
    mysqli_stmt_execute($deleteBookingsStmt);
    mysqli_stmt_close($deleteBookingsStmt);

    $deleteReviewsStmt = mysqli_prepare($con, "DELETE FROM reviews WHERE user_id = ?");
    mysqli_stmt_bind_param($deleteReviewsStmt, "i", $userId);
    mysqli_stmt_execute($deleteReviewsStmt);
    mysqli_stmt_close($deleteReviewsStmt);

    $deleteFavoritesStmt = mysqli_prepare($con, "DELETE FROM favorites WHERE user_id = ?");
    mysqli_stmt_bind_param($deleteFavoritesStmt, "i", $userId);
    mysqli_stmt_execute($deleteFavoritesStmt);
    mysqli_stmt_close($deleteFavoritesStmt);

    // نمسح صورة البروفايل من السيرفر لو مش الصورة الافتراضية
    if (!empty($_SESSION['user']['image']) && $_SESSION['user']['image'] !== 'default.png') {
        $imgPath = "uploads/user/" . $_SESSION['user']['image'];
        if (file_exists($imgPath)) {
            unlink($imgPath);
        }
    }

    // نمسح المستخدم نفسه
    $deleteUserStmt = mysqli_prepare($con, "DELETE FROM users WHERE user_id = ? LIMIT 1");
    mysqli_stmt_bind_param($deleteUserStmt, "i", $userId);
    $deleteUser = mysqli_stmt_execute($deleteUserStmt);
    mysqli_stmt_close($deleteUserStmt);

    if ($deleteUser) {
        // ننهي الجلسة ونرجّعه لصفحة تسجيل الدخول
        session_unset();
        session_destroy();
        
        header("Location: login.php?deleted=1");
        exit();
    } else {
        // لو الحذف فشل هيظهر سبب الخطأ بدل ما يفشل بصمت
        $error = "لم يتم حذف الحساب: " . mysqli_error($con);
    }
}

//===========================
// User Profile Data
//===========================
$userId = filter_var($_SESSION['user']['user_id'] ?? null, FILTER_VALIDATE_INT);

$profileStmt = mysqli_prepare($con, "SELECT * FROM users WHERE user_id = ?");
mysqli_stmt_bind_param($profileStmt, "i", $userId);
mysqli_stmt_execute($profileStmt);
$result = mysqli_stmt_get_result($profileStmt);

$row = mysqli_fetch_assoc($result);
mysqli_stmt_close($profileStmt);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once __DIR__ . '/../includes/functions.php'; ?>
    <link rel="icon" type="image/png" href="<?= htmlspecialchars(app_url('assets/images/SaferlyLogo.png'), ENT_QUOTES, 'UTF-8') ?>">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/profile.css">
    <link rel="stylesheet" href="../includes/CSS/includes.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <title>Profile Page</title>
</head>

<body>
    <?php include_once("../includes/header.php"); ?>
    <div class="profile">
        <?php include_once("navbar.php"); ?>
        <main class="profile-page">
            <div class="profile-card w-75">
                <div class="UP_photo">
                    <img src="uploads\user\<?= htmlspecialchars($row['image']) ?>" alt="Profile">
                </div>

                <div class="user-data">
                    <h2>Name: <?= htmlspecialchars($_SESSION["user"]['name']) ?></h2>
                    <h3>Email: <?= htmlspecialchars($_SESSION["user"]['email']) ?></h3>
                    <h3>Phone: <?= htmlspecialchars($_SESSION["user"]['phone']) ?></h3>
                </div>
            </div>
        </main>
    </div>
    <?php include_once("../includes/footer.php"); ?>
    <script src="../js/bootstrap.bundle.min.js"></script>

</body>

</html>