<?php
include("../config/db.php");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Company</title>
    <link rel="stylesheet" href="CSS/admin.css">
</head>

<body>

<div class="content">

    <form class="add-form" action="insert_company.php" method="POST">

        <h1>Add Company</h1>

        <label>Company Name</label><br>
        <input type="text" name="name" required><br><br>

        <label>Email</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password</label><br>
        <input type="password" name="password" required><br><br>

        <label>Tax Number</label><br>
        <input type="text" name="tax_number" required><br><br>

        <button type="submit">Add Company</button>

    </form>

</div>

</body>

</html>