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

         
         <input type="submit" name="ViewSub" value="View" class="btn view">
         <input type="submit" name="SearchSub" value="Search" class="btn search">
         <br> <br>

         <label for="">Room Type Name:</label> 
         <input type="text" name="room_type_name" id="room_type_name"> <br> <br>
       
         <label for="">Room Type Price:</label> 
         <input type="number" name="room_type_price" id="room_type_price"> <br> <br>

         <label for="">Maximum Capacity:</label> 
         <input type="number" name="max_capacity" id="max_capacity"> <br> <br>
        
             <center>
        <div class="btn-group">
            <input type="submit" name="InsertSub" value="Add" class="btn insert">
            <input type="submit" name="EditSub" value="Edit" class="btn update">
            <input type="submit" name="DeleteSub" value="Delete" class="btn delete">
            <input type="reset" name="ResetSub" value="Reset" class="btn reset">
        </div>
</form>

<?php
include("database.php");

$conn= mysqli_connect($DBHost, $DBUser, $DBPass, $DBName);

if (!$conn){
    die("Error connecting database.".mysqli_error($conn));
}

if (isset($_POST['InsertSub'])){
    if($_POST['room_type_name']==''|| $_POST['room_type_price']==''||$_POST['max_capacity'] ==''){
        echo "<br><center>Fields are incomplete </center>";
    }
    else if ($_POST['room_type_price']==1000||$_POST['max_capacity'] <= 1){
        echo "<br><center>Invalid Fields</center>";
    }
    else{   
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
    if(!preg_match("/^[ 0-9]+$/", $_POST['room_type_id'])){
        echo "<br><center>No alphabetical values allowed </center>";
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
            $sql= "UPDATE room_type SET room_type = '$_POST[room_type_name]', room_price = '$_POST[room_type_price]', guest_capacity = '$_POST[max_capacity]' WHERE room_type_id = '$_POST[room_type_id]'";
            $result= mysqli_query($conn, $sql);

            if($result){
                echo"<br><center>Record Updated.</center>";
            } else {
                echo"<br><center>Error Occur!</center>";
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
        $sql="DELETE FROM room_type WHERE room_type_id = '$_POST[room_type_id]'";
        $result= mysqli_query($conn, $sql);
        echo "<br><center>Record Deleted.</center>";
    }
}
?>
</body>
</html>