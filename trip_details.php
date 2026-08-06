<?php

// Connect to Database

require "config/db.php";
$id = $_GET['id'];

$sql = "SELECT * FROM trips WHERE trip_id = $id";
$result = mysqli_query($con, $sql);

if(mysqli_num_rows($result) > 0){

    $trip = mysqli_fetch_assoc($result);

}else{

    die("Trip Not Found");

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Trip Details</title>

    <!-- CSS File -->
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<div class="details-container">

    <div class="trip-image">
    <img src="assets/images/<?php echo $trip['image']; ?>" alt="">
    <div class="overlay"></div>
</div>

    <div class="trip-info">
        <h1><?php echo $trip['trip_name']; ?></h1>

        <h3>Destination:</h3>
        <p><?php echo $trip['destination']; ?></p>

        <h3>Description:</h3>
        <p><?php echo $trip['description']; ?></p>

        <h3>Category:</h3>
        <p><?php echo $trip['category']; ?></p>

        <h3>Price:</h3>
        <p><?php echo $trip['price']; ?> EGP</p>

        <h3>Duration:</h3>
        <p><?php echo $trip['duration_days']; ?> Days</p>

        <h3>Hotel Level:</h3>
        <p><?php echo $trip['hotel_level']; ?> Stars</p>

        <h3>Start Date:</h3>
        <p><?php echo $trip['start_date']; ?></p>

        <h3>Status:</h3>
        <p><?php echo $trip['status']; ?></p>

       <a href="booking/booking.php?trip_id=<?php echo $trip['trip_id']; ?>">
    <button type="button" class="book-btn">Book Now</button>
</a>
    </div>

       <div class="trip-buttons" style="margin-top: 20px;">
        

           <!-- 2. زرار المراجعات -->
           <a href="booking/reviews.php?trip_id=<?php echo $trip['trip_id']; ?>">
               <button type="button" class="book-btn" style="width: 100%; background-color: #ff9900; color: #000; margin-bottom: 10px;">View & Add Reviews</button>
           </a>

           <!-- 3. زرار المفضلة -->
        
        <a href="booking/favourites.php?trip_id=<?php echo $trip['trip_id']; ?>">
        <button type="button" class="book-btn" style="width: 100%; background-color: #ff9900; color: #000;">Add to Favorites ❤️</button>
    </a>
</div>
</div>

</body>
</html>