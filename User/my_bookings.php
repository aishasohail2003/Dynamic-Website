<?php 
session_start(); 
include('config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// UPDATED QUERY: Ab hum 'payments' table use kar rahe hain aur seedha 'movies' se join kar rahe hain
$query = "SELECT p.*, m.title as movie_title 
          FROM payments p 
          JOIN movies m ON p.movie_id = m.movie_id 
          WHERE p.user_name = (SELECT full_name FROM users WHERE user_id = '$user_id')
          ORDER BY p.id DESC";

$bookings = $conn->query($query);
include('header.php'); 
?>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800;900&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = { theme: { extend: { colors: { movixo: '#FF6B00' }, fontFamily: { 'poppins': ['Poppins', 'sans-serif'] } } } }
</script>

<div class="container mx-auto px-4 py-16 min-h-screen bg-black text-white font-poppins">
    <div class="mb-12 border-l-8 border-movixo pl-6">
        <h2 class="text-6xl font-extrabold tracking-tight uppercase leading-none">MY <span class="text-movixo">BOOKINGS</span></h2>
        <p class="text-gray-500 text-xs mt-3 font-bold uppercase tracking-[0.4em]">Manage Your Movie Tickets</p>
    </div>

    <div class="grid grid-cols-1 gap-6">
        <?php if ($bookings && $bookings->num_rows > 0): ?>
            <?php while($row = $bookings->fetch_assoc()): ?>
            <div class="group relative bg-[#111] border border-gray-800 rounded-3xl overflow-hidden hover:border-movixo/50 transition-all duration-300 shadow-2xl">
                <div class="p-8 md:p-10 flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="flex items-center gap-8 w-full md:w-auto">
                        <div class="w-20 h-20 bg-movixo rounded-2xl flex items-center justify-center text-black text-3xl shadow-[0_0_20px_rgba(255,107,0,0.3)]">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <div>
                            <h3 class="text-4xl font-bold uppercase tracking-tight mb-2 group-hover:text-movixo transition-colors"><?= htmlspecialchars($row['movie_title']) ?></h3>
                            <div class="flex flex-wrap gap-4 mt-1">
                                <span class="bg-gray-900 text-gray-400 text-[10px] font-bold px-3 py-1 rounded-md uppercase border border-gray-800">Seats: <?= $row['seats'] ?></span>
                                <span class="bg-gray-900 text-gray-400 text-[10px] font-bold px-3 py-1 rounded-md uppercase border border-gray-800">Date: <?= date('d M, Y', strtotime($row['booking_date'])) ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-10 w-full md:w-auto justify-between md:justify-end border-t md:border-t-0 border-gray-800 pt-6 md:pt-0">
                        <div class="text-left md:text-right">
                            <p class="text-gray-600 text-[10px] font-bold uppercase tracking-widest mb-1">Amount Paid</p>
                            <p class="text-4xl font-extrabold text-white tracking-tight"><span class="text-movixo text-xl mr-1">Rs.</span><?= number_format($row['amount']) ?></p>
                        </div>
                        <a href="ticket.php?payment_id=<?= $row['id'] ?>" class="bg-movixo hover:bg-white text-black font-extrabold px-10 py-5 rounded-2xl text-xs uppercase tracking-widest transition-all shadow-lg active:scale-95 inline-block">
                            Details
                        </a>
                    </div>
                </div>
                <div class="absolute top-0 right-10">
                    <div class="bg-green-600 text-black text-[9px] font-black px-6 py-1 rounded-b-lg uppercase"><?= $row['payment_status'] ?></div>
                </div>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="bg-[#111] p-24 text-center rounded-[3rem] border border-gray-800">
                <h3 class="text-white font-bold text-3xl uppercase">No Bookings Found</h3>
                <a href="index.php" class="bg-movixo text-black px-12 py-5 rounded-2xl font-bold inline-block mt-8 uppercase text-xs">Browse Movies</a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php include('footer.php'); ?>