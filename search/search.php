<?php
session_start();
require_once("../config/db.php");

//  index بناء استعلام البحث بناءً على البيانات القادمة من الـ 
$where_clauses = ["status = 'active'"];
$query_params = [];
$query_types = "";

if (isset($_GET['destination']) && !empty($_GET['destination'])) {
    $destination = "%" . $_GET['destination'] . "%";
    $where_clauses[] = "(destination LIKE ? OR trip_name LIKE ?)";
    $query_params[] = $destination;
    $query_params[] = $destination;
    $query_types .= "ss";
    }
    if (isset($_GET['start_date']) && !empty($_GET['start_date'])) {
        $start_date = $_GET['start_date'];
    $where_clauses[] = "start_date >= ?";
    $query_params[] = $start_date;
    $query_types .= "s";
    }
    
    // تجميع الشروط
    $where_sql = implode(" AND ", $where_clauses);
    $query = "SELECT * FROM trips WHERE $where_sql ORDER BY start_date ASC";
    $stmt = mysqli_prepare($con, $query);
    if ($query_params) {
        $bind_params = [$stmt, $query_types];
        foreach (array_keys($query_params) as $index) {
            $bind_params[] = &$query_params[$index];
        }
        call_user_func_array("mysqli_stmt_bind_param", $bind_params);
    }
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once __DIR__ . '/../includes/functions.php'; ?>
    <link rel="icon" type="image/png" href="<?= htmlspecialchars(app_url('assets/images/SaferlyLogo.png'), ENT_QUOTES, 'UTF-8') ?>">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/search.css">
    <link rel="stylesheet" href="../includes/CSS/includes.css">
    <title>Search Results</title>
</head>
<body>
    <?php include("../includes/header.php");?>
    <main class="container" style="min-height: 70vh; padding-top: 40px;">
        <h2 style="margin-bottom: 30px; text-align: center;">Search Results</h2>
        <div class="search-results">
            
            <?php if(mysqli_num_rows($res) > 0): ?>
                <?php while($trip = mysqli_fetch_assoc($res)): ?>
                    <div class="search-result">
                        <img src="../assets/images/<?php echo htmlspecialchars($trip['image']); ?>" class="search-image" alt="Trip Image">
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
<script>
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('in-view');
                observer.unobserve(entry.target); // يشتغل مرة واحدة بس
            }
        });
    }, { threshold: 0.15 });

    document.querySelectorAll('.content2, .content3, .search-result, .place-card')
        .forEach(el => observer.observe(el));
</script>
</html>
