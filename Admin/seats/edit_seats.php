<?php 
session_start(); 
include_once __DIR__ . '/../../connection/config.php'; 

// Security Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../User/login.php");
    exit();
}

$seat_id = $_GET['id'];
$seat = $conn->query("SELECT * FROM seats WHERE seat_id = $seat_id")->fetch_assoc();

if (isset($_POST['update_seat'])) {
    $seat_number = $_POST['seat_number'];
    $seat_type = $_POST['seat_type']; // e.g., VIP, Regular

    $sql = "UPDATE seats SET seat_number = '$seat_number', seat_type = '$seat_type' WHERE seat_id = $seat_id";
    if ($conn->query($sql)) {
        header("Location: manage_seat.php?success=updated");
        exit();
    }
}

include_once __DIR__ . '/../../inc/header.php'; 
?>

<div class="mb-10">
    <h2 class="text-4xl font-black text-white tracking-tighter uppercase italic">
        EDIT <span class="text-red-600">SEAT</span>
    </h2>
</div>

<div class="max-w-2xl bg-[#161616] border border-gray-800 p-8 rounded-3xl shadow-2xl">
    <form method="POST" class="space-y-6">
        <div>
            <label class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-2 block">Seat Number</label>
            <input type="text" name="seat_number" value="<?= $seat['seat_number'] ?>" class="w-full bg-black border border-gray-800 rounded-xl px-4 py-3 text-white focus:border-red-600 outline-none transition" required>
        </div>

        <div>
            <label class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-2 block">Seat Type</label>
            <select name="seat_type" class="w-full bg-black border border-gray-800 rounded-xl px-4 py-3 text-white focus:border-red-600 outline-none transition">
                <option value="Regular" <?= $seat['seat_type'] == 'Regular' ? 'selected' : '' ?>>Regular</option>
                <option value="VIP" <?= $seat['seat_type'] == 'VIP' ? 'selected' : '' ?>>VIP</option>
            </select>
        </div>

        <div class="flex gap-4">
            <button type="submit" name="update_seat" class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all">
                Update Seat
            </button>
            <a href="manage_seat.php" class="bg-gray-800 hover:bg-gray-700 text-white px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all text-center">
                Cancel
            </a>
        </div>
    </form>
</div>

<?php include_once __DIR__ . '/../../inc/footer.php'; ?>