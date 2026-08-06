<?php

include("../config/db.php");

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$phone = $_POST['phone'];


$query = "
INSERT INTO users (name, email, password, phone, role)
VALUES ('$name', '$email', '$password', '$phone', 'user')
";


mysqli_query($con, $query);


header("Location: manage_users.php?success=user_added");
exit();

?>