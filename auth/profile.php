<?php
session_start();
require_once("../config/db.php");

require_once "../includes/login_check.php";
checkLogin();

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
    <link rel="stylesheet" href="Css/profile.css">
    <link rel="stylesheet" href="../includes/Css/includes.css">
    <title>Profile Page</title>
</head>

<body>
    <?php include_once("../includes/header.php"); ?>
    <main class="profile-page">
        <div class="profile-card">
            <div class="UP_photo">
                <img src="uploads/user/<?= $row['image'] ?>" alt="Profile">
            </div>

            <div class="user-data">
                <h2><?= $_SESSION["user"]['name'] ?></h2>
                <p><?= $_SESSION["user"]['email'] ?></p>

                <div class="profile-buttons">
                    <a href="edit_profile.php" class="edit-btn">
                        <i class="fa-solid fa-pen-to-square"></i>
                        Edit Profile
                    </a>

                    <a href="profile.php?action=delete" class="delete-btn">
                        <i class="fa-solid fa-trash"></i>
                        Delete Profile
                    </a>
                </div>
            </div>

            <div class="user-trips-data">
                
            </div>
        </div>
    </main>
    <?php include_once("../includes/header.php"); ?>
</body>

</html>