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
  
      
        <h2> Room Type</h2>

         <label for="">Room Type ID (for Edit/Delete/Search):</label> 
         <input type="number" name="room_type_id" id="room_type_id"> <br> 

         <input type="submit" name="SearchSub" value="Search" class="btn search" style="margin-left: 94%; margin-top: 0.7%;">
            
         <br> <br>
         
         <label for="">Room Type Name:</label> 
         <input type="text" name="room_type_name" id="room_type_name"> <br> <br>
       
         <label for="">Room Type Price:</label> 
         <input type="number" name="room_type_price" id="room_type_price"> <br> <br>

         <label for="">Maximum Guest Capacity:</label> 
         <input type="number" name="max_capacity" id="max_capacity"> <br> <br>
        
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

$conn= mysqli_connect($DBHost, $DBUser, $DBPass, $DBName);

if (!$conn){
    die("Error connecting database.".mysqli_error($conn));
}

if (isset($_POST['InsertSub'])){
    if($_POST['room_type_name']==''|| $_POST['room_type_price']==''||$_POST['max_capacity'] ==''){
        echo "<br><center>Fields are incomplete </center>";
    }
    else{
        if (!is_word($_POST['room_type_name'])){
            die("<br><br><center>Invalid Format: Room Type Name</center>");
        }
        if ($_POST['room_type_price']<=500){
            die("<br><br><center>Invalid Value: Room Type Price</center>");
        }
        if ($_POST['max_capacity'] <= 1){
            die("<br><br><center>Invalid Value: Room Guest Capacity</center>");
        }
        try {
            $sql= "INSERT into room_type (room_type,room_price,guest_capacity ) VALUES ('$_POST[room_type_name]', '$_POST[room_type_price]','$_POST[max_capacity]')";
            $result= mysqli_query($conn, $sql);

            if($result){
                echo "<br><center>Room Added.</center>";
            }
        } 
        catch(mysqli_sql_exception $e){

                die("<br><br><center>Error: " . $e->getMessage()."</center>");
        }
    }
}

if(isset($_POST['ViewSub'])){
    echo "<br> <center>";
    $sql= "SELECT * FROM room_type";
    $result= mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
        echo "  <table border= '1'>";
        echo "
        <tr>
            <th>Room Type ID</th>
            <th>Room Type Name</th>
            <th>Room Type Price</th>
            <th>Room Type Max Capacity </th> 
        </tr>";

    while($rows= mysqli_fetch_assoc($result)){
        echo "
        <tr>
            <td>".$rows['room_type_id']."</td>
            <td>".$rows['room_type']."</td>
            <td>".$rows['room_price']."</td>
            <td>".$rows['guest_capacity']."</td>
        </tr>";
    }
        echo "</table>";
        echo "<br> Records Displayed";
    }
    echo "</center>";
}

if(isset($_POST['SearchSub'])){
    if(!isset($_POST['root_type_id'])){
        die("<br><center>Enter Room Type ID. </center>");
    }
    else{
        echo "<center><br>";
        $sql= "SELECT * FROM room_type WHERE room_type_id= '$_POST[room_type_id]'";
        $result= mysqli_query($conn,$sql);

        if(mysqli_num_rows($result) > 0){
            echo "<table border='1'>";
            echo "
            <tr>
               <th>Room Type ID</th>
               <th>Room Type</th>
               <th>Room Price</th> 
               <th>Room Max Capacity </th> 
            </tr>";

            while($rows= mysqli_fetch_assoc($result)){
                echo "
                <tr>
                     <td>".$rows['room_type_id']."</td>
                     <td>".$rows['room_type']."</td>
                     <td>".$rows['room_price']."</td>
                     <td>".$rows['guest_capacity']."</td>
                </tr>";
            }
            echo "</table>";
            echo "<br> Room Found.";
        }
        echo "</center>";
    }
}

if(isset($_POST['EditSub'])){
    if($_POST['room_type_id']=='' || $_POST['room_type_name']==''|| $_POST['room_type_price']==''||$_POST['max_capacity'] ==''){
        echo "<center>Incomplete Fields.</center>";
    }
    else{
        try {

             if (!is_word($_POST['room_type_name'])){
                die("<br><br><center>Invalid Format: Room Type Name</center>");
            }
            if ($_POST['room_type_price']<=500){
                die("<br><br><center>Invalid Value: Room Type Price</center>");
            }
            if ($_POST['max_capacity'] <= 1){
                die("<br><br><center>Invalid Value: Room Guest Capacity</center>");
            }

            // It is safer to escape strings to prevent SQL errors
            $id = mysqli_real_escape_string($conn, $_POST['room_type_id']);
            $name = mysqli_real_escape_string($conn, $_POST['room_type_name']);
            $price = mysqli_real_escape_string($conn, $_POST['room_type_price']);
            $cap = mysqli_real_escape_string($conn, $_POST['max_capacity']);

            $sql= "UPDATE room_type SET 
                    room_type = '$name', 
                    room_price = '$price', 
                    guest_capacity = '$cap' 
                   WHERE room_type_id = '$id'";
            
            $result = mysqli_query($conn, $sql);

            $count = mysqli_affected_rows($conn);

            if($count > 0){
                echo "<br><br><center>Record Updated Successfully ($count row(s) changed).</center>";
            } elseif($count == 0) {
                echo "<br><br><center>No changes were made (Data is already identical) or no record with that ID</center>";
            } else {
                echo "<br><br><center>Error: Could not update record.</center>";
            }
        }
        catch(mysqli_sql_exception $e){
            die("<br><br><center>Error: " . $e->getMessage()."</center>");
        }
    }
}
if (isset($_POST['DeleteSub'])){
     if($_POST['room_type_id']==''){
        echo "<center>Incomplete Fields.</center>";
    }
    else{
        try{
             $sql="DELETE FROM room_type WHERE room_type_id = '$_POST[room_type_id]'";
            $result= mysqli_query($conn, $sql);   
            $count = mysqli_affected_rows($conn);

            if($count > 0){
                echo "<br><br><center>Record Deleted Successfully ($count row(s) deleted).</center>";
            } elseif($count == 0) {
                echo "<br><br><center>No Room Type With {$_POST['room_type_id']}.</center>";
            } else {
                echo "<br><br><center>Error: Could not delete record.</center>";
            }
        }catch(mysqli_sql_exception $e){
             die("<br><br><center>Error: Cannot Delete Room Type used in Room. Remove or Reassign the room(s) first</center>");
        }
    }
}
?>
</body>
</html>