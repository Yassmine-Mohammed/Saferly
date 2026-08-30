<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("../config/db.php");
include("../includes/header.php");

// بناء استعلام البحث بناءً على الفلاتر
$where_clauses = ["status = 'active'"];

if (isset($_GET['destination']) && !empty($_GET['destination'])) {
    $destination = mysqli_real_escape_string($con, $_GET['destination']);
    $where_clauses[] = "(destination LIKE '%$destination%' OR trip_name LIKE '%$destination%')";
}
if (isset($_GET['min_price']) && !empty($_GET['min_price'])) {
    $min_price = (float)$_GET['min_price'];
    $where_clauses[] = "price >= $min_price";
}
if (isset($_GET['max_price']) && !empty($_GET['max_price'])) {
    $max_price = (float)$_GET['max_price'];
    $where_clauses[] = "price <= $max_price";
}
if (isset($_GET['category']) && !empty($_GET['category'])) {
    $category = mysqli_real_escape_string($con, $_GET['category']);
    $where_clauses[] = "category = '$category'";
}

$where_sql = implode(" AND ", $where_clauses);
$query = "SELECT * FROM trips WHERE $where_sql ORDER BY start_date ASC";
$result = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Safarly</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../includes/CSS/includes.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="CSS/search.css">
    </head>
    <body>
<main class="container my-5">
    <div class="row">
        <!-- قسم الفلاتر (Sidebar) -->
        <div class="col-md-3">
            <div class="filter-sidebar p-4 bg-light rounded shadow-sm">
                <h4>Filter Trips</h4>
                <form action="filters.php" method="GET">
                    <div class="mb-3">
                        <label>Destination</label>
                        <input type="text" name="destination" class="form-control" value="<?php echo isset($_GET['destination']) ? htmlspecialchars($_GET['destination']) : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label>Category</label>
                        <select name="category" class="form-control">
                            <option value="">All</option>
                            <option value="Adventure" <?php echo (isset($_GET['category']) && $_GET['category'] == 'Adventure') ? 'selected' : ''; ?>>Adventure</option>
                            <option value="Relaxation" <?php echo (isset($_GET['category']) && $_GET['category'] == 'Relaxation') ? 'selected' : ''; ?>>Relaxation</option>
                            <option value="Historical" <?php echo (isset($_GET['category']) && $_GET['category'] == 'Historical') ? 'selected' : ''; ?>>Historical</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Min Price (EGP)</label>
                        <input type="number" name="min_price" class="form-control" value="<?php echo isset($_GET['min_price']) ? htmlspecialchars($_GET['min_price']) : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label>Max Price (EGP)</label>
                        <input type="number" name="max_price" class="form-control" value="<?php echo isset($_GET['max_price']) ? htmlspecialchars($_GET['max_price']) : ''; ?>">
                    </div>
                    <button type="submit" class="btn btn-dark w-100">Apply Filters</button>
                    <a href="filters.php" class="btn btn-outline-secondary w-100 mt-2">Clear</a>
                </form>
            </div>
        </div>

        <!-- قسم عرض النتائج -->
        <div class="col-md-9">
            <h2 class="mb-4">Search Results</h2>
            <div class="search-results">
                <?php if(mysqli_num_rows($result) > 0): ?>
                    <?php while($trip = mysqli_fetch_assoc($result)): ?>
                        <div class="search-result">
                            <img src="../assets/images/<?php echo htmlspecialchars($trip['image']); ?>" class="search-image" alt="Trip Image">
                            <div class="search-details">
                                <h1><?php echo htmlspecialchars($trip['trip_name']); ?></h1>
                                <h2><?php echo htmlspecialchars($trip['hotel_level']); ?> Stars Hotel</h2>
                                <p><?php echo htmlspecialchars(substr($trip['description'], 0, 100)) . '...'; ?></p>
                                <h3><i class="fa-regular fa-calendar"></i> Duration: <?php echo htmlspecialchars($trip['duration_days']); ?> Days</h3>
                                <h3><i class="fa-solid fa-location-dot"></i> To: <?php echo htmlspecialchars($trip['destination']); ?></h3>
                                <h3><i class="fa-solid fa-list"></i> Category: <?php echo htmlspecialchars($trip['category']); ?></h3>
                            </div>
                            <div class="search-price">
                                <h1><?php echo htmlspecialchars($trip['price']); ?> EGP</h1>
                                <a href="../booking/trip_details.php?id=<?php echo $trip['trip_id']; ?>" style="text-decoration: none;">
                                    <button type="button">View Details</button>
                                </a>
                                <!-- زر المقارنة -->
                                <form action="compare.php" method="GET" class="mt-2">
                                    <input type="hidden" name="id1" value="<?php echo $trip['trip_id']; ?>">
                                    <button type="submit" style="background-color: #333; font-size: 14px; padding: 10px 20px;">Compare</button>
                                </form>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="alert alert-warning">No trips found matching your criteria.</div>
                <?php endif; ?>
            </div>
        </div>
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