<?php
session_start();
require_once("../config/db.php");

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
    <link rel="stylesheet" href="Css/style.css">
    <title>Profile Page</title>
</head>

<body>
    <main class="profile-page" style="justify-content: center; text-align: center; align-items: center;">
        <h2 class="text-center">User Profile</h2>
        <div class="d-flex">
            <div class = "UP_photo">
            <img src="uploads/user/<?= $row['image'] ?>" alt="Profile">
            </div>
            <div class="user-data">
                <h4>User Name Is: <?php echo $_SESSION["user"]['name'] ?></h4>
                <h4>Email Is: <?php echo $_SESSION["user"]['email'] ?></h4>
                <a href="profile.php?action=edit"><button> <i class="fa-solid fa-pen-to-square" style="color:green"></i>
                        Edit Profile</button></a>
                <a href="profile.php?action=delete"><button><i style="color:red" class="fa-solid fa-x"></i> Delete
                        Profile</button></a>
            </div>
        </div>
    </main>
</body>

</html>