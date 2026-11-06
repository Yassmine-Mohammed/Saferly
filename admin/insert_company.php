<?php

include("../config/db.php");

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$tax_number = $_POST['tax_number'];


$stmt = mysqli_prepare(
    $con,
    "INSERT INTO companies (name, email, password, tax_number, status) VALUES (?, ?, ?, ?, 'pending')"
);
mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $password, $tax_number);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);


header("Location: manage_companies.php?success=company_added");
exit();

?>