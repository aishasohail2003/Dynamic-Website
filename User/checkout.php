<?php 
include('config.php'); 
include('header.php'); 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- 1. LOGIN CHECK ---
if (!isset($_SESSION['user_id'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['selected_seats'])) {
        $_SESSION['booking_data'] = [
            'movie_id' => $_POST['movie_id'] ?? '',
            'selected_seats' => $_POST['selected_seats'] ?? '',
            'total_amount' => $_POST['total_amount'] ?? '',
        ];
        $_SESSION['redirect_after_login'] = 'checkout';
    }
    
    echo "<script>
            alert('Please log in to proceed with your booking!');
            window.location.href='login.php';
          </script>";
    exit();
}

/**
 * 2. DATA VALIDATION & RESTORATION
 */
if (isset($_SESSION['booking_data']) && isset($_SESSION['redirect_after_login']) && $_SESSION['redirect_after_login'] == 'checkout') {
    $movie_id = intval($_SESSION['booking_data']['movie_id']);
    $seats = mysqli_real_escape_string($conn, $_SESSION['booking_data']['selected_seats']);
    $total_amount = intval($_SESSION['booking_data']['total_amount']);
    
    unset($_SESSION['booking_data']);
    unset($_SESSION['redirect_after_login']);
} 
elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['selected_seats']) && !empty($_POST['selected_seats'])) {
    $movie_id = intval($_POST['movie_id']);
    $seats = mysqli_real_escape_string($conn, $_POST['selected_seats']);
    $total_amount = intval($_POST['total_amount']);
} 
else {
    echo "<div style='background:#000; color:white; height:80vh; display:flex; flex-direction:column; justify-content:center; align-items:center;'>
            <h3>No seats selected!</h3>
            <p>Please go back and select your seats.</p>
            <a href='index.php' style='color:#ff6b00; text-decoration:none; border:1px solid #ff6b00; padding:10px 20px; border-radius:5px;'>Go Back</a>
          </div>";
    include('footer.php');
    exit();
}

$u_name = $_SESSION['full_name'] ?? '';
$u_email = $_SESSION['email'] ?? '';

$movie_name = "Selected Movie";
$m_query = mysqli_query($conn, "SELECT title FROM movies WHERE movie_id = '$movie_id'");
if($m_query && mysqli_num_rows($m_query) > 0) {
    $m_data = mysqli_fetch_assoc($m_query);
    $movie_name = $m_data['title'];
}
?>

<style>
    .checkout-body {
        margin: 0; padding: 60px 20px; min-height: 85vh;
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(rgba(0,0,0,0.85), rgba(0,0,0,0.85)), 
                    url('https://img.freepik.com/free-photo/dark-vip-cinema-studio-still-life_23-2149500599.jpg?semt=ais_hybrid&w=740&q=80');
        background-size: cover; background-position: center; background-attachment: fixed;
        display: flex; justify-content: center; align-items: center;
    }
    .checkout-card {
        max-width: 450px; width: 100%; background: rgba(20, 20, 20, 0.98);
        padding: 40px; border-radius: 15px; border: 1px solid #333;
        box-shadow: 0 20px 50px rgba(0,0,0,0.8);
    }
    .info-box { background: #111; padding: 15px; border-radius: 8px; margin-bottom: 25px; border-left: 4px solid #ff6b00; }
    .form-group { margin-bottom: 15px; text-align: left; }
    .form-group label { color: #888; font-size: 11px; text-transform: uppercase; display: block; margin-bottom: 5px; }
    .form-group input { width: 100%; padding: 12px; background: #222; border: 1px solid #444; color: white; border-radius: 6px; outline: none; box-sizing: border-box; }
    .form-group input:focus { border-color: #ff6b00; }
    .confirm-btn { width: 100%; padding: 15px; background: linear-gradient(45deg, #ff0000, #ff7300); border: none; color: white; font-weight: bold; border-radius: 8px; cursor: pointer; text-transform: uppercase; transition: 0.3s; margin-top: 10px; }
    .confirm-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(255, 107, 0, 0.4); }
</style>

<div class="checkout-body">
    <div class="checkout-card">
        <h2 style="color:#ff6b00; text-align:center; text-transform:uppercase; margin:0 0 20px 0;">Checkout</h2>
        
        <div class="info-box">
            <p style="margin: 5px 0; color: #eee; font-size: 14px;">Movie: <span style="float:right; font-weight:bold;"><?php echo htmlspecialchars($movie_name); ?></span></p>
            <p style="margin: 5px 0; color: #eee; font-size: 14px;">Seats: <span style="float:right; color:#ff6b00; font-weight:bold;"><?php echo htmlspecialchars($seats); ?></span></p>
            <p style="margin: 5px 0; color: #eee; font-size: 14px;">Total Payable: <span style="float:right; color:#ff6b00; font-weight:bold;">Rs <?php echo number_format($total_amount); ?></span></p>
        </div>

        <form action="payment.php" method="POST">
            <input type="hidden" name="movie_id" value="<?php echo $movie_id; ?>">
            <input type="hidden" name="selected_seats" value="<?php echo htmlspecialchars($seats); ?>">
            <input type="hidden" name="final_amount" value="<?php echo $total_amount; ?>">

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="user_name" value="<?php echo htmlspecialchars($u_name); ?>" required placeholder="Enter your name">
            </div>
            
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="cust_email" value="<?php echo htmlspecialchars($u_email); ?>" required placeholder="email@example.com">
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="tel" 
                       name="cust_phone" 
                       required 
                       placeholder="03XXXXXXXXX"
                       pattern="03[0-9]{9}" 
                       maxlength="11"
                       title="Please enter a valid 11-digit number starting with 03"
                       oninput="this.value = this.value.replace(/[^0-9]/g, '');">
            </div>

            <button type="submit" class="confirm-btn">CONFIRM & PAY NOW</button>
            
        </form>
    </div>
</div>

<?php include('footer.php'); ?>