<?php

include("../config/db.php");

$id = (int) ($_GET['id'] ?? 0);

$stmt = mysqli_prepare($con, "
    SELECT trips.*, companies.name AS company_name
    FROM trips
    JOIN companies ON trips.company_id = companies.company_id
    WHERE trips.trip_id = ?
");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$trip = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$trip) {
    header("Location: manage_trips.php?error=Trip+not+found");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View Trip | Saferly Admin</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<link rel="stylesheet" href="CSS/admin.css">
<style>
    /* ============================
       View Trip (Admin) - Styles
       (كلاسات مبدوءة بـ vt- لتفادي أي تعارض مع admin.css)
       ============================ */
    .vt-page {
        max-width: 960px;
        margin: 30px auto;
        padding: 0 20px;
        font-family: 'Segoe UI', Tahoma, sans-serif;
        color: #1e2a3a;
    }

    .vt-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        color: #6c757d;
        font-size: 14px;
        margin-bottom: 18px;
        transition: 0.2s;
    }

    .vt-back:hover {
        color: #0d6efd;
    }

    .vt-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
    }

    .vt-banner {
        position: relative;
        width: 100%;
        height: 320px;
        overflow: hidden;
        background: linear-gradient(135deg, #0d6efd, #0dcaf0);
    }

    .vt-banner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .vt-banner-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.75) 0%, rgba(0, 0, 0, 0.1) 55%, transparent 100%);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 28px;
    }

    .vt-banner-overlay h1 {
        color: #fff;
        margin: 0 0 6px;
        font-size: 28px;
        font-weight: 700;
    }

    .vt-banner-overlay .vt-company {
        color: #e9ecef;
        font-size: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .vt-status {
        position: absolute;
        top: 20px;
        right: 20px;
        padding: 6px 16px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
        text-transform: capitalize;
        color: #fff;
        backdrop-filter: blur(4px);
    }

    .vt-status.active { background: rgba(25, 135, 84, 0.9); }
    .vt-status.inactive,
    .vt-status.not_verified { background: rgba(108, 117, 125, 0.9); }
    .vt-status.pending { background: rgba(255, 193, 7, 0.9); color: #1e2a3a; }

    .vt-body {
        padding: 30px;
    }

    .vt-desc {
        color: #495057;
        line-height: 1.7;
        margin-bottom: 28px;
        font-size: 15px;
    }

    .vt-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 16px;
        margin-bottom: 10px;
    }

    .vt-stat {
        background: #f4f6f9;
        border-radius: 12px;
        padding: 16px 18px;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .vt-stat .vt-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
        color: #fff;
        background: #0d6efd;
        flex-shrink: 0;
    }

    .vt-stat.i-price .vt-icon { background: #198754; }
    .vt-stat.i-duration .vt-icon { background: #fd7e14; }
    .vt-stat.i-hotel .vt-icon { background: #d63384; }
    .vt-stat.i-date .vt-icon { background: #0dcaf0; }
    .vt-stat.i-category .vt-icon { background: #6f42c1; }
    .vt-stat.i-id .vt-icon { background: #6c757d; }

    .vt-stat .vt-label {
        font-size: 12px;
        color: #6c757d;
        margin: 0 0 2px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .vt-stat .vt-value {
        font-size: 15px;
        font-weight: 600;
        margin: 0;
        color: #1e2a3a;
    }

    .vt-footer-actions {
        margin-top: 28px;
        padding-top: 22px;
        border-top: 1px solid #eef1f4;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .vt-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: 0.2s;
        border: none;
        cursor: pointer;
    }

    .vt-btn-primary {
        background: #0d6efd;
        color: #fff;
    }

    .vt-btn-primary:hover {
        background: #0b5ed7;
    }

    @media (max-width: 600px) {
        .vt-banner { height: 220px; }
        .vt-banner-overlay h1 { font-size: 21px; }
    }
</style>
</head>

<body>

<div class="vt-page">

    <a href="manage_trips.php" class="vt-back">
        <i class="fa-solid fa-arrow-left"></i> Back to Trips
    </a>

    <div class="vt-card">

        <div class="vt-banner">
            <?php if (!empty($trip['image'])): ?>
                <img src="../assets/images/trips/<?= htmlspecialchars(basename($trip['image'])) ?>" alt="<?= htmlspecialchars($trip['trip_name']) ?>">
            <?php endif; ?>
            <span class="vt-status <?= htmlspecialchars(strtolower($trip['status'])) ?>">
                <?= htmlspecialchars($trip['status']) ?>
            </span>
            <div class="vt-banner-overlay">
                <h1><?= htmlspecialchars($trip['trip_name']) ?></h1>
                <div class="vt-company">
                    <i class="fa-solid fa-building"></i> <?= htmlspecialchars($trip['company_name']) ?>
                    <span>&nbsp;•&nbsp;</span>
                    <i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($trip['destination']) ?>
                </div>
            </div>
        </div>

        <div class="vt-body">

            <?php if (!empty($trip['description'])): ?>
                <p class="vt-desc"><?= nl2br(htmlspecialchars($trip['description'])) ?></p>
            <?php endif; ?>

            <div class="vt-grid">

                <div class="vt-stat i-id">
                    <div class="vt-icon"><i class="fa-solid fa-hashtag"></i></div>
                    <div>
                        <p class="vt-label">Trip ID</p>
                        <p class="vt-value">#<?= (int) $trip['trip_id'] ?></p>
                    </div>
                </div>

                <div class="vt-stat i-price">
                    <div class="vt-icon"><i class="fa-solid fa-tag"></i></div>
                    <div>
                        <p class="vt-label">Price</p>
                        <p class="vt-value"><?= number_format((float) $trip['price'], 2) ?> EGP</p>
                    </div>
                </div>

                <div class="vt-stat i-duration">
                    <div class="vt-icon"><i class="fa-solid fa-calendar-days"></i></div>
                    <div>
                        <p class="vt-label">Duration</p>
                        <p class="vt-value"><?= (int) $trip['duration_days'] ?> Days</p>
                    </div>
                </div>

                <div class="vt-stat i-hotel">
                    <div class="vt-icon"><i class="fa-solid fa-star"></i></div>
                    <div>
                        <p class="vt-label">Hotel Level</p>
                        <p class="vt-value"><?= (int) $trip['hotel_level'] ?> Stars</p>
                    </div>
                </div>

                <div class="vt-stat i-date">
                    <div class="vt-icon"><i class="fa-solid fa-plane-departure"></i></div>
                    <div>
                        <p class="vt-label">Start Date</p>
                        <p class="vt-value"><?= htmlspecialchars($trip['start_date']) ?></p>
                    </div>
                </div>

                <div class="vt-stat i-category">
                    <div class="vt-icon"><i class="fa-solid fa-layer-group"></i></div>
                    <div>
                        <p class="vt-label">Category</p>
                        <p class="vt-value"><?= htmlspecialchars($trip['category']) ?></p>
                    </div>
                </div>

            </div>

            <div class="vt-footer-actions">
                <a href="manage_trips.php" class="vt-btn vt-btn-primary">
                    <i class="fa-solid fa-arrow-left"></i> Back to Trips
                </a>
            </div>

        </div>

    </div>

</div>

</body>

</html>