<?php
session_start();
require_once("../config/db.php");
include("../includes/header.php");

//  index بناء استعلام البحث بناءً على البيانات القادمة من الـ 
$where_clauses = ["status = 'active'"];

if (isset($_GET['destination']) && !empty($_GET['destination'])) {
    $destination = mysqli_real_escape_string($con, $_GET['destination']);
    $where_clauses[] = "(destination LIKE '%$destination%' OR trip_name LIKE '%$destination%')";
}
if (isset($_GET['start_date']) && !empty($_GET['start_date'])) {
    $start_date = mysqli_real_escape_string($con, $_GET['start_date']);
    $where_clauses[] = "start_date >= '$start_date'";
}

// تجميع الشروط
$where_sql = implode(" AND ", $where_clauses);
$query = "SELECT * FROM trips WHERE $where_sql ORDER BY start_date ASC";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/search.css">
    <link rel="stylesheet" href="CSS/all.css">
    <link rel="stylesheet" href="../includes/CSS/includes.css">

    <title>Search Results</title>
</head>
<body>
    <main class="container" style="min-height: 70vh; padding-top: 40px;">
        <h2 style="margin-bottom: 30px; text-align: center;">Search Results</h2>
        <div class="search-results">
            
            <?php if(mysqli_num_rows($result) > 0): ?>
                <?php while($trip = mysqli_fetch_assoc($result)): ?>
                    <div class="search-result">
                        <img src="../uploads/<?php echo htmlspecialchars($trip['image']); ?>" class="search-image" alt="Trip Image">
                        <div class="search-details">
                            <h1><?php echo htmlspecialchars($trip['trip_name']); ?></h1>
                            <h2><?php echo htmlspecialchars($trip['hotel_level']); ?> Stars Hotel</h2>
                            <p><?php echo htmlspecialchars($trip['description']); ?></p>
                            <h3><i class="fa-regular fa-clock"></i> Duration: <?php echo htmlspecialchars($trip['duration_days']); ?> Days</h3>
                            <h3><i class="fa-solid fa-location-dot"></i> Destination: <?php echo htmlspecialchars($trip['destination']); ?></h3>
                            <h3><i class="fa-solid fa-list"></i> Category: <?php echo htmlspecialchars($trip['category']); ?></h3>
                        </div>
                        <div class="search-price">
                            <h1><?php echo htmlspecialchars($trip['price']); ?> EGP</h1>
                            <!-- زرار التأكد من التوافر يوجه لصفحة تفاصيل الرحلة للحجز -->
                            <form action="../booking/trip_details.php" method="GET">
                                <input type="hidden" name="id" value="<?php echo $trip['trip_id']; ?>">
                                <button type="submit" name="check_availability" style="cursor: pointer;">Check Availability</button>
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div style="text-align: center; padding: 50px; background: #fff; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                    <h2 style="color: #555;">No trips found matching your search.</h2>
                    <a href="../index.php" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background: #000; color: #fff; text-decoration: none; border-radius: 20px;">Go Back</a>
                </div>
            <?php endif; ?>

        </div>
    </main>

    <?php include("../includes/footer.php"); ?>
</body>
</html>