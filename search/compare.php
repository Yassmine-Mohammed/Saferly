<?php
session_start();
require_once("../config/db.php");
include("../includes/header.php");

$trip1_id = isset($_GET['id1']) ? (int)$_GET['id1'] : 0;
$trip2_id = isset($_GET['id2']) ? (int)$_GET['id2'] : 0;

// Fetch all active trips for the selection dropdown
$all_trips_query = mysqli_query($con, "SELECT trip_id, trip_name FROM trips WHERE status='active'");

// Fetch data for selected trips
$trip1 = null;
$trip2 = null;

if($trip1_id > 0) {
    $q1 = mysqli_query($con, "SELECT * FROM trips WHERE trip_id = $trip1_id");
    $trip1 = mysqli_fetch_assoc($q1);
}
if($trip2_id > 0) {
    $q2 = mysqli_query($con, "SELECT * FROM trips WHERE trip_id = $trip2_id");
    $trip2 = mysqli_fetch_assoc($q2);
}
?>

<link rel="stylesheet" href="CSS/search.css">
<link rel="stylesheet" href="../includes/CSS/includes.css">


<main class="container my-5" style="min-height: 70vh;">
    <h1 class="text-center mb-5">Compare Trips</h1>

    <!-- نموذج اختيار الرحلات للمقارنة -->
    <form action="compare.php" method="GET" class="row justify-content-center mb-5">
        <div class="col-md-4">
            <select name="id1" class="form-control" required>
                <option value="">Select First Trip...</option>
                <?php 
                mysqli_data_seek($all_trips_query, 0);
                while($t = mysqli_fetch_assoc($all_trips_query)): ?>
                    <option value="<?php echo $t['trip_id']; ?>" <?php echo ($trip1_id == $t['trip_id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($t['trip_name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-1 text-center">
            <strong>VS</strong>
        </div>
        <div class="col-md-4">
            <select name="id2" class="form-control" required>
                <option value="">Select Second Trip...</option>
                <?php 
                mysqli_data_seek($all_trips_query, 0);
                while($t = mysqli_fetch_assoc($all_trips_query)): ?>
                    <option value="<?php echo $t['trip_id']; ?>" <?php echo ($trip2_id == $t['trip_id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($t['trip_name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-dark w-100">Compare</button>
        </div>
    </form>

    <!-- جدول المقارنة -->
    <?php if($trip1 && $trip2): ?>
    <div class="table-responsive shadow-sm">
        <table class="table table-bordered table-striped text-center bg-white">
            <thead class="table-dark">
                <tr>
                    <th style="width: 20%;">Feature</th>
                    <th style="width: 40%;"><?php echo htmlspecialchars($trip1['trip_name']); ?></th>
                    <th style="width: 40%;"><?php echo htmlspecialchars($trip2['trip_name']); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="fw-bold align-middle">Image</td>
                    <td><img src="../assets/images/<?php echo htmlspecialchars($trip1['image']); ?>" alt="Trip 1" style="width: 100%; max-height: 200px; object-fit: cover; border-radius: 8px;"></td>
                    <td><img src="../assets/images/<?php echo htmlspecialchars($trip2['image']); ?>" alt="Trip 2" style="width: 100%; max-height: 200px; object-fit: cover; border-radius: 8px;"></td>
                </tr>
                <tr>
                    <td class="fw-bold">Destination</td>
                    <td><?php echo htmlspecialchars($trip1['destination']); ?></td>
                    <td><?php echo htmlspecialchars($trip2['destination']); ?></td>
                </tr>
                <tr>
                    <td class="fw-bold">Category</td>
                    <td><?php echo htmlspecialchars($trip1['category']); ?></td>
                    <td><?php echo htmlspecialchars($trip2['category']); ?></td>
                </tr>
                <tr>
                    <td class="fw-bold">Duration</td>
                    <td><?php echo htmlspecialchars($trip1['duration_days']); ?> Days</td>
                    <td><?php echo htmlspecialchars($trip2['duration_days']); ?> Days</td>
                </tr>
                <tr>
                    <td class="fw-bold">Hotel Level</td>
                    <td><?php echo htmlspecialchars($trip1['hotel_level']); ?> Stars</td>
                    <td><?php echo htmlspecialchars($trip2['hotel_level']); ?> Stars</td>
                </tr>
                <tr>
                    <td class="fw-bold">Start Date</td>
                    <td><?php echo htmlspecialchars($trip1['start_date']); ?></td>
                    <td><?php echo htmlspecialchars($trip2['start_date']); ?></td>
                </tr>
                <tr>
                    <td class="fw-bold fs-5">Price</td>
                    <td class="fs-5 fw-bold text-success"><?php echo htmlspecialchars($trip1['price']); ?> EGP</td>
                    <td class="fs-5 fw-bold text-success"><?php echo htmlspecialchars($trip2['price']); ?> EGP</td>
                </tr>
                <tr>
                    <td class="fw-bold">Action</td>
                    <td><a href="../booking/trip_details.php?id=<?php echo $trip1['trip_id']; ?>" class="btn btn-primary">Book Now</a></td>
                    <td><a href="../booking/trip_details.php?id=<?php echo $trip2['trip_id']; ?>" class="btn btn-primary">Book Now</a></td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php elseif($trip1_id > 0 || $trip2_id > 0): ?>
        <div class="alert alert-info text-center">Please select two trips to compare.</div>
    <?php endif; ?>

</main>

<?php include("../includes/footer.php"); ?>