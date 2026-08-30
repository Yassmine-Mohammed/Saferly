<?php
include("../config/db.php");

$query = "SELECT * FROM companies";
$result = mysqli_query($con, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Companies</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <link rel="stylesheet" href="CSS/admin.css">
</head>

<body>

<div class="sidebar">

    <h2>Saferly</h2>
 <ul>
        <li><a href="dashboard.php"><i class="fa-solid fa-gauge"></i>  Dashboard</a></li>
        <li><a href="manage_users.php"><i class="fa-solid fa-users"></i>  Users</a></li>
        <li><a href="manage_companies.php"><i class="fa-solid fa-building"></i>  Companies</a></li>
        <li><a href="manage_trips.php"><i class="fa-solid fa-map-location-dot"></i>  Trips</a></li>
        <li><a class="active" href="reports.php"><i class="fa-solid fa-chart-line"></i>  Reports</a></li>
        <li><a href="../auth/logout.php"><i class="fa-solid fa-right-from-bracket"></i>  Logout</a></li>
    </ul>

</div>


<div class="content">

<h1>Manage Companies</h1>


<?php if(isset($_GET['success']) && $_GET['success']=="company_rejected"){ ?>

<div class="success-message">
    Company rejected successfully.
</div>

<?php } ?>


<?php if(isset($_GET['success']) && $_GET['success']=="company_approved"){ ?>

<div class="success-message">
    Company approved successfully.
</div>

<?php } ?>


<table class="users-table">

<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Tax Number</th>
    <th>Status</th>
    <th>Actions</th>
</tr>


<?php while($company = mysqli_fetch_assoc($result)) { 

    $status = strtolower(trim($company['status']));

?>

<tr>

<td>
    <?php echo $company['company_id']; ?>
</td>


<td>
    <?php echo $company['name']; ?>
</td>


<td>
    <?php echo $company['email']; ?>
</td>


<td>
    <?php echo $company['tax_number']; ?>
</td>


<td>
    <?php echo $company['status']; ?>
</td>


<td>

<a href="view_company.php?id=<?php echo $company['company_id']; ?>">
    View
</a>


<?php if($status == "pending"){ ?>

=======
<a href="approve_company.php?id=<?php echo $company['company_id']; ?>">
    Approve
</a>

<a href="reject_company.php?id=<?php echo $company['company_id']; ?>">
    Reject
</a>


<?php } elseif($status == "approved"){ ?>

<a href="reject_company.php?id=<?php echo $company['company_id']; ?>">
    Reject
</a>


<?php } elseif($status == "rejected"){ ?>

<a href="approve_company.php?id=<?php echo $company['company_id']; ?>">
    Approve
</a>


<?php } ?>



</td>


</tr>

<?php } ?>


</table>

</div>

</body>

</html>