<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pristine-Coast Whale Hotel - Guest Info</title>
    <link rel="stylesheet" href="Style.css">
</head>
<body>

<?php include 'HotelNavBar.php'; ?>

<div class>
    <center><h2>Guest Information</h2></center>

    <form action="" method="POST">
        <center>
            <label>Guest ID:</label> 
            <input type="number" name="guest_id" id="guest_id"> <br><br>
            <input type="submit" name="ViewSub" value="View" class="btn view">
            <input type="submit" name="SearchSub" value="Search" class="btn search">
            <br><br>

            <label>First Name:</label> 
            <input type="text" name="first_name" id="first_name"> <br><br>

            <label>Last Name:</label> 
            <input type="text" name="last_name" id="last_name"> <br><br>
            
            <label>Email Address:</label> 
            <input type="text" name="email" id="email"> <br><br>

            <div class="btn-group">
                <input type="submit" name="InsertSub" value="Add" class="btn insert">
                <input type="submit" name="EditSub" value="Edit" class="btn update">
                <input type="submit" name="DeleteSub" value="Delete" class="btn delete">
                <input type="reset" name="ResetSub" value="Reset" class="btn reset">
            </div>
        </center>
    </form>
</div>

<?php
include("database.php");

if (!$conn){
    die("<center>Error connecting database: " . mysqli_connect_error() . "</center>");
}

if (isset($_POST['InsertSub'])){
    if(empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['email'])){
        die ("<br><center>Fields are incomplete</center>" );
    } else {
        $fname = mysqli_real_escape_string($conn, $_POST['first_name']);
        $lname = mysqli_real_escape_string($conn, $_POST['last_name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);

        try {
            $sql = "INSERT INTO guest (first_name, last_name, email) VALUES ('$fname', '$lname', '$email')";
            $result = mysqli_query($conn, $sql);
            if($result) {
                echo "<br><br><center>Guest Added Successfully.</center>";
            }
        } catch(mysqli_sql_exception $e) {
            echo "<br><br><center>Error: This email is already taken!</center>";
        }
    }
}

if(isset($_POST['ViewSub'])){
    echo "<br><center>";
    $sql = "SELECT * FROM guest";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        echo "<table border='1'>
        <tr>
            <th>Guest ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email Address</th> 
        </tr>";
        while($rows = mysqli_fetch_assoc($result)){
            echo "<tr>
                <td>".$rows['guest_id']."</td>
                <td>".$rows['first_name']."</td>
                <td>".$rows['last_name']."</td>
                <td>".$rows['email']."</td>
            </tr>";
        }
        echo "</table><br>Records Displayed";
    } else {
        die ("No records found.");
    }
    echo "</center>";
}

if(isset($_POST['SearchSub'])){
    $fname = mysqli_real_escape_string($conn, $_POST['first_name'] ?? '');
    $lname = mysqli_real_escape_string($conn, $_POST['last_name'] ?? '');
    $gid   = mysqli_real_escape_string($conn, $_POST['guest_id'] ?? '');

    if(empty($fname) && empty($lname) && empty($gid)){
        echo "<br><center>Please enter an ID or Name to search</center>";
    } else {
        echo "<center><br>";
        
        $sql = "SELECT * FROM guest WHERE 1=0 "; 

        if(!empty($fname)) { $sql .= " OR first_name LIKE '%$fname%'"; }
        if(!empty($lname)) { $sql .= " OR last_name LIKE '%$lname%'"; }
        if(!empty($gid))   { $sql .= " OR guest_id = '$gid'"; }

        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0){
            echo "<table border='1'>
            <tr>
                <th>Guest ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email Address</th> 
            </tr>";
            while($rows = mysqli_fetch_assoc($result)){
                echo "<tr>
                    <td>".$rows['guest_id']."</td>
                    <td>".$rows['first_name']."</td>
                    <td>".$rows['last_name']."</td>
                    <td>".$rows['email']."</td>
                </tr>";
            }
            echo "</table><br>Guest(s) Found.";
        } else {
            echo "No results found.";
        }
        echo "</center>";
    }
}

if(isset($_POST['EditSub'])){
    if(empty($_POST['guest_id']) || empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['email'])){
        echo "<center>Incomplete Fields for Update.</center>";
    } else {
        $id = mysqli_real_escape_string($conn, $_POST['guest_id']);
        $fname = mysqli_real_escape_string($conn, $_POST['first_name']);
        $lname = mysqli_real_escape_string($conn, $_POST['last_name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        try {
            $sql = "UPDATE guest SET first_name = '$fname', last_name = '$lname', email = '$email' WHERE guest_id = '$id'";
            mysqli_query($conn, $sql);
            
            $count = mysqli_affected_rows($conn);
            if($count > 0){
                echo "<br><center>Record Updated Successfully.</center>";
            } else {
                echo "<br><center>No changes made or Guest ID not found.</center>";
            }
        }catch(mysqli_sql_exception $e){
                die("<br><br><center>Error: " . $e->getMessage()."</center>");
        }
        
    }
}

if (isset($_POST['DeleteSub'])){
    if(empty($_POST['guest_id'])){
        echo "<center>Please provide Guest ID to delete.</center>";
    } else {
        try{
            $id = mysqli_real_escape_string($conn, $_POST['guest_id']);
            $sql = "DELETE FROM guest WHERE guest_id = '$id'";
            mysqli_query($conn, $sql);
            
            if(mysqli_affected_rows($conn) > 0){
                echo "<br><br><center>Record Deleted Successfully.</center>";
            } else {
                echo "<br><br><center>No Guest found with ID: $id</center>";
            }
        }
        catch(mysqli_sql_exception $e){
            die("<br><br><center>Error: Cannot DELETE guest used in Reservation. Delete their reservation record(s) first</center>");
        }
    }
}
?>
</body>
</html>