<?php

include("../config/db.php");

$id = $_POST['user_id'];
$role = $_POST['role'];

$query = "
UPDATE users
SET role='$role'
WHERE user_id=$id
";

mysqli_query($con, $query);

header("Location: manage_users.php?success=role_updated");
exit();

?>