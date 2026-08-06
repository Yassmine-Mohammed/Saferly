<?php
/* company/add_trip.php */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../config/db.php";

if (empty($_SESSION['company'])) {
    header("Location: ../auth/login.php");
    exit();
}

$company    = $_SESSION['company'];
$company_id = (int) $company['company_id'];

$error = "";

$allowedCategories = ["Cultural", "Family", "Adventure", "Beach"];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_trip'])) {

    $trip_name     = trim($_POST['trip_name']);
    $destination   = trim($_POST['destination']);
    $description   = trim($_POST['description']);
    $category      = trim($_POST['category']);
    $price         = $_POST['price'];
    $duration_days = $_POST['duration_days'];
    $hotel_level   = $_POST['hotel_level'] !== '' ? (int) $_POST['hotel_level'] : null;
    $start_date    = $_POST['start_date'];
    $status        = $_POST['status'] === 'active' ? 'active' : 'inactive';

    /* -------- التحقق من صحة المدخلات -------- */
    if ($trip_name === '' || $destination === '' || $category === '' || $start_date === '') {
        $error = "Please fill in all required fields.";
    } elseif (!is_numeric($price) || $price <= 0) {
        $error = "Price must be a positive number.";
    } elseif (!is_numeric($duration_days) || $duration_days <= 0) {
        $error = "Duration must be a positive number of days.";
    } elseif (!in_array($category, $allowedCategories, true)) {
        $error = "Please choose a valid category.";
    } elseif ($hotel_level !== null && ($hotel_level < 1 || $hotel_level > 5)) {
        $error = "Hotel level must be between 1 and 5.";
    }

    $imageFileName = null;

    /* -------- رفع صورة الرحلة (اختياري) -------- */
    if (empty($error) && isset($_FILES['trip_image']) && $_FILES['trip_image']['error'] !== UPLOAD_ERR_NO_FILE) {

        $file = $_FILES['trip_image'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $error = "Error uploading image.";
        } else {
            $allowedTypes = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
            $finfo    = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);

            $maxSize = 3 * 1024 * 1024; // 3MB

            if (!isset($allowedTypes[$mimeType])) {
                $error = "Only JPG, PNG or WEBP images are allowed.";
            } elseif ($file['size'] > $maxSize) {
                $error = "Image size must not exceed 3MB.";
            } else {
                $ext = $allowedTypes[$mimeType];
                // اسم فريد وآمن للملف لمنع تعارض الأسماء أو حقن مسارات
                $imageFileName = "trip_" . $company_id . "_" . uniqid() . "." . $ext;
                $destination_path = "../assets/images/trips/" . $imageFileName;

                if (!move_uploaded_file($file['tmp_name'], $destination_path)) {
                    $error = "Failed to save the uploaded image.";
                    $imageFileName = null;
                }
            }
        }
    }

    /* -------- الإدخال في قاعدة البيانات -------- */
    if (empty($error)) {
        $stmt = mysqli_prepare($con, "
            INSERT INTO trips
                (company_id, trip_name, destination, description, category, price, duration_days, hotel_level, image, start_date, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        mysqli_stmt_bind_param(
            $stmt,
            "issssdiisss",
            $company_id,
            $trip_name,
            $destination,
            $description,
            $category,
            $price,
            $duration_days,
            $hotel_level,
            $imageFileName,
            $start_date,
            $status
        );

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            header("Location: dashboard.php?added=1");
            exit();
        } else {
            $error = "Could not add the trip. Please try again.";
        }
        mysqli_stmt_close($stmt);
    }
}

$page_title = "Add New Trip";
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

    <aside class="company-sidebar">
        <div class="sidebar-logo">
            <span>Company Panel</span>
        </div>
        <ul class="sidebar-menu">
            <li><a href="dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
            <li class="active"><a href="add_trip.php"><i class="fa-solid fa-circle-plus"></i> Add New Trip</a></li>
            <li><a href="company_profile.php"><i class="fa-solid fa-building"></i> Company Profile</a></li>
        </ul>
    </aside>

    <div class="company-main">
        <div class="company-content">

            <h3 class="mb-4">Add New Trip</h3>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <div class="card company-card p-4">
                <form method="POST" enctype="multipart/form-data">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Trip Name</label>
                            <input type="text" name="trip_name" class="form-control"
                                value="<?= htmlspecialchars($_POST['trip_name'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Destination</label>
                            <input type="text" name="destination" class="form-control"
                                value="<?= htmlspecialchars($_POST['destination'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-select" required>
                                <option value="">Choose...</option>
                                <?php foreach ($allowedCategories as $cat): ?>
                                    <option value="<?= $cat ?>"
                                        <?= (($_POST['category'] ?? '') === $cat) ? 'selected' : '' ?>>
                                        <?= $cat ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Price (EGP)</label>
                            <input type="number" step="0.01" min="0" name="price" class="form-control"
                                value="<?= htmlspecialchars($_POST['price'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Duration (days)</label>
                            <input type="number" min="1" name="duration_days" class="form-control"
                                value="<?= htmlspecialchars($_POST['duration_days'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Hotel Level</label>
                            <select name="hotel_level" class="form-select">
                                <option value="">N/A</option>
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <option value="<?= $i ?>"
                                        <?= (($_POST['hotel_level'] ?? '') == $i) ? 'selected' : '' ?>>
                                        <?= $i ?> Star<?= $i > 1 ? 's' : '' ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="date" name="start_date" class="form-control"
                                value="<?= htmlspecialchars($_POST['start_date'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="active" <?= (($_POST['status'] ?? 'active') === 'active') ? 'selected' : '' ?>>Active</option>
                                <option value="inactive" <?= (($_POST['status'] ?? '') === 'inactive') ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Trip Image</label>
                            <input type="file" name="trip_image" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                        </div>
                    </div>

                    <button type="submit" name="add_trip" class="btn btn-primary mt-2">
                        <i class="fa-solid fa-plus"></i> Add Trip
                    </button>
                    <a href="dashboard.php" class="btn btn-outline-secondary mt-2">Cancel</a>

                </form>
            </div>

        </div>
    </div>
</div>

<?php require_once "../includes/footer.php"; ?>