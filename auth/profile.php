<?php
session_start();
require_once("../config/db.php");

require_once "../includes/login_check.php";
checkLogin();

//===========================
// User Profile Data
//===========================
$userId = $_SESSION['user']['user_id'];

$query = "SELECT * FROM users WHERE user_id = '$userId'";
$result = mysqli_query($con, $query);

$row = mysqli_fetch_assoc($result);

//===========================
// User Booking Trips Data
//===========================

$sql = "SELECT
    b.booking_id AS booking_id,
    b.status AS booking_status,
    b.booking_date AS booking_date,
    t.trip_id AS trip_id,
    t.trip_name,
    t.destination,
    t.price,
    t.start_date,
    DATE_ADD(t.start_date, INTERVAL t.duration_days DAY) AS end_date,
    t.image,
    c.name AS company_name
FROM bookings b
JOIN trips t ON b.trip_id = t.trip_id
JOIN companies c ON t.company_id = c.company_id
WHERE b.user_id = $userId
ORDER BY b.booking_date DESC";

$result = mysqli_query($con, $sql);
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

                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($trip = mysqli_fetch_assoc($result)) {
                        ?>
                        <div class="trip-card">
                            <img src="uploads/trips/<?= $trip['image'] ?>" alt="<?= $trip['title'] ?>">

                            <h3><?= $trip['title'] ?></h3>

                            <p>Destination: <?= $trip['destination'] ?></p>

                            <p>Company: <?= $trip['company_name'] ?></p>

                            <p>Price: <?= $trip['price'] ?> EGP</p>

                            <p>Status: <?= $trip['booking_status'] ?></p>

                            <p>Booked At: <?= $trip['booking_date'] ?></p>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p>You haven't booked any trips yet.</p>";
                }
                ?>

            </div>
        </div>
    </main>
    <?php include_once("../includes/header.php"); ?>
</body>

</html>