<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receptionist Dashboard</title>
    <link rel="stylesheet" href="Style.css">
</head>
<body>

<?php include 'HotelNavBar.php'; ?>
<center>

<?php
$DBHost = "localhost";
$DBUser = "root";
$DBPass = "1234";
$DBName = "hotel";

$conn = mysqli_connect($DBHost, $DBUser, $DBPass, $DBName);

if (!$conn) {
    die("Error connecting database: " . mysqli_error($conn));
}

if (isset($_POST['check_in'])) {
    $reservation_id = $_POST['reservation_id'];
    $check_in_time = $_POST['check_in_time'];
    
    $update_reservation = "UPDATE reservation SET reservation_status = 'CHECKED IN' WHERE reservation_id = '$reservation_id'";
    $insert_stay = "INSERT INTO stay (check_in, reservation_id) VALUES ('$check_in_time', '$reservation_id')";
    
    if (mysqli_query($conn, $update_reservation) && mysqli_query($conn, $insert_stay)) {
        echo "<p>Guest checked in successfully!</p>";
    } else {
        echo "<p>Error checking in: " . mysqli_error($conn) . "</p>";
    }
}

if (isset($_POST['check_out'])) {
    $reservation_id = $_POST['reservation_id'];
    $check_out_time = $_POST['check_out_time'];
    
    $update_reservation = "UPDATE reservation SET reservation_status = 'CHECKED OUT' WHERE reservation_id = '$reservation_id'";
    $update_stay = "UPDATE stay SET check_out = '$check_out_time' WHERE reservation_id = '$reservation_id' AND check_out IS NULL";
    
    if (mysqli_query($conn, $update_reservation) && mysqli_query($conn, $update_stay)) {
        echo "<p>Guest checked out successfully! Room set to maintenance.</p>";
    } else {
        echo "<p>Error checking out: " . mysqli_error($conn) . "</p>";
    }
}

$sql = "SELECT 
    r.room_id,
    r.room_number,
    r.vacancy_status,
    res.reservation_id,
    res.reservation_status,
    res.start_date,
    res.end_date,
    CONCAT(g.first_name, ' ', g.last_name) as guest_name,
    s.check_in,
    s.check_out,
    s.stay_id
FROM room r
LEFT JOIN reservation res ON r.room_id = res.room_id AND res.reservation_status IN ('CHECKED IN', 'CONFIRMED', 'PENDING')
LEFT JOIN guest g ON res.guest_id = g.guest_id
LEFT JOIN stay s ON res.reservation_id = s.reservation_id AND s.check_out IS NULL
ORDER BY r.room_number";

$result = mysqli_query($conn, $sql);
?>

<h2>Current Stays</h2>

<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>Room</th>
            <th>Guest Name</th>
            <th>Check In Time</th>
            <th>Expected Check Out</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>ROOM " . $row['room_number'] . "</td>";
                echo "<td>" . ($row['guest_name'] ? $row['guest_name'] : 'na') . "</td>";
                echo "<td>" . ($row['check_in'] ? date('g:iA', strtotime($row['check_in'])) : 'na') . "</td>";
                echo "<td>" . ($row['end_date'] ? date('g:i A', strtotime($row['end_date'])) : 'na') . "</td>";
                
                if ($row['reservation_status'] == 'CHECKED OUT') {
                    echo "<td>checked out</td>";
                } elseif ($row['vacancy_status'] == 'AVAILABLE') {
                    echo "<td>AVAILABLE</td>";
                } elseif ($row['vacancy_status'] == 'OCCUPIED') {
                    echo "<td>CHECKED IN</td>";
                } elseif ($row['vacancy_status'] == 'MAINTENANCE') {
                    echo "<td>MAINTENANCE</td>";
                } else {
                    echo "<td>" . $row['vacancy_status'] . "</td>";
                }
                
                echo "<td>";
                if ($row['reservation_status'] == 'CONFIRMED' || $row['reservation_status'] == 'PENDING') {
                    echo "<form method='POST' style='display:inline;'>
                        <input type='hidden' name='reservation_id' value='" . $row['reservation_id'] . "'>
                        <input type='hidden' name='check_in_time' value='" . date('Y-m-d H:i:s') . "'>
                        <input type='submit' name='check_in' value='Check In'>
                    </form>";
                } elseif ($row['reservation_status'] == 'CHECKED IN') {
                    echo "<form method='POST' style='display:inline;'>
                        <input type='hidden' name='reservation_id' value='" . $row['reservation_id'] . "'>
                        <input type='hidden' name='check_out_time' value='" . date('Y-m-d H:i:s') . "'>
                        <input type='submit' name='check_out' value='Check Out'>
                    </form>";
                } elseif ($row['reservation_status'] == 'CHECKED OUT') {
                    echo "<button>View</button>";
                } else {
                    echo "<button>View</button>";
                }
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No rooms found</td></tr>";
        }
        ?>
    </tbody>
</table>

<br>

<h2>Statistics</h2>

<?php
$stats_sql = "SELECT 
    SUM(CASE WHEN vacancy_status = 'OCCUPIED' THEN 1 ELSE 0 END) as checked_in,
    SUM(CASE WHEN vacancy_status = 'AVAILABLE' THEN 1 ELSE 0 END) as available,
    SUM(CASE WHEN vacancy_status = 'MAINTENANCE' THEN 1 ELSE 0 END) as maintenance
FROM room";

$stats_result = mysqli_query($conn, $stats_sql);
$stats = mysqli_fetch_assoc($stats_result);

$today_checkouts_sql = "SELECT COUNT(*) as today_checkouts 
FROM reservation 
WHERE DATE(end_date) = CURDATE() AND reservation_status = 'CHECKED IN'";
$today_checkouts_result = mysqli_query($conn, $today_checkouts_sql);
$today_checkouts = mysqli_fetch_assoc($today_checkouts_result);
?>

<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>Checked In</th>
        <th>Available Rooms</th>
        <th>Expected Checkouts Today</th>
        <th>Maintenance</th>
    </tr>
    <tr>
        <td><?php echo $stats['checked_in']; ?></td>
        <td><?php echo $stats['available']; ?></td>
        <td><?php echo $today_checkouts['today_checkouts']; ?></td>
        <td><?php echo $stats['maintenance']; ?></td>
    </tr>
</table>

<br>

<h2>Manual Check-In</h2>
<form method="POST">
    <label>Reservation ID:</label>
    <input type="number" name="reservation_id" required>
    <br><br>
    <label>Check-In Time:</label>
    <input type="datetime-local" name="check_in_time" required>
    <br><br>
    <input type="submit" name="check_in" value="Check In Guest"  class="btn insert">
</form>

<br>

<h2>Manual Check-Out</h2>
<form method="POST">
    <label>Reservation ID:</label>
    <input type="number" name="reservation_id" required>
    <br><br>
    <label>Check-Out Time:</label>
    <input type="datetime-local" name="check_out_time" required>
    <br><br>
    <input type="submit" name="check_out" value="Check Out Guest"  class="btn update">
</form>

</center>

</body>
</html>