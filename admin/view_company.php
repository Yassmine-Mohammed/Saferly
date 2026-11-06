<?php

include("../config/db.php");


$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
if ($id === false || $id <= 0) {
    http_response_code(400);
    exit("Invalid company ID.");
}


$stmt = mysqli_prepare($con, "SELECT * FROM companies WHERE company_id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$company = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once __DIR__ . '/../includes/functions.php'; ?>
    <link rel="icon" type="image/png" href="<?= htmlspecialchars(app_url('assets/images/SaferlyLogo.png'), ENT_QUOTES, 'UTF-8') ?>">

<meta charset="UTF-8">

<title>View Company</title>

<link rel="stylesheet" href="CSS/admin.css">

</head>


<body>


<div class="content">


<h1>Company Details</h1>


<div class="box">


<p>
<strong>ID:</strong>
<?php echo $company['company_id']; ?>
</p>


<p>
<strong>Name:</strong>
<?php echo $company['name']; ?>
</p>


<p>
<strong>Email:</strong>
<?php echo $company['email']; ?>
</p>


<p>
<strong>Tax Number:</strong>
<?php echo $company['tax_number']; ?>
</p>


<p>
<strong>Status:</strong>
<?php echo $company['status']; ?>
</p>


</div>


<a href="manage_companies.php">
Back
</a>


</div>


</body>

</html>