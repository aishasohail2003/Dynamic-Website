<?php include_once __DIR__ . '/../../inc/header.php'; ?>

<div class="max-w-4xl mx-auto px-4 py-10">
    <div class="mb-10 text-center">
        <h2 class="text-4xl font-black text-white tracking-tighter uppercase italic">SCHEDULE <span class="text-red-600">NEW SHOW</span></h2>
        <p class="text-gray-500 text-xs font-bold uppercase tracking-[0.3em] mt-2">Validation Enabled • Real-time Conflict Check</p>
    </div>

    <div class="bg-[#161616] border border-gray-800 rounded-[30px] shadow-2xl overflow-hidden border-t-4 border-t-red-600">
        <form action="process_shows.php" method="POST" class="p-10 space-y-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase text-gray-500 tracking-widest italic flex items-center gap-2">
                        <i class="fas fa-film text-red-600"></i> 1. Select Movie
                    </label>
                    <select name="movie_id" required class="w-full bg-black border border-gray-800 rounded-2xl py-4 px-5 text-white focus:border-red-600 outline-none transition-all">
                        <option value="">-- Choose Movie --</option>
                        <?php 
                        $movies = mysqli_query($conn, "SELECT movie_id, title FROM movies");
                        while($m = mysqli_fetch_assoc($movies)) echo "<option value='".$m['movie_id']."'>".$m['title']."</option>";
                        ?>
                    </select>
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase text-gray-500 tracking-widest italic flex items-center gap-2">
                        <i class="fas fa-building text-red-600"></i> 2. Select Theatre
                    </label>
                    <select name="theatre_id" required class="w-full bg-black border border-gray-800 rounded-2xl py-4 px-5 text-white focus:border-red-600 outline-none transition-all">
                        <option value="">-- Choose Theatre --</option>
                        <?php 
                        $theatres = mysqli_query($conn, "SELECT theatre_id, name FROM theatres");
                        while($t = mysqli_fetch_assoc($theatres)) echo "<option value='".$t['theatre_id']."'>".$t['name']."</option>";
                        ?>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase text-gray-500 tracking-widest italic flex items-center gap-2">
                        <i class="fas fa-desktop text-red-600"></i> 3. Choose Screen
                    </label>
                    <select name="screen_id" required class="w-full bg-black border border-gray-800 rounded-2xl py-4 px-5 text-white focus:border-red-600 outline-none transition-all">
                        <option value="">-- Select Screen --</option>
                        <?php 
                        $screens = mysqli_query($conn, "SELECT screen_id, screen_name FROM screens");
                        while($s = mysqli_fetch_assoc($screens)) echo "<option value='".$s['screen_id']."'>".$s['screen_name']."</option>";
                        ?>
                    </select>
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase text-gray-500 tracking-widest italic flex items-center gap-2">
                        <i class="fas fa-calendar-alt text-red-600"></i> 4. Show Date
                    </label>
                    <input type="date" name="show_date" min="<?= date('Y-m-d') ?>" required class="w-full bg-black border border-gray-800 rounded-2xl py-4 px-5 text-white focus:border-red-600 outline-none transition-all [color-scheme:dark]">
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase text-gray-500 tracking-widest italic flex items-center gap-2">
                        <i class="fas fa-clock text-red-600"></i> 5. Show Time
                    </label>
                    <input type="time" name="show_time" required class="w-full bg-black border border-gray-800 rounded-2xl py-4 px-5 text-white focus:border-red-600 outline-none transition-all [color-scheme:dark]">
                </div>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black uppercase text-gray-500 tracking-widest italic flex items-center gap-2">
                    <i class="fas fa-tags text-red-600"></i> 6. Ticket Price (PKR)
                </label>
                <input type="number" name="ticket_price" min="1" placeholder="e.g. 1000" required class="w-full bg-black border border-gray-800 rounded-2xl py-4 px-5 text-white focus:border-red-600 outline-none transition-all">
            </div>

            <button type="submit" name="add_showtime" class="w-full bg-red-600 text-white font-black py-5 rounded-2xl uppercase tracking-[0.3em] text-xs hover:bg-red-700 transition-all shadow-2xl shadow-red-600/30">
                Verify & Schedule Show
            </button>
        </form>
    </div>
</div>

<?php include_once __DIR__ . '/../../inc/footer.php'; ?>