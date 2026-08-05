<?php

include("../config/db.php");


$company_id = $_POST['company_id'];
$trip_name = $_POST['trip_name'];
$destination = $_POST['destination'];
$price = $_POST['price'];
$duration_days = $_POST['duration_days'];
$start_date = $_POST['start_date'];


$query = "
INSERT INTO trips 
(company_id, trip_name, destination, price, duration_days, start_date, status)

VALUES

('$company_id',
'$trip_name',
'$destination',
'$price',
'$duration_days',
'$start_date',
'active')
";


mysqli_query($con, $query);


header("Location: manage_trips.php?success=trip_added");

exit();

?>