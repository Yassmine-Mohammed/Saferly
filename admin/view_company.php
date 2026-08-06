<?php

include("../config/db.php");


$id = $_GET['id'];


$query = "SELECT * FROM companies WHERE company_id=$id";

$result = mysqli_query($con, $query);

$company = mysqli_fetch_assoc($result);


?>


<!DOCTYPE html>
<html lang="en">

<head>

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