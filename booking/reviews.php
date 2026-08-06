<?php
session_start();
require_once "../config/db.php";

$trip_id = isset($_GET['trip_id']) ? intval($_GET['trip_id']) : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment'])) {
    $comment = mysqli_real_escape_string($con, $_POST['comment']);
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 5;
    $user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 1;

    $sql = "INSERT INTO reviews (user_id, trip_id, rating, comment) VALUES ('$user_id', '$trip_id', '$rating', '$comment')";
    
    if (mysqli_query($con, $sql)) {
        echo "<script>window.location.href = 'reviews.php?trip_id=$trip_id';</script>";
        exit();
    } else {
        echo "Error: " . mysqli_error($con);
    }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trip Reviews & Comments</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            background-color: #000000 !important;
            color: #ffffff !important;
        }
        .reviews-main-container {
            max-width: 700px;
            margin: 30px auto;
            background: #111111 !important;
            padding: 25px;
            border-radius: 8px;
            border: 1px solid #333333;
        }
        .reviews-main-container h2, .reviews-main-container h3, .reviews-main-container label {
            color: #ffffff !important;
        }
        .reviews-main-container textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            background: #222222 !important;
            color: #ffffff !important;
            border: 1px solid #444444;
            border-radius: 4px;
        }
        .reviews-main-container select {
            padding: 8px;
            background: #222222 !important;
            color: #ffffff !important;
            border: 1px solid #444444;
            border-radius: 4px;
        }
        .custom-submit-btn {
            background: #ff8c00 !important;
            color: white !important;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
            font-weight: bold;
            width: 100%;
        }
        .review-card {
            background: #222222 !important;
            padding: 12px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #333333;
        }
    </style>
</head>
<body>

<div class="reviews-main-container">
    <h2>Trip Reviews & Comments</h2>
    
    <!-- نموذج إدخال التقييم -->
    <form action="" method="POST" style="margin-top: 15px;">
        <label style="display: block; margin-bottom: 5px;">Rating (1 to 5 Stars):</label>
        <select name="rating" style="margin-bottom: 10px;">
            <option value="5">⭐⭐⭐⭐⭐ (5 Stars)</option>
            <option value="4">⭐⭐⭐⭐ (4 Stars)</option>
            <option value="3">⭐⭐⭐ (3 Stars)</option>
            <option value="2">⭐⭐ (2 Stars)</option>
            <option value="1">⭐ (1 Star)</option>
        </select>

        <br>
        <label style="display: block; margin-bottom: 5px;">Write your review here...</label>
        <textarea name="comment" required></textarea>
        
        <br><br>
        <button type="submit" class="custom-submit-btn">Submit Review</button>
    </form>

    <hr style="border-color: #333333; margin: 20px 0;">

    <!-- قسم عرض جميع التقييمات -->
    <h3>All Reviews:</h3>
    <div class="reviews-list" style="margin-top: 10px;">
        <?php
        $rev_sql = "SELECT * FROM reviews WHERE trip_id = $trip_id";
        $rev_result = mysqli_query($con, $rev_sql);
        
        if ($rev_result && mysqli_num_rows($rev_result) > 0) {
            while ($row = mysqli_fetch_assoc($rev_result)) {
                $rating = isset($row['rating']) ? intval($row['rating']) : 5;
                $comment = isset($row['comment']) ? $row['comment'] : '';
                
                echo "<div class='review-card'>";
                echo "<span style='color: gold;'>" . str_repeat('⭐', $rating) . " (" . $rating . " Stars)</span>";
                echo "<p style='margin-top: 8px; color: #f1f1f1;'>" . htmlspecialchars($comment) . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p style='color: #888888;'>No reviews yet for this trip. Be the first to write one!</p>";
        }
        ?>
    </div>

    <!-- زر الرجوع للرئيسية -->
    <div style="margin-top: 20px;">
        <a href="index.php" style="color: #ff8c00; text-decoration: underline;">Back to Home</a>
    </div>
</div>

</body>
</html>