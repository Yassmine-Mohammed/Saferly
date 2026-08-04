<?php
require "config/db.php";

$sql = "SELECT * FROM trips";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Trips</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="trips-container">

<?php while($trip = mysqli_fetch_assoc($result)){ ?>

<div class="trip-card">

    <img src="assets/images/<?php echo $trip['image']; ?>" alt="Trip">

    <h2><?php echo $trip['trip_name']; ?></h2>

    <p><?php echo $trip['destination']; ?></p>

    <p><?php echo $trip['price']; ?> EGP</p>

    <a href="trip_details.php?id=<?php echo $trip['trip_id']; ?>">
        <button>View Details</button>
    </a>

</div>

<?php } ?>

</div>

</body>
</html>