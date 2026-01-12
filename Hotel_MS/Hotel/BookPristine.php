<?php
$DBHost = "localhost";
$DBUser = "root";
$DBPass = "1234";
$DBName = "hotel";

$conn = mysqli_connect($DBHost, $DBUser, $DBPass, $DBName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$booking_message = "";
$booking_status = "";
$payment_status = "";

if (isset($_POST['SubmitBooking'])) {
    if (empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['contact_info']) || 
        empty($_POST['start_date']) || empty($_POST['end_date']) || empty($_POST['amount']) || 
        empty($_POST['email_address']) || empty($_POST['room_quantity'])) {
        $booking_message = "Please complete all fields.";
        $booking_status = "error";
    } else {
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $email = mysqli_real_escape_string($conn, $_POST['email_address']);
        $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
        $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
        $contact = mysqli_real_escape_string($conn, $_POST['contact_info']);
        $amount = mysqli_real_escape_string($conn, $_POST['amount']);
        $requested_type_id = (int)$_POST['room_type_id'];
        $payment_method = 'GCASH';
        $room_quantity = (int)$_POST['room_quantity'];
        $adults = (int)$_POST['adults'];

        if ($adults < $room_quantity) {
            $booking_message = "At least 1 adult is required per room. You selected $room_quantity room(s) but only have $adults adult(s).";
            $booking_status = "error";
        } else {
            $sql_find_rooms = "SELECT r.room_id 
                              FROM room r
                              WHERE r.room_type_id = '$requested_type_id'
                              AND r.room_id NOT IN (
                                  SELECT room_id 
                                  FROM reservation 
                                  WHERE reservation_status NOT IN ('CANCELLED', 'CHECKED OUT')
                                  AND (
                                      (start_date <= '$end_date' AND end_date >= '$start_date')
                                  )
                              )
                              LIMIT $room_quantity";
            $room_result = mysqli_query($conn, $sql_find_rooms);

            if (mysqli_num_rows($room_result) >= $room_quantity) {
                $available_rooms = [];
                while ($room_data = mysqli_fetch_assoc($room_result)) {
                    $available_rooms[] = $room_data['room_id'];
                }
                
                $start_datetime = new DateTime($start_date);
                $end_datetime = new DateTime($end_date);
                $now = new DateTime();
                
                if($start_datetime >= $now && $start_datetime < $end_datetime){
                    $sql_is_guest_new = "SELECT guest_id FROM guest WHERE email = '$email' LIMIT 1";
                    $has_new_guest = mysqli_query($conn, $sql_is_guest_new);
                    
                    $new_guest_id = "";
                    if (mysqli_num_rows($has_new_guest) > 0) {
                        $row = mysqli_fetch_assoc($has_new_guest);
                        $new_guest_id = $row['guest_id'];
                    } else {
                        $sql_guest = "INSERT INTO guest (first_name, last_name, email) VALUES ('$first_name', '$last_name', '$email')";
                        if (mysqli_query($conn, $sql_guest)) {
                            $new_guest_id = mysqli_insert_id($conn);
                        }
                    }

                    $reservation_status = 'CONFIRMED';
                    $all_reservations = [];
                    $amount_per_room = $amount / $room_quantity;
                    
                    foreach ($available_rooms as $assigned_room_id) {
                        $sql_reservation = "INSERT INTO reservation (guest_id, room_id, contact_info, start_date, end_date, reservation_status) 
                                           VALUES ('$new_guest_id', '$assigned_room_id', '$contact', '$start_date', '$end_date', '$reservation_status')";
                        
                        if (mysqli_query($conn, $sql_reservation)) {
                            $new_res_id = mysqli_insert_id($conn);
                            $all_reservations[] = $new_res_id;
                            
                            $sql_pay = "INSERT INTO payment (amount, reservation_id, payment_method) VALUES ('$amount_per_room', '$new_res_id', '$payment_method')";
                            mysqli_query($conn, $sql_pay);
                        }
                    }
                    
                    if (count($all_reservations) == $room_quantity) {
                        $payment_status = "PAID";
                        $booking_message = "Reservation Confirmed! Your Reservation IDs are: " . implode(', ', $all_reservations) . ". Payment Status: PAID via GCash";
                        $booking_status = "success";
                    } else {
                        $booking_message = "Error creating all reservations. Please try again.";
                        $booking_status = "error";
                    }
                } else {
                    $booking_message = "Sorry, the selected dates are not valid for this reservation.";
                    $booking_status = "error";
                }
            } else {
                $available_count = mysqli_num_rows($room_result);
                $booking_message = "Sorry, only $available_count room(s) of that type are available for the selected dates. You requested $room_quantity room(s).";
                $booking_status = "error";
            }
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
  <link rel="stylesheet" href="Style.css">
</head>

<body>

  <nav class="navbar navbar-expand-lg fixed-top px-3">
    <a class="navbar-brand" href="hotel.php">
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

  <div class="booking-section">
    <div class="container">
      <div class="booking-bar">
        <div class="row g-3 align-items-end">
          <div class="col-md-2">
            <label class="form-label">Check-in</label>
            <input type="date" class="form-control" id="searchCheckin">
          </div>
          <div class="col-md-2">
            <label class="form-label">Check-out</label>
            <input type="date" class="form-control" id="searchCheckout">
          </div>
          <div class="col-md-2">
            <label class="form-label" style="font-size: 0.7rem; margin-bottom: 0.2rem;">Adults</label>
            <input type="number" class="form-control" id="searchAdults" placeholder="1" min="1" value="1">
          </div>
          <div class="col-md-2">
            <label class="form-label" style="font-size: 0.7rem; margin-bottom: 0.2rem;">Children</label>
            <input type="number" class="form-control" id="searchChildren" placeholder="0" min="0" value="0">
          </div>
          <div class="col-md-2">
            <label class="form-label" style="font-size: 0.7rem; margin-bottom: 0.2rem;">Rooms</label>
            <input type="number" class="form-control" id="searchRooms" placeholder="1" min="1" value="1">
          </div>
          <div class="col-md-2">
            <button class="btn btn-primary w-100" onclick="filterRoomsByGuests()">Search</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="rooms-section" id="rooms">
    <div class="container">

      <?php if ($booking_message): ?>
        <div class="alert <?php echo $booking_status == 'success' ? 'alert-success' : 'alert-danger'; ?>" role="alert">
          <strong><?php echo $booking_status == 'success' ? '✓ Success!' : '✗ Error:'; ?></strong> 
          <?php echo $booking_message; ?>
          <?php if ($payment_status): ?>
            <span class="payment-status <?php echo $payment_status == 'PAID' ? 'payment-paid' : 'payment-pending'; ?>">
              <?php echo $payment_status; ?>
            </span>
          <?php endif; ?>
        </div>
      <?php endif; ?>
      
      <h2 class="section-title">Available Rooms</h2>

      <div class="row g-4" id="roomsContainer">

        <div class="col-lg-4 col-md-6 room-item" data-capacity="3">
          <div class="card room-card">
            <div class="room-image-wrapper">
              <span class="room-badge">Cozy</span>
              <img src="images/room1-pristine.jpeg" class="card-img-top" alt="Standard Single">
            </div>
            <div class="card-body">
              <h5 class="card-title">Standard Single</h5>
              <div class="room-features">
                <span class="room-feature">Up to 3 Guests</span>
                <span class="room-feature">City View</span>
                <span class="room-feature">WiFi</span>
              </div>
              <p class="card-text">₱1,500 <span>/ night</span></p>
              <button class="btn book-btn w-100" data-room="Standard Single" data-price="1500" data-room-id="1">
                Book Now
              </button>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 room-item" data-capacity="5">
          <div class="card room-card">
            <div class="room-image-wrapper">
              <span class="room-badge">Popular</span>
              <img src="images/room2-pristine.jpg" class="card-img-top" alt="Standard Double">
            </div>
            <div class="card-body">
              <h5 class="card-title">Standard Double</h5>
              <div class="room-features">
                <span class="room-feature">Up to 5 Guests</span>
                <span class="room-feature">Balcony</span>
                <span class="room-feature">WiFi</span>
              </div>
              <p class="card-text">₱2,500 <span>/ night</span></p>
              <button class="btn book-btn w-100" data-room="Standard Double" data-price="2500" data-room-id="2">
                Book Now
              </button>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 room-item" data-capacity="7">
          <div class="card room-card">
            <div class="room-image-wrapper">
              <span class="room-badge">Premium</span>
              <img src="images/room3-pristine.jpg" class="card-img-top" alt="Deluxe King">
            </div>
            <div class="card-body">
              <h5 class="card-title">Deluxe King</h5>
              <div class="room-features">
                <span class="room-feature">Up to 7 Guests</span>
                <span class="room-feature">Sea View</span>
                <span class="room-feature">Premium WiFi</span>
              </div>
              <p class="card-text">₱4,500 <span>/ night</span></p>
              <button class="btn book-btn w-100" data-room="Deluxe King" data-price="4500" data-room-id="3">
                Book Now
              </button>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 room-item" data-capacity="10">
          <div class="card room-card">
            <div class="room-image-wrapper">
              <span class="room-badge">Luxury</span>
              <img src="images/room1-pristine.jpeg" class="card-img-top" alt="Junior Suite">
            </div>
            <div class="card-body">
              <h5 class="card-title">Junior Suite</h5>
              <div class="room-features">
                <span class="room-feature">Up to 10 Guests</span>
                <span class="room-feature">Living Area</span>
                <span class="room-feature">Mini Bar</span>
              </div>
              <p class="card-text">₱7,000 <span>/ night</span></p>
              <button class="btn book-btn w-100" data-room="Junior Suite" data-price="7000" data-room-id="4">
                Book Now
              </button>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 room-item" data-capacity="12">
          <div class="card room-card">
            <div class="room-image-wrapper">
              <span class="room-badge">Executive</span>
              <img src="images/room2-pristine.jpg" class="card-img-top" alt="Executive Suite">
            </div>
            <div class="card-body">
              <h5 class="card-title">Executive Suite</h5>
              <div class="room-features">
                <span class="room-feature">Up to 12 Guests</span>
                <span class="room-feature">Ocean View</span>
                <span class="room-feature">Jacuzzi</span>
              </div>
              <p class="card-text">₱12,000 <span>/ night</span></p>
              <button class="btn book-btn w-100" data-room="Executive Suite" data-price="12000" data-room-id="5">
                Book Now
              </button>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 room-item" data-capacity="15">
          <div class="card room-card">
            <div class="room-image-wrapper">
              <span class="room-badge">Presidential</span>
              <img src="images/room3-pristine.jpg" class="card-img-top" alt="Presidential Suite">
            </div>
            <div class="card-body">
              <h5 class="card-title">Presidential Suite</h5>
              <div class="room-features">
                <span class="room-feature">Up to 15 Guests</span>
                <span class="room-feature">Penthouse</span>
                <span class="room-feature">Butler Service</span>
              </div>
              <p class="card-text">₱25,000 <span>/ night</span></p>
              <button class="btn book-btn w-100" data-room="Presidential Suite" data-price="25000" data-room-id="6">
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
          <p class="fw-bold mb-2">Room Quantity: <span id="modalRoomQuantity" class="text-primary">1</span></p>
          <p class="fw-bold mb-2">Number of Nights: <span id="modalNights" class="text-primary">1</span></p>
          <p class="fw-bold mb-4">Total Price: <span id="modalPrice" class="text-success"></span></p>

          <form method="POST" id="bookingForm">
            <input type="hidden" name="room_type_id" id="roomTypeId">
            <input type="hidden" name="room_quantity" id="roomQuantityHidden" value="1">
            <input type="hidden" name="adults" id="adultsHidden" value="1">
            
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
              <input type="email" class="form-control" id="emailAddress" name="email_address" placeholder="juan@gmail.com" required>
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
                  <input type="date" class="form-control" id="startDate" name="start_date" placeholder="Check-in" required>
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

            <h6 class="fw-bold mb-3">Payment Information</h6>

            <div class="alert alert-info mb-3" style="background: #e0f2fe; color: #0c4a6e; border: 1px solid #7dd3fc;">
              <strong>💳 Payment Method:</strong> GCash Only
            </div>

            <div class="form-floating mb-4">
              <input type="number" class="form-control" id="downpayment" name="amount" placeholder="0.00" min="0" step="0.01" required readonly>
              <label for="downpayment">Total Amount (₱)</label>
            </div>

            <div class="d-grid gap-2 mb-3">
              <button type="button" class="btn btn-primary w-100" style="background: #007bff; border: none; padding: 0.9rem; font-size: 1.1rem; font-weight: 600;" onclick="handleGCashPayment()">
                💳 Pay with GCash
              </button>
            </div>

            <button type="submit" name="SubmitBooking" class="btn btn-success w-100" style="display: none;" id="actualSubmitBtn">Confirm Booking</button>
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

    let currentPricePerNight = 0;

    function setMinDates() {
      const today = new Date();
      const todayStr = today.toISOString().split('T')[0];
      
      document.getElementById('searchCheckin').min = todayStr;
      document.getElementById('startDate').min = today.toISOString().slice(0, 16);
    }

    setMinDates();

    document.getElementById('searchCheckin').addEventListener('change', function() {
      const checkinDate = new Date(this.value);
      const nextDay = new Date(checkinDate);
      nextDay.setDate(nextDay.getDate() + 1);
      
      const minCheckout = nextDay.toISOString().split('T')[0];
      document.getElementById('searchCheckout').min = minCheckout;
      
      if (this.value && document.getElementById('searchCheckout').value < minCheckout) {
        document.getElementById('searchCheckout').value = minCheckout;
      }
    });

    function updateCheckoutMin() {
      const checkinValue = document.getElementById('startDate').value;
      if (!checkinValue) return;
      
      const checkin = new Date(checkinValue);
      const minCheckout = new Date(checkin);
      minCheckout.setDate(minCheckout.getDate() + 1);
      minCheckout.setHours(14, 0, 0, 0);
      
      const minCheckoutStr = minCheckout.toISOString().slice(0, 16);
      document.getElementById('endDate').min = minCheckoutStr;
      
      const currentCheckout = document.getElementById('endDate').value;
      if (currentCheckout && new Date(currentCheckout) < minCheckout) {
        document.getElementById('endDate').value = minCheckoutStr;
      }
      
      calculateTotalPrice();
    }

    document.getElementById('searchRooms').addEventListener('input', function() {
      const rooms = parseInt(this.value) || 1;
      const adultsField = document.getElementById('searchAdults');
      const currentAdults = parseInt(adultsField.value) || 1;
      
      if (currentAdults < rooms) {
        adultsField.value = rooms;
      }
    });

    function setDefaultDateTime() {
      const searchCheckin = document.getElementById('searchCheckin').value;
      const searchCheckout = document.getElementById('searchCheckout').value;
      
      let checkinDate, checkoutDate;
      
      if (searchCheckin && searchCheckout) {
        checkinDate = searchCheckin + 'T11:00';
        checkoutDate = searchCheckout + 'T14:00';
      } else {
        const today = new Date();
        const tomorrow = new Date(today);
        tomorrow.setDate(tomorrow.getDate() + 1);
        
        checkinDate = today.toISOString().slice(0, 10) + 'T11:00';
        checkoutDate = tomorrow.toISOString().slice(0, 10) + 'T14:00';
      }

      document.getElementById('startDate').value = checkinDate;
      document.getElementById('endDate').value = checkoutDate;
      
      updateCheckoutMin();
    }

    function calculateNights() {
      const startDate = document.getElementById('startDate').value;
      const endDate = document.getElementById('endDate').value;
      
      if (!startDate || !endDate) return 1;
      
      const start = new Date(startDate);
      const end = new Date(endDate);
      const diffTime = Math.abs(end - start);
      const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
      
      return diffDays > 0 ? diffDays : 1;
    }

    function calculateTotalPrice() {
      const roomQuantity = parseInt(document.getElementById('roomQuantityHidden').value) || 1;
      const nights = calculateNights();
      const totalPrice = currentPricePerNight * roomQuantity * nights;
      
      document.getElementById('modalNights').textContent = nights;
      document.getElementById('modalPrice').textContent = "₱" + totalPrice.toLocaleString();
      document.getElementById('downpayment').value = totalPrice;
    }

    function filterRoomsByGuests() {
      const adults = parseInt(document.getElementById('searchAdults').value) || 0;
      const children = parseInt(document.getElementById('searchChildren').value) || 0;
      const rooms = parseInt(document.getElementById('searchRooms').value) || 1;
      const totalGuests = adults + children;
      const totalCapacityNeeded = totalGuests;

      const roomItems = document.querySelectorAll('.room-item');
      let hasVisibleRooms = false;

      roomItems.forEach(item => {
        const itemCapacity = parseInt(item.dataset.capacity);
        const badge = item.querySelector('.room-badge');
        
        if (badge.classList.contains('recommended-badge')) {
          badge.classList.remove('recommended-badge');
          badge.textContent = badge.dataset.originalText || badge.textContent;
        } else {
          badge.dataset.originalText = badge.textContent;
        }

        const totalRoomCapacity = itemCapacity * rooms;

        if (totalRoomCapacity >= totalCapacityNeeded) {
          item.style.display = 'block';
          hasVisibleRooms = true;
          
          if (totalRoomCapacity >= totalCapacityNeeded && totalRoomCapacity <= totalCapacityNeeded + (2 * rooms)) {
            badge.textContent = 'Recommended';
            badge.classList.add('recommended-badge');
          }
        } else {
          item.style.display = 'none';
        }
      });

      if (!hasVisibleRooms) {
        roomItems.forEach(item => {
          item.style.display = 'block';
        });
        alert('No rooms found for ' + totalGuests + ' guests in ' + rooms + ' room(s). Showing all available rooms.');
      }

      document.getElementById('rooms').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    const bookingButtons = document.querySelectorAll(".book-btn");
    const modalRoom = document.getElementById("modalRoom");
    const modalPrice = document.getElementById("modalPrice");
    const modalRoomQuantity = document.getElementById("modalRoomQuantity");
    const roomTypeId = document.getElementById("roomTypeId");
    const amountField = document.getElementById("downpayment");
    const roomQuantityHidden = document.getElementById("roomQuantityHidden");
    const adultsHidden = document.getElementById("adultsHidden");

    bookingButtons.forEach(btn => {
      btn.addEventListener("click", () => {
        const roomType = btn.dataset.room;
        const pricePerRoom = parseInt(btn.dataset.price);
        const roomId = btn.dataset.roomId;
        const roomQuantity = parseInt(document.getElementById('searchRooms').value) || 1;
        const adults = parseInt(document.getElementById('searchAdults').value) || 1;
        
        currentPricePerNight = pricePerRoom;
        
        modalRoom.textContent = roomType;
        modalRoomQuantity.textContent = roomQuantity;
        roomTypeId.value = roomId;
        roomQuantityHidden.value = roomQuantity;
        adultsHidden.value = adults;
        
        setDefaultDateTime();
        
        new bootstrap.Modal(document.getElementById('bookingModal')).show();
      });
    });

    function handleGCashPayment() {
      const roomQuantity = parseInt(document.getElementById('roomQuantityHidden').value);
      const adults = parseInt(document.getElementById('adultsHidden').value);
      
      if (adults < roomQuantity) {
        alert(`At least 1 adult is required per room. You selected ${roomQuantity} room(s) but only have ${adults} adult(s).`);
        return;
      }
      
      if (!validateBookingForm()) {
        alert('Please fill in all required fields before proceeding with payment.');
        return;
      }
      
      const amount = document.getElementById('downpayment').value;
      if (!amount || parseFloat(amount) <= 0) {
        alert('Please enter a valid payment amount.');
        return;
      }

      const nights = calculateNights();
      const confirmed = confirm(
        `🔵 GCash Payment\n\n` +
        `Amount: ₱${parseFloat(amount).toLocaleString()}\n` +
        `Rooms: ${roomQuantity}\n` +
        `Nights: ${nights}\n\n` +
        `You will be redirected to GCash to complete your payment.\n\n` +
        `Click OK to proceed.`
      );

      if (confirmed) {
        alert('✅ Payment Successful!\n\nYour booking will now be processed.');
        document.getElementById('actualSubmitBtn').click();
      }
    }

    function validateBookingForm() {
      const requiredFields = [
        'firstName', 'lastName', 'emailAddress', 'contactInfo',
        'startDate', 'endDate', 'downpayment'
      ];

      for (let fieldId of requiredFields) {
        const field = document.getElementById(fieldId);
        if (!field.value) {
          field.focus();
          return false;
        }
      }
      return true;
    }

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