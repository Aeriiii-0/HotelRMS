<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation</title>
    <link rel="stylesheet" type="text/css" href="hotel-Style.css?v=2.0">
    <!-- Updated Pagination Version 2.0 - Clear Cache! -->
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
        
        //ATTENTION FIX THIS: NEEDS PAYMENT AND WILL BE UPDATED TO INCLUDE THE NAMES AND DETAILS OF THE GUEST
        //$call_procedure = "CALL sp_make_reservation_with_payment($guest_id, $room_id,'$contact_info', '$start_date', '$end_date',)";
        
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
        $call_procedure = "CALL sp_update_reservation_status($reservation_id,'CONFIRMED')";
        $proc_result = mysqli_query($conn, $call_procedure);
        
        if($proc_result){
            $proc_data = mysqli_fetch_assoc($proc_result);
            
            if (isset($proc_data['message'])) {
                $color = ($proc_data['status'] === 'SUCCESS') ? '#81C784' : '#E57373';
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
// UNIFIED VIEW & SEARCH LOGIC
// ============================================================================
if(isset($_REQUEST['ViewSub']) || isset($_REQUEST['SearchSub']) || isset($_GET['page'])){
    echo "<br> <center>";
    
    $search_id = isset($_REQUEST['reservation_id']) ? mysqli_real_escape_string($conn, $_REQUEST['reservation_id']) : '';
    $filter_status = isset($_REQUEST['filter_status']) ? mysqli_real_escape_string($conn, $_REQUEST['filter_status']) : '';
    
    $rows_per_page = 10;
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($current_page - 1) * $rows_per_page;

    $conditions = [];
    $title = "Showing: All reservations";

    if (!empty($search_id)) {
        $conditions[] = "r.reservation_id = '$search_id'";
        $title = "Showing: Search result for ID $search_id";
    }

    if (!empty($filter_status)) {
        $conditions[] = "r.reservation_status = '$filter_status'";
        if(empty($search_id)) $title = "Showing: $filter_status reservations";
    }

    $where_clause = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";

    $count_sql = "SELECT COUNT(*) as total FROM reservation r $where_clause";
    $count_result = mysqli_query($conn, $count_sql);
    $total_rows = mysqli_fetch_assoc($count_result)['total'];
    $total_pages = ceil($total_rows / $rows_per_page);

    $sql = "SELECT r.*, CONCAT(g.first_name, ' ', g.last_name) as guest_name, rm.room_number 
            FROM reservation r 
            LEFT JOIN guest g ON r.guest_id = g.guest_id 
            LEFT JOIN room rm ON r.room_id = rm.room_id 
            $where_clause 
            ORDER BY r.reservation_id DESC
            LIMIT $rows_per_page OFFSET $offset";
    
    echo "<h3>$title</h3>";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        echo "<table border='1'>
        <tr>
            <th>Res ID</th>
            <th>Date Created</th>
            <th>Guest Name</th>
            <th>Room #</th>
            <th>Contact</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
        </tr>";

        while($rows = mysqli_fetch_assoc($result)){
            echo "<tr class='clickable-row' 
                      data-resid='".$rows['reservation_id']."' 
                      data-datecreated='".$rows['date_created']."'
                      data-guestid='".$rows['guest_id']."' 
                      data-roomid='".$rows['room_id']."' 
                      data-contact='".$rows['contact_info']."' 
                      data-startdate='".$rows['start_date']."' 
                      data-enddate='".$rows['end_date']."' 
                      data-status='".$rows['reservation_status']."'>
                <td>".$rows['reservation_id']."</td>
                <td>".$rows['date_created']."</td>
                <td>".$rows['guest_name']."</td>
                <td>Room ".$rows['room_number']."</td>
                <td>".$rows['contact_info']."</td>
                <td>".$rows['start_date']."</td>
                <td>".$rows['end_date']."</td>
                <td>".$rows['reservation_status']."</td>
            </tr>";
        }
        echo "</table><br>";

        echo "<div class='pagination'>";
        echo "\n";
        
        // Previous arrow
        if ($current_page > 1) {
            echo "<a href='?page=".($current_page - 1)."&reservation_id=$search_id&filter_status=$filter_status' class='pagination-arrow'>←</a>\n";
        } else {
            echo "<span class='pagination-arrow disabled'>←</span>\n";
        }
        
        // Calculate which pages to show (3 buttons)
        $start_page = max(1, $current_page - 1);
        $end_page = min($total_pages, $start_page + 2);
        
        // Adjust if we're near the end
        if ($end_page - $start_page < 2) {
            $start_page = max(1, $end_page - 2);
        }
        
        // Show first page if not in range
        if ($start_page > 1) {
            echo "<a href='?page=1&reservation_id=$search_id&filter_status=$filter_status'>1</a>\n";
            if ($start_page > 2) {
                echo "<span class='pagination-ellipsis'>...</span>\n";
            }
        }
        
        // Show the 3 page buttons
        for($i = $start_page; $i <= $end_page; $i++){
            $active_class = ($i == $current_page) ? "active" : "";
            echo "<a href='?page=$i&reservation_id=$search_id&filter_status=$filter_status' class='$active_class'>$i</a>\n";
        }
        
        // Show last page if not in range
        if ($end_page < $total_pages) {
            if ($end_page < $total_pages - 1) {
                echo "<span class='pagination-ellipsis'>...</span>\n";
            }
            echo "<a href='?page=$total_pages&reservation_id=$search_id&filter_status=$filter_status'>$total_pages</a>\n";
        }
        
        // Next arrow
        if ($current_page < $total_pages) {
            echo "<a href='?page=".($current_page + 1)."&reservation_id=$search_id&filter_status=$filter_status' class='pagination-arrow'>→</a>\n";
        } else {
            echo "<span class='pagination-arrow disabled'>→</span>\n";
        }
        
        echo "</div><br>";
        echo "Total Records Found: $total_rows";
    } else {
        echo "<p style='color: #E57373;'>No records found matching your criteria.</p>";
    }
    echo "</center>";
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
    rt.room_type,
    res.reservation_id,
    res.reservation_status,
    res.start_date,
    res.end_date,
    CONCAT(g.first_name, ' ', g.last_name) as guest_name,
    res.check_in,
    res.check_out
FROM room r
LEFT JOIN room_type rt ON r.room_type_id = rt.room_type_id
LEFT JOIN reservation res ON r.room_id = res.room_id AND res.reservation_status IN ('CHECKED IN', 'CONFIRMED', 'PENDING')
LEFT JOIN guest g ON res.guest_id = g.guest_id
ORDER BY r.room_number";

$room_result = mysqli_query($conn, $room_sql);

// Statistics query
$stats_sql = "SELECT 
    -- 1. Guests currently in their rooms
    SUM(CASE WHEN r.reservation_status = 'CHECKED IN' THEN 1 ELSE 0 END) AS currently_checked_in,

    -- 2. Guests expected to arrive today
    SUM(CASE WHEN DATE(r.start_date) = CURDATE() AND r.reservation_status IN ('PENDING', 'CONFIRMED') THEN 1 ELSE 0 END) AS arrivals_today,

    -- 3. Guests expected to leave today
    SUM(CASE WHEN DATE(r.end_date) = CURDATE() AND r.reservation_status = 'CHECKED IN' THEN 1 ELSE 0 END) AS departures_today,

    -- 4. Total Rooms minus Busy Rooms = Available Rooms
    (SELECT COUNT(*) FROM room) - 
    COUNT(DISTINCT CASE WHEN r.reservation_status NOT IN ('CANCELLED', 'CHECKED OUT') 
          AND CURDATE() BETWEEN DATE(r.start_date) AND DATE(r.end_date) 
          THEN r.room_id END) AS rooms_available_now

FROM reservation r
WHERE CURDATE() BETWEEN DATE(r.start_date) AND DATE(r.end_date)
   OR DATE(r.start_date) = CURDATE()
   OR DATE(r.end_date) = CURDATE();";

$stats_result = mysqli_query($conn, $stats_sql);
$stats = mysqli_fetch_assoc($stats_result);

$today_checkouts_sql = "SELECT COUNT(*) as today_checkouts 
FROM reservation 
WHERE DATE(end_date) = CURDATE() AND reservation_status = 'CHECKED IN'";
$today_checkouts_result = mysqli_query($conn, $today_checkouts_sql);
$today_checkouts = mysqli_fetch_assoc($today_checkouts_result);

$pending_reservations ="SELECT 
	SUM(CASE WHEN reservation_status = 'PENDING' THEN 1 ELSE 0 END) AS 'PENDING',
    SUM(CASE WHEN reservation_status = 'UNPROCESSED' THEN 1 ELSE 0 END) AS 'UNPROCESSED',
    COUNT(*) AS 'Total'    
FROM reservation
WHERE MONTH(start_date) = MONTH(CURRENT_DATE()) AND
		YEAR(start_date) = YEAR(CURRENT_DATE());";
$pending_reservation_result = mysqli_query($conn,$pending_reservations); 
$pending_result = mysqli_fetch_assoc($pending_reservation_result);
?>

<div style="display: block; gap: 30px; max-width: 1400px; margin: 0 auto;">
    <div style="flex: 1;">
        <form action="" method="POST" id="reservationForm">
         
            <div class="filter-section">
                <label>Filter by Status:</label>
                <select name="filter_status" id="filter_status">
                    <option value="">All Statuses</option>
                    <option value="PENDING">PENDING</option>
                    <option value="CONFIRMED">CONFIRMED</option>
                    <option value="CHECKED IN">CHECKED IN</option>
                    <option value="CHECKED OUT">CHECKED OUT</option>
                    <option value="CANCELLED">CANCELLED</option>
                    <option value="CANCELLED">UNPROCESSED</option>
                </select>
                
                <label>Reservation ID:</label> 
                <input type="number" name="reservation_id" id="reservation_id"> <br> <br>

            </div>
            
            
            <div class="btn-group-centered" style="margin-top: 10px;">
                <input type="submit" name="ViewSub" value="View" class="btn view">
                <input type="submit" name="SearchSub" value="Search" class="btn search">
            </div>
            <br><br>
            <h2>Reservation Management</h2>


            <label>Guest First Name:</label> 
            <input type="text" name="first_name" id="first_name">
            
            <label>Guest Last Name:</label> 
            <input type="text" name="last_name" id="last_name">
            
            <label>Email:</label> 
            <input type="email" name="email" id="email">
            
            <label>Contact Info:</label> 
            <input type="text" name="contact_info" id="contact_info" placeholder="09xxxxxxxxx" maxlength="11">
            <br><br><br>

            <div class = "Room-type">
                <label>Room Type:</label> 
                <select>
                    <option value="">Select a Room Type</option>
                    <option value="Standard Single">Standard Single</option>    
                    <option value="Standard Double">Standard Double</option>    
                    <option value="Deluxe King">Deluxe King</option>
                    <option value="Junior Suite">Junior Suite</option>    
                    <option value="Executive Suite">Executive Suite</option>    
                    <option value="Presidential Suite">Presidential Suite</option>    
                </select>
            </div>
            
            <label>Start Date:</label> 
            <input type="date" name="start_date" id="start_date">

            <label>End Date:</label> 
            <input type="date" name="end_date" id="end_date"> 

            <br><br><br>

            <label>End Date:</label> 
            <div class = "Room-type">
                <label>Room Type:</label> 
                <select>
                    <option value="">Select a Room Type</option>
                    <option value="Standard Single">Standard Single</option>    
                    <option value="Standard Double">Standard Double</option>    
                    <option value="Deluxe King">Deluxe King</option>
                    <option value="Junior Suite">Junior Suite</option>    
                    <option value="Executive Suite">Executive Suite</option>    
                    <option value="Presidential Suite">Presidential Suite</option>    
                </select>
            </div>

            <center>
            <div class="btn-group">
                <input type="submit" name="InsertSub" value="Add" class="btn insert">
                <input type="submit" name="ConfirmSub" value="Confirm" class="btn update" style="background: #90CAF9;">
                <input type="submit" name="CancelSub" value="Cancel Res" class="btn delete" style="background: #EF9A9A;">
                <input type="reset" name="ResetSub" value="Reset" class="btn reset">
            
            </div>
            <br><br>
            </center>
        </form>
    </div>
    <div>
        <br>
        <h2>Pending Count</h2>
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>Pending</th>
                <th>Unprocessed</th>
                <th>Total this month</th>
            </tr>
            <tr>
                <td><?php echo $pending_result['PENDING']?></td>
                <td><?php echo $pending_result['UNPROCESSED']?></td>
                <td><?php echo $pending_result['Total']?></td>
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
            // const status = this.getAttribute('data-status');
            
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
            
            // document.getElementById('reservation_status').value = status;
            
            document.getElementById('reservationForm').scrollIntoView({ behavior: 'smooth' });
        });
    });
}
</script>

</body>
</html>