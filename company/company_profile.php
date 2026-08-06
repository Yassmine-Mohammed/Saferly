<?php
/* company/company_profile.php */

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

$success = "";
$error   = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {

    $name       = trim($_POST['name']);
    $email      = trim($_POST['email']);
    $tax_number = trim($_POST['tax_number']);
    $new_password = $_POST['new_password'] ?? '';

    if ($name === '' || $email === '' || $tax_number === '') {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {

        if ($new_password !== '') {
            // تحديث البيانات مع كلمة سر جديدة
            $hashed = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = mysqli_prepare($con, "
                UPDATE companies
                SET name = ?, email = ?, tax_number = ?, password = ?
                WHERE company_id = ?
            ");
            mysqli_stmt_bind_param($stmt, "ssssi", $name, $email, $tax_number, $hashed, $company_id);
        } else {
            // تحديث البيانات بدون تغيير كلمة السر
            $stmt = mysqli_prepare($con, "
                UPDATE companies
                SET name = ?, email = ?, tax_number = ?
                WHERE company_id = ?
            ");
            mysqli_stmt_bind_param($stmt, "sssi", $name, $email, $tax_number, $company_id);
        }

        if (mysqli_stmt_execute($stmt)) {
            // تحديث بيانات الجلسة فورًا لتعكس آخر تعديل
            $_SESSION['company']['name']       = $name;
            $_SESSION['company']['email']      = $email;
            $_SESSION['company']['tax_number'] = $tax_number;
            $company = $_SESSION['company'];
            $success = "Profile updated successfully.";
        } else {
            // على الأغلب خطأ تكرار الإيميل (unique key)
            $error = "Could not update profile. The email may already be in use.";
        }
        mysqli_stmt_close($stmt);
    }
}

$page_title = "Company Profile";
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
            <li><a href="add_trip.php"><i class="fa-solid fa-circle-plus"></i> Add New Trip</a></li>
            <li class="active"><a href="company_profile.php"><i class="fa-solid fa-building"></i> Company Profile</a></li>
        </ul>
    </aside>

    <div class="company-main">
        <div class="company-content">

            <h3 class="mb-4">Company Profile</h3>

            <?php if ($success): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <div class="card company-card p-4" style="max-width: 600px;">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Company Name</label>
                        <input type="text" name="name" class="form-control"
                            value="<?= htmlspecialchars($company['name']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"
                            value="<?= htmlspecialchars($company['email']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tax Number</label>
                        <input type="text" name="tax_number" class="form-control"
                            value="<?= htmlspecialchars($company['tax_number']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password <span class="text-muted">(leave empty to keep current password)</span></label>
                        <input type="password" name="new_password" class="form-control" placeholder="••••••••">
                    </div>

                    <div class="mb-4">
                        <label class="form-label d-block">Account Status</label>
                        <span class="badge bg-<?= $company['status'] === 'approved' ? 'success' : 'secondary' ?>">
                            <?= htmlspecialchars($company['status']) ?>
                        </span>
                    </div>

                    <button type="submit" name="update_profile" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Save Changes
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<?php require_once "../includes/footer.php"; ?>