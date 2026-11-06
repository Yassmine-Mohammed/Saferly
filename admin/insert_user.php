<?php

include("../config/db.php");

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$phone = $_POST['phone'];


$stmt = mysqli_prepare(
    $con,
    "INSERT INTO users (name, email, password, phone, role) VALUES (?, ?, ?, ?, 'user')"
);
mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $password, $phone);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);


header("Location: manage_users.php?success=user_added");
exit();

?>