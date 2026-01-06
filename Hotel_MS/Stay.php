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
 
    
        <h2> Stay</h2>

        <label>Stay ID:</label> 
        <input type="number" name="stay_id"> <br> <br>

        <label>Check In:</label> 
        <input type="datetime-local" name="check_in"> <br> <br>

        <label>Check Out:</label> 
        <input type="datetime-local" name="check_out"> <br> <br>

        <label>Reservation ID:</label> 
        <input type="number" name="reservation_id"> <br> <br>
        
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

$conn= mysqli_connect($DBHost, $DBUser, $DBPass, $DBName);

if (!$conn){
    die("Error connecting database.".mysqli_error($conn));
}

if (isset($_POST['InsertSub'])){
    if($_POST['check_in']=='' || $_POST['reservation_id']==''){
        echo "<br><center>Fields are incomplete </center>";
    }
    else{
        $check_out_val = ($_POST['check_out'] == '') ? "NULL" : "'$_POST[check_out]'";
        $sql= "INSERT into stay (check_in, check_out, reservation_id) VALUES ('$_POST[check_in]', $check_out_val, '$_POST[reservation_id]')";
        $result= mysqli_query($conn, $sql);

        if($result){
            echo "<br><center>Stay Record Added.</center>";
        }
    }
}

if(isset($_POST['ViewSub'])){
    echo "<br> <center>";
    $sql= "SELECT * FROM stay";
    $result= mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
        echo "<table border='1'>
        <tr>
            <th>Stay ID</th>
            <th>Check In</th>
            <th>Check Out</th>
            <th>Reservation ID</th>
        </tr>";

        while($rows= mysqli_fetch_assoc($result)){
            echo "<tr>
                <td>".$rows['stay_id']."</td>
                <td>".$rows['check_in']."</td>
                <td>".$rows['check_out']."</td>
                <td>".$rows['reservation_id']."</td>
            </tr>";
        }
        echo "</table><br> Records Displayed";
    }
    echo "</center>";
}

if(isset($_POST['SearchSub'])){
    if(!preg_match("/^[ 0-9]+$/", $_POST['stay_id'])){
        echo "<br><center>No alphabetical values allowed </center>";
    }
    else{
        echo "<center><br>";
        $sql= "SELECT * FROM stay WHERE stay_id= '$_POST[stay_id]'";
        $result= mysqli_query($conn,$sql);

        if(mysqli_num_rows($result) > 0){
            echo "<table border='1'>
            <tr>
               <th>Stay ID</th>
               <th>Check In</th>
               <th>Check Out</th>
               <th>Reservation ID</th>
            </tr>";
            while($rows= mysqli_fetch_assoc($result)){
                echo "<tr>
                     <td>".$rows['stay_id']."</td>
                     <td>".$rows['check_in']."</td>
                     <td>".$rows['check_out']."</td>
                     <td>".$rows['reservation_id']."</td>
                </tr>";
            }
            echo "</table><br> Stay Found.";
        }
        echo "</center>";
    }
}

if(isset($_POST['EditSub'])){
    if($_POST['stay_id']=='' || $_POST['check_in']=='' || $_POST['reservation_id']==''){
        echo "<center>Incomplete Fields.</center>";
    }
    else{
        $check_out_val = ($_POST['check_out'] == '') ? "NULL" : "'$_POST[check_out]'";
        $sql= "UPDATE stay SET check_in = '$_POST[check_in]', check_out = $check_out_val, reservation_id = '$_POST[reservation_id]' WHERE stay_id = '$_POST[stay_id]'";
        $result= mysqli_query($conn, $sql);

        if($result){
            echo"<br><center>Record Updated.</center>";
        }
    }
}

if (isset($_POST['DeleteSub'])){
     if($_POST['stay_id']==''){
        echo "<center>Incomplete Fields.</center>";
    }
    else{
        $sql="DELETE FROM stay WHERE stay_id = '$_POST[stay_id]'";
        $result= mysqli_query($conn, $sql);
        echo "<br><center>Record Deleted.</center>";
    }
}
?>
</body>
</html>