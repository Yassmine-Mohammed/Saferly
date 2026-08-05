<?php

include("../config/db.php");

$id = $_GET['id'];

$query = "UPDATE companies 
SET status='rejected' 
WHERE company_id=$id";

mysqli_query($con, $query);

header("Location: manage_companies.php");

exit();

?>