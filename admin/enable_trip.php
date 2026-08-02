<?php

include("../config/db.php");

$id = $_GET['id'];

$query = "UPDATE trips SET status='active' WHERE trip_id=$id";

mysqli_query($con, $query);

header("Location: manage_trips.php");

exit();

?>