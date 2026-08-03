<?php
include("../config/db.php");

$query = "SELECT * FROM users";
$result = mysqli_query($con, $query);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>

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
        <a class="active"
         href="manage_users.php">Users</a>
    </li>

    <li>
        <a href="manage_companies.php">Companies</a>
    </li>

    <li>
        <a href="manage_trips.php">Trips</a>
    </li>

    <li>
        <a href="reports.php">Reports</a>
    </li>

</ul>
    </div>


    <div class="content">



    <h1>Manage Users</h1>

    <table class="users-table">

        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
        </tr>


        <?php while($user = mysqli_fetch_assoc($result)) { ?>

        <tr>

            <td><?php echo $user['user_id']; ?></td>

            <td><?php echo $user['name']; ?></td>

            <td><?php echo $user['email']; ?></td>

            <td><?php echo $user['role']; ?></td>

        </tr>

        <?php } ?>


    </table>


</div>

</body>

</html>