<?php 
ob_start(); 
include_once('config.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'emailwork/PHPMailer-master/src/Exception.php';
require 'emailwork/PHPMailer-master/src/PHPMailer.php';
require 'emailwork/PHPMailer-master/src/SMTP.php';

if (session_status() === PHP_SESSION_NONE) { session_start(); }

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first!'); window.location.href='login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];

// 1. DATA RECEIVE FROM FORM
$movie_id     = isset($_POST['movie_id']) ? intval($_POST['movie_id']) : 0;
$user_name    = mysqli_real_escape_string($conn, $_POST['user_name'] ?? 'User');
$user_email   = mysqli_real_escape_string($conn, $_POST['cust_email'] ?? ''); 
$seats        = mysqli_real_escape_string($conn, $_POST['selected_seats'] ?? 'N/A');
$total_amount = isset($_POST['final_amount']) ? intval($_POST['final_amount']) : 0;

// ✅ SAFETY CHECK: Agar form se email nahi mili, toh database se uthao
if (empty($user_email)) {
    $u_res = mysqli_query($conn, "SELECT email FROM users WHERE user_id = '$user_id'");
    if ($u_res && mysqli_num_rows($u_res) > 0) {
        $u_data = mysqli_fetch_assoc($u_res);
        $user_email = $u_data['email'];
    }
}

// Movie Title Fetch
$movie_title = "Movie Ticket";
$m_res = mysqli_query($conn, "SELECT title FROM movies WHERE movie_id = '$movie_id'");
if ($m_res && mysqli_num_rows($m_res) > 0) {
    $m_data = mysqli_fetch_assoc($m_res);
    $movie_title = $m_data['title'];
}

$payment_id = 0;

// 2. DATABASE INSERT & EMAIL LOGIC
if ($movie_id > 0) {
    $query = "INSERT INTO payments (movie_id, user_name, seats, amount, payment_status) 
              VALUES ('$movie_id', '$user_name', '$seats', '$total_amount', 'Paid')";
    
    if (mysqli_query($conn, $query)) {
        $payment_id = mysqli_insert_id($conn);

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'mominaasim666@gmail.com'; 
            $mail->Password   = 'uqwnpozecvpdrhsk'; // ✅ Working App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
            $mail->Port       = 465;
            $mail->SMTPDebug  = 0; 

            $mail->SMTPOptions = array(
                'ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true)
            );

            $mail->setFrom('mominaasim666@gmail.com', 'Movixo Cinemas');
            
            // ✅ Dynamic Email: Jo user login hai usi ko jaye
            if (!empty($user_email)) {
                $mail->addAddress($user_email); 
            }

            $mail->isHTML(true);
            $mail->Subject = 'Booking Confirmed - ' . $movie_title;
            $mail->Body    = "
                <div style='font-family: Arial; border: 2px solid #ff6b00; padding: 20px; border-radius: 15px;'>
                    <h2 style='color: #ff6b00;'>Booking Confirmed</h2>
                    <p>Dear <b>$user_name</b>, enjoy your movie.</p>
                    <p><b>Movie:</b> $movie_title | <b>Seats:</b> $seats</p>
                    <p><b>Booking ID:</b> #$payment_id</p>
                </div>";

            $mail->send();
        } catch (Exception $e) { }
    }
}

include_once('header.php'); 
?>

<style>
    body { margin: 0; font-family: 'Poppins', sans-serif; background: #000; color: white; }
    .receipt-wrapper { 
        min-height: 100vh; display: flex; align-items: center; justify-content: center; 
        background: linear-gradient(rgba(0,0,0,0.9), rgba(0,0,0,0.9)), 
                    url('https://img.freepik.com/free-photo/dark-vip-cinema-studio-still-life_23-2149500599.jpg');
        background-size: cover; background-position: center; padding: 20px;
    }
    .receipt-card {
        background: #111; max-width: 450px; width: 100%; padding: 40px; 
        border-radius: 25px; border: 1px solid #FF6B00; text-align: center;
        box-shadow: 0 30px 60px rgba(0,0,0,0.7);
    }
    .status-icon { width: 60px; height: 60px; border: 2px solid #FF6B00; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 30px; color: #FF6B00; }
    .movie-title { color: #FF6B00; font-size: 24px; font-weight: 800; text-transform: uppercase; margin-bottom: 20px; }
    .price-box { font-size: 28px; font-weight: 900; color: #FF6B00; margin: 20px 0; }
    .btn-ticket { display: block; width: 100%; padding: 15px; background: #fff; color: #000; text-decoration: none; border-radius: 10px; font-weight: 900; margin-top: 10px; transition: 0.3s; text-transform: uppercase; }
    .btn-ticket:hover { background: #FF6B00; color: white; }
</style>

<div class="receipt-wrapper">
    <div class="receipt-card">
        <div class="status-icon">✓</div>
        <h2 style="margin-bottom: 5px;">Booking Confirmed</h2>
        <p style="color: #666; font-size: 12px; margin-bottom: 20px;">Receipt ID: #<?= $payment_id ?></p>
        <div class="movie-title"><?= htmlspecialchars($movie_title) ?></div>
        <div class="price-box">PKR <?= number_format($total_amount) ?></div>
        <p style="font-size: 11px; color: #555;">Details sent to: <?= htmlspecialchars($user_email) ?></p>
        <a href="ticket.php?payment_id=<?= $payment_id ?>" class="btn-ticket">View Digital Ticket</a>
    </div>
</div>

<?php 
include_once('footer.php'); 
ob_end_flush(); 
?>