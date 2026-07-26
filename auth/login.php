<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $con = mysqli_connect("localhost:3307", "root", "", "safarly");
    if(!$con){
    die("Connection Failed: " . mysqli_connect_error());
}

    $username = $_POST['user_name'];
    $phoneno = $_POST['user_phone'];
    $email = $_POST['user_email'];
    password_verify($password, $hashFromDatabase);
    $role = $_POST['user_role'];
    $date = date("Y-m-d H:i:s");


    //Query
    $query = "INSERT INTO `users`(`name`, `email`, `password`, `phone`, `role`, `created_at`) VALUES ('$username','$email','$password','$phoneno','$role','$date')";
    $result = mysqli_query($con, $query);

    if ($result) {
        echo "Registered Successfully";
    } else {
        echo mysqli_error($con);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="CSS/auth.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <title>Register Page</title>
</head>

<body>
    <div class="bg-image"></div>
    <h4 class="text-left" style="font-weight: bold; margin-left: 20%; font-size: 70px; color: white;">Welcome To <span
            style="font-size: 100px; color:  #00a2ff;">Saferly</span></h4>

    <div class="container mt-5 w-50 mx-auto">
        <form method="POST">
            <input type="text" class="form-control" name="user_name" placeholder="Please Enter Your Name"
                required /><br>
            <input type="phone" class="form-control" name="user_phone" placeholder="Please Enter Your Phone Number"><br>
            <input type="email" class="form-control" name="user_email" placeholder="Please Enter Your E-mail"
                required><br>
            <input type="password" class="form-control" name="user_password" placeholder="Please Enter Your Password"
                required>

            <h6 class="text-center mt-3">What is your Role?</h6>

            <div class="text-center">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="user_role" id="user" value="User" required>
                    <label class="form-check-label" for="user">User</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="user_role" id="company" value="Company">
                    <label class="form-check-label" for="company">Company</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">
                Register
            </button>
        </form>
    </div>

    <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>