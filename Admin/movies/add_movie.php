<?php 
// 1. Error Fix: Headers already sent fix karne ke liye ob_start aur session top par
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Database Connection
include_once __DIR__ . '/../../connection/config.php'; 

// 3. Data Fetching Logic
$is_edit = false;
$data = [
    'movie_id' => '', 'title' => '', 'genre' => '', 'duration' => '',
    'release_date' => '', 'status' => 'Active', 'trailer_url' => '',
    'description' => '', 'poster' => ''
];

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "SELECT * FROM movies WHERE movie_id = '$id'";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $is_edit = true;
    }
}

// 4. Header Include
include_once __DIR__ . '/../../inc/header.php';
?>

<div class="max-w-6xl mx-auto px-4 pb-20">
    
    <div class="flex justify-between items-center mb-8 border-b border-gray-900 pb-4">
        <h2 class="text-2xl font-black text-white uppercase italic tracking-tighter">
            <?= $is_edit ? 'Update <span class="text-red-600">Movie Intel</span>' : 'Deploy <span class="text-red-600">New Asset</span>' ?>
        </h2>
        <div class="flex items-center gap-2">
            <span class="text-[9px] font-black text-gray-600 uppercase tracking-[0.2em]">System Status</span>
            <span class="flex items-center gap-1.5 bg-black/50 px-3 py-1 rounded-full border border-gray-800">
                <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                <span class="text-[9px] font-bold text-white uppercase">Online</span>
            </span>
        </div>
    </div>

    <form action="process_movie.php" method="POST" enctype="multipart/form-data" class="space-y-6">
        
        <?php if ($is_edit): ?>
            <input type="hidden" name="movie_id" value="<?= $data['movie_id'] ?>">
            <input type="hidden" name="old_poster" value="<?= $data['poster'] ?>">
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Movie Title</label>
                <input type="text" name="title" value="<?= htmlspecialchars($data['title']) ?>" placeholder="Enter Title..." required
                    class="w-full bg-[#0a0a0a] border border-gray-900 rounded-xl py-4 px-5 text-white focus:border-red-600 outline-none transition-all">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Genre</label>
                <input type="text" name="genre" value="<?= htmlspecialchars($data['genre']) ?>" placeholder="Action, Sci-Fi..." required
                    class="w-full bg-[#0a0a0a] border border-gray-900 rounded-xl py-4 px-5 text-white focus:border-red-600 outline-none transition-all">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Duration (Min)</label>
                <input type="number" name="duration" value="<?= $data['duration'] ?>" placeholder="145" required
                    class="w-full bg-[#0a0a0a] border border-gray-900 rounded-xl py-4 px-5 text-white focus:border-red-600 outline-none transition-all">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Release Date</label>
                <input type="date" name="release_date" value="<?= $data['release_date'] ?>" required
                    class="w-full bg-[#0a0a0a] border border-gray-900 rounded-xl py-4 px-5 text-white focus:border-red-600 outline-none transition-all [color-scheme:dark]">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest">System Status</label>
                <select name="status" class="w-full bg-[#0a0a0a] border border-gray-900 rounded-xl py-4 px-5 text-white focus:border-red-600 outline-none appearance-none cursor-pointer">
                    <option value="Active" <?= ($data['status'] == 'Active') ? 'selected' : '' ?>>Active / Showing</option>
                    <option value="Inactive" <?= ($data['status'] == 'Inactive') ? 'selected' : '' ?>>Inactive / Standby</option>
                </select>
            </div>
        </div>

        <div class="space-y-2">
            <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest flex items-center gap-2">
                <i class="fab fa-youtube text-red-600"></i> Trailer URL (YouTube Link)
            </label>
            <input type="url" name="trailer_url" value="<?= htmlspecialchars($data['trailer_url'] ?? '') ?>" placeholder="https://www.youtube.com/watch?v=..."
                class="w-full bg-[#0a0a0a] border border-gray-900 rounded-xl py-4 px-5 text-white focus:border-red-600 outline-none transition-all italic text-sm">
        </div>

        <div class="space-y-2">
            <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Short Description</label>
            <textarea name="description" rows="5" placeholder="Enter a brief synopsis..."
                class="w-full bg-[#0a0a0a] border border-gray-900 rounded-2xl py-5 px-6 text-gray-400 focus:border-red-600 outline-none transition-all resize-none"><?= htmlspecialchars($data['description']) ?></textarea>
        </div>

        <div class="space-y-2">
            <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Movie Poster Asset</label>
            <div class="relative group h-44 w-full md:w-72 bg-[#0a0a0a] border-2 border-dashed border-gray-900 rounded-2xl flex flex-col items-center justify-center transition-all hover:border-red-600/40 overflow-hidden">
                <?php if (!empty($data['poster'])): ?>
                    <img id="posterPreview" src="../../uploads/posters/<?= $data['poster'] ?>" class="absolute inset-0 w-full h-full object-cover opacity-30 group-hover:opacity-50 transition-opacity">
                <?php else: ?>
                    <img id="posterPreview" class="absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity" />
                <?php endif; ?>
                <i class="fas fa-cloud-arrow-up text-gray-800 text-3xl mb-2 group-hover:text-red-600 transition-colors"></i>
                <span class="text-[9px] font-black text-gray-700 uppercase tracking-widest group-hover:text-gray-400">Upload Poster Asset</span>
                <input type="file" name="poster" id="posterInput" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
            </div>
        </div>

        <div class="pt-8">
            <button type="submit" name="<?= $is_edit ? 'update_movie' : 'add_movie' ?>" 
                class="w-full bg-red-600 hover:bg-red-700 text-white font-black py-5 rounded-2xl shadow-[0_15px_40px_rgba(220,38,38,0.2)] transition-all transform hover:-translate-y-1 uppercase tracking-[0.3em] text-[11px] flex items-center justify-center gap-4">
                <i class="fas <?= $is_edit ? 'fa-sync-alt' : 'fa-rocket' ?> text-xs"></i> 
                <span><?= $is_edit ? 'Update Movie Configuration' : 'Save Movie to Database' ?></span>
            </button>
        </div>

    </form>

<script>
    const posterInput = document.getElementById('posterInput');
    const posterPreview = document.getElementById('posterPreview');
    if (posterInput && posterPreview) {
        posterInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    posterPreview.src = e.target.result;
                    posterPreview.style.opacity = '1';
                };
                reader.readAsDataURL(file);
            }
        });
    }
</script>

</div>

<?php 
include_once __DIR__ . '/../../inc/footer.php'; 
ob_end_flush();
?>