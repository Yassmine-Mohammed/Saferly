<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saferly</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Safarly</title>
    <link rel="stylesheet" href="CSS/includes.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
<header>
    <div class="container">
        <div class="logo">
            <a href="../index.php">
                <img src="../images/logo.png" alt="Safarly Logo" style="width: 170px; display: block;">
            </a>
        </div>
        <nav>
            <ul>
                <!-- not <li><a href="../index.php">Home</a></li> -->
                <li><a href="../search/index.php">Home</a></li>
                <li><a href="../search/filters.php">Trips</a></li>
                <li><a href="../about/index.php">About</a></li>
                <li><a href="../contact/index.php">Contact</a></li>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li><a href="../auth/logout.php">Logout</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <div class="header-right">
            <?php if(!isset($_SESSION['user_id'])): ?>
                <a href="../auth/login.php" class="btn-login">Login</a>
                <a href="../auth/register.php" class="btn-signup">Sign Up</a>
            <?php else: ?>
                <a href="../auth/profile.php" class="btn-signup">My Profile</a>
            <?php endif; ?>
        </div>
    </div>
</header>
