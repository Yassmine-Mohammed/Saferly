<?php
/* company/dashboard.php */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../config/db.php";

// السماح فقط للشركات المسجلة دخول (وليس المستخدمين العاديين)
if (empty($_SESSION['company'])) {
    header("Location: ../auth/login.php");
    exit();
}

$company    = $_SESSION['company'];
$company_id = (int) $company['company_id'];

/* ---------- عدد الرحلات الخاصة بالشركة ---------- */
$stmt = mysqli_prepare($con, "SELECT COUNT(*) AS total FROM trips WHERE company_id = ?");
mysqli_stmt_bind_param($stmt, "i", $company_id);
mysqli_stmt_execute($stmt);
$tripsCount = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))['total'];
mysqli_stmt_close($stmt);

/* ---------- عدد الحجوزات الخاصة برحلات الشركة ---------- */
$stmt = mysqli_prepare($con, "
    SELECT COUNT(*) AS total
    FROM bookings b
    INNER JOIN trips t ON b.trip_id = t.trip_id
    WHERE t.company_id = ?
");
mysqli_stmt_bind_param($stmt, "i", $company_id);
mysqli_stmt_execute($stmt);
$bookingsCount = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))['total'];
mysqli_stmt_close($stmt);

/* ---------- كل رحلات الشركة (الأحدث أولًا) ---------- */
$stmt = mysqli_prepare($con, "
    SELECT trip_id, trip_name, destination, price, duration_days, image, start_date, status
    FROM trips
    WHERE company_id = ?
    ORDER BY trip_id DESC
");
mysqli_stmt_bind_param($stmt, "i", $company_id);
mysqli_stmt_execute($stmt);
$trips = mysqli_stmt_get_result($stmt);

$page_title = "Dashboard";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?> | Saferly</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="CSS/company.css">
</head>
<body>

<div class="company-wrapper">

    <!-- Sidebar -->
    <aside class="company-sidebar">
        <div class="sidebar-logo">
            <span>Company Panel</span>
        </div>
        <ul class="sidebar-menu">
            <li class="active"><a href="dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
            <li><a href="add_trip.php"><i class="fa-solid fa-circle-plus"></i> Add New Trip</a></li>
            <li><a href="company_profile.php"><i class="fa-solid fa-building"></i> Company Profile</a></li>
        </ul>
    </aside>

    <!-- Main content -->
    <div class="company-main">

        <div class="company-content">

            <h3 class="mb-1">Welcome, <?= htmlspecialchars($company['name']) ?> 👋</h3>
            <p class="text-muted mb-4">Here is what's happening with your trips today.</p>

            <?php if (isset($_GET['added'])): ?>
                <div class="alert alert-success">Trip added successfully.</div>
            <?php elseif (isset($_GET['updated'])): ?>
                <div class="alert alert-success">Trip updated successfully.</div>
            <?php elseif (isset($_GET['deleted'])): ?>
                <div class="alert alert-success">Trip deleted successfully.</div>
            <?php elseif (isset($_GET['error'])): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
            <?php endif; ?>

            <!-- Stat cards -->
            <div class="row">
                <div class="col-md-6">
                    <div class="stat-card">
                        <div class="icon-box bg-trips"><i class="fa-solid fa-map-location-dot"></i></div>
                        <div>
                            <h3><?= (int) $tripsCount ?></h3>
                            <p>Total Trips</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stat-card">
                        <div class="icon-box bg-bookings"><i class="fa-solid fa-ticket"></i></div>
                        <div>
                            <h3><?= (int) $bookingsCount ?></h3>
                            <p>Total Bookings</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trips table -->
            <div class="d-flex justify-content-between align-items-center mt-4 mb-2">
                <h5 class="m-0">Your Trips</h5>
                <a href="add_trip.php" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-plus"></i> Add New Trip
                </a>
            </div>

            <div class="table-responsive company-table-wrap">
                <table class="table table-hover align-middle bg-white">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Trip Name</th>
                            <th>Destination</th>
                            <th>Price</th>
                            <th>Duration</th>
                            <th>Start Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($trips) === 0): ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    No trips added yet. Click "Add New Trip" to get started.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php while ($trip = mysqli_fetch_assoc($trips)): ?>
                                <tr>
                                    <td>
                                        <?php if (!empty($trip['image'])): ?>
                                            <img src="../assets/images/<?= htmlspecialchars($trip['image']) ?>"
                                                alt="" class="trip-thumb">
                                        <?php else: ?>
                                            <span class="text-muted">No image</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($trip['trip_name']) ?></td>
                                    <td><?= htmlspecialchars($trip['destination']) ?></td>
                                    <td><?= number_format($trip['price'], 2) ?> EGP</td>
                                    <td><?= (int) $trip['duration_days'] ?> days</td>
                                    <td><?= htmlspecialchars($trip['start_date']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $trip['status'] === 'active' ? 'success' : 'secondary' ?>">
                                            <?= htmlspecialchars($trip['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="edit_trip.php?trip_id=<?= (int) $trip['trip_id'] ?>"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <a href="delet_trip.php?trip_id=<?= (int) $trip['trip_id'] ?>"
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Delete this trip? This cannot be undone.');">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<?php require_once "../includes/footer.php"; ?>