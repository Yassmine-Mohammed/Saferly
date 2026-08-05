<?php

include("../config/db.php");

$id = $_GET['id'];

$query = "DELETE FROM users WHERE user_id=$id";

mysqli_query($con, $query);

header("Location: manage_users.php?success=user_deleted");
exit();

?>