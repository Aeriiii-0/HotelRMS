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
  <br> <br> <br>

     
        <h2> Staff Information</h2>

         <label for="">Staff ID:</label> 
         <input type="text" name="staff_id" id="staff_id"> <br> <br>

         <label for="">First Name:</label> 
         <input type="text" name="first_name" id="first_name"> <br> <br>

         <label for="">Middle Name:</label> 
         <input type="text" name="middle_name" id="middle_name"> <br> <br>

         <label for="">Last Name:</label> 
         <input type="text" name="last_name" id="last_name"> <br> <br>
        
         <label for="role" name= "role" id="role">Role: </label> 
      
            <select name="role" id="role">
                <option value="">Select a role</option>
                <option value="House Keeping">House Keeping</option>
                <option value="Food and Beverages">Food and Beverage</option>
                <option value="Guest Service">Guest Service</option>
                <option value="Management">Management</option>
            </select>

            <label for="status" name= "status" id="status">Status: </label> 
      
            <select name="status" id="status">
                <option value="ACTIVE">Active</option>
                <option value="INACTIVE">Inactive</option>
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

//add nav bar sa taas babe
include("database.php");
if (!$conn){
    die("Error connecting database.".mysqli_error());
}

if (isset($_POST['InsertSub'])){

    //add pa validation of pregmatch (only characters)
    if($_POST['first_name']=='' || $_POST['last_name']=='' || $_POST['role']==''){
        echo "<br><center>Fields are incomplete </center>";
    }

    else{
        $sql= "INSERT into staff (first_name,last_name,role) VALUES ('$_POST[first_name]', '$_POST[last_name]', '$_POST[role]')";
        $result= mysqli_query($conn, $sql);

        if($result){
            echo "<br><center>Staff Added.</center>";
        }
    }

}


if(isset($_POST['ViewSub'])){

    echo "<br> <center>";

    $sql= "SELECT * FROM staff";
    $result= mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
        echo "  <table border= '1'>";
        echo "
        <tr>
            <th>Staff ID</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name </th>
            <th>Role</th> 
            <th>Status</th> 
        </tr>";

    while($rows= mysqli_fetch_assoc($result)){
        echo "
        <tr>
            <td>".$rows['staff_id']."</td>
            <td>".$rows['first_name']."</td>
            <td>".$rows['middle_name']." </td>
            <td>".$rows['last_name']." </td>
            <td>".$rows['role']."</td>
            <td>".$rows['status']."</td>
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
        $sql= "SELECT staff_id, first_name, last_name, role FROM staff WHERE first_name LIKE '%".$fname."%'";
        $result= mysqli_query($conn,$sql);

        if(mysqli_num_rows($result) > 0){
            echo "<table border='1'>";
            echo "
            <tr>
                <th>Staff ID</th>
                <th>First Name</th>
                <th>Last Name </th>
                <th>Role</th> 
            </tr>";

        while($rows= mysqli_fetch_assoc($result)){
            echo "
            <tr>
                <td>".$rows['staff_id']."</td>
                <td>".$rows['first_name']."</td>
                <td>".$rows['last_name']."</td>
                <td>".$rows['role']."</td>
            </tr>";
        }


            echo "</table>";
            echo "<br> Staff Found.";

        }
        echo "</center>";
    }

}

if(isset($_POST['EditSub'])){

    if($_POST['first_name']=='' || $_POST['last_name']==''||$_POST['role']==''){
        echo "<center>Incomplete Fields.</center>";
    }

    else{
        $sql= "UPDATE staff SET first_name = '$_POST[first_name]', last_name = '$_POST[last_name]'
        WHERE staff_id = '$_POST[staff_id]'";
        $result= mysqli_query($conn, $sql);

        if($result){
            echo"<br><center>Record Updated.</center>";

        }
    }

}

if (isset($_POST['DeleteSub'])){

     if($_POST['staff_id']==''){
        echo "<center>Incomplete Fields.</center>";
    }

    else{

        $sql="DELETE FROM staff WHERE staff_id = '$_POST[staff_id]'";
        $result= mysqli_query($conn, $sql);
            echo "<br><center>Record Deleted.</center>";
        
    }


}



?>
</body>
</html>