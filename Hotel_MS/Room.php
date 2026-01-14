<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pristine-Coast Whale Hotel</title>
    <link rel="stylesheet" href="hotel-Style.css">
</head>
<body>

<?php include 'HotelNavBar.php'; ?>

<form action="" method="POST">
    <h2> Room Information</h2>

    <label for="room_id">Room ID (for Edit/Delete/Search):</label> 
    <input type="number" name="room_id" id="room_id"> <br>

    <input type="submit" name="SearchSub" value="Search" class="btn search" style="margin-left: 94%; margin-top: 0.7%;">
    <br><br>

    <label for="room_number">Room Number:</label> 
    <input type="number" name="room_number" id="room_number"> <br> <br>

    <label for="room_type_id">Room Type ID:</label> 
    <input type="number" name="room_type_id" id="room_type_id"> <br> <br>

    <center>
        <div class="btn-group">
            <input type="submit" name="InsertSub" value="Add" class="btn insert">
            <input type="submit" name="EditSub" value="Edit" class="btn update">
            <input type="submit" name="DeleteSub" value="Delete" class="btn delete">
            <input type="submit" name="ViewSub" value="View" class="btn view">
            <input type="reset" name="ResetSub" value="Reset" class="btn reset">
        </div>
    </center>
</form>

<?php

include("database.php");
include("validation.php");


if (!$conn){
    die("Error connecting database.".mysqli_error($conn));
}

if (isset($_POST['InsertSub'])){
    if($_POST['room_number']=='' || $_POST['room_type_id']==''){
        echo "<br><center>Fields are incomplete </center>";
    }
    else {
        if (!is_valid_room($_POST['room_number'])){
           echo "<br><center>Invalid Value: Room Number. It should be within 100 - 999. </center>";
        } else {
            $room_num = mysqli_real_escape_string($conn, $_POST['room_number']);
            $type_id = mysqli_real_escape_string($conn, $_POST['room_type_id']);

            $sql= "INSERT INTO room (room_number, room_type_id) VALUES ('$room_num', '$type_id')";
            try {
                $result= mysqli_query($conn, $sql);
                if($result){
                    echo "<br><center>Room Added Successfully.</center>";
                } 
            } catch(mysqli_sql_exception $e){
                // TARGETING THE CONSTRAINT ERROR
                if ($e->getCode() == 1452) {
                    echo "<br><center>Error:The Room Type ID ($type_id) does not exist. Please check the Room Type table.</center>";
                } else {
                    echo "<br><center>Error: " . $e->getMessage()."</center>";
                }
            }
        }
    }
}

if(isset($_POST['ViewSub'])){
    echo "<br> <center>";
    $sql= "SELECT * FROM room";
    $result= mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
        echo "<table border='1'>
        <tr>
            <th>Room ID</th>
            <th>Room Number</th>
            <th>Room Type ID</th>
        </tr>";

        while($rows= mysqli_fetch_assoc($result)){
            echo "<tr>
                <td>".$rows['room_id']."</td>
                <td>".$rows['room_number']."</td>
                <td>".$rows['room_type_id']."</td>
            </tr>";
        }
        echo "</table><br> Records Displayed";
    }
    echo "</center>";
}

if(isset($_POST['SearchSub'])){

    if(empty($_POST['room_id'])){
        echo "<br><center>Please enter a Room ID to search</center>";
    } else {
        if ($_POST['room_id'] <= 0){
            die("<br><center>Invalid Value: Room ID should not be less than or equal to 0.</center>");
        }
        echo "<center><br>";
        $search_num = mysqli_real_escape_string($conn, $_POST['room_id']);
        $sql= "SELECT * FROM room WHERE room_id= '$search_num'";
        $result= mysqli_query($conn,$sql);

        if(mysqli_num_rows($result) > 0){
            echo "<table border='1'>
            <tr>
                <th>Room ID</th>
                <th>Room Number</th>
                <th>Room Type ID</th>
            </tr>";
            while($rows= mysqli_fetch_assoc($result)){
                echo "<tr>
                     <td>".$rows['room_id']."</td>
                     <td>".$rows['room_number']."</td>
                     <td>".$rows['room_type_id']."</td>
                </tr>";
            }
            echo "</table><br> Room Found.";
        } else {
            echo "No results found.";
        }
        echo "</center>";
    }
}

if(isset($_POST['EditSub'])){
    if($_POST['room_id']=='' || $_POST['room_number']==''|| $_POST['room_type_id'] == ''){
        echo "<br><center>Incomplete Fields for updating.</center>";
    } else {
        $id = mysqli_real_escape_string($conn, $_POST['room_id']);
        $num = mysqli_real_escape_string($conn, $_POST['room_number']);
        $tid = mysqli_real_escape_string($conn, $_POST['room_type_id']);

        try {
            $sql= "UPDATE room SET room_number = '$num', room_type_id = '$tid' WHERE room_id = '$id'";
            $result= mysqli_query($conn, $sql);
            $count = mysqli_affected_rows($conn);

            if($count > 0){
                echo "<br><center>Record Updated Successfully.</center>";
            } else {
                echo "<br><center>No changes were made or ID not found.</center>";
            }
        }
        catch (mysqli_sql_exception $e){
            // TARGETING THE CONSTRAINT ERROR HERE TOO
            if ($e->getCode() == 1452) {
                echo "<br><center>Error: Cannot update. Room Type ID ($tid) is invalid.</center>";
            } else {
                echo "<br><center>Error: " . $e->getMessage()."</center>";
            }
        }
    }
}

if (isset($_POST['DeleteSub'])){
     if($_POST['room_id']==''){
        echo "<center>Please enter Room ID to delete.</center>";
    } else {
         if ($_POST['room_id'] <= 0){
            die("<br><center>Invalid Value: Room ID should not be less than or equal to 0.</center>");
        }
        try{
            $id = mysqli_real_escape_string($conn, $_POST['room_id']);
            $sql="DELETE FROM room WHERE room_id = '$id'";
            $result= mysqli_query($conn, $sql);
            
            $count = mysqli_affected_rows($conn);

            if($count > 0){
                echo "<br><br><center>Record Deleted Successfully ($count row(s) changed).</center>";
            } elseif($count == 0) {
                echo "<br><br><center>No record with that ID</center>";
            } else {
                echo "<br><br><center>Error: Could not deleting record.</center>";
            }
        }catch(mysqli_sql_exception $e){
            die("<br><br><center>Error: Cannot DELETE room used in reservation records. Reassign or Remove the reservation(s) first</center>");
        }
    }
}
?>
</body>
</html>