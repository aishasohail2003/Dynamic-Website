<?php 
include_once __DIR__ . '/../../inc/header.php'; 
?>

<div class="flex justify-between items-center mb-10">
    <div>
        <h2 class="text-4xl font-black text-white tracking-tighter uppercase italic">MOVIE <span class="text-red-600">LIBRARY</span></h2>
        <p class="text-gray-500 text-sm font-medium mt-1">Manage your cinema's movie collection and show statuses.</p>
    </div>
    <a href="add_movie.php" class="bg-red-600 hover:bg-red-700 text-white px-8 py-3.5 rounded-2xl font-black flex items-center gap-3 transition-all transform hover:-translate-y-1 shadow-xl shadow-red-600/20 uppercase text-xs tracking-widest">
        <i class="fas fa-plus"></i> Add Movie
    </a>
</div>

<div class="bg-[#111111] border border-gray-800/50 rounded-[30px] overflow-hidden shadow-2xl">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-white/[0.02] border-b border-gray-800/50">
                <th class="p-6 text-[11px] uppercase font-black text-gray-500 tracking-[0.2em]">Movie Poster & Details</th>
                <th class="p-6 text-[11px] uppercase font-black text-gray-500 tracking-[0.2em]">Genre & Info</th>
                <th class="p-6 text-[11px] uppercase font-black text-gray-500 tracking-[0.2em]">Release</th>
                <th class="p-6 text-[11px] uppercase font-black text-gray-500 tracking-[0.2em]">Status</th>
                <th class="p-6 text-[11px] uppercase font-black text-gray-500 tracking-[0.2em] text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-800/40">
            <?php
            $res = mysqli_query($conn, "SELECT * FROM movies ORDER BY movie_id DESC");
            if(mysqli_num_rows($res) > 0) {
                while($row = mysqli_fetch_assoc($res)) {
                    // Status styling logic
                    $status_bg = (strtolower($row['status']) == 'active') ? 'bg-green-500/10 text-green-500 border-green-500/20' : 'bg-red-500/10 text-red-500 border-red-500/20';
                    
                    // Path Fix: Kyunki manage_movie.php 'movies' folder mein hai, 
                    // aur images 'movies/uploads/posters/' mein hain.
                    $poster_path = "../../uploads/posters/" . $row['poster'];
            ?>
            <tr class="hover:bg-white/[0.03] transition-all duration-300 group">
                <td class="p-6">
                    <div class="flex items-center gap-6">
                        <div class="relative w-[70px] h-[100px] shrink-0">
                            <div class="absolute inset-0 bg-red-600/20 blur-xl rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            
                            <div class="relative w-full h-full rounded-[15px] overflow-hidden border border-gray-700/50 bg-[#0a0a0a] shadow-xl">
                                <?php if(!empty($row['poster']) && file_exists($poster_path)): ?>
                                    <img src="<?= $poster_path ?>" alt="Poster" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center bg-gray-900">
                                        <i class="fas fa-film text-gray-700"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div>
                            <div class="font-black text-white text-lg tracking-tight group-hover:text-red-500 transition-colors uppercase italic"><?= htmlspecialchars($row['title']) ?></div>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-[9px] bg-white/5 text-gray-400 px-2 py-0.5 rounded border border-gray-800 font-mono tracking-tighter">HD 4K</span>
                                <span class="text-[10px] text-gray-600 font-black uppercase tracking-widest">UID-0<?= $row['movie_id'] ?></span>
                            </div>
                        </div>
                    </div>
                </td>
                
                <td class="p-6">
                    <div class="text-sm text-gray-300 font-bold tracking-wide uppercase"><?= htmlspecialchars($row['genre']) ?></div>
                    <div class="text-[11px] text-gray-500 mt-2 flex items-center gap-2 font-black">
                        <span class="p-1 bg-red-600/10 rounded text-red-500"><i class="fas fa-clock"></i></span> 
                        <?= $row['duration'] ?> MINUTES
                    </div>
                </td>

                <td class="p-6">
                    <div class="text-sm text-gray-400 font-bold italic tracking-tighter">
                        <?= date('d M, Y', strtotime($row['release_date'])) ?>
                    </div>
                </td>

                <td class="p-6">
                    <span class="border <?= $status_bg ?> px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-[0.1em]">
                        <?= $row['status'] ?>
                    </span>
                </td>

                <td class="p-6">
                    <div class="flex justify-center items-center gap-3">
                        <a href="edit_movie.php?id=<?= $row['movie_id'] ?>" class="w-10 h-10 rounded-xl bg-blue-500/5 text-blue-500 flex items-center justify-center hover:bg-blue-500 hover:text-white transition-all border border-blue-500/10">
                            <i class="fas fa-edit text-xs"></i>
                        </a>
                        <a href="process_movie.php?delete_id=<?= $row['movie_id'] ?>" onclick="return confirm('Remove this masterpiece?')" class="w-10 h-10 rounded-xl bg-red-500/5 text-red-500 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all border border-red-500/10">
                            <i class="fas fa-trash-alt text-xs"></i>
                        </a>
                    </div>
                </td>
            </tr>
            <?php 
                }
            } else {
                echo "<tr><td colspan='5' class='p-20 text-center text-gray-800 font-black uppercase tracking-[0.5em] opacity-30'>Library Empty</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include_once __DIR__ . '/../../inc/footer.php'; ?>