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
        <h2> Room Information</h2>

         <label for="">Room ID:</label> 
         <input type="number" name="room_id" id="room_id"> <br> <br>

         <label for="">Room Number:</label> 
         <input type="number" name="room_number" id="room_number"> <br> <br>
        
         <label for="vacancy_status" name= "vacancy_status" id="vacancy_status">Vacancy Status: </label> 
      
            <select name="vacancy_status" id="vacancy_status">
                <option value="">Select a status</option>
                <option value="Available">Available </option>
                <option value="Occupied">Occupied</option>
                <option value="Maintenance">Maintenance</option>
            </select>

         <label for="">Room ID:</label> 
         <input type="number" name="room_id" id="room_id"> <br> <br>

            <br> <br>
          
            <input type="submit" name="InsertSub" value="Add">
            <input type="submit" name="EditSub" value="Edit">
            <input type="submit" name="ViewSub" value="View">
            <input type="submit" name="SearchSub" value="Search">
            <input type="submit" name="DeleteSub" value="Delete">
            <input type="reset" name="ResetSub" value="Reset">
        </center>

</form>
      

<?php

//add nav bar sa taas babe
$DBHost= "localhost";
$DBUser= "root";
$DBPass= "1234";
$DBName= "hotel";

$conn= mysqli_connect($DBHost, $DBUser, $DBPass, $DBName);

if (!$conn){
    die("Error connecting database.".mysqli_error());
}

if (isset($_POST['InsertSub'])){

    //add pa validation of pregmatch (only characters)
    if($_POST['vacancy_status']=='' || $_POST['room_number']==''){
        echo "<br><center>Fields are incomplete </center>";
    }

    else{
        $sql= "INSERT into room (room_number,vacancy_status,room_type_id ) VALUES ('$_POST[room_number]', '$_POST[vacancy_status]', '$_POST[room_type_id]')";
        $result= mysqli_query($conn, $sql);

        if($result){
            echo "<br><center>Room Added.</center>";
        }
    }

}


if(isset($_POST['ViewSub'])){

    echo "<br> <center>";

    $sql= "SELECT * FROM room";
    $result= mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
        echo "  <table border= '1'>";
        echo "
        <tr>
            <th>Room ID</th>
            <th>Room Number</th>
            <th>Vacancy Status</th> 
        </tr>";

    while($rows= mysqli_fetch_assoc($result)){
        echo "
        <tr>
            <td>".$rows['room_id']."</td>
            <td>".$rows['room_number']."</td>
            <td>".$rows['vacancy_status']."</td>
        </tr>";
    }
        
        echo "</table>";
        echo "<br> Records Displayed";
    }
    echo "</center>";
}


if(isset($_POST['SearchSub'])){
    if(!preg_match("/^[ 0-9]+$/", $_POST['room_number'])){
        echo "<br><center>No alphabetical values allowed </center>";
    }

   /*  if(!preg_match("/^[ a-z a-Z]+$/", $_POST['last_name'])){
        echo "<br><center>No numerical values allowed </center>";
    }*/

    else{

        //add last name bro
        echo "<center><br>";
        $fname=mysqli_real_escape_string($conn, $_POST['room_number']);
        $sql= "SELECT room_id, room_number, vacancy_status  FROM room WHERE room_number= '$_POST[room_number]'";
        $result= mysqli_query($conn,$sql);

        if(mysqli_num_rows($result) > 0){
            echo "<table border='1'>";
            echo "
            <tr>
               <th>Room ID</th>
               <th>Room Number</th>
               <th>Vacancy Status</th> 
            </tr>";

        while($rows= mysqli_fetch_assoc($result)){
            echo "
            <tr>
                 <td>".$rows['room_id']."</td>
                 <td>".$rows['room_number']."</td>
                 <td>".$rows['vacancy_status']."</td>
            </tr>";
        }


            echo "</table>";
            echo "<br> Room Found.";

        }
        echo "</center>";
    }

}

if(isset($_POST['EditSub'])){

    if($_POST['room_id']=='' || $_POST['room_number']==''||$_POST['vacancy_status']==''){
        echo "<center>Incomplete Fields.</center>";
    }

    else{
        $sql= "UPDATE room SET room_number = '$_POST[room_number]', vacancy_status = '$_POST[vacancy_status]'
        WHERE room_id = '$_POST[room_id]'";
        $result= mysqli_query($conn, $sql);

        if($result){
            echo"<br><center>Record Updated.</center>";

        }
    }

}

if (isset($_POST['DeleteSub'])){

     if($_POST['room_id']==''){
        echo "<center>Incomplete Fields.</center>";
    }

    else{

        $sql="DELETE FROM room WHERE room_id = '$_POST[room_id]'";
        $result= mysqli_query($conn, $sql);
            echo "<br><center>Record Deleted.</center>";
        
    }


}



?>
</body>
</html>