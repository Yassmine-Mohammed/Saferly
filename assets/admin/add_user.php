<?php
include("../config/db.php");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add User</title>
    <link rel="stylesheet" href="CSS/admin.css">
</head>

<body>

<div class="content">

    <form class="add-form" action="insert_user.php" method="POST">

        <h1>Add User</h1>

        <label>Name</label><br>
        <input type="text" name="name" required><br><br>

        <label>Email</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password</label><br>
        <input type="password" name="password" required><br><br>

        <label>Phone</label><br>
        <input type="text" name="phone" required><br><br>

        <button type="submit">Add User</button>

    </form>

</div>

</body>

</html>