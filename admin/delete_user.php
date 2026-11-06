<?php

include("../config/db.php");

$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
if ($id === false || $id <= 0) {
    http_response_code(400);
    exit("Invalid user ID.");
}

$stmt = mysqli_prepare($con, "DELETE FROM users WHERE user_id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: manage_users.php?success=user_deleted");
exit();

?>