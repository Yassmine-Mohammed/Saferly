<?php if (!empty($_GET['action']) && $_GET['action'] == "edit") { ?>
        <?php if (isset($_POST['submit']) && $_POST['submit'] == 'Update') {
            if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] == 0) {
                if(file_exists($_SESSION['user']['image'])) {
                    unlink($_SESSION['user']['image']);
                    }
                $folder = "uploads/";
                if (!file_exists($folder)) {
                    mkdir($folder);
                }
                $destination = $folder . $_FILES["image"]["name"];
                move_uploaded_file($_FILES["image"]["tmp_name"], $destination);
                $image_added = true;
            }
            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $id = $_SESSION['user']['id'];

            if ($image_added == true) {
                $query = "update userinfo set Name = '$username', Email ='$email',Password ='$password', image ='$destination' where id ='$id' limit 1";
            } else {
                $query = "update userinfo set Name = '$username', Email ='$email', Password ='$password' where id ='$id' limit 1";
            }
            mysqli_query($con, $query);

            $query = "SELECT * From userinfo where id ='$id' limit 1";
            $result = mysqli_query($con, $query);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);
                $_SESSION["user"] = $row;
            }

        } ?>
        <main class="edit">

            <h2 class="text-center">Edit Page</h2>
            <div class="text-center">
                <img width="250px" style="text-align:center;" src="<?= $_SESSION['user']['image'] ?>" />
            </div>
            <form class="editprofile" method="POST" enctype="multipart/form-data">
                <input type="file" name="image" required />
                <input type="text" name="username" value="<?= $_SESSION['user']['Name'] ?>" placeholder="username" required/>
                <br><input type="email" name="email" value="<?= $_SESSION['user']['Email'] ?>"  placeholder="email" required/>
                <br><input type="password" name="password" value="<?= $_SESSION['user']['Password'] ?>"  placeholder="password" required/>
                <input type="submit" name="submit" value="Update"/>
                <a href="Profile.php" class="btn">Cancel</a>
            </form>
        </main>
    <?php } else if (!empty($_GET["action"]) && $_GET["action"] == "delete") {
        echo "Your Profile has deleted";
    }