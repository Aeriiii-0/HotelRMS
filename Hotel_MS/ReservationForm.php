<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pristine-Coast Whale Hotel</title>
</head>
<body>

<?php include 'HotelNavBar.php'; ?>
<form action="" method="POST">
    <br> <br> <br>
    <center>
        <h2> Book Your Stay</h2>

        <h3>Personal Information</h3>
        <label>First Name:</label> 
        <input type="text" name="first_name"> <br> <br>

        <label>Last Name:</label> 
        <input type="text" name="last_name"> <br> <br>

        <label>Contact Info:</label> 
        <input type="text" name="contact_info"> <br> <br>

        <hr width="30%">

        <h3>Reservation Details</h3>
        <label>Select Room Type:</label> 
        <select name="room_type_id">
            <?php
            $DBHost= "localhost";
            $DBUser= "root";
            $DBPass= "1234";
            $DBName= "hotel";
            $conn= mysqli_connect($DBHost, $DBUser, $DBPass, $DBName);
            
            $type_query = "SELECT * FROM room_type";
            $type_result = mysqli_query($conn, $type_query);
            while($t_row = mysqli_fetch_assoc($type_result)){
                echo "<option value='".$t_row['room_type_id']."'>".$t_row['room_type_name']." - $".$t_row['room_type_price']."</option>";
            }
            ?>
        </select> <br> <br>

        <label>Check-in Date:</label> 
        <input type="datetime-local" name="start_date"> <br> <br>

        <label>Check-out Date:</label> 
        <input type="datetime-local" name="end_date"> <br> <br>

        <label>Downpayment Amount:</label> 
        <input type="number" name="amount"> <br> <br>
        
        <input type="submit" name="SubmitBooking" value="Request Reservation">
        <input type="reset" value="Reset">
    </center>
</form>

<?php
if (isset($_POST['SubmitBooking'])){
    if($_POST['first_name']=='' || $_POST['last_name']=='' || $_POST['contact_info']=='' || $_POST['start_date']=='' || $_POST['end_date']=='' || $_POST['amount']==''){
        echo "<br><center>Please complete all fields.</center>";
    }
    else{
        $sql_find_room = "SELECT room_id FROM room WHERE room_type_id = '$_POST[room_type_id]' AND vacancy_status = 'AVAILABLE' LIMIT 1";
        $room_result = mysqli_query($conn, $sql_find_room);

        if(mysqli_num_rows($room_result) > 0){
            $room_data = mysqli_fetch_assoc($room_result);
            $assigned_room_id = $room_data['room_id'];

            $sql_guest = "INSERT INTO guest (first_name, last_name, contact_info) 
                          VALUES ('$_POST[first_name]', '$_POST[last_name]', '$_POST[contact_info]')";
            
            if(mysqli_query($conn, $sql_guest)){
                $new_guest_id = mysqli_insert_id($conn);

                $sql_res = "INSERT INTO reservation (guest_id, room_id, start_date, end_date, reservation_status) 
                            VALUES ('$new_guest_id', '$assigned_room_id', '$_POST[start_date]', '$_POST[end_date]', 'PENDING')";
                
                if(mysqli_query($conn, $sql_res)){
                    $new_res_id = mysqli_insert_id($conn);

                    $sql_pay = "INSERT INTO payment (amount, reservation_id) 
                                VALUES ('$_POST[amount]', '$new_res_id')";
                    mysqli_query($conn, $sql_pay);

                    echo "<br><center><h3>Reservation Requested!</h3>";
                    echo "Your Reservation ID is: " . $new_res_id . "<br>Status: PENDING ADMIN CONFIRMATION</center>";
                }
            }
        } else {
            echo "<br><center><b style='color:red;'>Sorry, no rooms of that type are currently available.</b></center>";
        }
    }
}
?>
</body>
</html>