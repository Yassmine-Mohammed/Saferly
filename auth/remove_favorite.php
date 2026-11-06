
<?php
session_start();

//===========================
// Remove Trip from Favorites
//===========================
require_once("../config/db.php");

require_once "../includes/login_check.php";
checkLogin();

$userId = (int) $_SESSION['user']['user_id'];
if ($userId <= 0) {
    http_response_code(400);
    exit("Invalid user ID.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['trip_id'])) {
    $tripId = (int) $_POST['trip_id'];

    $stmt = mysqli_prepare($con, "DELETE FROM favorites WHERE user_id = ? AND trip_id = ?");
    mysqli_stmt_bind_param($stmt, "ii", $userId, $tripId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

header("Location: user_favorites.php?removed=1");
exit;