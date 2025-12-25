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
        <h2> Reservation</h2>

        <label>Reservation ID:</label> 
        <input type="number" name="reservation_id"> <br> <br>

        <label>Guest ID:</label> 
        <input type="number" name="guest_id"> <br> <br>

        <label>Room ID:</label> 
        <input type="number" name="room_id"> <br> <br>

        <label>Start Date:</label> 
        <input type="datetime-local" name="start_date"> <br> <br>

        <label>End Date:</label> 
        <input type="datetime-local" name="end_date"> <br> <br>

        <label>Status:</label> 
        <select name="reservation_status">
            <option value="PENDING">PENDING</option>
            <option value="CONFIRMED">CONFIRMED</option>
            <option value="CHECKED IN">CHECKED IN</option>
            <option value="CHECKED OUT">CHECKED OUT</option>
            <option value="CANCELLED">CANCELLED</option>
        </select> <br> <br>
        
        <input type="submit" name="InsertSub" value="Add">
        <input type="submit" name="EditSub" value="Edit">
        <input type="submit" name="ViewSub" value="View">
        <input type="submit" name="SearchSub" value="Search">
        <input type="submit" name="DeleteSub" value="Delete">
        <input type="reset" name="ResetSub" value="Reset">
    </center>
</form>

<?php
$DBHost= "localhost";
$DBUser= "root";
$DBPass= "1234";
$DBName= "hotel";

$conn= mysqli_connect($DBHost, $DBUser, $DBPass, $DBName);

if (!$conn){
    die("Error connecting database.".mysqli_error($conn));
}

if (isset($_POST['InsertSub'])){
    if($_POST['guest_id']=='' || $_POST['room_id']=='' || $_POST['start_date']=='' || $_POST['end_date']==''){
        echo "<br><center>Fields are incomplete </center>";
    }
    else{
        $sql= "INSERT into reservation (guest_id, room_id, start_date, end_date, reservation_status) 
               VALUES ('$_POST[guest_id]', '$_POST[room_id]', '$_POST[start_date]', '$_POST[end_date]', '$_POST[reservation_status]')";
        $result= mysqli_query($conn, $sql);

        if($result){
            echo "<br><center>Reservation Added.</center>";
        }
    }
}

if(isset($_POST['ViewSub'])){
    echo "<br> <center>";
    $sql= "SELECT * FROM reservation";
    $result= mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
        echo "<table border='1'>
        <tr>
            <th>Res ID</th>
            <th>Guest ID</th>
            <th>Room ID</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
        </tr>";

        while($rows= mysqli_fetch_assoc($result)){
            echo "<tr>
                <td>".$rows['reservation_id']."</td>
                <td>".$rows['guest_id']."</td>
                <td>".$rows['room_id']."</td>
                <td>".$rows['start_date']."</td>
                <td>".$rows['end_date']."</td>
                <td>".$rows['reservation_status']."</td>
            </tr>";
        }
        echo "</table><br> Records Displayed";
    }
    echo "</center>";
}

if(isset($_POST['SearchSub'])){
    if(!preg_match("/^[ 0-9]+$/", $_POST['reservation_id'])){
        echo "<br><center>No alphabetical values allowed </center>";
    }
    else{
        echo "<center><br>";
        $sql= "SELECT * FROM reservation WHERE reservation_id= '$_POST[reservation_id]'";
        $result= mysqli_query($conn,$sql);

        if(mysqli_num_rows($result) > 0){
            echo "<table border='1'>
            <tr>
               <th>Res ID</th>
               <th>Guest ID</th>
               <th>Room ID</th>
               <th>Start</th>
               <th>End</th>
               <th>Status</th>
            </tr>";
            while($rows= mysqli_fetch_assoc($result)){
                echo "<tr>
                     <td>".$rows['reservation_id']."</td>
                     <td>".$rows['guest_id']."</td>
                     <td>".$rows['room_id']."</td>
                     <td>".$rows['start_date']."</td>
                     <td>".$rows['end_date']."</td>
                     <td>".$rows['reservation_status']."</td>
                </tr>";
            }
            echo "</table><br> Reservation Found.";
        }
        echo "</center>";
    }
}

if(isset($_POST['EditSub'])){
    if($_POST['reservation_id']==''){
        echo "<center>Incomplete Fields.</center>";
    }
    else{
        $sql= "UPDATE reservation SET 
               guest_id = '$_POST[guest_id]', 
               room_id = '$_POST[room_id]', 
               start_date = '$_POST[start_date]', 
               end_date = '$_POST[end_date]', 
               reservation_status = '$_POST[reservation_status]' 
               WHERE reservation_id = '$_POST[reservation_id]'";
        
        $result= mysqli_query($conn, $sql);
        if($result){
            echo"<br><center>Record Updated.</center>";
        }
    }
}

if (isset($_POST['DeleteSub'])){
     if($_POST['reservation_id']==''){
        echo "<center>Incomplete Fields.</center>";
    }
    else{
        $sql="DELETE FROM reservation WHERE reservation_id = '$_POST[reservation_id]'";
        $result= mysqli_query($conn, $sql);
        echo "<br><center>Record Deleted.</center>";
    }
}
?>
</body>
</html>