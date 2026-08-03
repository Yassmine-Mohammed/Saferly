<?php

include("../config/db.php");

$id = $_GET['id'];

$query = "
SELECT trips.*, companies.name AS company_name
FROM trips
JOIN companies
ON trips.company_id = companies.company_id
WHERE trips.trip_id = $id
";

$result = mysqli_query($con, $query);

$trip = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<title>View Trip</title>

<link rel="stylesheet" href="CSS/admin.css">

</head>

<body>

<div class="content">

<h1>Trip Details</h1>

<div class="box">

<p><strong>Trip ID:</strong> <?php echo $trip['trip_id']; ?></p>

<p><strong>Trip Name:</strong> <?php echo $trip['trip_name']; ?></p>

<p><strong>Company:</strong> <?php echo $trip['company_name']; ?></p>

<p><strong>Destination:</strong> <?php echo $trip['destination']; ?></p>

<p><strong>Description:</strong> <?php echo $trip['description']; ?></p>

<p><strong>Category:</strong> <?php echo $trip['category']; ?></p>

<p><strong>Price:</strong> <?php echo $trip['price']; ?> EGP</p>

<p><strong>Duration:</strong> <?php echo $trip['duration_days']; ?> Days</p>

<p><strong>Hotel Level:</strong> <?php echo $trip['hotel_level']; ?> Stars</p>

<p><strong>Start Date:</strong> <?php echo $trip['start_date']; ?></p>

<p><strong>Status:</strong> <?php echo $trip['status']; ?></p>

<p><strong>Image:</strong></p>

<img src="../auth/<?php echo
basename($trip['image']);?>"width="300">

<br><br>

<a href="manage_trips.php">Back</a>

</div>

</div>

</body>

</html>
