<?php
include("../config/db.php");

$users_query = "SELECT COUNT(*) AS total_users FROM users";
$result = mysqli_query($con, $users_query);

$users = mysqli_fetch_assoc($result);

$total_users = $users['total_users'];


$companies_query = "SELECT COUNT(*) AS total_companies FROM companies";
$result = mysqli_query($con, $companies_query);

$companies = mysqli_fetch_assoc($result);

$total_companies = $companies['total_companies'];
$trips_query = "SELECT COUNT(*) AS total_trips FROM trips";
$result = mysqli_query($con, $trips_query);

$trips = mysqli_fetch_assoc($result);

$total_trips = $trips['total_trips'];


$bookings_query = "SELECT COUNT(*) AS total_bookings FROM bookings";
$result = mysqli_query($con, $bookings_query);

$bookings = mysqli_fetch_assoc($result);

$total_bookings = $bookings['total_bookings'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <link rel="stylesheet" href="Css/admin.css">
</head>

<body>

    <div class="sidebar">

        <h2>Saferly</h2>

   <ul>

     <ul>
        <li><a href="dashboard.php"><i class="fa-solid fa-gauge"></i>  Dashboard</a></li>
        <li><a href="manage_users.php"><i class="fa-solid fa-users"></i>  Users</a></li>
        <li><a href="manage_companies.php"><i class="fa-solid fa-building"></i>  Companies</a></li>
        <li><a href="manage_trips.php"><i class="fa-solid fa-map-location-dot"></i>  Trips</a></li>
        <li><a class="active" href="reports.php"><i class="fa-solid fa-chart-line"></i>  Reports</a></li>
        <li><a href="../auth/logout.php"><i class="fa-solid fa-right-from-bracket"></i>  Logout</a></li>
    </ul>

</ul>
    </div>


    <div class="content">

        <h1>Admin Dashboard</h1>

<div class="topbar">

    <h2>Dashboard Overview</h2>



</div>
<div class="cards">


    <div class="card users">

        <div class="icon">
            👥
        </div>

        <h3>Users</h3>

        <p><?php echo $total_users;?></p>

    </div>



    <div class="card companies">

        <div class="icon">
            🏢
        </div>

        <h3>Companies</h3>

       <p><?php echo $total_companies; ?></p>

    </div>




    <div class="card trips">

        <div class="icon">
            ✈️
        </div>

        <h3>Trips</h3>

      <p><?php echo $total_trips;?></p>

    </div>




    <div class="card bookings">

        <div class="icon">
            🎫
        </div>

        <h3>Bookings</h3>

      <p><?php echo $total_bookings;?></p>

    </div>


</div>
<div class="dashboard-section">

    <div class="box">

        <h2>Recent Trips</h2>

        <div class="item">
            <span>Trip to Cairo</span>
            <span>Pending</span>
        </div>

        <div class="item">
            <span>Trip to Hurghada</span>
            <span>Approved</span>
        </div>

        <div class="item">
            <span>Trip to Luxor</span>
            <span>Pending</span>
        </div>

    </div>



    <div class="box">

        <h2>Quick Actions</h2>
<a href="add_user.php">
    <button>Add User</button>
</a>
<a href="add_company.php">
        <button>Add Company</button>
</a>
<a href="add_trip.php">
        <button>Add Trip</button>
</a>
    </div>


</div>

</body>

</html>