<?php
include("../config/db.php");

$companies = mysqli_query($con, "SELECT * FROM companies WHERE status='approved'");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Trip</title>
    <link rel="stylesheet" href="CSS/admin.css">
</head>

<body>

<div class="content">

<form class="add-form" action="insert_trip.php" method="POST">

<h1>Add Trip</h1>


<label>Company</label>
<select name="company_id" required>

<option value="">Select Company</option>

<?php while($company = mysqli_fetch_assoc($companies)){ ?>

<option value="<?php echo $company['company_id']; ?>">
<?php echo $company['name']; ?>
</option>

<?php } ?>

</select>


<label>Trip Name</label>
<input type="text" name="trip_name" required>


<label>Destination</label>
<input type="text" name="destination" required>



<label>Price</label>
<input type="number" name="price" required>


<label>Duration Days</label>
<input type="number" name="duration_days" required>



<label>Start Date</label>
<input type="date" name="start_date">


<button type="submit">
Add Trip
</button>


</form>

</div>

</body>

</html>