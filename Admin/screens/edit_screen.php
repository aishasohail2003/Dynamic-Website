<?php 
include_once __DIR__ . '/../../inc/header.php'; 

// ID check
if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $result = mysqli_query($conn, "SELECT * FROM screens WHERE screen_id = '$id'");
    $data = mysqli_fetch_assoc($result);

    if(!$data) {
        echo "<script>alert('Screen not found!'); window.location.href='manage_screens.php';</script>";
        exit();
    }
} else {
    header("Location: manage_screens.php");
    exit();
}
?>

<div class="max-w-4xl mx-auto">
    <div class="mb-10 text-center">
        <h2 class="text-4xl font-black text-white tracking-tighter uppercase italic">EDIT <span class="text-red-600">SCREEN</span></h2>
    </div>

    <div class="bg-[#161616] border border-gray-800 rounded-[30px] shadow-2xl overflow-hidden">
        <form action="process_screen.php" method="POST" class="p-10 space-y-8">
            <input type="hidden" name="screen_id" value="<?= $data['screen_id'] ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Assign Theatre</label>
                    <div class="relative">
                        <select name="theatre_id" required class="w-full bg-black/50 border border-gray-800 rounded-2xl py-4 px-5 text-white focus:border-red-600 outline-none appearance-none cursor-pointer">
                            <option value="">Choose a Theatre...</option>
                            
                            <option value="1" <?= ($data['theatre_id'] == '1') ? 'selected' : '' ?>>Nueplex Cinemas - DHA</option>
                            <option value="2" <?= ($data['theatre_id'] == '2') ? 'selected' : '' ?>>Cinepax - Ocean Mall</option>
                            <option value="3" <?= ($data['theatre_id'] == '3') ? 'selected' : '' ?>>Atrium Mall - Saddar</option>
                            <option value="4" <?= ($data['theatre_id'] == '4') ? 'selected' : '' ?>>The Arena - Bahria Town</option>
                            <option value="5" <?= ($data['theatre_id'] == '5') ? 'selected' : '' ?>>Universal Cinemas - Emporium</option>
                            <option value="6" <?= ($data['theatre_id'] == '6') ? 'selected' : '' ?>>Mega Cinema - City Center</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-gray-600 pointer-events-none text-xs"></i>
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Screen Name</label>
                    <input type="text" name="screen_name" value="<?= $data['screen_name'] ?>" required 
                        class="w-full bg-black/50 border border-gray-800 rounded-2xl py-4 px-5 text-white focus:border-red-600 outline-none">
                </div>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Total Seats</label>
                <input type="number" name="total_seats" value="<?= $data['total_seats'] ?>" required 
                    class="w-full bg-black/50 border border-gray-800 rounded-2xl py-4 px-5 text-white focus:border-red-600 outline-none">
            </div>

            <button type="submit" name="update_screen" class="w-full bg-red-600 text-white font-black py-5 rounded-2xl uppercase tracking-widest text-sm shadow-xl hover:bg-red-700 transition-all">
                Update Configuration
            </button>
        </form>
    </div>
</div>

<?php include_once __DIR__ . '/../../inc/footer.php'; ?>