<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/profile.css">
    <title>Document</title>
</head>
<body>
    <aside class="profile-sidebar">
        <div class="sidebar-logo">
            <span>Profile Panel</span>
        </div>
        <ul class="sidebar-menu">
            <li class="active"><a href="profile.php"><i class="fa-solid fa-building"></i>Profile</a></li>
            <li><a href="Booked_trips.php"><i class="fa-solid fa-gauge"></i>Check Your Journey</a></li>
            <li><a href="edit_profile.php"><i class="fa-solid fa-circle-plus"></i>Edit Profile</a></li>
            <li> <a href="profile.php?action=delete" class="delete-btn" onclick="return confirm('Are you sure you Want to delete your Account?');"> <i class="fa-solid fa-trash"></i>Delete Profile</a></li>
        </ul>
    </aside>
</body>
</html>