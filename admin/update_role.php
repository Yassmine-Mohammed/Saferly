<?php

include("../config/db.php");

$id = filter_var($_POST['user_id'] ?? null, FILTER_VALIDATE_INT);
if ($id === false || $id <= 0) {
    http_response_code(400);
    exit("Invalid user ID.");
}
$role = $_POST['role'] ?? null;
if (!in_array($role, ['user', 'admin'], true)) {
    http_response_code(400);
    exit("Invalid role.");
}

$stmt = mysqli_prepare($con, "UPDATE users SET role = ? WHERE user_id = ?");
mysqli_stmt_bind_param($stmt, "si", $role, $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: manage_users.php?success=role_updated");
exit();

?>