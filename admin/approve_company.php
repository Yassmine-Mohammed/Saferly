<?php

include("../config/db.php");

$id = $_GET['id'];

$query = "UPDATE companies
SET status='approved'
WHERE company_id=$id";

mysqli_query($con, $query);

header("Location: manage_companies.php?success=company_approved");

exit();

?>