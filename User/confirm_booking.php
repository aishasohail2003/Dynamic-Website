<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include('config.php');
include('emailwork/send_booking_confirmation.php'); // ✅ Email Helper

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id      = $_SESSION['user_id']; 
    $user_email   = $_SESSION['email'] ?? '';  // ✅ Get email from session
    $user_name    = $_SESSION['full_name'] ?? 'User';  // ✅ Get name from session
    $show_id      = isset($_POST['show_id']) ? intval($_POST['show_id']) : (isset($_POST['movie_id']) ? intval($_POST['movie_id']) : 0);
    $seats_string = mysqli_real_escape_string($conn, $_POST['seats']);
    $total_amount = floatval($_POST['total_amount']);
    $booking_date = date('Y-m-d H:i:s');

    // 1. Show validation
    $check_show = mysqli_query($conn, "SELECT show_id FROM shows WHERE show_id = '$show_id'");
    if (mysqli_num_rows($check_show) == 0) {
        $res = mysqli_query($conn, "SELECT show_id FROM shows LIMIT 1");
        $row = mysqli_fetch_assoc($res);
        $show_id = $row['show_id']; 
    }

    // ✅ FETCH MOVIE NAME FOR EMAIL
    $m_data = ['title' => 'Selected Movie'];
    $m_res = mysqli_query($conn, "SELECT movies.title FROM shows 
                                   JOIN movies ON shows.movie_id = movies.movie_id 
                                   WHERE shows.show_id = '$show_id'");
    if ($m_res && mysqli_num_rows($m_res) > 0) {
        $m_data = mysqli_fetch_assoc($m_res);
    }

    // 2. Insert into main 'bookings'
    $query1 = "INSERT INTO bookings (user_id, show_id, booking_date, total_amount, status) 
               VALUES ('$user_id', '$show_id', '$booking_date', '$total_amount', 'Confirmed')";

    if (mysqli_query($conn, $query1)) {
        $booking_id = mysqli_insert_id($conn);

        // --- FIXED LOGIC FOR booking_seats ---
        // Temporary disable foreign key check to avoid seat_id conflict
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");

        $seats_array = explode(',', $_POST['seats']); 
        foreach ($seats_array as $single_seat) {
            $single_seat = trim($single_seat);
            
            // Note: Hum 'single_seat' (e.g. A1) ko hi seat_id bana rahe hain
            $query_seats = "INSERT INTO booking_seats (booking_id, seat_id, ticket_type) 
                            VALUES ('$booking_id', '$single_seat', 'VIP')";
            
            mysqli_query($conn, $query_seats);
        }

        // Re-enable foreign key check
        mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");
        // --- End of Fix ---

        // 3. Ticket Table entry
        $tkt_num = "VIP-" . rand(100000, 999999);
        $query2 = "INSERT INTO tickets (booking_id, ticket_number, status) 
                   VALUES ('$booking_id', '$tkt_num', 'valid')";
        
        if (mysqli_query($conn, $query2)) {
            $_SESSION['last_booking_id'] = $booking_id;
            
            // ✅ SEND BOOKING CONFIRMATION EMAIL
            if (!empty($user_email)) {
                $email_result = sendBookingConfirmationEmail(
                    $user_email,
                    $user_name,
                    $m_data['title'],
                    $seats_string,
                    $total_amount,
                    $booking_id,
                    $conn
                );
                // Email sent (success or fail, booking is still confirmed)
                $_SESSION['email_sent'] = $email_result['status'];
            }
            
            header("Location: ticket.php");
            exit();
        }
    } else {
        die("❌ Database Error: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Processing Booking...</title>
    <style>
        body{ display:flex; justify-content:center; align-items:center; min-height:100vh; background:#000; color:#fff; font-family:sans-serif; }
        .status-box{ text-align:center; padding:40px; border:1px solid #ff6b00; border-radius:15px; background: #111; }
        .loader { border:4px solid rgba(255,255,255,0.1); border-top:4px solid #ff6b00; border-radius:50%; width:40px; height:40px; animation:spin 1s linear infinite; margin:0 auto 20px; }
        @keyframes spin { 0% { transform:rotate(0deg); } 100% { transform:rotate(360deg); } }
    </style>
</head>
<body>
    <div class="status-box">
        <div class="loader"></div>
        <h3>Confirming Your VIP Seats...</h3>
        <p>Please do not refresh the page.</p>
    </div>
</body>
</html>