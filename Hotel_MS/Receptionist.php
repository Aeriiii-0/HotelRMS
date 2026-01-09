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
include("database.php");
$conn = mysqli_connect($DBHost, $DBUser, $DBPass, $DBName);

if (!$conn) {
    die("Error connecting database: " . mysqli_error($conn));
}

// --- 1. HANDLE CHECK-IN ACTION ---
if (isset($_POST['check_in'])) {
    $reservation_id = mysqli_real_escape_string($conn, $_POST['reservation_id']);
    $update_reservation = "CALL check_in_reservation($reservation_id)";
    
    $res = mysqli_query($conn, $update_reservation);
    if ($res && $row = mysqli_fetch_assoc($res)) {
        echo "<p style='color:green;'><strong>Check-In:</strong> " . $row['message'] . "</p>";
    } else {
        echo "<p style='color:red;'>Error checking in: " . mysqli_error($conn) . "</p>";
    }
    // Clear buffer
    while(mysqli_more_results($conn)) { mysqli_next_result($conn); }
}

// --- 2. HANDLE CHECK-OUT ACTION ---
if (isset($_POST['check_out'])) {
    $reservation_id = mysqli_real_escape_string($conn, $_POST['reservation_id']);
    $update_reservation = "CALL check_out_reservation($reservation_id)";
    
    $res = mysqli_query($conn, $update_reservation);
    if ($res && $row = mysqli_fetch_assoc($res)) {
        echo "<p style='color:blue;'><strong>Check-Out:</strong> " . $row['message'] . "</p>";
    } else {
        echo "<p style='color:red;'>Error checking out: " . mysqli_error($conn) . "</p>";
    }
    // Clear buffer
    while(mysqli_more_results($conn)) { mysqli_next_result($conn); }
}

// --- 3. HANDLE MAINTENANCE/CLEANING ---
if (isset($_POST['Maintenance'])) {
    $roomID = mysqli_real_escape_string($conn, $_POST['roomID']);
    $maintenance_Procedure = "CALL make_room_status_available('$roomID')";

    if(mysqli_query($conn, $maintenance_Procedure)){
        echo "<p style='color:purple;'>Room cleaned and is now available!</p>";
    } else {
        echo "<p style='color:red;'> Error cleaning: " . mysqli_error($conn) . "</p>";
    }
    // Clear buffer
    while(mysqli_more_results($conn)) { mysqli_next_result($conn); }
}

// --- 4. MAIN QUERY: ONLY SHOW TODAY'S STATUS ---
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
    s.check_out
FROM room r
LEFT JOIN reservation res ON r.room_id = res.room_id 
    -- Only pull reservations active TODAY
    AND CURDATE() BETWEEN DATE(res.start_date) AND DATE(res.end_date)
    AND res.reservation_status IN ('CHECKED IN', 'CONFIRMED')
LEFT JOIN guest g ON res.guest_id = g.guest_id
LEFT JOIN stay s ON res.reservation_id = s.reservation_id AND s.check_out IS NULL
ORDER BY r.room_number";

$result = mysqli_query($conn, $sql);
?>

<h2>Current Room & Guest Status (Today)</h2>

<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>Room ID</th>
            <th>Room Number</th>
            <th>Guest Name</th>
            <th>Arrival</th>
            <th>Departure</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['room_id'] . "</td>";
                echo "<td>ROOM " . $row['room_number'] . "</td>";
                echo "<td>" . ($row['guest_name'] ? $row['guest_name'] : '<i style="color:gray;">Vacant</i>') . "</td>";
                echo "<td>" . ($row['start_date'] ? date('M d, g:iA', strtotime($row['start_date'])) : '--') . "</td>";
                echo "<td>" . ($row['end_date'] ? date('M d, g:iA', strtotime($row['end_date'])) : '--') . "</td>";
                
                // Display Status Labels
                echo "<td>";
                if ($row['reservation_status'] == 'CHECKED IN') {
                    echo "<b style='color:green;'>IN HOUSE</b>";
                } elseif ($row['reservation_status'] == 'CONFIRMED' || $row['reservation_status'] == 'PENDING') {
                    echo "<b style='color:orange;'>ARRIVING</b>";
                } elseif ($row['vacancy_status'] == 'MAINTENANCE') {
                    echo "<b style='color:red;'>CLEANING</b>";
                } else {
                    echo "<span style='color:gray;'>AVAILABLE</span>";
                }
                echo "</td>";
                
                // Action Buttons
                echo "<td>";
                if ($row['reservation_status'] == 'CONFIRMED' || $row['reservation_status'] == 'PENDING') {
                    echo "<form method='POST' style='display:inline;'>
                        <input type='hidden' name='reservation_id' value='" . $row['reservation_id'] . "'>
                        <input type='submit' name='check_in' value='Check In' class='btn insert'>
                    </form>";
                } elseif ($row['reservation_status'] == 'CHECKED IN') {
                    echo "<form method='POST' style='display:inline;'>
                        <input type='hidden' name='reservation_id' value='" . $row['reservation_id'] . "'>
                        <input type='submit' name='check_out' value='Check Out' class='btn update'>
                    </form>";
                } elseif ($row['vacancy_status'] == 'MAINTENANCE' || $row['reservation_status'] == 'CHECKED OUT') {
                    echo "<form method='POST' style='display:inline;'>
                        <input type='hidden' name='roomID' value='" . $row['room_id'] . "'>
                        <input type='submit' name='Maintenance' value='Mark Ready'>
                    </form>";
                } else {
                    echo "--";
                }
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No room data found</td></tr>";
        }
        ?>
    </tbody>
</table>

<br>
<hr>

<h2>Daily Overview Statistics</h2>
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
        <th>Currently Occupied</th>
        <th>Vacant & Ready</th>
        <th>Departing Today</th>
        <th>Under Maintenance</th>
    </tr>
    <tr>
        <td><?php echo $stats['checked_in']; ?></td>
        <td><?php echo $stats['available']; ?></td>
        <td><?php echo $today_checkouts['today_checkouts']; ?></td>
        <td><?php echo $stats['maintenance']; ?></td>
    </tr>
</table>

</center>
</body>
</html>