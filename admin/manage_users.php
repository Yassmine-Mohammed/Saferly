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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <link rel="stylesheet" href="CSS/admin.css">
</head>

<body>
    

    <div class="sidebar">

        <h2>Saferly</h2>

     <ul>
        <li><a href="dashboard.php"><i class="fa-solid fa-gauge"></i>  Dashboard</a></li>
        <li><a href="manage_users.php"><i class="fa-solid fa-users"></i>  Users</a></li>
        <li><a href="manage_companies.php"><i class="fa-solid fa-building"></i>  Companies</a></li>
        <li><a href="manage_trips.php"><i class="fa-solid fa-map-location-dot"></i>  Trips</a></li>
        <li><a class="active" href="reports.php"><i class="fa-solid fa-chart-line"></i>  Reports</a></li>
        <li><a href="../auth/logout.php"><i class="fa-solid fa-right-from-bracket"></i>  Logout</a></li>
    </ul>
    </div>


    <div class="content">



    <h1>Manage Users</h1>
    <?php
if(isset($_GET['success']) && $_GET['success']=="role_updated"){
?>
    <div class="success-message">
        Role updated successfully.
    </div>
<?php
}
?>
<?php
if(isset($_GET['success']) && $_GET['success']=="user_deleted"){
?>
<div class="success-message">
    User deleted successfully.
</div>
<?php
}
?>
<?php
if(isset($_GET['success']) && $_GET['success']=="user_added"){
?>
<div class="success-message">
    User added successfully.
</div>
<?php
}
?>
    <table class="users-table">

        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>


        <?php while($user = mysqli_fetch_assoc($result)) { ?>

        <tr>

            <td><?php echo $user['user_id']; ?></td>

            <td><?php echo $user['name']; ?></td>

            <td><?php echo $user['email']; ?></td>
<td>

<form action="update_role.php" method="POST">

<input type="hidden" 
name="user_id" 
value="<?php echo $user['user_id']; ?>">


<select name="role">

<option value="user"
<?php if($user['role']=="user") echo "selected"; ?>>
User
</option>


<option value="admin"
<?php if($user['role']=="admin") echo "selected"; ?>>
Admin
</option>


</select>


<button type="submit">
Update
</button>


</form>

</td>
           <td>

<a href="view_user.php?id=<?php echo $user['user_id']; ?>">
    View
</a>

|

<a href="delete_user.php?id=<?php echo $user['user_id']; ?>"
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