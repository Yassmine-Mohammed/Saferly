<?php
session_start();
require_once("../config/db.php");

require_once "../includes/login_check.php";
checkLogin();

$id = $_SESSION['user']['user_id'];
$folder = "uploads/user/";
$error = "";

if (isset($_POST['submit']) && $_POST['submit'] == 'Update') {

    $fname = mysqli_real_escape_string($con, $_POST["user_Fname"]);
    $lname = mysqli_real_escape_string($con, $_POST["user_Lname"]);
    $username = $fname . " " . $lname;
    $phoneno = mysqli_real_escape_string($con, $_POST["user_phone"]);
    $email = mysqli_real_escape_string($con, $_POST["user_email"]);
    $password = $_POST['user_password'];

    // نتأكد إن الإيميل والتليفون مش مستخدمين من حد تاني
    $emailCheck = mysqli_query($con, "SELECT user_id FROM users WHERE email='$email' AND user_id != '$id'");
    $phoneCheck = mysqli_query($con, "SELECT user_id FROM users WHERE phone='$phoneno' AND user_id != '$id'");

    if (mysqli_num_rows($emailCheck) > 0) {

        $error = "This Email is already registered.";

    } elseif (mysqli_num_rows($phoneCheck) > 0) {

        $error = "This Phone is already registered.";

    } else {

        $image_added = false;
        $destination = "";

        // رفع صورة جديدة اختياري
        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] == 0) {
            $destination = $folder . time() . "_" . basename($_FILES["image"]["name"]);

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $destination)) {
                if (!empty($_SESSION['user']['image']) && file_exists($folder . $_SESSION['user']['image'])) {
                    unlink($folder . $_SESSION['user']['image']);
                }
                $image_added = true;
            }
        }

        // نبني جزء الـ SET ديناميك حسب اللي المستخدم غيّره فعلًا
        //عشان لو مثلا مغيرش غير الاسم بس مبعملش الباقي null والدنيا تخرب !

        $setParts = [];
        $setParts[] = "name = '$username'";
        $setParts[] = "phone = '$phoneno'";
        $setParts[] = "email = '$email'";

        if (!empty($password)) {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $setParts[] = "password = '$hashed'";
        }

        if ($image_added) {
            $imageName = basename($destination);
            $setParts[] = "image = '$imageName'";
        }

        $query = "UPDATE users SET " . implode(", ", $setParts) . " WHERE user_id = '$id' LIMIT 1";
        $result = mysqli_query($con, $query);

        if ($result) {
            $selectQuery = "SELECT * FROM users WHERE user_id = '$id' LIMIT 1";
            $selectResult = mysqli_query($con, $selectQuery);
            $row = mysqli_fetch_assoc($selectResult);
            $_SESSION["user"] = $row;

            header("Location: profile.php");
            exit();
        } else {
            $error = "An Error Occured While Update!: " . mysqli_error($con);
        }
    }
}

$row = $_SESSION['user'];

$nameParts = explode(" ", $row['name'], 2);
$currentFname = $nameParts[0] ?? "";
$currentLname = $nameParts[1] ?? "";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/auth.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../includes/Css/includes.css">
    <title>Update Your Profile</title>
</head>

<body>
    <h2 class="text-center">Edit Profile</h2>
    <?php include_once("../includes/header.php"); ?>

    <?php if (!empty($error)) { ?>
        <div class="alert alert-danger text-center">
            <?= $error ?>
        </div>
    <?php } ?>

    <div class="container mt-4 w-50 mx-auto text-center">
        <div class="UP_photo mb-3">
            <img src="<?= !empty($row['image']) ? $folder . $row['image'] : 'uploads/user/default.png' ?>" alt="Profile"
                style="width:200px;border-radius:50%;object-fit:cover;">
        </div>
    </div>

    <div class="container mt-3 w-50 mx-auto">
        <form class="form-box" method="POST" enctype="multipart/form-data">
            <label for="form-control" class="form-label">Photo</label>
            <input type="file" class="form-control" name="image" accept="image/*"><br>

            <label for="form-control" class="form-label">Full Name</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="user_Fname" value="<?= htmlspecialchars($currentFname) ?>"
                    placeholder="Please Enter Your First Name" required />
                <input type="text" class="form-control" name="user_Lname" value="<?= htmlspecialchars($currentLname) ?>"
                    placeholder="Please Enter Your Last Name" required />
            </div>
            <label for="form-control" class="form-label">Phone Number</label>
            <input type="phone" class="form-control" name="user_phone" value="<?= htmlspecialchars($row['phone']) ?>"
                placeholder="Please Enter Your Phone Number"><br>

            <label for="form-control" class="form-label">Email</label>
            <input type="email" class="form-control" name="user_email" value="<?= htmlspecialchars($row['email']) ?>"
                placeholder="Please Enter Your E-mail" required><br>

            <label for="form-control" class="form-label">Update Password</label>
            <input type="password" class="form-control" name="user_password" placeholder="New Password"><br>

            <button type="submit" name="submit" value="Update" class="btn btn-primary w-100 mt-3">
                Update
            </button>

            <div class="login-footer text-center mt-2">
                <a href="profile.php">Cancel</a>
            </div>
        </form>
    </div>

    <script src="../js/bootstrap.bundle.min.js"></script>
    <?php include_once("../includes/footer.php"); ?>
</body>

</html>