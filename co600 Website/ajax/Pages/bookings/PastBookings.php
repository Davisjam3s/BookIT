<?php 
$x = 1; 
$date = date("d-m-y");
$ptime = "11:00";
$dtime = "12:00";
echo "<p>Past Bookings</p>";
echo "<table><tr><th>Booking</th><th>Item</th><th>Pick up(date)</th><th>Pick up(time)</th><th>Drop off(time)</th><th>From</th><th>Returned Quality</th></tr>";
while($x <= 10) {
    
    echo "<tr><td>$x</td><td>Pi</td><td>$date</td><td>$ptime</td><td>$dtime</td><td>you</td><td>As Given</td></tr>";
    $x++;
} 
echo "</table>";
?>

