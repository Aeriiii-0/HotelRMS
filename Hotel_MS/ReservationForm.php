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

$room_types = [];
$room_type_query = "SELECT room_type_id, room_type, room_price, guest_capacity FROM room_type";
$room_type_result = mysqli_query($conn, $room_type_query);
while ($row = mysqli_fetch_assoc($room_type_result)) {
    $room_types[$row['room_type_id']] = $row;
}

if (isset($_POST['SubmitBooking'])) {
    if (empty($_POST['first_name']) || empty($_POST['last_name']) || 
        empty($_POST['email_address']) || empty($_POST['start_date']) || empty($_POST['end_date'])) {
        $booking_message = "Please complete all fields.";
        $booking_status = "error";
    } else {
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $email = mysqli_real_escape_string($conn, $_POST['email_address']);
        $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
        $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
        $payment_method = 'CASH';
        
        $room_numbers = isset($_POST['room_number']) ? $_POST['room_number'] : [];
        $amounts = isset($_POST['amount']) ? $_POST['amount'] : [];
        
        if (empty($room_numbers) || count($room_numbers) == 0) {
            $booking_message = "Please add at least one room to book.";
            $booking_status = "error";
        } else {
            $start_datetime = new DateTime($start_date);
            $end_datetime = new DateTime($end_date);
            $now = new DateTime();
            
            if ($start_datetime < $now || $start_datetime >= $end_datetime) {
                $booking_message = "Sorry, the selected dates are not valid for this reservation.";
                $booking_status = "error";
            } else {
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
                
                $success_count = 0;
                $reservation_ids = [];
                $errors = [];
                
                foreach ($room_numbers as $index => $room_number) {
                    $room_number = mysqli_real_escape_string($conn, $room_number);
                    $amount = isset($amounts[$index]) ? mysqli_real_escape_string($conn, $amounts[$index]) : 0;
                    
                    if (empty($room_number)) continue;
                    
                    $room_query = "SELECT room_id, room_type_id FROM room WHERE room_number = '$room_number' LIMIT 1";
                    $room_result = mysqli_query($conn, $room_query);
                    
                    if (mysqli_num_rows($room_result) > 0) {
                        $room_data = mysqli_fetch_assoc($room_result);
                        $room_id = $room_data['room_id'];
                        
                        $availability_check = "SELECT room_id 
                                              FROM reservation 
                                              WHERE room_id = '$room_id'
                                              AND reservation_status NOT IN ('CANCELLED', 'CHECKED OUT')
                                              AND (
                                                  (start_date <= '$end_date' AND end_date >= '$start_date')
                                              )";
                        $availability_result = mysqli_query($conn, $availability_check);
                        
                        if (mysqli_num_rows($availability_result) > 0) {
                            $errors[] = "Room $room_number is not available for the selected dates.";
                        } else {
                            $reservation_status = 'CONFIRMED';
                            $contact = '';
                            
                            $sql_reservation = "INSERT INTO reservation (guest_id, room_id, contact_info, start_date, end_date, reservation_status) 
                                               VALUES ('$new_guest_id', '$room_id', '$contact', '$start_date', '$end_date', '$reservation_status')";
                            
                            if (mysqli_query($conn, $sql_reservation)) {
                                $new_res_id = mysqli_insert_id($conn);
                                
                                $sql_pay = "INSERT INTO payment (amount, reservation_id, payment_method) VALUES ('$amount', '$new_res_id', '$payment_method')";
                                
                                if (mysqli_query($conn, $sql_pay)) {
                                    $success_count++;
                                    $reservation_ids[] = $new_res_id;
                                } else {
                                    $errors[] = "Error processing payment for room $room_number: " . mysqli_error($conn);
                                }
                            } else {
                                $errors[] = "Error creating reservation for room $room_number: " . mysqli_error($conn);
                            }
                        }
                    } else {
                        $errors[] = "Room number $room_number not found.";
                    }
                }
                
                if ($success_count > 0) {
                    $booking_message = "Successfully booked $success_count room(s)! Reservation IDs: " . implode(', ', $reservation_ids) . ". Payment Status: PAID via CASH";
                    if (count($errors) > 0) {
                        $booking_message .= " | Errors: " . implode('; ', $errors);
                    }
                    $booking_status = "success";
                } else {
                    $booking_message = "No rooms were booked. " . implode('; ', $errors);
                    $booking_status = "error";
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Walk-in Booking - Pristine Hotel</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #e8e3d6, #c5d4c8);
            padding: 20px;
            padding-top: 100px;
            margin: 0;
            min-height: 100vh;
        }

        .booking-container {
            background: white;
            max-width: 600px;
            width: 100%;
            margin: 0 auto;
            padding: 35px 40px;
            border-radius: 18px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
            border: 2px solid #e8e3d6;
        }

        .booking-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .booking-header h2 {
            color: #4a4a4a;
            font-weight: 600;
            font-size: 1.8rem;
            margin-bottom: 8px;
        }

        .booking-header p {
            color: #555;
            font-size: 0.95rem;
        }

        label {
            display: block;
            margin: 12px 0 5px;
            font-weight: 600;
            color: #555;
            font-size: 14px;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="datetime-local"] {
            width: 100%;
            padding: 12px;
            border-radius: 12px;
            border: 1px solid #d4c9ba;
            background: #fcfcfa;
            font-size: 16px;
            transition: 0.3s ease;
            box-sizing: border-box;
            color: #555;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="number"]:focus,
        input[type="datetime-local"]:focus {
            outline: none;
            border-color: #b8a894;
            background: #ffffff;
        }

        .row {
            display: flex;
            gap: 10px;
            flex-wrap:nowrap;
            margin-bottom: 0;
        }

        .col-md-6 {
           flex: 0 0 50%;
           max-width: 50%;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .btn-book {
            width: 100%;
            padding: 12px 22px;
            border-radius: 12px;
            cursor: pointer;
            font-size: 15px;
            font-weight: bold;
            transition: 0.25s ease;
            color: #5a5a5a;
            border: 3px solid #b8a894;
            background: #d4c5b9;
            margin-top: 10px;
        }

        .btn-book:hover {
            opacity: 0.9;
        }

        .btn-book:active {
            transform: scale(0.97);
        }

        .room-info-card {
            background: #faf8f3;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            border: 2px solid #e8e3d6;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
        }

        .room-info-card h5 {
            color: #4a4a4a;
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 1.1rem;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e8e3d6;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #555;
            font-weight: 500;
        }

        .info-value {
            color: #4a4a4a;
            font-weight: 600;
        }

        .alert {
            width: 100%;
            text-align: center;
            margin-bottom: 20px;
            padding: 12px;
            font-weight: bold;
            border-radius: 10px;
            font-size: 15px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid #d4c9ba;
        }

        .alert-success {
            background: #d4e8d4;
            color: #2d5a2d;
            border-color: #a8c9a8;
        }

        .alert-danger {
            background: #e5c9c9;
            color: #5a2d2d;
            border-color: #d1aeae;
        }

        .payment-badge {
            background: rgba(143, 167, 142, 0.35);
            color: #4a4a4a;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
            border: 1px solid #8fa78e;
        }

        .text-success {
            color: #5a8a5a !important;
        }

        .rooms-section {
            margin-bottom: 20px;
        }

        .room-entry {
            background: #faf8f3;
            border: 2px solid #e8e3d6;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            position: relative;
        }

        .room-entry-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .room-entry-title {
            color: #4a4a4a;
            font-weight: 600;
            font-size: 1rem;
        }

        .btn-remove-room {
            background: #e5c9c9;
            border: 2px solid #d1aeae;
            color: #5a5a5a;
            padding: 6px 12px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            font-weight: bold;
            transition: 0.25s ease;
        }

        .btn-remove-room:hover {
            opacity: 0.9;
        }

        .btn-add-room {
            width: 100%;
            padding: 10px 22px;
            border-radius: 12px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: 0.25s ease;
            color: #5a5a5a;
            border: 3px solid #a3b8c0;
            background: #c4d4d9;
            margin-bottom: 15px;
        }

        .btn-add-room:hover {
            opacity: 0.9;
        }

        .btn-add-room:active,
        .btn-remove-room:active {
            transform: scale(0.97);
        }

        .room-details {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .total-summary {
            background: #e8f5e9;
            border: 2px solid #a8c9a8;
            border-radius: 12px;
            padding: 15px 20px;
            margin-bottom: 20px;
            text-align: center;
        }

        .total-summary h4 {
            color: #2d5a2d;
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .total-amount {
            color: #1b3d1b;
            font-size: 1.8rem;
            font-weight: bold;
        }

        .btn-back {
            position: fixed;
            top: 20px;
            left: 20px;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: 0.25s ease;
            color: #5a5a5a;
            border: 2px solid #b8a894;
            background: #ffffff;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-back:hover {
            background: #f5f5f5;
            transform: translateY(-2px);
            box-shadow: 0 5px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-back:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <a href="Receptionist.php" class="btn-back">
        ← Back to Reception
    </a>
 
    <div class="booking-container">
        <div class="booking-header">
            <h2>🏨 Walk-in Booking</h2>
            <p>Complete the form below to book a room</p>
        </div>

        <?php if ($booking_message): ?>
            <div class="alert <?php echo $booking_status == 'success' ? 'alert-success' : 'alert-danger'; ?>" role="alert">
                <strong><?php echo $booking_status == 'success' ? '✓ Success!' : '✗ Error:'; ?></strong> 
                <?php echo $booking_message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" id="bookingForm">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="firstName">First Name</label>
                        <input type="text" id="firstName" name="first_name" 
                               placeholder="Juan" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" id="lastName" name="last_name" 
                               placeholder="Dela Cruz" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="emailAddress">Email Address</label>
                <input type="email" id="emailAddress" name="email_address" 
                       placeholder="juan@gmail.com" required>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="startDate">Check-in</label>
                        <input type="datetime-local" id="startDate" name="start_date" 
                               required onchange="updateCheckoutMin(); updateAllRoomTotals();">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="endDate">Check-out</label>
                        <input type="datetime-local" id="endDate" name="end_date" 
                               required onchange="updateAllRoomTotals();">
                    </div>
                </div>
            </div>

            <div class="rooms-section">
                <h5 style="color: #4a4a4a; margin-bottom: 15px; font-weight: 600;">Rooms to Book</h5>
                <div id="roomsContainer">
                </div>
                <button type="button" class="btn-add-room" onclick="addRoomEntry()">
                    ➕ Add Another Room
                </button>
            </div>

            <div class="total-summary" id="totalSummary" style="display: none;">
                <h4>Total Booking Amount</h4>
                <div class="total-amount" id="grandTotal">₱0.00</div>
                <div style="font-size: 0.9rem; color: #555; margin-top: 5px;">
                    <span id="roomCount">0</span> room(s) × <span id="nightCount">0</span> night(s)
                </div>
            </div>

            <button type="submit" name="SubmitBooking" class="btn-book">
                💰 Confirm Cash Payment & Book All Rooms
            </button>
        </form>
    </div>

    <script>
        const roomTypes = <?php echo json_encode($room_types); ?>;
        let roomCounter = 0;

        function getRoomTypeFromNumber(roomNumber) {
            const firstDigit = roomNumber.toString()[0];
            const typeMap = {
                '1': 1,
                '2': 2,
                '3': 3,
                '4': 4,
                '5': 5,
                '6': 6
            };
            return typeMap[firstDigit] || null;
        }

        function addRoomEntry() {
            roomCounter++;
            const container = document.getElementById('roomsContainer');
            
            const roomEntry = document.createElement('div');
            roomEntry.className = 'room-entry';
            roomEntry.id = 'roomEntry' + roomCounter;
            roomEntry.setAttribute('data-room-id', roomCounter);
            
            roomEntry.innerHTML = `
                <div class="room-entry-header">
                    <span class="room-entry-title">Room #${roomCounter}</span>
                    <button type="button" class="btn-remove-room" onclick="removeRoomEntry(${roomCounter})">
                        ✕ Remove
                    </button>
                </div>
                <div class="room-details">
                    <div class="form-group">
                        <label>Room Number (e.g., 101, 201)</label>
                        <input type="text" name="room_number[]" 
                               placeholder="Enter room number" 
                               onchange="lookupRoom(${roomCounter})" 
                               data-room-input="${roomCounter}">
                    </div>
                    <div style="background: #f0f0f0; padding: 10px; border-radius: 8px; display: none;" 
                         id="roomInfo${roomCounter}">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                            <span style="color: #666;">Room Type:</span>
                            <strong id="roomType${roomCounter}">-</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                            <span style="color: #666;">Rate/Night:</span>
                            <strong id="roomRate${roomCounter}">₱0</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: #666;">Total:</span>
                            <strong style="color: #5a8a5a;" id="roomTotal${roomCounter}">₱0.00</strong>
                        </div>
                    </div>
                    <input type="hidden" name="amount[]" id="amount${roomCounter}" value="0">
                </div>
            `;
            
            container.appendChild(roomEntry);
            updateGrandTotal();
        }

        function removeRoomEntry(roomId) {
            const entry = document.getElementById('roomEntry' + roomId);
            if (entry) {
                entry.remove();
                updateGrandTotal();
            }
        }

        function lookupRoom(roomId) {
            const input = document.querySelector(`[data-room-input="${roomId}"]`);
            const roomNumber = input.value;
            
            if (!roomNumber) return;

            const roomTypeId = getRoomTypeFromNumber(roomNumber);
            
            if (roomTypeId && roomTypes[roomTypeId]) {
                const roomType = roomTypes[roomTypeId];
                const roomPrice = parseFloat(roomType.room_price);
                
                document.getElementById('roomType' + roomId).textContent = roomType.room_type;
                document.getElementById('roomRate' + roomId).textContent = '₱' + roomPrice.toLocaleString();
                document.getElementById('roomInfo' + roomId).style.display = 'block';
                
                input.setAttribute('data-price', roomPrice);
                
                calculateRoomTotal(roomId);
            } else {
                alert('Invalid room number. First digit should be 1-6 (e.g., 101 for Single, 201 for Double)');
                document.getElementById('roomInfo' + roomId).style.display = 'none';
            }
        }

        function calculateRoomTotal(roomId) {
            const input = document.querySelector(`[data-room-input="${roomId}"]`);
            const roomPrice = parseFloat(input.getAttribute('data-price') || 0);
            
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            
            if (!startDate || !endDate || roomPrice === 0) return;
            
            const start = new Date(startDate);
            const end = new Date(endDate);
            const diffTime = Math.abs(end - start);
            const nights = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            if (nights > 0) {
                const total = roomPrice * nights;
                document.getElementById('roomTotal' + roomId).textContent = '₱' + total.toLocaleString();
                document.getElementById('amount' + roomId).value = total;
            }
            
            updateGrandTotal();
        }

        function updateAllRoomTotals() {
            const allRoomInputs = document.querySelectorAll('[data-room-input]');
            allRoomInputs.forEach(input => {
                const roomId = input.getAttribute('data-room-input');
                if (input.value && input.getAttribute('data-price')) {
                    calculateRoomTotal(roomId);
                }
            });
        }

        function updateGrandTotal() {
            const allAmounts = document.querySelectorAll('input[name="amount[]"]');
            let grandTotal = 0;
            let roomCount = 0;
            
            allAmounts.forEach(amountInput => {
                const amount = parseFloat(amountInput.value || 0);
                if (amount > 0) {
                    grandTotal += amount;
                    roomCount++;
                }
            });
            
            if (roomCount > 0) {
                document.getElementById('totalSummary').style.display = 'block';
                document.getElementById('grandTotal').textContent = '₱' + grandTotal.toLocaleString();
                document.getElementById('roomCount').textContent = roomCount;
                
                const startDate = document.getElementById('startDate').value;
                const endDate = document.getElementById('endDate').value;
                if (startDate && endDate) {
                    const start = new Date(startDate);
                    const end = new Date(endDate);
                    const nights = Math.ceil(Math.abs(end - start) / (1000 * 60 * 60 * 24));
                    document.getElementById('nightCount').textContent = nights;
                }
            } else {
                document.getElementById('totalSummary').style.display = 'none';
            }
        }

        function updateCheckoutMin() {
            const checkinValue = document.getElementById('startDate').value;
            if (!checkinValue) return;
            
            const checkin = new Date(checkinValue);
            const minCheckout = new Date(checkin);
            minCheckout.setDate(minCheckout.getDate() + 1);
            minCheckout.setHours(14, 0, 0, 0);
            
            const minCheckoutStr = formatDateTimeLocal(minCheckout);
            document.getElementById('endDate').min = minCheckoutStr;
            document.getElementById('endDate').value = minCheckoutStr;
        }

        function formatDateTimeLocal(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            return `${year}-${month}-${day}T${hours}:${minutes}`;
        }

        function setMinDates() {
            const now = new Date();
            const nowStr = formatDateTimeLocal(now);
            document.getElementById('startDate').min = nowStr;
            
            const checkin = new Date();
            checkin.setHours(11, 0, 0, 0);
            document.getElementById('startDate').value = formatDateTimeLocal(checkin);
            
            const checkout = new Date();
            checkout.setDate(checkout.getDate() + 1);
            checkout.setHours(14, 0, 0, 0);
            document.getElementById('endDate').value = formatDateTimeLocal(checkout);
        }

        document.getElementById('startDate').addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            selectedDate.setHours(11, 0, 0, 0);
            this.value = formatDateTimeLocal(selectedDate);
        });

        document.getElementById('endDate').addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            selectedDate.setHours(14, 0, 0, 0);
            this.value = formatDateTimeLocal(selectedDate);
        });

        setMinDates();
        addRoomEntry();

        <?php if ($booking_message && $booking_status == 'success'): ?>
        setTimeout(() => {
            if (confirm('Booking successful! Would you like to create another booking?')) {
                window.location.href = window.location.pathname;
            }
        }, 1000);
        <?php endif; ?>
    </script>
</body>
</html>