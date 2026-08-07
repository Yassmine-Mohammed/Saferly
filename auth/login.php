<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //connect database
    require_once "../config/db.php";

    if (isset($_POST['login_user'])) {
        $email = $_POST['user_email'];


        $query = "SELECT * FROM users WHERE email = '$email'  LIMIT 1";


        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            if (password_verify($_POST['user_password'], $row['password'])) {
                $_SESSION['user'] = $row;
                if ($row['role'] == 'admin') {
                    header("Location:../admin/dashboard.php");
                } else {
                    header("Location:../search/index.php");
                }
                exit();
            } else {
                $error = "Incorrect password";
            }
        } else {
            $error = "Email not found";
        }
    }
    if (isset($_POST['login_company'])) {
        $Co_email = $_POST['company_email'];

        $query = "SELECT * FROM companies WHERE email = '$Co_email' LIMIT 1";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            if (password_verify($_POST['company_password'], $row['password'])) {
                $_SESSION['company'] = $row;
                header("Location:../company/dashboard.php");
                exit();
            } else {
                $error = "Incorrect password";
            }
        } else {
            $error = "Company email not found";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/auth.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <title>Login Page</title>
</head>

<body>
    <div class="bg-image"></div>
    <div class="logo text-center  justify-content-center"><img src="images\SaferlyLogo.png" width=200px>
        <img src="images\NameWithSlugan.png" width=350px>
    </div>

    <nav>
        <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-user-tab" data-bs-toggle="tab" data-bs-target="#nav-user"
                type="button" role="tab" aria-controls="nav-user" aria-selected="true"
                style="text-align:center;">User</button>

            <button class="nav-link" id="nav-company-tab" data-bs-toggle="tab" data-bs-target="#nav-company"
                type="button" role="tab" aria-controls="nav-company" aria-selected="false">Company</button>
    </nav>

    <?php if (!empty($error)) { ?>
        <div class="alert alert-danger text-center">
            <?= $error ?>
        </div>
    <?php } ?>

    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane ease show active" id="nav-user" role="tabpanel" aria-labelledby="nav-user-tab"
            tabindex="0">
            <div class="container mt-5 w-50 mx-auto">
                <form class="form-box" method="POST">
                    <input type="email" class="form-control" name="user_email" placeholder="Please Enter Your E-mail"
                        required><br>
                    <input type="password" class="form-control" name="user_password"
                        placeholder="Please Enter Your Password" required>
                    <button type="submit" name="login_user" class="btn btn-primary w-100 mt-3">
                        Login
                    </button>
                    <div class="login-footer text-center mt-2">
                        <span>Don't have an account</span>
                        <a href="register.php">Register Now!</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="tab-pane ease" id="nav-company" role="tabpanel" aria-labelledby="nav-company-tab" tabindex="0">
            <div class="container mt-5 w-50 mx-auto">
                <form class="form-box" method="POST">
                    <input type="email" class="form-control" name="company_email"
                        placeholder="Please Enter Company E-mail" required><br>
                    <input type="password" class="form-control" name="company_password"
                        placeholder="Please Enter Your Password" required><br>
                    <button type="submit" name="login_company" class="btn btn-primary w-100 mt-3">
                        Login
                    </button>
                    <div class="login-footer text-center mt-2">
                        <span>Don't have an account</span>
                        <a href="register.php">Register Now!</a>
                    </div>
                </form>
            </div>
        </div>


        <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>
