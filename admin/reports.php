<?php

include("../config/db.php");


$users = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM users"));

$companies = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM companies"));

$trips = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM trips"));

$bookings = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM bookings"));


?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Reports</title>

<link rel="stylesheet" href="CSS/admin.css">

</head>


<body>


<div class="sidebar">

<h2>Saferly</h2>

<ul>

    <li>
        <a href="dashboard.php">Dashboard</a>
    </li>

    <li>
        <a href="manage_users.php">Users</a>
    </li>

    <li>
        <a href="manage_companies.php">Companies</a>
    </li>

    <li>
        <a href="manage_trips.php">Trips</a>
    </li>

    <li>
        <a class="active"
       href="rports.php">Reports</a>
    </li>

</ul>
</div>


<div class="content">

<h1>Reports</h1>


<div class="cards">


<div class="card users">

<h3>Total Users</h3>

<p>
<?php echo $users['total']; ?>
</p>

</div>



<div class="card companies">

<h3>Total Companies</h3>

<p>
<?php echo $companies['total']; ?>
</p>

</div>



<div class="card trips">

<h3>Total Trips</h3>

<p>
<?php echo $trips['total']; ?>
</p>

</div>



<div class="card bookings">

<h3>Total Bookings</h3>

<p>
<?php echo $bookings['total']; ?>
</p>

</div>


</div>


</div>


</body>

</html>