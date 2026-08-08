
<?php
session_start();

//===========================
// Remove Trip from Favorites
//===========================
require_once("../config/db.php");

require_once "../includes/login_check.php";
checkLogin();

$userId = (int) $_SESSION['user']['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['trip_id'])) {
    $tripId = (int) $_POST['trip_id'];

    $sql = "DELETE FROM favorites WHERE user_id = $userId AND trip_id = $tripId";
    mysqli_query($con, $sql);
}

header("Location: user_favorites.php?removed=1");
exit;