<?php

include("../config/db.php");

$query = "
SELECT trips.*, companies.name AS company_name
FROM trips
JOIN companies
ON trips.company_id = companies.company_id
";
$result = mysqli_query($con, $query);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Trips</title>

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
       <a class="active"
       href="manage_trips.php">Trips</a>
    </li>

    <li>
        <a href="reports.php">Reports</a>
    </li>

</ul>
</div>


<div class="content">

    <h1>Manage Trips</h1>

<table class="users-table">

    <tr>
        <th>ID</th>
        <th>Trip Name</th>
        <th>Company</th>

        <th>Destination</th>
        <th>Category</th>
        <th>Price</th>
        <th>Start Date</th>
        <th>Status</th>
        <th>Actions</th>

    </tr>


    <?php while($trip = mysqli_fetch_assoc($result)) { ?>

    <tr>

        <td><?php echo $trip['trip_id']; ?></td>

        <td><?php echo $trip['trip_name']; ?></td>
        <td><?php echo $trip['company_name']; ?></td>

        <td><?php echo $trip['destination']; ?></td>

        <td><?php echo $trip['category']; ?></td>

        <td><?php echo $trip['price']; ?></td>

        <td><?php echo $trip['start_date']; ?></td>

        <td><?php echo $trip['status']; ?></td>
     
<td>

<a href="view_trip.php?id=<?php echo $trip['trip_id']; ?>">
    View
</a>

|

<?php
if($trip['status'] == "active"){
?>

<a href="disable_trip.php?id=<?php echo $trip['trip_id']; ?>">
    Disable
</a>

<?php
}else{
?>

<a href="enable_trip.php?id=<?php echo $trip['trip_id']; ?>">
    Enable
</a>

<?php
}
?>

|

<a href="delete_trip.php?id=<?php echo $trip['trip_id']; ?>"
onclick="return confirm('Are you sure?');">
    Delete
</a>

</td>
</tr>
<?php } ?>
</table>
</div>


</body>

</html>