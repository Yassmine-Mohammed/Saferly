<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //connect database
    require_once "../config/db.php";
    if (isset($_POST['register_user'])) {
        $fname = $_POST['user_Fname'];
        $lname = $_POST['user_Lname'];
        $username = $fname . " " . $lname;
        $phoneno = $_POST['user_phone'];
        $email = $_POST['user_email'];
        $password = password_hash($_POST['user_password'], PASSWORD_DEFAULT);
        $date = date("Y-m-d H:i:s");

        //check email
        $emailCheck = mysqli_query($con, "SELECT user_id FROM users WHERE email='$email'");

        //check phone
        $phoneCheck = mysqli_query($con, "SELECT user_id FROM users WHERE phone='$phoneno'");

    }
    if (isset($_POST['register_company'])) {
        $Co_name = $_POST['company_name'];
        $Co_taxno = $_POST['tax_number'];
        $Co_email = $_POST['company_email'];
        $Co_password = password_hash($_POST['company_password'], PASSWORD_DEFAULT);

        //check email
        $emailCheck = mysqli_query(
            $con,
            "SELECT company_id FROM companies WHERE email='$Co_email'"
        );

        //check phone
        $taxCheck = mysqli_query(
            $con,
            "SELECT company_id FROM companies WHERE tax_number='$Co_taxno'"
        );
    }
    if (mysqli_num_rows($emailCheck) > 0) {

        $error = "This Email is already registered.";

    } elseif (mysqli_num_rows($taxCheck) > 0) {

        $error = "This Phone is already registered.";

    } else {
        if (isset($_POST['register_user'])) {
            //Query
            $query = "INSERT INTO `users`(`name`, `email`, `password`, `phone`, `created_at`) VALUES ('$username','$email','$password','$phoneno','$date')";
            $result = mysqli_query($con, $query);
        }
        if (isset($_POST['register_company'])) {
            //Query
            $query = "INSERT INTO `companies`(`name`, `email`, `password`, `tax_number`) VALUES ('$Co_name','$Co_email','$Co_password','$Co_taxno')";
            $result = mysqli_query($con, $query);
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
    <title>Register Page</title>
</head>

<body>
    <div class="bg-image"></div>
    <div class="logo text-center  justify-content-center"><img src="images\ChatGPT Image Jul 31, 2026, 12_42_35 AM.png"
            width=200px>
        <img src="images\ChatGPT Image Jul 31, 2026, 01_08_17 AM.png" width=350px>
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
        <div class="tab-pane fade show active" id="nav-user" role="tabpanel" aria-labelledby="nav-user-tab"
            tabindex="0">
            <div class="container mt-5 w-50 mx-auto">
                <form class="form-box" method="POST">
                    <div class="input-group" mb-3>
                        <input type="text" class="form-control" name="user_Fname"
                            placeholder="Please Enter Your First Name" required />
                        <input type="text" class="form-control" name="user_Lname"
                            placeholder="Please Enter Your Last Name" required />
                    </div><br>
                    <input type="phone" class="form-control" name="user_phone"
                        placeholder="Please Enter Your Phone Number"><br>
                    <input type="email" class="form-control" name="user_email" placeholder="Please Enter Your E-mail"
                        required><br>
                    <input type="password" class="form-control" name="user_password"
                        placeholder="Please Enter Your Password" required>
                    <button type="submit" name="register_user" class="btn btn-primary w-100 mt-3">
                        Register
                    </button>
                    <div class="login-footer text-center mt-2">
                        <span>Already have an account?</span>
                        <a href="login.php">Sign In</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="tab-pane fade" id="nav-company" role="tabpanel" aria-labelledby="nav-company-tab" tabindex="0">
            <div class="container mt-5 w-50 mx-auto">
                <form class="form-box" method="POST">
                    <input type="text" class="form-control" name="company_name"
                        placeholder="Please Enter Your Company Name" required /><br>
                    <input type="phone" class="form-control" name="tax_number"
                        placeholder="Please Enter Company Tax Number"><br>
                    <input type="email" class="form-control" name="company_email"
                        placeholder="Please Enter Company E-mail" required><br>
                    <input type="password" class="form-control" name="company_password"
                        placeholder="Please Enter Your Password" required><br>
                    <button type="submit" name="register_company" class="btn btn-primary w-100 mt-3">
                        Register
                    </button>
                    <div class="login-footer text-center mt-2">
                        <span>Already have an account?</span>
                        <a href="login.php">Sign In</a>
                    </div>
                </form>
            </div>
        </div>


        <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>