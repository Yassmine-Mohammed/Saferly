<?php 
session_start();
require_once("../config/db.php");

//  أحدث الرحلات
$trips_query = "SELECT * FROM trips WHERE status = 'active' LIMIT 6";
$trips_result = mysqli_query($con, $trips_query);

//  آراء العملاء (التقييمات) مع اسم المستخدم
$reviews_query = "SELECT reviews.*, users.name AS user_name 
                  FROM reviews 
                  JOIN users ON reviews.user_id = users.user_id 
                  ORDER BY reviews.created_at DESC LIMIT 5";
$reviews_result = mysqli_query($con, $reviews_query);

include("../includes/header.php"); 
?>

<link rel="stylesheet" href="CSS/search.css">
<link rel="stylesheet" href="../includes/CSS/includes.css">

<main>
    <div class="content1">
        <h1 class="main-heading container">Make in<br>your journey.</h1>
        <p class="sub-text container">Explore the world with what you love beautiful natural beauty.</p>
        <div class="form-data container">
            <!-- توجيه الفورم لصفحة search.php باستخدام طريقة GET -->
            <form action="/Saferly/search/search.php" method="GET">
                <input type="text" class="location" name="destination" placeholder="Where to ?">
                <input type="date" class="date" name="start_date">
                <input type="number" class="adult" name="adult" min="1" max="10" placeholder="Adult">
                <input type="number" class="child" name="child" min="0" max="10" placeholder="Child">
                <button type="submit">Explore now</button>
            </form>
        </div>
    </div>

    <div class="content2 container">
        <div class="section-header">
            <h2>Explore new worlds with<br>exotic natural scenery</h2>
            <p>Explore the world with what you love beautiful natural beauty.</p>
        </div>
        <div class="nav-btn-card">
            
            <div class="suggestions">
                <?php while($trip = mysqli_fetch_assoc($trips_result)): ?>
                    <div class="place-card">
                        <img src="uploads/<?php echo htmlspecialchars($trip['image']); ?>" alt="Trip" style="width:100%; height:150px; object-fit:cover; border-radius:15px 15px 0 0;">
                        <div style="padding: 15px; font-size:16px;">
                            <h3 style="margin-bottom: 10px;"><?php echo htmlspecialchars($trip['trip_name']); ?></h3>
                            <p><i class="fa-solid fa-location-dot"></i> <?php echo htmlspecialchars($trip['destination']); ?></p>
                            <p><i class="fa-regular fa-clock"></i> <?php echo htmlspecialchars($trip['duration_days']); ?> Days</p>
                            <p><i class="fa-solid fa-star" style="color: #f39c12;"></i> <?php echo htmlspecialchars($trip['hotel_level']); ?> Stars Hotel</p>
                            <h4 style="margin-top: 10px; color: #27ae60;"><?php echo htmlspecialchars($trip['price']); ?> EGP</h4>
                            <a href="../booking/trip_details.php?id=<?php echo $trip['trip_id']; ?>" style="text-decoration: none;">
                                <button type="button">View Details</button>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            
        </div>
    </div>

    <div class="content3">
        <h2>Why Choose Us?</h2>
        <p>our services have been trusted by world travelers</p>
        <div class="trust-travel">
            <div class="trust1">
                <i class="fa-solid fa-people-group" style="font-size: 40px; margin: 25px 0;"></i>
                <h3>Best Service</h3>
                <p style="text-align: center; padding: 0 15px;">We are committed to providing exceptional customer support and a seamless travel experience from start to finish.</p>
            </div>
            <div class="trust2">
                <i class="fa-solid fa-hand-holding-dollar" style="font-size: 40px; margin: 25px 0;"></i>
                <h3>Price guarantee</h3>
                <p style="text-align: center; padding: 0 15px;">Enjoy the best rates available. We ensure competitive pricing so you can travel without breaking the bank.</p>
            </div>
            <div class="trust3">
                <i class="fa-solid fa-trophy" style="font-size: 40px; margin: 25px 0;"></i>
                <h3>Handpicked Hotels</h3>
                <p style="text-align: center; padding: 0 15px;">We carefully select and review all our accommodations to guarantee comfort, quality, and an unforgettable stay.</p>
            </div>
        </div>
    </div>

    <div class="clint-say container">
        <h4>TESTIMONIAL</h4>
        <h2>What Our Clients Say</h2>
        <div class="nav-btn-card">
            
            <div class="suggestions">
                <!-- PHP لطباعة آراء العملاء -->
                <?php while($review = mysqli_fetch_assoc($reviews_result)): ?>
                    <div class="place-card" style="padding: 20px; text-align: center; display: block;">
                        <i class="fa-solid fa-quote-left" style="font-size: 35px; color: #ccc;"></i>
                        <p style="margin-top: 15px; font-size: 16px; color: #555;">"<?php echo htmlspecialchars($review['comment']); ?>"</p>
                        <h3 style="margin-top: 20px; color: #000; font-size: 20px;"><?php echo htmlspecialchars($review['user_name']); ?></h3>
                        <div style="color: #f39c12; margin-top: 5px;">
                            <?php for($i=1; $i<=5; $i++): ?>
                                <?php if($i <= $review['rating']): ?>
                                    <i class="fa-solid fa-star"></i>
                                <?php else: ?>
                                    <i class="fa-regular fa-star"></i>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            
        </div>
    </div>
</main>

<?php include("../includes/footer.php"); ?>