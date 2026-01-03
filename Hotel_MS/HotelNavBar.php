<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body { background-color: #f8f9fa; }
        .navbar { margin-bottom: 30px; }
        .nav-link.active { 
            font-weight: bold; 
            color: #fff !important;
            border-bottom: 2px solid #fff;
        }
    </style>
</head>
<body>

<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Pristine-Coast Whale Hotel</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
         <li class="nav-item">
          <a class="nav-link <?php echo ($current_page == 'Room.php') ? 'active' : ''; ?>" href="Room.php">Room</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo ($current_page == 'RoomType.php') ? 'active' : ''; ?>" href="RoomType.php">Room Types</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo ($current_page == 'Reservation.php') ? 'active' : ''; ?>" href="Reservation.php">Reservations</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo ($current_page == 'Payment.php') ? 'active' : ''; ?>" href="Payment.php">Payments</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo ($current_page == 'Stay.php') ? 'active' : ''; ?>" href="Stay.php">Stays</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo ($current_page == 'Guest.php') ? 'active' : ''; ?>" href="Guest.php">Guests</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo ($current_page == 'Staff.php') ? 'active' : ''; ?>" href="Staff.php">Staff</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo ($current_page == 'ReservationForm.php') ? 'active text-info' : ''; ?>" href="ReservationForm.php">Reservation Form</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo ($current_page == 'Receptionist.php') ? 'active' : ''; ?>" href="Receptionist.php">Receptionist</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">