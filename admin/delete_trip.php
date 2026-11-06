<?php

include("../config/db.php");

$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
if ($id === false || $id <= 0) {
    http_response_code(400);
    exit("Invalid trip ID.");
}

$stmt = mysqli_prepare($con, "DELETE FROM trips WHERE trip_id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: manage_trips.php?success=trip_deleted");
exit();

?>