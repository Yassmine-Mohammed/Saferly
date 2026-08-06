<?php

include("../config/db.php");

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$tax_number = $_POST['tax_number'];


$query = "
INSERT INTO companies (name, email, password, tax_number, status)
VALUES ('$name', '$email', '$password', '$tax_number', 'pending')
";


mysqli_query($con, $query);


header("Location: manage_companies.php?success=company_added");
exit();

?>