<?php
session_start();
require_once("../config/db.php");
require_once "../includes/login_check.php";
checkLogin();
$userId = $_SESSION['user']['user_id'];

$sql = "SELECT f.trip_id, t.trip_name, t.destination, t.image, 
               t.price, c.name, f.created_at
        FROM favorites f
        JOIN trips t ON f.trip_id = t.trip_id
        JOIN companies c ON t.company_id = c.company_id
        WHERE f.user_id = $userId
        ORDER BY f.created_at DESC";

$res = mysqli_query($con, $sql);
if (!$res) {
    die("Query Error: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/profile.css">
    <title>My Favourites</title>
</head>

<body>
    <?php include_once("../includes/header.php"); ?>
    <div class="profile">
        <?php include_once("navbar.php"); ?>

        <main class="profile-page">
            <div class="profile-card table-view">
                <div>
                    <h2 class="text-center">My Favourite Trips</h2>
                    <br>

                    <?php if (isset($_GET['removed'])) { ?>
                        <div class="alert alert-success text-center">Trip removed from favourites.</div>
                    <?php } ?>

                    <div class="table-container">
                        <?php if (mysqli_num_rows($res) > 0) { ?>
                            <table class="trips-table">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Trip</th>
                                        <th>Destination</th>
                                        <th>Company</th>
                                        <th>Price</th>
                                        <th>Added On</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php while ($trip = mysqli_fetch_assoc($res)) { ?>
                                        <tr>
                                            <td>
                                                <img src="../assets/images/<?= htmlspecialchars($trip['image']) ?>"
                                                    alt="<?= htmlspecialchars($trip['trip_name']) ?>" width="80">
                                            </td>
                                            <td><?= htmlspecialchars($trip['trip_name']) ?></td>
                                            <td><?= htmlspecialchars($trip['destination']) ?></td>
                                            <td><?= htmlspecialchars($trip['name']) ?></td>
                                            <td><?= htmlspecialchars($trip['price']) ?> EGP</td>
                                            <td><?= htmlspecialchars($trip['created_at']) ?></td>
                                            <td>
                                                <a href="../booking/trip_details.php?id=<?= $trip['trip_id'] ?>"
                                                    class="btn btn-primary btn-sm">View</a>
                                                <form action="remove_favorite.php" method="POST" style="display:inline;">
                                                    <input type="hidden" name="trip_id" value="<?= $trip['trip_id'] ?>">
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Remove this trip from favourites?');">Remove</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                        <?php } else { ?>
                            <p>You haven't added any trips to your favourites yet.</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <?php include_once("../includes/footer.php"); ?>
</body>

</html>