<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation</title>
    <link rel="stylesheet" href="Style.css">
</head>
<body>

<?php include 'HotelNavBar.php'; ?>

<?php
include("database.php");

if (!$conn){
    die("Error connecting database.".mysqli_error($conn));
}

// ============================================================================
// ADD RESERVATION
// ============================================================================
if (isset($_POST['InsertSub'])){
    if($_POST['guest_id']=='' || $_POST['room_id']=='' || $_POST['start_date']=='' || $_POST['end_date']=='' || $_POST['contact_info']==''){
        echo "<br><center>Fields are incomplete</center>";
    }
    else{
        // FIXED: Escape inputs and add contact_info parameter
        $guest_id = mysqli_real_escape_string($conn, $_POST['guest_id']);
        $room_id = mysqli_real_escape_string($conn, $_POST['room_id']);
        $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
        $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
        $contact_info = mysqli_real_escape_string($conn, $_POST['contact_info']);
        
        $call_procedure = "CALL make_reservation($guest_id, $room_id, '$start_date', '$end_date', '$contact_info')";
        $proc_result = mysqli_query($conn, $call_procedure);
        
        if($proc_result){
            $proc_data = mysqli_fetch_assoc($proc_result);
            
            if (isset($proc_data['message'])) {
                echo "<br><center><span style='color: #E57373;'>".$proc_data['message']."</span></center>";
            } else if (isset($proc_data['reservation_id'])) {
                echo "<br><center><span style='color: #81C784;'>Reservation Added. Reservation ID: ".$proc_data['reservation_id']."</span></center>";
            }
            
            // Clear stored procedure results
            while(mysqli_more_results($conn)) {
                mysqli_next_result($conn);
            }
        }
    }
}

// ============================================================================
// CONFIRM RESERVATION
// ============================================================================
if(isset($_POST['ConfirmSub'])){
    if($_POST['reservation_id']==''){
        echo "<br><center>Please enter Reservation ID</center>";
    }
    else{
        $reservation_id = mysqli_real_escape_string($conn, $_POST['reservation_id']);
        $call_procedure = "CALL confirm_reservation($reservation_id)";
        $proc_result = mysqli_query($conn, $call_procedure);
        
        if($proc_result){
            $proc_data = mysqli_fetch_assoc($proc_result);
            
            if (isset($proc_data['message'])) {
                $color = (strpos($proc_data['message'], 'SUCCESS') !== false || strpos($proc_data['message'], 'CONFIRMED') !== false) ? '#81C784' : '#E57373';
                echo "<br><center><span style='color: $color;'>".$proc_data['message']."</span></center>";
            }
            
            while(mysqli_more_results($conn)) {
                mysqli_next_result($conn);
            }
        }
    }
}

// ============================================================================
// CHECK IN
// ============================================================================
if(isset($_POST['CheckInSub'])){
    if($_POST['reservation_id']==''){
        echo "<br><center>Please enter Reservation ID</center>";
    }
    else{
        $reservation_id = mysqli_real_escape_string($conn, $_POST['reservation_id']);
        $call_procedure = "CALL check_in_reservation($reservation_id)";
        $proc_result = mysqli_query($conn, $call_procedure);
        
        if($proc_result){
            $proc_data = mysqli_fetch_assoc($proc_result);
            
            if (isset($proc_data['message'])) {
                $color = (strpos($proc_data['message'], 'SUCCESS') !== false || strpos($proc_data['message'], 'CHECKED IN') !== false) ? '#81C784' : '#E57373';
                echo "<br><center><span style='color: $color;'>".$proc_data['message']."</span></center>";
            }
            
            while(mysqli_more_results($conn)) {
                mysqli_next_result($conn);
            }
            
            // REMOVED: Manual room update and stay creation - triggers handle this automatically!
        }
    }
}

// ============================================================================
// CHECK OUT
// ============================================================================
if(isset($_POST['CheckInSub'])){
    if($_POST['reservation_id'] != ''){
        $reservation_id = mysqli_real_escape_string($conn, $_POST['reservation_id']);
        $call_procedure = "CALL check_in_reservation($reservation_id)";
        $proc_result = mysqli_query($conn, $call_procedure);
        
        if($proc_result){
            // Success! 
            // Redirecting prevents "Double Submission" on Page Refresh
            header("Location: " . $_SERVER['PHP_SELF'] . "?status=checkedin");
            exit();
        }
    }
}

// ============================================================================
// VIEW RESERVATIONS
// ============================================================================
if(isset($_POST['ViewSub'])){
    echo "<br> <center>";
    
    $filter_status = '';
    if(!empty($_POST['filter_status'])){
        $filter_status = mysqli_real_escape_string($conn, $_POST['filter_status']);
        $sql= "SELECT r.*, CONCAT(g.first_name, ' ', g.last_name) as guest_name, rm.room_number 
               FROM reservation r 
               LEFT JOIN guest g ON r.guest_id = g.guest_id 
               LEFT JOIN room rm ON r.room_id = rm.room_id 
               WHERE r.reservation_status = '$filter_status' 
               ORDER BY r.reservation_id DESC";
        echo "<h3>Showing: $filter_status reservations</h3>";
    } else {
        $sql= "SELECT r.*, CONCAT(g.first_name, ' ', g.last_name) as guest_name, rm.room_number 
               FROM reservation r 
               LEFT JOIN guest g ON r.guest_id = g.guest_id 
               LEFT JOIN room rm ON r.room_id = rm.room_id 
               ORDER BY r.reservation_id DESC";
        echo "<h3>Showing: All reservations</h3>";
    }
    
    $result= mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
        echo "<table border='1'>
        <tr>
            <th>Res ID</th>
            <th>Guest Name</th>
            <th>Room #</th>
            <th>Contact</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
        </tr>";

        while($rows= mysqli_fetch_assoc($result)){
            echo "<tr class='clickable-row' 
                      data-resid='".$rows['reservation_id']."' 
                      data-guestid='".$rows['guest_id']."' 
                      data-roomid='".$rows['room_id']."' 
                      data-contact='".$rows['contact_info']."' 
                      data-startdate='".$rows['start_date']."' 
                      data-enddate='".$rows['end_date']."' 
                      data-status='".$rows['reservation_status']."'>
                <td>".$rows['reservation_id']."</td>
                <td>".$rows['guest_name']."</td>
                <td>Room ".$rows['room_number']."</td>
                <td>".$rows['contact_info']."</td>
                <td>".$rows['start_date']."</td>
                <td>".$rows['end_date']."</td>
                <td>".$rows['reservation_status']."</td>
            </tr>";
        }
        echo "</table><br> Records Displayed: " . mysqli_num_rows($result);
    } else {
        echo "<p>No reservations found.</p>";
    }
    echo "</center>";
}

// ============================================================================
// SEARCH RESERVATION
// ============================================================================
if(isset($_POST['SearchSub'])){
    if(!preg_match("/^[0-9]+$/", $_POST['reservation_id'])){
        echo "<br><center>Please enter a valid Reservation ID (numbers only)</center>";
    }
    else{
        echo "<center><br>";
        $reservation_id = mysqli_real_escape_string($conn, $_POST['reservation_id']);
        $sql= "SELECT r.*, CONCAT(g.first_name, ' ', g.last_name) as guest_name, rm.room_number 
               FROM reservation r 
               LEFT JOIN guest g ON r.guest_id = g.guest_id 
               LEFT JOIN room rm ON r.room_id = rm.room_id 
               WHERE r.reservation_id= '$reservation_id'";
        $result= mysqli_query($conn,$sql);

        if(mysqli_num_rows($result) > 0){
            echo "<table border='1'>
            <tr>
               <th>Res ID</th>
               <th>Guest Name</th>
               <th>Room #</th>
               <th>Contact</th>
               <th>Start</th>
               <th>End</th>
               <th>Status</th>
            </tr>";
            while($rows= mysqli_fetch_assoc($result)){
                echo "<tr class='clickable-row' 
                          data-resid='".$rows['reservation_id']."' 
                          data-guestid='".$rows['guest_id']."' 
                          data-roomid='".$rows['room_id']."' 
                          data-contact='".$rows['contact_info']."' 
                          data-startdate='".$rows['start_date']."' 
                          data-enddate='".$rows['end_date']."' 
                          data-status='".$rows['reservation_status']."'>
                     <td>".$rows['reservation_id']."</td>
                     <td>".$rows['guest_name']."</td>
                     <td>Room ".$rows['room_number']."</td>
                     <td>".$rows['contact_info']."</td>
                     <td>".$rows['start_date']."</td>
                     <td>".$rows['end_date']."</td>
                     <td>".$rows['reservation_status']."</td>
                </tr>";
            }
            echo "</table><br> Reservation Found.";
        } else {
            echo "<p style='color: #E57373;'>No reservation found with ID: $reservation_id</p>";
        }
        echo "</center>";
    }
}

// ============================================================================
// EDIT RESERVATION
// ============================================================================
if(isset($_POST['EditSub'])){
    if($_POST['reservation_id']=='' || $_POST['guest_id']=='' || $_POST['room_id']=='' || 
       $_POST['start_date']=='' || $_POST['end_date']=='' || $_POST['contact_info']==''){
        echo "<center>Incomplete Fields.</center>";
    }
    else{
        $reservation_id = mysqli_real_escape_string($conn, $_POST['reservation_id']);
        $guest_id = mysqli_real_escape_string($conn, $_POST['guest_id']);
        $room_id = mysqli_real_escape_string($conn, $_POST['room_id']);
        $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
        $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
        $contact_info = mysqli_real_escape_string($conn, $_POST['contact_info']);
        $status = mysqli_real_escape_string($conn, $_POST['reservation_status']);
        
        $sql= "UPDATE reservation SET 
               guest_id = '$guest_id', 
               room_id = '$room_id', 
               start_date = '$start_date', 
               end_date = '$end_date',
               contact_info = '$contact_info',
               reservation_status = '$status' 
               WHERE reservation_id = '$reservation_id'";
        
        $result= mysqli_query($conn, $sql);
        if($result){
            echo"<br><center><span style='color: #81C784;'>Record Updated.</span></center>";
        } else {
            echo"<br><center><span style='color: #E57373;'>Error updating record.</span></center>";
        }
    }
}

// ============================================================================
// DELETE RESERVATION
// ============================================================================
if (isset($_POST['DeleteSub'])){
    if($_POST['reservation_id']==''){
        echo "<center>Please enter Reservation ID</center>";
    }
    else{
        $reservation_id = mysqli_real_escape_string($conn, $_POST['reservation_id']);
        
        // First delete related stay records
        $delete_stay = "DELETE FROM stay WHERE reservation_id = '$reservation_id'";
        mysqli_query($conn, $delete_stay);
        
        // Then delete payment records
        $delete_payment = "DELETE FROM payment WHERE reservation_id = '$reservation_id'";
        mysqli_query($conn, $delete_payment);
        
        // Finally delete reservation
        $sql="DELETE FROM reservation WHERE reservation_id = '$reservation_id'";
        $result= mysqli_query($conn, $sql);
        
        if($result){
            echo "<br><center><span style='color: #81C784;'>Record Deleted.</span></center>";
        } else {
            echo "<br><center><span style='color: #E57373;'>Error deleting record.</span></center>";
        }
    }
}

// ============================================================================
// CANCEL RESERVATION
// ============================================================================
if(isset($_POST['CancelSub'])){
    if($_POST['reservation_id']==''){
        echo "<center>Please enter Reservation ID</center>";
    }
    else{
        $reservation_id = mysqli_real_escape_string($conn, $_POST['reservation_id']);
        
        // FIXED: Update triggers the room status change automatically
        $sql= "UPDATE reservation SET reservation_status = 'CANCELLED' 
               WHERE reservation_id = '$reservation_id'";
        
        $result= mysqli_query($conn, $sql);
        if($result){
            echo"<br><center><span style='color: #FFB74D;'>Reservation Cancelled.</span></center>";
        } else {
            echo"<br><center><span style='color: #E57373;'>Error cancelling reservation.</span></center>";
        }
    }
}
?>

<?php
// Room availability query
$room_sql = "SELECT 
    r.room_id,
    r.room_number,
    r.vacancy_status,
    rt.room_type_name,
    res.reservation_id,
    res.reservation_status,
    res.start_date,
    res.end_date,
    CONCAT(g.first_name, ' ', g.last_name) as guest_name,
    s.check_in,
    s.check_out
FROM room r
LEFT JOIN room_type rt ON r.room_type_id = rt.room_type_id
LEFT JOIN reservation res ON r.room_id = res.room_id AND res.reservation_status IN ('CHECKED IN', 'CONFIRMED', 'PENDING')
LEFT JOIN guest g ON res.guest_id = g.guest_id
LEFT JOIN stay s ON res.reservation_id = s.reservation_id AND s.check_out IS NULL
ORDER BY r.room_number";

$room_result = mysqli_query($conn, $room_sql);

// Statistics query
$stats_sql = "SELECT 
    SUM(CASE WHEN vacancy_status = 'OCCUPIED' THEN 1 ELSE 0 END) as checked_in,
    SUM(CASE WHEN vacancy_status = 'AVAILABLE' THEN 1 ELSE 0 END) as available,
    SUM(CASE WHEN vacancy_status = 'MAINTENANCE' THEN 1 ELSE 0 END) as maintenance,
    (SELECT COUNT(*) FROM reservation WHERE reservation_status = 'PENDING') as pending
FROM room";

$stats_result = mysqli_query($conn, $stats_sql);
$stats = mysqli_fetch_assoc($stats_result);

$today_checkouts_sql = "SELECT COUNT(*) as today_checkouts 
FROM reservation 
WHERE DATE(end_date) = CURDATE() AND reservation_status = 'CHECKED IN'";
$today_checkouts_result = mysqli_query($conn, $today_checkouts_sql);
$today_checkouts = mysqli_fetch_assoc($today_checkouts_result);
?>

<div style="display: flex; gap: 30px; max-width: 1400px; margin: 0 auto;">
    <div style="flex: 1;">
        <form action="" method="POST" id="reservationForm">
            
            <h2>Reservation Management</h2>

            <label>Reservation ID:</label> 
            <input type="number" name="reservation_id" id="reservation_id"> <br> <br>

            <label>Guest ID:</label> 
            <input type="number" name="guest_id" id="guest_id"> <br> <br>

            <label>Room ID:</label> 
            <input type="number" name="room_id" id="room_id"> <br> <br>

            <label>Contact Info:</label> 
            <input type="text" name="contact_info" id="contact_info" placeholder="09xxxxxxxxx" maxlength="11"> <br> <br>

            <label>Start Date:</label> 
            <input type="datetime-local" name="start_date" id="start_date"> <br> <br>

            <label>End Date:</label> 
            <input type="datetime-local" name="end_date" id="end_date"> <br> <br>

            <center>
            <label>Status:</label> 
            <select name="reservation_status" id="reservation_status">
                <option value="choose">Select Status</option>
                <option value="PENDING">PENDING</option>
                <option value="CONFIRMED">CONFIRMED</option>
                <option value="CHECKED IN">CHECKED IN</option>
                <option value="CHECKED OUT">CHECKED OUT</option>
                <option value="CANCELLED">CANCELLED</option>
            </select>
            <br><br>
            
            
            <div class="filter-section">
                <label>Filter by Status:</label>
                <select name="filter_status" id="filter_status">
                    <option value="">All Statuses</option>
                    <option value="PENDING">PENDING</option>
                    <option value="CONFIRMED">CONFIRMED</option>
                    <option value="CHECKED IN">CHECKED IN</option>
                    <option value="CHECKED OUT">CHECKED OUT</option>
                    <option value="CANCELLED">CANCELLED</option>
                </select>
            </div>
            
            <div class="btn-group">
                <input type="submit" name="InsertSub" value="Add" class="btn insert">
                <input type="submit" name="ConfirmSub" value="Confirm" class="btn update" style="background: #90CAF9;">
                <input type="submit" name="CheckInSub" value="Check In" class="btn update" style="background: #A5D6A7;">
                <input type="submit" name="CheckOutSub" value="Check Out" class="btn update" style="background: #FFCC80;">
            </div>
            <div class="btn-group" style="margin-top: 10px;">
                <input type="submit" name="EditSub" value="Edit" class="btn update">
                <input type="submit" name="ViewSub" value="View" class="btn view">
                <input type="submit" name="SearchSub" value="Search" class="btn search">
                <input type="submit" name="CancelSub" value="Cancel Res" class="btn delete" style="background: #EF9A9A;">
                <input type="reset" name="ResetSub" value="Reset" class="btn reset">
            </div>
            </center>
        </form>
    </div>

    <div style="flex: 1;">
        <h2>Room Availability</h2>
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%;">
            <thead>
                <tr>
                    <th>Room</th>
                    <th>Type</th>
                    <th>Guest Name</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($room_result) > 0) {
                    while ($row = mysqli_fetch_assoc($room_result)) {
                        echo "<tr>";
                        echo "<td>ROOM " . $row['room_number'] . "</td>";
                        echo "<td>" . $row['room_type_name'] . "</td>";
                        echo "<td>" . ($row['guest_name'] ? $row['guest_name'] : 'N/A') . "</td>";
                        echo "<td>" . ($row['start_date'] ? date('M d, g:iA', strtotime($row['start_date'])) : 'N/A') . "</td>";
                        echo "<td>" . ($row['end_date'] ? date('M d, g:iA', strtotime($row['end_date'])) : 'N/A') . "</td>";
                        
                        if ($row['reservation_status'] == 'PENDING') {
                            echo "<td style='color: #FFB74D; font-weight: bold;'>PENDING</td>";
                        } elseif ($row['reservation_status'] == 'CONFIRMED') {
                            echo "<td style='color: #64B5F6; font-weight: bold;'>CONFIRMED</td>";
                        } elseif ($row['vacancy_status'] == 'OCCUPIED') {
                            echo "<td style='color: #81C784; font-weight: bold;'>CHECKED IN</td>";
                        } elseif ($row['vacancy_status'] == 'AVAILABLE') {
                            echo "<td><strong style='color: #81C784;'>AVAILABLE</strong></td>";
                        } elseif ($row['vacancy_status'] == 'MAINTENANCE') {
                            echo "<td style='color: #FFB74D;'>MAINTENANCE</td>";
                        } else {
                            echo "<td>" . $row['vacancy_status'] . "</td>";
                        }
                        
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No rooms found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <br>

        <h2>Dashboard Statistics</h2>
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%;">
            <tr>
                <th>Pending Approval</th>
                <th>Checked In</th>
                <th>Available Rooms</th>
                <th>Expected Today</th>
            </tr>
            <tr>
                <td style="background: #FFF9C4; font-weight: bold;"><?php echo $stats['pending']; ?></td>
                <td style="background: #C8E6C9; font-weight: bold;"><?php echo $stats['checked_in']; ?></td>
                <td style="background: #B3E5FC; font-weight: bold;"><?php echo $stats['available']; ?></td>
                <td style="background: #FFCCBC; font-weight: bold;"><?php echo $today_checkouts['today_checkouts']; ?></td>
            </tr>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    addRowClickListeners();
});

function addRowClickListeners() {
    const rows = document.querySelectorAll('.clickable-row');
    
    rows.forEach(row => {
        row.addEventListener('dblclick', function() {
            const resId = this.getAttribute('data-resid');
            const guestId = this.getAttribute('data-guestid');
            const roomId = this.getAttribute('data-roomid');
            const contact = this.getAttribute('data-contact');
            const startDate = this.getAttribute('data-startdate');
            const endDate = this.getAttribute('data-enddate');
            const status = this.getAttribute('data-status');
            
            document.getElementById('reservation_id').value = resId;
            document.getElementById('guest_id').value = guestId;
            document.getElementById('room_id').value = roomId;
            document.getElementById('contact_info').value = contact;
            
            if(startDate) {
                document.getElementById('start_date').value = startDate.replace(' ', 'T').substring(0, 16);
            }
            if(endDate) {
                document.getElementById('end_date').value = endDate.replace(' ', 'T').substring(0, 16);
            }
            
            document.getElementById('reservation_status').value = status;
            
            document.getElementById('reservationForm').scrollIntoView({ behavior: 'smooth' });
        });
    });
}
</script>

</body>
</html>