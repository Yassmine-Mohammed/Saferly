<?php
// تأكد من بدء الجلسة
if (session_status() === PHP_SESSION_NONE) {
    session_start();

}
require_once("../config/db.php");
$userId = $_SESSION['user']['user_id'] ?? null;
$query = "SELECT * FROM users WHERE user_id = '$userId'";
$result = mysqli_query($con, $query);

$row = mysqli_fetch_assoc($result);

?>
    <title>Safarly</title>

        <link rel="stylesheet" href="../assets/css/style.css">
        <!-- استدعاء ملف الـ CSS الخاص بك فقط -->
        <link rel="stylesheet" href="/Final Project/Saferly/includes/CSS/includes.css"> <!-- 2. رابط Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- مكتبة الأيقونات FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
        
        <header>
            <div class="container">
                <div class="logo">
                    <a href="../search/index.php">
                        <img src="../includes/images/logo.png" alt="Safarly Logo">
                    </a>
                </div>

                <nav>
                    <ul>

                        <!-- not <li><a href="../index.php">Home</a></li> -->
                        <li><a href="../search/index.php">Home</a></li>
                        <li><a href="../search/filters.php">Trips</a></li>
                        <li><a href="../about/index.php">About</a></li>
                    </ul>
                </nav>

                <div class="header-right">
                    <?php if (!isset($_SESSION['user'])): ?>
                        <!-- يظهر للزوار -->
                        <a href="../auth/login.php" class="btn-login">Login</a>
                        <a href="../auth/register.php" class="btn-signup">Sign Up</a>
                    <?php else: ?>
                        <!-- يظهر للمستخدم المسجل -->
                        <div class="user-menu">
                            <a href="../auth/profile.php" title="My Profile">
                                <img src="../auth/uploads/user/<?= htmlspecialchars($row['image']) ?>" alt="Profile"
                                    class="profile-circle"
                                    onerror="this.src='https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png';">
                            </a>
                            <a href="../auth/logout.php" class="btn-logout">
                                <i class="fa-solid fa-right-from-bracket"></i> Logout
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </header>