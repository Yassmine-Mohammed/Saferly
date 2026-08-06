<?php
session_start();
require "../config/db.php";

$trip_id = isset($_GET['trip_id']) ? $_GET['trip_id'] : 1;
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['review_text'])) {
    $review_text = mysqli_real_escape_string($con, $_POST['review_text']);
    $rating = intval($_POST['rating']); // استقبال قيمة النجوم اللي اختارها المستخدم
    
    $insert_sql = "REPLACE INTO reviews (trip_id, user_id, rating, comment) VALUES ($trip_id, $user_id, $rating, '$review_text')";
    mysqli_query($con, $insert_sql);
    
    header("Location: reviews.php?trip_id=" . $trip_id);
    exit();
}

// جلب المراجعات الخاصة بالرحلة
$sql = "SELECT * FROM reviews WHERE trip_id = $trip_id";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trip Reviews</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body style="background-color: #0b0f19; color: #fff; font-family: Arial, sans-serif; padding: 30px;">

    <h2>Trip Reviews & Comments</h2>

    <!-- نموذج كتابة مراجعة جديدة مع النجوم -->
    <form method="POST" style="margin-bottom: 30px;">
        <label style="display: block; margin-bottom: 5px; color: #c9d1d9;">Rating (1 to 5 Stars):</label>
        <select name="rating" style="width: 100%; padding: 10px; border-radius: 8px; background: #161b22; color: #fff; border: 1px solid #30363d; margin-bottom: 15px;">
            <option value="5">⭐⭐⭐⭐⭐ (5 Stars)</option>
            <option value="4">⭐⭐⭐⭐ (4 Stars)</option>
            <option value="3">⭐⭐⭐ (3 Stars)</option>
            <option value="2">⭐⭐ (2 Stars)</option>
            <option value="1">⭐ (1 Star)</option>
        </select>

        <textarea name="review_text" placeholder="Write your review here..." required style="width: 100%; height: 80px; padding: 10px; border-radius: 8px; background: #161b22; color: #fff; border: 1px solid #30363d;"></textarea>
        <button type="submit" style="background-color: #ff9900; color: #000; padding: 10px 20px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; margin-top: 10px;">Submit Review</button>
    </form>

    <hr style="border-color: #30363d;">

    <!-- عرض المراجعات السابقة من قاعدة البيانات -->
    <h3>All Reviews:</h3>
    <?php if ($result && mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div style="background: #161b22; padding: 15px; border-radius: 8px; margin-bottom: 10px; border: 1px solid #30363d;">
                <p style="color: #ff9900; margin-bottom: 5px;">Rating: <?php echo $row['rating']; ?> ⭐</p>
                <p style="color: #c9d1d9; margin: 0;"><?php echo $row['comment']; ?></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="color: #8b949e;">No reviews yet for this trip. Be the first to write one!</p>
    <?php endif; ?>

    <br>
    <a href="../index.php" style="color: #ff9900; text-decoration: underline;">Back to Home</a>

</body>
</html>