<?php

include("../config/db.php");

$users     = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM users"));
$companies = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM companies"));
$trips     = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM trips"));
$bookings  = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM bookings"));

$top_company_result = mysqli_query($con, "
    SELECT companies.name, COUNT(trips.trip_id) AS total_trips
    FROM companies
    LEFT JOIN trips ON companies.company_id = trips.company_id
    GROUP BY companies.company_id
    ORDER BY total_trips DESC
    LIMIT 1
");
$top_company = mysqli_fetch_assoc($top_company_result);

/* Top 5 companies by trip count, for the chart */
$top5_result = mysqli_query($con, "
    SELECT companies.name, COUNT(trips.trip_id) AS total_trips
    FROM companies
    LEFT JOIN trips ON companies.company_id = trips.company_id
    GROUP BY companies.company_id
    ORDER BY total_trips DESC
    LIMIT 5
");
$chart_labels = [];
$chart_values = [];
while ($row = mysqli_fetch_assoc($top5_result)) {
    $chart_labels[] = $row['name'];
    $chart_values[] = (int) $row['total_trips'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reports | Saferly Admin</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<link rel="stylesheet" href="CSS/admin.css">

<style>
    /* ============================
       Reports page enhancements
       (كلاسات مبدوءة بـ rp- لتفادي أي تعارض مع admin.css)
       ============================ */
    .rp-header {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        margin-bottom: 22px;
    }

    .rp-header p {
        color: #6c757d;
        margin: 4px 0 0;
        font-size: 14px;
    }

    .cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 18px;
        margin-bottom: 26px;
    }

    .card {
        background: #fff;
        border-radius: 14px;
        padding: 22px;
        box-shadow: 0 2px 14px rgba(0, 0, 0, 0.06);
        position: relative;
        overflow: hidden;
        border-left: 4px solid transparent;
    }

    .card::before {
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        position: absolute;
        right: 18px;
        top: 18px;
        font-size: 30px;
        opacity: 0.12;
    }

    .card h3 {
        margin: 0 0 8px;
        font-size: 13px;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .card p {
        margin: 0;
        font-size: 30px;
        font-weight: 700;
        color: #1e2a3a;
    }

    .card.users { border-left-color: #0d6efd; }
    .card.users::before { content: "\f0c0"; color: #0d6efd; }

    .card.companies { border-left-color: #6f42c1; }
    .card.companies::before { content: "\f1ad"; color: #6f42c1; }

    .card.trips { border-left-color: #fd7e14; }
    .card.trips::before { content: "\f5a0"; color: #fd7e14; }

    .card.bookings { border-left-color: #198754; }
    .card.bookings::before { content: "\f145"; color: #198754; }

    .rp-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
    }

    @media (max-width: 900px) {
        .rp-grid { grid-template-columns: 1fr; }
    }

    .rp-panel {
        background: #fff;
        border-radius: 14px;
        padding: 24px;
        box-shadow: 0 2px 14px rgba(0, 0, 0, 0.06);
    }

    .rp-panel h2 {
        margin: 0 0 18px;
        font-size: 17px;
        color: #1e2a3a;
    }

    .box {
        background: linear-gradient(135deg, #1e2a3a, #2b3a4f);
        border-radius: 14px;
        padding: 26px;
        color: #fff;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 10px;
    }

    .box h2 {
        margin: 0;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #cfd8e3;
        font-weight: 600;
    }

    .box .rp-trophy {
        font-size: 26px;
        color: #ffc107;
    }

    .box p {
        margin: 0;
        font-size: 15px;
        line-height: 1.7;
    }

    .box strong {
        font-size: 20px;
        display: block;
        margin-bottom: 4px;
    }

    .rp-empty {
        color: #cfd8e3;
        font-size: 14px;
    }
</style>
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

    <div class="rp-header">
        <div>
            <h1>Reports</h1>
            <p>An overview of platform activity and top performers.</p>
        </div>
    </div>

    <div class="cards">

        <div class="card users">
            <h3>Total Users</h3>
            <p><?= (int) $users['total'] ?></p>
        </div>

        <div class="card companies">
            <h3>Total Companies</h3>
            <p><?= (int) $companies['total'] ?></p>
        </div>

        <div class="card trips">
            <h3>Total Trips</h3>
            <p><?= (int) $trips['total'] ?></p>
        </div>

        <div class="card bookings">
            <h3>Total Bookings</h3>
            <p><?= (int) $bookings['total'] ?></p>
        </div>

    </div>

    <div class="rp-grid">

        <div class="rp-panel">
            <h2>Top 5 Companies by Trips</h2>
            <?php if (!empty($chart_labels)): ?>
                <canvas id="topCompaniesChart" height="140"></canvas>
            <?php else: ?>
                <p class="rp-empty">No data available.</p>
            <?php endif; ?>
        </div>

        <div class="box">
            <h2><i class="fa-solid fa-trophy rp-trophy"></i> Top Company</h2>
            <?php if ($top_company && $top_company['total_trips'] > 0): ?>
                <p>
                    <strong><?= htmlspecialchars($top_company['name']) ?></strong>
                    Total Trips: <?= (int) $top_company['total_trips'] ?>
                </p>
            <?php else: ?>
                <p class="rp-empty">No data available.</p>
            <?php endif; ?>
        </div>

    </div>

</div>

<?php if (!empty($chart_labels)): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const ctx = document.getElementById('topCompaniesChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($chart_labels) ?>,
            datasets: [{
                label: 'Trips',
                data: <?= json_encode($chart_values) ?>,
                backgroundColor: '#0d6efd',
                borderRadius: 6,
                maxBarThickness: 46
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });
</script>
<?php endif; ?>

</body>

</html>