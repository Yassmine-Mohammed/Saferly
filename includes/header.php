<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/functions.php";
$userId = filter_var($_SESSION['user']['user_id'] ?? null, FILTER_VALIDATE_INT);
$row = false;
if ($userId !== false && $userId > 0) {
    $stmt = mysqli_prepare($con, "SELECT * FROM users WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

?>
    <title>Safarly</title>

        <link rel="stylesheet" href="<?= htmlspecialchars(app_url('assets/css/style.css'), ENT_QUOTES, 'UTF-8') ?>">
        <!-- استدعاء ملف الـ CSS الخاص بك فقط -->
        <link rel="stylesheet" href="<?= htmlspecialchars(app_url('includes/CSS/includes.css'), ENT_QUOTES, 'UTF-8') ?>">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- مكتبة الأيقونات FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
        
        <header>
            <div class="container">
                <div class="logo">
                    <a href="<?= htmlspecialchars(app_url(), ENT_QUOTES, 'UTF-8') ?>">
                        <img src="<?= htmlspecialchars(app_url('includes/images/logo.png'), ENT_QUOTES, 'UTF-8') ?>" alt="Safarly Logo">
                    </a>
                </div>

                <nav>
                    <ul>

                        <li><a href="<?= htmlspecialchars(app_url(), ENT_QUOTES, 'UTF-8') ?>">Home</a></li>
                        <li><a href="<?= htmlspecialchars(app_url('search/filters.php'), ENT_QUOTES, 'UTF-8') ?>">Trips</a></li>
                        <li><a href="<?= htmlspecialchars(app_url('about/index.php'), ENT_QUOTES, 'UTF-8') ?>">About</a></li>
                    </ul>
                </nav>

                <div class="header-right">
                    <?php if (!isset($_SESSION['user'])): ?>
                        <!-- يظهر للزوار -->
                        <a href="<?= htmlspecialchars(app_url('auth/login.php'), ENT_QUOTES, 'UTF-8') ?>" class="btn-login">Login</a>
                        <a href="<?= htmlspecialchars(app_url('auth/register.php'), ENT_QUOTES, 'UTF-8') ?>" class="btn-signup">Sign Up</a>
                    <?php else: ?>
                        <!-- يظهر للمستخدم المسجل -->
                        <div class="user-menu">
                            <a href="<?= htmlspecialchars(app_url('auth/profile.php'), ENT_QUOTES, 'UTF-8') ?>" title="My Profile">
                                <img src="<?= htmlspecialchars(app_url('auth/uploads/user/' . rawurlencode($row['image'])), ENT_QUOTES, 'UTF-8') ?>" alt="Profile"
                                    class="profile-circle"
                                    onerror="this.src='https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png';">
                            </a>
                            <a href="<?= htmlspecialchars(app_url('auth/logout.php'), ENT_QUOTES, 'UTF-8') ?>" class="btn-logout">
                                <i class="fa-solid fa-right-from-bracket"></i> Logout
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </header>