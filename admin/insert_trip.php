<?php

include("../config/db.php");


$company_id = filter_var($_POST['company_id'] ?? null, FILTER_VALIDATE_INT);
if ($company_id === false || $company_id <= 0) {
    http_response_code(400);
    exit("Invalid company ID.");
}
$trip_name = $_POST['trip_name'];
$destination = $_POST['destination'];
$price = $_POST['price'] ?? null;
if (!is_numeric($price) || !is_finite((float) $price)) {
    http_response_code(400);
    exit("Invalid trip price.");
}
$duration_days = filter_var($_POST['duration_days'] ?? null, FILTER_VALIDATE_INT);
if ($duration_days === false || $duration_days <= 0) {
    http_response_code(400);
    exit("Invalid trip duration.");
}
$start_date = $_POST['start_date'];

$stmt = mysqli_prepare(
    $con,
    "INSERT INTO trips
        (company_id, trip_name, destination, price, duration_days, start_date, status, description, category, hotel_level, image)
     VALUES (?, ?, ?, ?, ?, ?, 'active', '', '', '', '')"
);
mysqli_stmt_bind_param($stmt, "isssis", $company_id, $trip_name, $destination, $price, $duration_days, $start_date);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);


header("Location: manage_trips.php?success=trip_added");

exit();

?>