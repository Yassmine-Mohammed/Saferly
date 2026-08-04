<?php
require "../config/db.php";

$result = mysqli_query($con, "SHOW COLUMNS FROM reviews");

echo "<h2>Columns in 'reviews' table:</h2><ul>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<li><strong>" . $row['Field'] . "</strong> (" . $row['Type'] . ")</li>";
}
echo "</ul>";
?>