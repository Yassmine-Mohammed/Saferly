<?php
session_start();
require "../config/db.php";

$id = isset($_GET['id']) ? intval($_GET['id']) : (isset($_GET['trip_id']) ? intval($_GET['trip_id']) : 0);

$sql = "SELECT * FROM trips WHERE trip_id = $id";
$result = mysqli_query($con, $sql);

if (!$result) {
    die("SQL Error: " . mysqli_error($con));
}

if(mysqli_num_rows($result) > 0){
    $trip = mysqli_fetch_assoc($result);
} else {
    die("No trip found with ID: " . $id);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trip Details</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

<div class="details-container">

    <div class="trip-image">
        <?php if (!empty($trip['image'])): ?>
            <img src="../assets/images/<?php echo htmlspecialchars($trip['image']); ?>" alt="<?php echo htmlspecialchars($trip['trip_name']); ?>">
        <?php endif; ?>
    </div>

    <div class="trip-info">
        <h1><?php echo htmlspecialchars($trip['trip_name']); ?></h1>

        <h3>Destination:</h3>
        <p><?php echo htmlspecialchars($trip['destination']); ?></p>

        <h3>Description:</h3>
        <p><?php echo htmlspecialchars($trip['description']); ?></p>

        <h3>Category:</h3>
        <p><?php echo htmlspecialchars($trip['category']); ?></p>

        <h3>Price:</h3>
        <p><?php echo htmlspecialchars($trip['price']); ?> EGP</p>

        <h3>Duration:</h3>
        <p><?php echo htmlspecialchars($trip['duration_days']); ?> Days</p>

        <h3>Hotel Level:</h3>
        <p><?php echo htmlspecialchars($trip['hotel_level']); ?> Stars</p>

        <h3>Start Date:</h3>
        <p><?php echo htmlspecialchars($trip['start_date']); ?></p>

        <h3>Status:</h3>
        <p><?php echo htmlspecialchars($trip['status']); ?></p>

    <!-- زرار الحجز الأساسي -->
        <a href="booking.php?trip_id=<?php echo $trip['trip_id']; ?>">
            <button type="button" class="book-btn">Book Now</button>
        </a>

        <!-- زرار المفضلة بنفس شكل وحجم زرار الحجز -->
        <a href="add_favorites.php?trip_id=<?php echo $trip['trip_id']; ?>">
            <button type="button" class="book-btn" style="margin-top: 10px;">Add to Favorites ❤️</button>
        </a>

        <!-- زرار الريفيوز بنفس شكل وحجم زرار الحجز -->
        <a href="reviews.php?trip_id=<?php echo $trip['trip_id']; ?>">
            <button type="button" class="book-btn" style="margin-top: 10px;">View Reviews ⭐</button>
        </a>
        </div>
        </a>
    </div>

</div>

</body>
</html>