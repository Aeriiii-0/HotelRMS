<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body { 
            background: linear-gradient(135deg, #E8E3D6, #C5D4C8);
            padding: 0;
            margin: 0;
        }
        .navbar { 
            margin: 0 !important;
            border-radius: 0 !important;
        }
        
       
        .navbar-custom {
            background: linear-gradient(135deg, #8FA78E 0%, #9CB89B 100%) !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            padding-top: 0 !important;
            padding-bottom: 18px !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        
        .navbar-custom .container-fluid {
            padding-left: 20px;
            padding-right: 20px;
            padding-top: 18px;
        }
        
        .navbar-custom .navbar-brand {
            color: #FCFCFA !important;
            font-weight: 700;
            font-size: 1.4rem;
            letter-spacing: 0.5px;
        }
        
        .navbar-custom .nav-link {
            color: #F5F3EE !important;
            transition: all 0.3s ease;
            font-weight: 500;
            padding: 8px 16px !important;
            margin: 0 4px;
        }
        
        .navbar-custom .nav-link:hover {
            color: #FFFFFF !important;
            background-color: rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            transform: translateY(-2px);
        }
        
        .navbar-custom .nav-link.active { 
            font-weight: 700;
            color: #FFFFFF !important;
            border-bottom: 3px solid #E8E3D6;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 10px 10px 0 0;
        }
        
        .navbar-custom .navbar-toggler {
            border-color: rgba(252, 252, 250, 0.4);
            padding: 8px 12px;
        }
        
        .navbar-custom .navbar-toggler:focus {
            box-shadow: 0 0 0 0.2rem rgba(232, 227, 214, 0.3);
        }
        
        .navbar-custom .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28252, 252, 250, 0.9%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        
        .container {
            margin-top: 30px;
        }
    </style>
</head>
<body>

<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar navbar-expand-lg navbar-custom">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Pristine-Coast Hotel</a>
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
        <!-- <li class="nav-item">
          <a class="nav-link <?php echo ($current_page == 'Stay.php') ? 'active' : ''; ?>" href="Stay.php">Stays</a>
        </li> -->
        <li class="nav-item">
          <a class="nav-link <?php echo ($current_page == 'Guest.php') ? 'active' : ''; ?>" href="Guest.php">Guests</a>
        </li>
        <!-- <li class="nav-item">
          <a class="nav-link <?php echo ($current_page == 'Staff.php') ? 'active' : ''; ?>" href="Staff.php">Staff</a>
        </li> -->
        <li class="nav-item">
          <a class="nav-link <?php echo ($current_page == 'BookCoast.php') ? 'active' : ''; ?>" href="Hotel/BookCoast.php">
            Reservation Form
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo ($current_page == 'Receptionist.php') ? 'active' : ''; ?>" href="Receptionist.php">Receptionist</a>
        </li>
      </ul>
    </div>
  </div>
</nav>


<div class="container">
