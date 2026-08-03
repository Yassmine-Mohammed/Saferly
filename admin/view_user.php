<?php

include("../config/db.php");


$id = $_GET['id'];


$query = "SELECT * FROM users WHERE user_id = $id";

$result = mysqli_query($con, $query);

$user = mysqli_fetch_assoc($result);


?>


<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<title>View User</title>

<link rel="stylesheet" href="CSS/admin.css">

</head>


<body>


<div class="content">


<h1>User Details</h1>


<div class="box">


<p>
<strong>ID:</strong>
<?php echo $user['user_id']; ?>
</p>


<p>
<strong>Name:</strong>
<?php echo $user['name']; ?>
</p>


<p>
<strong>Email:</strong>
<?php echo $user['email']; ?>
</p>


<p>
<strong>Phone:</strong>
<?php echo $user['phone']; ?>
</p>


<p>
<strong>Role:</strong>
<?php echo $user['role']; ?>
</p>


</div>


<a href="manage_users.php">
Back
</a>


</div>


</body>

</html>