<?php
session_start();

//===========================
// User fav Trips Data
//===========================
require_once("../config/db.php");

require_once "../includes/login_check.php";
checkLogin();
$userId = $_SESSION['user']['user_id'];

$sql = "SELECT * FROM favorites;
WHERE b.user_id = $userId";

$result = mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Css/profile.css">
    <link rel="stylesheet" href="../includes/Css/includes.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <title>My Favourits
    </title>
</head>

<body>
    <?php include_once("../includes/header.php"); ?>
    <div class="profile">
    <?php include_once("navbar.php"); ?>

    <main class="profile-page">
        <div class="profile-card w-75 h-100">
            <div>
            <h2 class="text-center">My Booked Trips</h2>
            <br>
            <div class="table-container">
            <?php if (mysqli_num_rows($result) > 0) { ?>
                <table class="trips-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Trip</th>
                            <th>Destination</th>
                            <th>Company</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Booked At</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($trip = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td>
                                    <img src="../assets/images/<?= $trip['image'] ?>" alt="<?= $trip['trip_name'] ?>" width="80">
                                </td>

                                <td><?= $trip['trip_name'] ?></td>

                                <td><?= $trip['destination'] ?></td>

                                <td><?= $trip['company_name'] ?></td>

                                <td><?= $trip['price'] ?> EGP</td>

                                <td><?= ucfirst($trip['booking_status']) ?></td>

                                <td><?= $trip['booking_date'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            <?php } else { ?>

                <p>You haven't booked any trips yet.</p>

            <?php } ?>
            </div>
</div>
        </div>
    </main>
    </div>
        <?php include_once("../includes/footer.php"); ?>
</body>

</html>