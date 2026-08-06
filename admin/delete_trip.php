<?php

include("../config/db.php");

$id = $_GET['id'];

$query = "DELETE FROM trips WHERE trip_id=$id";

mysqli_query($con, $query);

header("Location: manage_trips.php?success=trip_deleted");
exit();

?>