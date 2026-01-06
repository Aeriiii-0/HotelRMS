<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pristine-Coast Whale Hotel</title>
    <link rel="stylesheet" href="Style.css">
</head>
<body>

<?php include 'HotelNavBar.php'; ?>

<form action="" method="POST">
    <h2> Room Information</h2>

    <label for="room_id">Room ID (for Edit/Delete):</label> 
    <input type="number" name="room_id" id="room_id"> <br> <br>

    <label for="room_number">Room Number:</label> 
    <input type="number" name="room_number" id="room_number"> <br> <br>

    <label for="room_type_id">Room Type ID:</label> 
    <input type="number" name="room_type_id" id="room_type_id"> <br> <br>
    
    <label for="vacancy_status">Vacancy Status: </label> 
    <select name="vacancy_status" id="vacancy_status">
        <option value="">Select a status</option>
        <option value="AVAILABLE">AVAILABLE</option>
        <option value="OCCUPIED">OCCUPIED</option>
        <option value="MAINTENANCE">MAINTENANCE</option>
    </select>

    <br> <br>
    <center>
        <div class="btn-group">
            <input type="submit" name="InsertSub" value="Add" class="btn insert">
            <input type="submit" name="EditSub" value="Edit" class="btn update">
            <input type="submit" name="ViewSub" value="View" class="btn view">
            <input type="submit" name="SearchSub" value="Search" class="btn search">
            <input type="submit" name="DeleteSub" value="Delete" class="btn delete">
            <input type="reset" name="ResetSub" value="Reset" class="btn reset">
        </div>
    </center>
</form>

<?php

include("database.php");


if (!$conn){
    die("Error connecting database.".mysqli_error($conn));
}

if (isset($_POST['InsertSub'])){
    if($_POST['vacancy_status']=='' || $_POST['room_number']=='' || $_POST['room_type_id']==''){
        echo "<br><center>Fields are incomplete </center>";
    } else {
        $room_num = mysqli_real_escape_string($conn, $_POST['room_number']);
        $status = mysqli_real_escape_string($conn, $_POST['vacancy_status']);
        $type_id = mysqli_real_escape_string($conn, $_POST['room_type_id']);

        $sql= "INSERT INTO room (room_number, vacancy_status, room_type_id) VALUES ('$room_num', '$status', '$type_id')";
        $result= mysqli_query($conn, $sql);

        if($result){
            echo "<br><center>Room Added.</center>";
        } else {
            echo "<br><center>Error: " . mysqli_error($conn) . "</center>";
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
            <th>Type ID</th>
            <th>Vacancy Status</th> 
        </tr>";

        while($rows= mysqli_fetch_assoc($result)){
            echo "<tr>
                <td>".$rows['room_id']."</td>
                <td>".$rows['room_number']."</td>
                <td>".$rows['room_type_id']."</td>
                <td>".$rows['vacancy_status']."</td>
            </tr>";
        }
        echo "</table><br> Records Displayed";
    }
    echo "</center>";
}


if(isset($_POST['SearchSub'])){
    if(empty($_POST['room_number'])){
        echo "<br><center>Please enter a Room Number to search</center>";
    } else {
        echo "<center><br>";
        $search_num = mysqli_real_escape_string($conn, $_POST['room_number']);
        $sql= "SELECT * FROM room WHERE room_number= '$search_num'";
        $result= mysqli_query($conn,$sql);

        if(mysqli_num_rows($result) > 0){
            echo "<table border='1'>
            <tr>
                <th>Room ID</th>
                <th>Room Number</th>
                <th>Type ID</th>
                <th>Vacancy Status</th> 
            </tr>";
            while($rows= mysqli_fetch_assoc($result)){
                echo "<tr>
                     <td>".$rows['room_id']."</td>
                     <td>".$rows['room_number']."</td>
                     <td>".$rows['room_type_id']."</td>
                     <td>".$rows['vacancy_status']."</td>
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
    if($_POST['room_id']=='' || $_POST['room_number']=='' || $_POST['vacancy_status'] =='' || $_POST['room_type_id'] == ''){
        echo "<center>Incomplete Fields for updating.</center>";
    } else {
        $id = mysqli_real_escape_string($conn, $_POST['room_id']);
        $num = mysqli_real_escape_string($conn, $_POST['room_number']);
        $stat = mysqli_real_escape_string($conn, $_POST['vacancy_status']);
        $tid = mysqli_real_escape_string($conn, $_POST['room_type_id']);

        $sql= "UPDATE room SET room_number = '$num', vacancy_status = '$stat', room_type_id = '$tid' WHERE room_id = '$id'";
        $result= mysqli_query($conn, $sql);

        if($result){
            echo"<br><center>Record Updated.</center>";
        }
    }
}


if (isset($_POST['DeleteSub'])){
     if($_POST['room_id']==''){
        echo "<center>Please enter Room ID to delete.</center>";
    } else {
        $id = mysqli_real_escape_string($conn, $_POST['room_id']);
        $sql="DELETE FROM room WHERE room_id = '$id'";
        $result= mysqli_query($conn, $sql);
        if($result) {
            echo "<br><center>Record Deleted.</center>";
        }
    }
}
?>
</body>
</html>