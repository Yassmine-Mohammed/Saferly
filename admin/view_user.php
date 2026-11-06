<?php

include("../config/db.php");


$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
if ($id === false || $id <= 0) {
    http_response_code(400);
    exit("Invalid user ID.");
}


$stmt = mysqli_prepare($con, "SELECT * FROM users WHERE user_id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);


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