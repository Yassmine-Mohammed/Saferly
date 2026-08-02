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

    <link rel="stylesheet" href="CSS/admin.css">
</head>

<body>

    <div class="sidebar">

        <h2>Saferly</h2>

        <ul>
            <li>Dashboard</li>
            <li>Users</li>
            <li>Companies</li>
            <li>Trips</li>
            <li>Reports</li>
        </ul>

    </div>

    <div class="content">

        <h1>Manage Companies</h1>
<table class="users-table">

    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Tax Number</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>

    <?php while($company = mysqli_fetch_assoc($result)) { ?>

    <tr>

        <td><?php echo $company['company_id']; ?></td>

        <td><?php echo $company['name']; ?></td>

        <td><?php echo $company['email']; ?></td>

        <td><?php echo $company['tax_number']; ?></td>

   <td><?php echo $company['status']; ?></td>

<td>

<?php
if($company['status'] == "not_verified"){
?>

<a href="approve_company.php?id=<?php echo $company['company_id']; ?>">
    Approve
</a>

<?php
}else{
    echo "verified";
}
?>

</td>

    </tr>

    <?php } ?>

</table>
    </div>

</body>

</html>

