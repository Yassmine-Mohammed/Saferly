<?php
session_start();
require_once("../config/db.php");

require_once "../includes/login_check.php";
checkLogin();

$userId = $_SESSION['user']['user_id'];
//===========================
// Delete Profile
//===========================
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    
    $userId = mysqli_real_escape_string($con, $userId);

    // نمسح كل الصفوف المرتبطة بالمستخدم في الجداول التانية الأول
    // عشان مانكسرش foreign key لما نمسح المستخدم نفسه
    mysqli_query($con, "DELETE FROM bookings WHERE user_id = '$userId'");
    mysqli_query($con, "DELETE FROM reviews WHERE user_id = '$userId'");
    mysqli_query($con, "DELETE FROM favorites WHERE user_id = '$userId'");

    // نمسح صورة البروفايل من السيرفر لو مش الصورة الافتراضية
    if (!empty($_SESSION['user']['image']) && $_SESSION['user']['image'] !== 'default.png') {
        $imgPath = "uploads/user/" . $_SESSION['user']['image'];
        if (file_exists($imgPath)) {
            unlink($imgPath);
        }
    }

    // نمسح المستخدم نفسه
    $deleteUser = mysqli_query($con, "DELETE FROM users WHERE user_id = '$userId' LIMIT 1");

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
$userId = $_SESSION['user']['user_id'];

$query = "SELECT * FROM users WHERE user_id = '$userId'";
$result = mysqli_query($con, $query);

$row = mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>
<html lang="en">

<head>
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