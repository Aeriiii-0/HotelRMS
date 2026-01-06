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

<div class="">
    <h2>Guest Information</h2>

    <form action="" method="POST">

        <label>Guest ID:</label> 
        <input type="number" name="guest_id" id="guest_id">

        <label>First Name:</label> 
        <input type="text" name="first_name" id="first_name">

        <label>Last Name:</label> 
        <input type="text" name="last_name" id="last_name">
       
        <label>Contact Information:</label> 
        <input type="number" name="contact_info" id="contact_info">
</div>

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

//add nav bar sa taas babe
include("database.php");
//look at the database.php file to change pass

$conn= mysqli_connect($DBHost, $DBUser, $DBPass, $DBName);

if (!$conn){
    die("Error connecting database.".mysqli_error());
}

if (isset($_POST['InsertSub'])){

    //add pa validation of pregmatch (only characters)
    if($_POST['first_name']=='' || $_POST['last_name']=='' || $_POST['contact_info']==''){
        echo "<br><center>Fields are incomplete </center>";
    }

    else{
        $sql= "INSERT into guest (first_name,last_name,contact_info) VALUES ('$_POST[first_name]', '$_POST[last_name]', '$_POST[contact_info]')";
        $result= mysqli_query($conn, $sql);

        if($result){
            echo "<br><center>Staff Added.</center>";
        }
    }

}


if(isset($_POST['ViewSub'])){

    echo "<br> <center>";

    $sql= "SELECT * FROM guest";
    $result= mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
        echo "  <table border= '1'>";
        echo "
        <tr>
            <th>Guest ID</th>
            <th>First Name</th>
            <th>Last Name </th>
            <th>Contact Information</th> 
        </tr>";

    while($rows= mysqli_fetch_assoc($result)){
        echo "
        <tr>
            <td>".$rows['guest_id']."</td>
            <td>".$rows['first_name']."</td>
            <td>".$rows['last_name']." </td>
            <td>".$rows['contact_info']."</td>
        </tr>";
    }
        
        echo "</table>";
        echo "<br> Records Displayed";
    }
    echo "</center>";
}


if(isset($_POST['SearchSub'])){
    if(!preg_match("/^[ a-z A-Z]+$/", $_POST['first_name'])){
        echo "<br><center>No numerical values allowed </center>";
    }

   /*  if(!preg_match("/^[ a-z a-Z]+$/", $_POST['last_name'])){
        echo "<br><center>No numerical values allowed </center>";
    }*/

    else{

        //add last name bro
        echo "<center><br>";
        $fname=mysqli_real_escape_string($conn, $_POST['first_name']);
        $sql= "SELECT guest_id, first_name, last_name, contact_info FROM guest WHERE first_name LIKE '%".$fname."%'";
        $result= mysqli_query($conn,$sql);

        if(mysqli_num_rows($result) > 0){
            echo "<table border='1'>";
            echo "
            <tr>
                <th>Guest ID</th>
                <th>First Name</th>
                <th>Last Name </th>
                <th>Contact Information</th> 
            </tr>";

        while($rows= mysqli_fetch_assoc($result)){
            echo "
            <tr>
                <td>".$rows['guest_id']."</td>
                <td>".$rows['first_name']."</td>
                <td>".$rows['last_name']." </td>
                <td>".$rows['contact_info']."</td>
            </tr>";
        }


            echo "</table>";
            echo "<br> Staff Found.";

        }
        echo "</center>";
    }

}

if(isset($_POST['EditSub'])){

    if($_POST['first_name']=='' || $_POST['last_name']==''||$_POST['contact_info']==''){
        echo "<center>Incomplete Fields.</center>";
    }

    else{
        $sql= "UPDATE guest SET first_name = '$_POST[first_name]', last_name = '$_POST[last_name]'
        WHERE guest_id = '$_POST[guest_id]'";
        $result= mysqli_query($conn, $sql);

        if($result){
            echo"<br><center>Record Updated.</center>";

        }
    }

}

if (isset($_POST['DeleteSub'])){

     if($_POST['guest_id']==''){
        echo "<center>Incomplete Fields.</center>";
    }

    else{

        $sql="DELETE FROM guest WHERE guest_id = '$_POST[guest_id]'";
        $result= mysqli_query($conn, $sql);
            echo "<br><center>Record Deleted.</center>";
        
    }


}



?>
</body>
</html>