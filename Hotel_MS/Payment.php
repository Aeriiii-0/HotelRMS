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
    
    
        <h2> Payment</h2>

        <label>Payment ID:</label> 
        <input type="number" name="payment_id"> <br> <br>

        <label>Amount:</label> 
        <input type="number" step="0.01" name="amount"> <br> <br>

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
    if($_POST['amount']=='' || $_POST['reservation_id']==''){
        echo "<br><center>Fields are incomplete </center>";
    }
    else{
        $sql= "INSERT into payment (amount, reservation_id) VALUES ('$_POST[amount]', '$_POST[reservation_id]')";
        $result= mysqli_query($conn, $sql);

        if($result){
            echo "<br><center>Payment Added.</center>";
        }
    }
}

if(isset($_POST['ViewSub'])){
    echo "<br> <center>";
    $sql= "SELECT * FROM payment";
    $result= mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
        echo "<table border='1'>
        <tr>
            <th>Payment ID</th>
            <th>Amount</th>
            <th>Reservation ID</th>
        </tr>";

        while($rows= mysqli_fetch_assoc($result)){
            echo "<tr>
                <td>".$rows['payment_id']."</td>
                <td>".$rows['amount']."</td>
                <td>".$rows['reservation_id']."</td>
            </tr>";
        }
        echo "</table><br> Records Displayed";
    }
    echo "</center>";
}

if(isset($_POST['SearchSub'])){
    if(!preg_match("/^[ 0-9]+$/", $_POST['payment_id'])){
        echo "<br><center>No alphabetical values allowed </center>";
    }
    else{
        echo "<center><br>";
        $sql= "SELECT * FROM payment WHERE payment_id= '$_POST[payment_id]'";
        $result= mysqli_query($conn,$sql);

        if(mysqli_num_rows($result) > 0){
            echo "<table border='1'>
            <tr>
               <th>Payment ID</th>
               <th>Amount</th>
               <th>Reservation ID</th>
            </tr>";
            while($rows= mysqli_fetch_assoc($result)){
                echo "<tr>
                     <td>".$rows['payment_id']."</td>
                     <td>".$rows['amount']."</td>
                     <td>".$rows['reservation_id']."</td>
                </tr>";
            }
            echo "</table><br> Payment Found.";
        }
        echo "</center>";
    }
}

if(isset($_POST['EditSub'])){
    if($_POST['payment_id']=='' || $_POST['amount']=='' || $_POST['reservation_id']==''){
        echo "<center>Incomplete Fields.</center>";
    }
    else{
        $sql= "UPDATE payment SET amount = '$_POST[amount]', reservation_id = '$_POST[reservation_id]' WHERE payment_id = '$_POST[payment_id]'";
        $result= mysqli_query($conn, $sql);

        if($result){
            echo"<br><center>Record Updated.</center>";
        }
    }
}

if (isset($_POST['DeleteSub'])){
     if($_POST['payment_id']==''){
        echo "<center>Incomplete Fields.</center>";
    }
    else{
        $sql="DELETE FROM payment WHERE payment_id = '$_POST[payment_id]'";
        $result= mysqli_query($conn, $sql);
        echo "<br><center>Record Deleted.</center>";
    }
}
?>
</body>
</html>