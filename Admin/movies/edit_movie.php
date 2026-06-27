<?php 
// Universal path logic
include_once __DIR__ . '/../../inc/header.php'; 

// ID check aur data fetch
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Movie details fetch karna
    $query = "SELECT * FROM movies WHERE movie_id = '$id'";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        
        // Trailer URL fetch karna (Trailers table se)
        $t_query = mysqli_query($conn, "SELECT trailer_url FROM trailers WHERE movie_id = '$id'");
        $t_data = mysqli_fetch_assoc($t_query);
        $current_trailer = $t_data['trailer_url'] ?? '';
    } else {
        echo "<script>alert('Movie not found!'); window.location.href='manage_movie.php';</script>";
        exit();
    }
} else {
    header("Location: manage_movie.php");
    exit();
}
?>

<div class="max-w-5xl mx-auto px-4 py-10">
    <div class="mb-10">
        <a href="manage_movie.php" class="text-gray-500 hover:text-red-500 transition-all flex items-center gap-2 text-xs uppercase font-bold tracking-widest mb-4">
            <i class="fas fa-arrow-left"></i> Back to Library
        </a>
        <h2 class="text-4xl font-black text-white tracking-tighter uppercase italic">
            Edit <span class="text-red-600">Movie Details</span>
        </h2>
    </div>

    <div class="bg-[#161616] border border-gray-800 rounded-3xl shadow-2xl overflow-hidden">
        <form action="process_movie.php" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
            <input type="hidden" name="movie_id" value="<?= $data['movie_id'] ?>">
            <input type="hidden" name="old_poster" value="<?= $data['poster'] ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase text-gray-500 tracking-widest">Movie Title</label>
                    <input type="text" name="title" value="<?= htmlspecialchars($data['title']) ?>" required 
                        class="w-full bg-black/50 border border-gray-800 rounded-2xl py-4 px-5 text-white focus:border-red-600 outline-none transition-all">
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase text-gray-500 tracking-widest">Genre</label>
                    <input type="text" name="genre" value="<?= htmlspecialchars($data['genre']) ?>" required 
                        class="w-full bg-black/50 border border-gray-800 rounded-2xl py-4 px-5 text-white focus:border-red-600 outline-none transition-all">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase text-gray-500 tracking-widest">Duration (Min)</label>
                    <input type="number" name="duration" value="<?= $data['duration'] ?>" required 
                        class="w-full bg-black/50 border border-gray-800 rounded-2xl py-4 px-5 text-white focus:border-red-600 outline-none transition-all">
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase text-gray-500 tracking-widest">Release Date</label>
                    <input type="date" name="release_date" value="<?= $data['release_date'] ?>" required 
                        class="w-full bg-black/50 border border-gray-800 rounded-2xl py-4 px-5 text-white focus:border-red-600 outline-none transition-all [color-scheme:dark]">
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase text-gray-500 tracking-widest">Status</label>
                    <select name="status" class="w-full bg-black/50 border border-gray-800 rounded-2xl py-4 px-5 text-white focus:border-red-600 outline-none cursor-pointer">
                        <option value="Active" <?= ($data['status'] == 'Active') ? 'selected' : '' ?>>Active</option>
                        <option value="Inactive" <?= ($data['status'] == 'Inactive') ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black uppercase text-gray-500 tracking-widest">Description</label>
                <textarea name="description" rows="4" 
                    class="w-full bg-black/50 border border-gray-800 rounded-2xl py-4 px-5 text-white focus:border-red-600 outline-none transition-all"><?= htmlspecialchars($data['description']) ?></textarea>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black uppercase text-gray-500 tracking-widest flex items-center gap-2">
                    <i class="fab fa-youtube text-red-600"></i> YouTube Trailer URL
                </label>
                <input type="text" name="trailer_url" value="<?= htmlspecialchars($current_trailer) ?>" 
                    placeholder="https://www.youtube.com/watch?v=..." 
                    class="w-full bg-black/50 border border-gray-800 rounded-2xl py-4 px-5 text-white focus:border-red-600 outline-none transition-all">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 items-center border-t border-gray-800 pt-8">
                <div class="md:col-span-1">
                    <p class="text-[10px] font-black uppercase text-gray-500 mb-3 tracking-widest">Current Poster</p>
                    <img src="../../uploads/posters/<?= $data['poster'] ?>" class="w-full h-48 object-cover rounded-2xl border border-gray-800 shadow-xl">
                </div>
                <div class="md:col-span-3 space-y-3">
                    <label class="text-[10px] font-black uppercase text-gray-500 tracking-widest text-red-600">Change Poster (Leave blank to keep current)</label>
                    <input type="file" name="poster" class="w-full bg-black/50 border border-gray-800 rounded-2xl py-4 px-5 text-white cursor-pointer file:bg-red-600 file:border-none file:text-white file:rounded-lg file:px-4 file:py-1 file:mr-4 hover:file:bg-red-700">
                </div>
            </div>

            <button type="submit" name="update_movie" 
                class="w-full bg-gradient-to-r from-red-600 to-red-800 text-white font-black py-5 rounded-2xl shadow-xl hover:from-red-700 hover:to-red-900 transition-all transform hover:-translate-y-1 uppercase tracking-widest text-sm flex items-center justify-center gap-3">
                <i class="fas fa-sync-alt"></i> Update Movie Configuration
            </button>
        </form>
    </div>
</div>

<?php include_once __DIR__ . '/../../inc/footer.php'; ?>