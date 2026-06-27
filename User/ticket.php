<?php
include('config.php');
include('header.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit();
}

// Payment page se 'payment_id' ya 'booking_id' jo bhi aaye usay handle karein
// Try payment_id from GET; if missing, fallback to session-stored last payment or latest payment by user
$p_id = 0;
if (isset($_GET['payment_id'])) {
    $p_id = intval($_GET['payment_id']);
} elseif (isset($_GET['booking_id'])) {
    $p_id = intval($_GET['booking_id']);
} elseif (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If still no id, try session fallback
if (empty($p_id) && !empty($_SESSION['last_payment_id'])) {
    $p_id = intval($_SESSION['last_payment_id']);
}

// Final fallback: try to find most recent payment for this logged in user (by name if available)
if (empty($p_id) && !empty($_SESSION['full_name'])) {
    $safe_name = mysqli_real_escape_string($conn, $_SESSION['full_name']);
    $res = mysqli_query($conn, "SELECT id FROM payments WHERE user_name = '$safe_name' ORDER BY id DESC LIMIT 1");
    if ($res && mysqli_num_rows($res) > 0) {
        $p_row = mysqli_fetch_assoc($res);
        $p_id = intval($p_row['id']);
    }
}

// FINAL QUERY: Fetching from 'payments' table according to your DB structure
$sql = "SELECT p.*, m.title, t.ticket_number, t.status as t_status, t.issued_at
        FROM payments p
        INNER JOIN movies m ON p.movie_id = m.movie_id 
        LEFT JOIN tickets t ON p.id = t.booking_id 
        WHERE p.id = '$p_id' 
        LIMIT 1";

$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) :
    $data = mysqli_fetch_assoc($result);
    // Ticket number generate logic agar table mein na ho
    $t_no = !empty($data['ticket_number']) ? $data['ticket_number'] : "VIP-".str_pad($data['id'], 6, '0', STR_PAD_LEFT);
?>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;900&family=Libre+Barcode+128&display=swap" rel="stylesheet">

<style>
    body { background: linear-gradient(rgba(0,0,0,0.85), rgba(0,0,0,0.85)), 
                url('https://img.freepik.com/free-photo/dark-vip-cinema-studio-still-life_23-2149500599.jpg?semt=ais_hybrid&w=740&q=80');
    background-size: cover; color: #fff; font-family: 'Poppins', sans-serif; }
    .ticket-screen-container { 
        display: flex; flex-direction: column; align-items: center; 
        justify-content: center; min-height: 100vh; padding: 50px 20px; 
    }
    .cinema-ticket-card {
        display: flex; width: 100%; max-width: 800px; height: 320px;
        background: #111; border-radius: 20px; overflow: hidden;
        border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 30px 60px rgba(0,0,0,0.5);
    }
    .tkt-main-content { flex: 2; background: #181818; padding: 40px; position: relative; }
    .movie-display-title { font-size: 40px; font-weight: 900; text-transform: uppercase; margin: 0 0 20px 0; color: #fff; letter-spacing: -1px; }
    .ticket-details-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; }
    .detail-box b { font-size: 10px; color: #FF6B00; display: block; text-transform: uppercase; margin-bottom: 5px; }
    .detail-box span { font-size: 14px; font-weight: 600; }
    .ticket-stub-orange {
        flex: 0.8; background: #FF6B00; color: #000;
        display: flex; flex-direction: column; justify-content: space-between;
        align-items: center; padding: 30px 10px; border-left: 2px dashed #000;
    }
    .barcode-section { transform: rotate(-90deg); width: 180px; text-align: center; }
    .barcode-font-style { font-family: 'Libre Barcode 128', cursive; font-size: 70px; line-height: 1; margin: 0; }
    .print-btn {
        margin-top: 30px; background: #FF6B00; color: #000; padding: 15px 40px;
        border: none; border-radius: 10px; font-weight: 800; text-transform: uppercase;
        cursor: pointer; transition: 0.3s;
    }
    .back-home-link {
        margin-top: 20px; display: inline-flex; align-items: center; gap: 10px;
        color: #FF6B00; text-decoration: none; font-weight: 600; font-size: 16px;
        transition: 0.3s;
    }
    .back-home-link:hover {
        color: #fff; transform: translateX(-5px);
    }
    .back-home-link svg {
        width: 20px; height: 20px;
    }
    @media print { .no-print { display: none; } }
</style>

<div class="ticket-screen-container">
    <div class="cinema-ticket-card">
        <div class="tkt-main-content">
            <p style="color: #444; font-size: 10px; font-weight: 800; letter-spacing: 3px; margin-bottom: 5px;">PREMIUM ACCESS</p>
            <h1 class="movie-display-title"><?= htmlspecialchars($data['title']) ?></h1>
            <div class="ticket-details-grid">
                <div class="detail-box"><b>Date</b><span><?= date('d M, Y', strtotime($data['booking_date'])) ?></span></div>
                <div class="detail-box"><b>Payment ID</b><span>#<?= $data['id'] ?></span></div>
                <div class="detail-box"><b>Seats</b><span><?= $data['seats'] ?></span></div>
                <div class="detail-box"><b>Price</b><span>Rs. <?= number_format($data['amount'], 2) ?></span></div>
                <div class="detail-box"><b>Status</b><span style="color:#00ff00;"><?= strtoupper($data['payment_status']) ?></span></div>
                <div class="detail-box"><b>Issued At</b><span><?= !empty($data['issued_at']) ? date('h:i A', strtotime($data['issued_at'])) : date('h:i A') ?></span></div>
            </div>
        </div>
        <div class="ticket-stub-orange">
            <div style="text-align: center;">
                <p style="font-size: 10px; font-weight: 800; margin: 0;">SEAT</p>
                <p style="font-size: 32px; font-weight: 900; margin: 0;"><?= $data['seats'] ?></p>
            </div>
            <div class="barcode-section">
                <p class="barcode-font-style"><?= $t_no ?></p>
                <p style="font-size: 9px; font-weight: 700; margin-top: 5px;"><?= $t_no ?></p>
            </div>
            <p style="font-size: 9px; font-weight: 900; margin: 0;">MOVIXO</p>
        </div>
    </div>
    <button onclick="window.print()" class="print-btn no-print">Print E-Ticket</button>
    <a href="index.php" class="back-home-link no-print">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Back to Home
    </a>
</div>

<?php else: ?>
    <div style="text-align:center; padding:150px 20px; background:#000; color:#fff; min-height:100vh;">
        <h2 style="color: #FF6B00;">TICKET NOT FOUND</h2>
        <p>Record for ID #<?= $p_id ?> was not found in the payments table.</p>
        <a href="index.php" style="color:#fff; text-decoration:underline;">Go Back Home</a>
    </div>
<?php endif; ?>

<?php include('footer.php'); ?>