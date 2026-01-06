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
  
      <center>
        <h2> Room Type</h2>

         <label for="">Room Type ID:</label> 
         <input type="number" name="room_type_id" id="room_type_id"> <br> <br>

         <label for="">Room Type Name:</label> 
         <input type="text" name="room_type_name" id="room_type_name"> <br> <br>
       
         <label for="">Room Type Price:</label> 
         <input type="number" name="room_type_price" id="room_type_price"> <br> <br>
        
             <center>
        <div class="btn-group">
            <input type="submit" name="InsertSub" value="Add" class="btn insert">
            <input type="submit" name="EditSub" value="Edit" class="btn update">
            <input type="submit" name="ViewSub" value="View" class="btn view">
            <input type="submit" name="SearchSub" value="Search" class="btn search">
            <input type="submit" name="DeleteSub" value="Delete" class="btn delete">
            <input type="reset" name="ResetSub" value="Reset" class="btn reset">
        </div>
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
    if($_POST['room_type_id']=='' || $_POST['room_type_name']==''|| $_POST['room_type_price']==''){
        echo "<br><center>Fields are incomplete </center>";
    }
    else{
        $sql= "INSERT into room_type (room_type_id,room_type_name,room_type_price ) VALUES ('$_POST[room_type_id]', '$_POST[room_type_name]', '$_POST[room_type_price]')";
        $result= mysqli_query($conn, $sql);

        if($result){
            echo "<br><center>Room Added.</center>";
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
        </tr>";

    while($rows= mysqli_fetch_assoc($result)){
        echo "
        <tr>
            <td>".$rows['room_type_id']."</td>
            <td>".$rows['room_type_name']."</td>
            <td>".$rows['room_type_price']."</td>
        </tr>";
    }
        echo "</table>";
        echo "<br> Records Displayed";
    }
    echo "</center>";
}

if(isset($_POST['SearchSub'])){
    if(!preg_match("/^[ 0-9]+$/", $_POST['room_type_id'])){
        echo "<br><center>No alphabetical values allowed </center>";
    }
    else{
        echo "<center><br>";
        $sql= "SELECT room_type_id, room_type_name, room_type_price FROM room_type WHERE room_type_id= '$_POST[room_type_id]'";
        $result= mysqli_query($conn,$sql);

        if(mysqli_num_rows($result) > 0){
            echo "<table border='1'>";
            echo "
            <tr>
               <th>Room Type ID</th>
               <th>Room Type Name</th>
               <th>Room Type Price</th> 
            </tr>";

            while($rows= mysqli_fetch_assoc($result)){
                echo "
                <tr>
                     <td>".$rows['room_type_id']."</td>
                     <td>".$rows['room_type_name']."</td>
                     <td>".$rows['room_type_price']."</td>
                </tr>";
            }
            echo "</table>";
            echo "<br> Room Found.";
        }
        echo "</center>";
    }
}

if(isset($_POST['EditSub'])){
    if($_POST['room_type_id']=='' || $_POST['room_type_name']==''||$_POST['room_type_price']==''){
        echo "<center>Incomplete Fields.</center>";
    }
    else{
        $sql= "UPDATE room_type SET room_type_name = '$_POST[room_type_name]', room_type_price = '$_POST[room_type_price]' WHERE room_type_id = '$_POST[room_type_id]'";
        $result= mysqli_query($conn, $sql);

        if($result){
            echo"<br><center>Record Updated.</center>";
        }
    }
}

if (isset($_POST['DeleteSub'])){
     if($_POST['room_type_id']==''){
        echo "<center>Incomplete Fields.</center>";
    }
    else{
        $sql="DELETE FROM room_type WHERE room_type_id = '$_POST[room_type_id]'";
        $result= mysqli_query($conn, $sql);
        echo "<br><center>Record Deleted.</center>";
    }
}
?>
</body>
</html>