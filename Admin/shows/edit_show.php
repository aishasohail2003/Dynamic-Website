<?php 
include_once __DIR__ . '/../../connection/config.php'; 
include_once __DIR__ . '/../../inc/header.php'; 

// 1. ID validate karein
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>window.location.href='manage_show.php';</script>";
    exit();
}

$show_id = mysqli_real_escape_string($conn, $_GET['id']);

// 2. Existing Data fetch karein
$query = "SELECT * FROM shows WHERE show_id = '$show_id'";
$res = mysqli_query($conn, $query);
$show_data = mysqli_fetch_assoc($res);

if (!$show_data) {
    echo "<script>alert('Show not found!'); window.location.href='manage_show.php';</script>";
    exit();
}
?>

<div class="max-w-4xl mx-auto px-4 py-10">
    <div class="mb-10 text-center">
        <h2 class="text-4xl font-black text-white tracking-tighter uppercase italic">EDIT <span class="text-red-600">SHOW</span></h2>
        <p class="text-gray-500 text-xs font-bold uppercase tracking-[0.3em] mt-2">Modify Schedule • Conflict Check Active</p>
    </div>

    <div class="bg-[#161616] border border-gray-800 rounded-[30px] shadow-2xl overflow-hidden border-t-4 border-t-red-600">
        <form action="process_shows.php" method="POST" class="p-10 space-y-8">
            <input type="hidden" name="show_id" value="<?= $show_data['show_id'] ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase text-gray-500 tracking-widest italic">1. Movie</label>
                    <select name="movie_id" required class="w-full bg-black border border-gray-800 rounded-2xl py-4 px-5 text-white focus:border-red-600 outline-none">
                        <?php 
                        $movies = mysqli_query($conn, "SELECT movie_id, title FROM movies");
                        while($m = mysqli_fetch_assoc($movies)) {
                            $sel = ($m['movie_id'] == $show_data['movie_id']) ? 'selected' : '';
                            echo "<option value='".$m['movie_id']."' $sel>".$m['title']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase text-gray-500 tracking-widest italic">2. Theatre</label>
                    <select name="theatre_id" required class="w-full bg-black border border-gray-800 rounded-2xl py-4 px-5 text-white focus:border-red-600 outline-none">
                        <?php 
                        $theatres = mysqli_query($conn, "SELECT theatre_id, name FROM theatres");
                        while($t = mysqli_fetch_assoc($theatres)) {
                            $sel = ($t['theatre_id'] == $show_data['theatre_id']) ? 'selected' : '';
                            echo "<option value='".$t['theatre_id']."' $sel>".$t['name']."</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase text-gray-500 tracking-widest italic">3. Screen</label>
                    <select name="screen_id" required class="w-full bg-black border border-gray-800 rounded-2xl py-4 px-5 text-white focus:border-red-600 outline-none">
                        <?php 
                        $screens = mysqli_query($conn, "SELECT screen_id, screen_name FROM screens");
                        while($s = mysqli_fetch_assoc($screens)) {
                            $sel = ($s['screen_id'] == $show_data['screen_id']) ? 'selected' : '';
                            echo "<option value='".$s['screen_id']."' $sel>".$s['screen_name']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase text-gray-500 tracking-widest italic">4. Date</label>
                    <input type="date" name="show_date" value="<?= $show_data['show_date'] ?>" min="<?= date('Y-m-d') ?>" required class="w-full bg-black border border-gray-800 rounded-2xl py-4 px-5 text-white focus:border-red-600 [color-scheme:dark]">
                </div>
                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase text-gray-500 tracking-widest italic">5. Time</label>
                    <input type="time" name="show_time" value="<?= date('H:i', strtotime($show_data['show_time'])) ?>" required class="w-full bg-black border border-gray-800 rounded-2xl py-4 px-5 text-white focus:border-red-600 [color-scheme:dark]">
                </div>
            </div>

            <button type="submit" name="update_showtime" class="w-full bg-amber-600 hover:bg-amber-700 text-white font-black py-5 rounded-2xl uppercase tracking-[0.2em] shadow-xl transition-all transform hover:-translate-y-1">
                Update Schedule Settings
            </button>
        </form>
    </div>
</div>
<?php include_once __DIR__ . '/../../inc/footer.php'; ?>