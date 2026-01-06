<?php
// Database connection
$DBHost = "localhost";
$DBUser = "root";
$DBPass = "1234";
$DBName = "hotel";
$conn = mysqli_connect($DBHost, $DBUser, $DBPass, $DBName);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
$booking_message = "";
$booking_status = "";

if (isset($_POST['SubmitBooking'])) {
    if (empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['contact_info']) || 
        empty($_POST['start_date']) || empty($_POST['end_date']) || empty($_POST['amount'])) {
        $booking_message = "Please complete all fields.";
        $booking_status = "error";
    } else {
        $sql_find_room = "SELECT room_id FROM room WHERE room_type_id = '".$_POST['room_type_id']."' AND vacancy_status = 'AVAILABLE' LIMIT 1";
        $room_result = mysqli_query($conn, $sql_find_room);

        if (mysqli_num_rows($room_result) > 0) {
            $room_data = mysqli_fetch_assoc($room_result);
            $assigned_room_id = $room_data['room_id'];

            $sql_guest = "INSERT INTO guest (first_name, last_name, contact_info) 
                          VALUES ('".$_POST['first_name']."', '".$_POST['last_name']."', '".$_POST['contact_info']."')";
            
            if (mysqli_query($conn, $sql_guest)) {
                $new_guest_id = mysqli_insert_id($conn);

                $sql_res = "INSERT INTO reservation (guest_id, room_id, start_date, end_date, reservation_status) 
                            VALUES ('$new_guest_id', '$assigned_room_id', '".$_POST['start_date']."', '".$_POST['end_date']."', 'PENDING')";
                
                if (mysqli_query($conn, $sql_res)) {
                    $new_res_id = mysqli_insert_id($conn);

                    $sql_pay = "INSERT INTO payment (amount, reservation_id) 
                                VALUES ('".$_POST['amount']."', '$new_res_id')";
                    mysqli_query($conn, $sql_pay);

                    $booking_message = "Reservation Requested! Your Reservation ID is: " . $new_res_id . ". Status: PENDING ADMIN CONFIRMATION";
                    $booking_status = "success";
                }
            }
        } else {
            $booking_message = "Sorry, no rooms of that type are currently available.";
            $booking_status = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Book Pristine Hotel</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background: #ffffff;
      font-family: 'Inter', sans-serif;
      color: #1a1a1a;
    }

    .navbar {
      background: transparent;
      padding: 0.5rem 2rem;
      transition: all 0.3s ease;
    }

    .navbar-logo {
      height: 80px;        
      width: auto;         
      margin-right: 10px;   
      vertical-align: middle;
    }

    .navbar-scrolled {
      background: rgba(255, 255, 255, 0.98);
      box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
    }

    .navbar-brand {
      font-size: 1.5rem;
      font-weight: 700;
      color: #1a1a1a !important;
      letter-spacing: 0.5px;
    }

    .nav-link {
      color:#1a1a1a !important;
      font-weight: 500;
      padding: 0.5rem 1rem !important;
      transition: color 0.3s ease;
      position: relative;
      text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7);
    }

    .nav-link::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      width: 0;
      height: 2px;
      background: #1a1a1a;
      transition: all 0.3s ease;
      transform: translateX(-50%);
    }

    .nav-link:hover {
      color: #666 !important;
    }

    .nav-link:hover::after {
      width: 80%;
    }

    .dropdown-menu {
      background: #ffffff;
      border: 1px solid #e0e0e0;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      padding: 0.5rem;
    }

    .dropdown-item {
      color: #1a1a1a;
      padding: 0.7rem 1rem;
      border-radius: 6px;
      transition: all 0.2s ease;
    }

    .dropdown-item:hover {
      background: #f5f5f5;
      color: #1a1a1a;
    }

    .dropdown:hover .dropdown-menu {
      display: block;
    }

    .dropdown-menu {
      margin-top: 0;
    }

    .hero-section {
      height: 85vh;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)),
                  url('images/hero-pristine.jpg');

      background-size: cover;
      background-position: center;
    }

    .hero-content {
      text-align: center;
      color: white;
    }

    .hero-content h1 {
      font-size: 4rem;
      font-weight: 600;
      margin-bottom: 1rem;
      letter-spacing: -1px;
    }

    .hero-content p {
      font-size: 1.3rem;
      font-weight: 300;
      letter-spacing: 2px;
    }

    .booking-section {
      padding: 3rem 0;
      background: #fafafa;
    }

    .booking-bar {
      background: #ffffff;
      padding: 2rem;
      border-radius: 16px;
      box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
    }

    .form-label {
      color: #666;
      font-weight: 600;
      font-size: 0.85rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 0.6rem;
    }

    .form-control, .form-select {
      background: #f8f8f8;
      border: 1px solid #e0e0e0;
      color: #1a1a1a;
      border-radius: 8px;
      padding: 0.75rem;
      transition: all 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
      background: #ffffff;
      border-color: #1a1a1a;
      box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05);
      color: #1a1a1a;
    }

    .btn-primary {
      background: #1a1a1a;
      border: none;
      padding: 0.75rem 2rem;
      font-weight: 600;
      border-radius: 8px;
      transition: all 0.2s ease;
    }

    .btn-primary:hover {
      background: #333;
      transform: translateY(-1px);
    }

    .rooms-section {
      padding: 5rem 0;
      background: #ffffff;
    }

    .section-title {
      font-size: 2.5rem;
      font-weight: 600;
      text-align: center;
      margin-bottom: 3rem;
      color: #1a1a1a;
      letter-spacing: -0.5px;
    }

    .room-card {
      background: #ffffff;
      border: 1px solid #e0e0e0;
      border-radius: 12px;
      overflow: hidden;
      transition: all 0.3s ease;
      height: 100%;
    }

    .room-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12);
    }

    .room-card img {
      height: 260px;
      object-fit: cover;
      transition: transform 0.3s ease;
    }

    .room-image-wrapper {
      position: relative;
      overflow: hidden;
      height: 260px;
    }

    .room-badge {
      position: absolute;
      top: 20px;
      right: 20px;
      background: linear-gradient(135deg, #000000, #000000); 
      color: white;
      padding: 0.5rem 1.2rem;
      border-radius: 50px;
      font-weight: 600;
      font-size: 0.85rem;
      z-index: 2;
      box-shadow: 0 5px 20px rgba(20, 20, 20, 0.4);
      letter-spacing: 0.5px;
    }

    .room-card:hover img {
      transform: scale(1.05);
    }

    .card-body {
      padding: 1.5rem;
    }

    .card-title {
      font-size: 1.5rem;
      font-weight: 600;
      color: #1a1a1a;
      margin-bottom: 0.5rem;
    }

    .room-features {
      display: flex;
      gap: 1rem;
      margin-bottom: 1.5rem;
      flex-wrap: wrap;
    }

    .room-feature {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      color: #64748b;
      font-size: 0.9rem;
      font-weight: 500;
    }

    .room-feature::before {
      content: '✓';
      color: #1a1a1a;
      font-weight: 700;
      font-size: 1.1rem;
    }

    .card-text {
      font-size: 1.3rem;
      font-weight: 600;
      color: #1a1a1a;
      margin-bottom: 1.2rem;
    }

    .card-text span {
      font-size: 0.9rem;
      color: #666;
      font-weight: 400;
    }

    .book-btn {
      background: #1a1a1a;
      border: none;
      color: #ffffff;
      padding: 0.7rem 1.5rem;
      border-radius: 8px;
      font-weight: 600;
      transition: all 0.2s ease;
    }

    .book-btn:hover {
      background: #333;
      transform: translateY(-2px);
    }

    .modal-content {
      border: none;
      border-radius: 16px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
    }

    .modal-header {
      background: #1a1a1a;
      color: white;
      border-radius: 16px 16px 0 0;
      padding: 1.5rem;
    }

    .modal-title {
      font-size: 1.5rem;
      font-weight: 600;
    }

    .modal-body {
      padding: 2rem;
    }

    .text-primary {
      color: #1a1a1a !important;
    }

    .text-success {
      color: #10b981 !important;
    }

    .btn-success {
      background: #10b981;
      border: none;
      padding: 0.75rem 2rem;
      font-weight: 600;
      border-radius: 8px;
      transition: all 0.2s ease;
    }

    .btn-success:hover {
      background: #059669;
      transform: translateY(-1px);
    }

    /* FLOATING LABEL STYLES */
    .form-floating {
      position: relative;
    }

    .form-floating > .form-control,
    .form-floating > .form-select {
      padding: 1rem 0.75rem;
      height: calc(3.5rem + 2px);
    }

    .form-floating > label {
      position: absolute;
      top: 0;
      left: 0;
      height: 100%;
      padding: 1rem 0.75rem;
      pointer-events: none;
      border: 1px solid transparent;
      transform-origin: 0 0;
      transition: opacity 0.1s ease-in-out, transform 0.1s ease-in-out;
      color: #666;
      font-weight: 400;
      font-size: 1rem;
      text-transform: none;
      letter-spacing: normal;
    }

    .form-floating > .form-control:focus ~ label,
    .form-floating > .form-control:not(:placeholder-shown) ~ label,
    .form-floating > .form-select:focus ~ label,
    .form-floating > .form-select ~ label {
      opacity: 0.65;
      transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
      color: #1a1a1a;
      font-weight: 500;
    }

    .form-floating > .form-control:focus,
    .form-floating > .form-select:focus {
      padding-top: 1.625rem;
      padding-bottom: 0.625rem;
    }

    .form-floating > .form-control:not(:placeholder-shown),
    .form-floating > .form-select {
      padding-top: 1.625rem;
      padding-bottom: 0.625rem;
    }

    .alert {
      border-radius: 12px;
      padding: 1.2rem;
      margin-bottom: 2rem;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .alert-success {
      background: #d1fae5;
      color: #065f46;
      border: 1px solid #10b981;
    }

    .alert-danger {
      background: #fee2e2;
      color: #991b1b;
      border: 1px solid #ef4444;
    }

    @media (max-width: 768px) {
      .hero-content h1 {
        font-size: 2.5rem;
      }

      .hero-content p {
        font-size: 1.1rem;
      }

      .section-title {
        font-size: 2rem;
      }

      .hero-section {
        height: 70vh;
      }
    }
  </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg fixed-top px-3">
    <a class="navbar-brand" href="#">
      <img src="images/pristine-logo-removebg.png" alt="Pristine Hotel Logo" class="navbar-logo">
      Pristine Hotel
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto gap-3">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button">
            Contact ⏷
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="tel:+63123456789">📞 +63 123 456 789</a></li>
            <li><a class="dropdown-item" href="https://www.pristine.ph">🌐 www.pristine.ph</a></li>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link" href="#rooms">Rooms</a></li>
      </ul>
    </div>
  </nav>

  <div class="hero-section">
    <div class="hero-content">
      <h1>Relax & Unwind</h1>
      <p>Experience comfort in the heart of the city</p>
    </div>
  </div>



  <div class="rooms-section" id="rooms">
    <div class="container">

      <?php if ($booking_message): ?>
        <div class="alert <?php echo $booking_status == 'success' ? 'alert-success' : 'alert-danger'; ?>" role="alert">
          <strong><?php echo $booking_status == 'success' ? '✓ Success!' : '✗ Error:'; ?></strong> 
          <?php echo $booking_message; ?>
        </div>
      <?php endif; ?>
      
      <h2 class="section-title">Available Rooms</h2>

      <div class="row g-4">

        <div class="col-lg-4 col-md-6">
          <div class="card room-card">
            <div class="room-image-wrapper">
            <span class="room-badge">Popular</span>
            <img src="images/room1-pristine.jpeg" class="card-img-top" alt="SINGLE">
            </div>
            <div class="card-body">
              <h5 class="card-title">SINGLE</h5>
              <div class="room-features">
                <span class="room-feature">1 Guest</span>
                <span class="room-feature">City View</span>
                <span class="room-feature">WiFi</span>
              </div>
              <p class="card-text">₱1,700 <span>/ night</span></p>
              <button class="btn book-btn w-100" data-room="SINGLE" data-price="1700" data-room-id="1">
                Book Now
              </button>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="card room-card">
            <img src="images/room2-pristine.jpg" class="card-img-top" alt="DOUBLE">
            <div class="card-body">
              <h5 class="card-title">DOUBLE</h5>
              <div class="room-features">
                <span class="room-feature">2 Guests</span>
                <span class="room-feature">Balcony</span>
                <span class="room-feature">WiFi</span>
              </div>
              <p class="card-text">₱2,300 <span>/ night</span></p>
              <button class="btn book-btn w-100" data-room="DOUBLE" data-price="2300" data-room-id="2">
                Book Now
              </button>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="card room-card">
            <div class="room-image-wrapper">
            <span class="room-badge">Best Value</span>
            <img src="images/room3-pristine.jpg" class="card-img-top" alt="SUITE">
            </div>
            <div class="card-body">
              <h5 class="card-title">SUITE</h5>
              <div class="room-features">
                <span class="room-feature">4 Guests</span>
                <span class="room-feature">Sea View</span>
                <span class="room-feature">WiFi</span>
              </div>
              <p class="card-text">₱3,500 <span>/ night</span></p>
              <button class="btn book-btn w-100" data-room="SUITE" data-price="3500" data-room-id="3">
                Book Now
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="bookingModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Complete Your Booking</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <p class="fw-bold mb-2">Selected Room: <span id="modalRoom" class="text-primary"></span></p>
          <p class="fw-bold mb-4">Price: <span id="modalPrice" class="text-success"></span> / night</p>

          <form method="POST" id="bookingForm">
            <input type="hidden" name="room_type_id" id="roomTypeId">
            
            <h6 class="fw-bold mb-3">Personal Information</h6>
            
            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="text" class="form-control" id="firstName" name="first_name" placeholder="Juan" required>
                  <label for="firstName">First Name</label>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-floating">
                  <input type="text" class="form-control" id="lastName" name="last_name" placeholder="Dela Cruz" required>
                  <label for="lastName">Last Name</label>
                </div>
              </div>
            </div>

            <div class="form-floating mb-3">
              <input type="email" class="form-control" id="emailAddress" name="email_address" placeholder="juan@gmail.com">
              <label for="emailAddress">Email Address</label>
            </div>

            <div class="form-floating mb-4">
              <input type="tel" class="form-control" id="contactInfo" name="contact_info" placeholder="09xxxxxxxxx" required>
              <label for="contactInfo">Contact Number</label>
            </div>

            <h6 class="fw-bold mb-3">Reservation Details</h6>

            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="datetime-local" class="form-control" id="startDate" name="start_date" placeholder="Check-in" required>
                  <label for="startDate">Check-in Date & Time</label>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-floating">
                  <input type="datetime-local" class="form-control" id="endDate" name="end_date" placeholder="Check-out" required>
                  <label for="endDate">Check-out Date & Time</label>
                </div>
              </div>
            </div>

            <div class="form-floating mb-4">
              <input type="number" class="form-control" id="downpayment" name="amount" placeholder="0.00" min="0" step="0.01" required>
              <label for="downpayment">Downpayment Amount (₱)</label>
            </div>

            <button type="submit" name="SubmitBooking" class="btn btn-success w-100">Confirm Booking</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    const nav = document.querySelector(".navbar");
    window.addEventListener("scroll", () => {
      nav.classList.toggle("navbar-scrolled", window.scrollY > 50);
    });

    const bookingButtons = document.querySelectorAll(".book-btn");
    const modalRoom = document.getElementById("modalRoom");
    const modalPrice = document.getElementById("modalPrice");
    const roomTypeId = document.getElementById("roomTypeId");

    bookingButtons.forEach(btn => {
      btn.addEventListener("click", () => {
        const roomType = btn.dataset.room;
        const price = btn.dataset.price;
        const roomId = btn.dataset.roomId;
        
        modalRoom.textContent = roomType;
        modalPrice.textContent = "₱" + parseInt(price).toLocaleString();
        roomTypeId.value = roomId;
        
        new bootstrap.Modal(document.getElementById('bookingModal')).show();
      });
    });

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      });
    });

    <?php if ($booking_message): ?>
    window.addEventListener('load', function() {
      window.scrollTo({top: 0, behavior: 'smooth'});
    });
    <?php endif; ?>
  </script>
</body>
</html>