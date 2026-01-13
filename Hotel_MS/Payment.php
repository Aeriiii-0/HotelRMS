<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pristine-Coast Whale Hotel - Payments</title>
    <link rel="stylesheet" href="hotel-Style.css">
</head>
<body>
    
<?php include 'HotelNavBar.php'; ?>
<form action="" method="POST">
        <h2> Payment</h2>

        <label>Payment ID (for Edit/Delete/Search):</label> 
        <input type="number" name="payment_id"> <br>
        <input type="submit" name="SearchSub" value="Search" class="btn search" style="margin-left: 94%; margin-top: 0.7%;">
        <br><br>

        <label>Amount:</label> 
        <input type="number" step="0.01" name="amount"> <br> <br>

        <label>Reservation ID:</label> 
        <input type="number" name="reservation_id"> <br> <br>

        <label>Payment Method:</label> 
        <select name="payment_method" id="payment_method">
            <option value="choose">Choose a Payment Method</option>
            <option value="CARD">Card</option>
            <option value="GCASH">Gcash</option>
        </select> 
        
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
$conn = mysqli_connect($DBHost, $DBUser, $DBPass, $DBName);

if (!$conn){
    die("Error connecting database: " . mysqli_connect_error());
}

// INSERT
if (isset($_POST['InsertSub'])){
    if($_POST['amount']=='' || $_POST['reservation_id']=='' || $_POST['payment_method']=='choose' ){
        echo "<br><center>Fields are incomplete </center>";
    }
    else{
        try {
            $sql = "INSERT INTO payment (amount, reservation_id, payment_method) 
                    VALUES ('$_POST[amount]', '$_POST[reservation_id]', '$_POST[payment_method]')";
            $result = mysqli_query($conn, $sql);
            if($result){
                echo "<br><center>Payment Added Successfully.</center>";
            }
        } catch(mysqli_sql_exception $e) {
            die( "<br><br><center>Error: ".$e->getMessage()."</center>");
        }
    }
}

// VIEW
if(isset($_POST['ViewSub'])){
    echo "<br> <center>";
    $sql = "SELECT * FROM payment ORDER BY date_created DESC";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        echo "<table border='1'>
        <tr>
            <th>Payment ID</th>
            <th>Amount</th>
            <th>Reservation ID</th>
            <th>Payment Method</th>
            <th>Date Created</th>
        </tr>";

        while($rows = mysqli_fetch_assoc($result)){
            echo "<tr>
                <td>".$rows['payment_id']."</td>
                <td>".$rows['amount']."</td>
                <td>".$rows['reservation_id']."</td>
                <td>".$rows['payment_method']."</td>
                <td>".$rows['date_created']."</td>
            </tr>";
        }
        echo "</table><br> Records Displayed";
    } else {
        echo "No payments found.";
    }
    echo "</center>";
}

// SEARCH
if(isset($_POST['SearchSub'])){
    if($_POST['payment_id'] == ''){
        echo "<br><center>Please provide a Payment ID to search.</center>";
    }
    else{
        echo "<center><br>";
        $sql = "SELECT * FROM payment WHERE payment_id = '$_POST[payment_id]' ORDER BY date_created DESC";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0){
            echo "<table border='1'>
            <tr>
               <th>Payment ID</th>
               <th>Amount</th>
               <th>Reservation ID</th>
               <th>Payment Method</th>
            </tr>";
            while($rows = mysqli_fetch_assoc($result)){
                echo "<tr>
                     <td>".$rows['payment_id']."</td>
                     <td>".$rows['amount']."</td>
                     <td>".$rows['reservation_id']."</td>
                     <td>".$rows['payment_method']."</td>
                </tr>";
            }
            echo "</table><br> Payment Found.";
        } else {
            echo "No record found with that ID.";
        }
        echo "</center>";
    }
}

// EDIT
if(isset($_POST['EditSub'])){
    if($_POST['payment_id']=='' || $_POST['amount']=='' || $_POST['reservation_id']=='' || $_POST['payment_method']=='choose'){
        echo "<center>Please provide ID and all fields to update.</center>";
    }
    else{
        try {
            $sql = "UPDATE payment SET amount = '$_POST[amount]', 
                    reservation_id = '$_POST[reservation_id]', 
                    payment_method = '$_POST[payment_method]' 
                    WHERE payment_id = '$_POST[payment_id]'";
            $result = mysqli_query($conn, $sql);
            if(mysqli_affected_rows($conn) > 0){
                echo "<br><center>Record Updated Successfully.</center>";
            } else {
                echo "<br><center>No changes made or ID not found.</center>";
            }
        } catch(mysqli_sql_exception $e) {
            die( "<br><br><center>Error: ".$e->getMessage() ."</center>");
        }
    }
}

// DELETE
if (isset($_POST['DeleteSub'])){
     if($_POST['payment_id']==''){
        echo "<center>Please provide Payment ID to delete.</center>";
    }
    else{
        try {
            $sql = "DELETE FROM payment WHERE payment_id = '$_POST[payment_id]'";
            $result = mysqli_query($conn, $sql);
            if(mysqli_affected_rows($conn) > 0){
                echo "<br><br><center>Record Deleted.</center>";
            } else {
                echo "<br><br><center>Record not found.</center>";
            }
        } catch (mysqli_sql_exception $e){
            die( "<br><br><center>Error: Cannot delete payment record used in a reservation. Remove or reassign the reservation first.</center>");
        }
    }
}
?>
</body>
</html>