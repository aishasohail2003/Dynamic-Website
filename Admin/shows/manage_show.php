<?php 
include_once __DIR__ . '/../../inc/header.php'; 
?>

<div class="px-8 py-10">
    <div class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-4xl font-black text-white tracking-tighter uppercase italic">MANAGE <span class="text-red-600">SHOWS</span></h2>
            <p class="text-gray-500 text-sm font-medium mt-1 uppercase tracking-widest">View and control your cinema schedule.</p>
        </div>
        <a href="add_show.php" class="bg-red-600 hover:bg-red-700 text-white px-8 py-3.5 rounded-2xl font-black uppercase text-xs tracking-widest transition-all shadow-xl shadow-red-600/20">
            <i class="fas fa-plus mr-2"></i> Add New Show
        </a>
    </div>

    <div class="bg-[#161616] border border-gray-800 rounded-[30px] overflow-hidden shadow-2xl">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white/5 border-b border-gray-800 text-[10px] uppercase font-black text-gray-500 tracking-widest">
                    <th class="p-6">Movie</th>
                    <th class="p-6">Cinema & Screen</th>
                    <th class="p-6">Date & Time</th>
                    <th class="p-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                <?php
                // Query to fetch shows with movie, theatre, and screen details
                $sql = "SELECT s.*, m.title as movie_title, m.poster, 
                               t.name as theatre_name, t.city, 
                               sc.screen_name 
                        FROM shows s
                        JOIN movies m ON s.movie_id = m.movie_id 
                        JOIN theatres t ON s.theatre_id = t.theatre_id 
                        JOIN screens sc ON s.screen_id = sc.screen_id 
                        ORDER BY s.show_date DESC, s.show_time ASC";

                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr class="hover:bg-white/[0.02] transition-colors group">
                    <td class="p-6">
                        <div class="flex items-center gap-4">
                            <img src="../../uploads/posters/<?= $row['poster'] ?>" class="w-12 h-16 rounded-xl object-cover border border-gray-800">
                            <div class="font-bold text-white uppercase italic text-sm group-hover:text-red-500 transition-colors">
                                <?= $row['movie_title'] ?>
                            </div>
                        </div>
                    </td>

                    <td class="p-6">
                        <div class="text-sm text-gray-300"><?= $row['theatre_name'] ?></div>
                        <div class="text-[10px] text-gray-500 uppercase font-black tracking-widest mt-1">
                            <?= $row['city'] ?> • <?= $row['screen_name'] ?>
                        </div>
                    </td>

                    <td class="p-6">
                        <div class="text-sm text-white font-bold"><?= date('d M, Y', strtotime($row['show_date'])) ?></div>
                        <div class="text-[10px] text-red-500 font-black uppercase mt-1 italic">
                            <i class="far fa-clock mr-1"></i> <?= date('h:i A', strtotime($row['show_time'])) ?>
                        </div>
                    </td>

                    <td class="p-6 text-center">
                        <div class="flex justify-center items-center gap-3">
                            <a href="../seats/add_seats.php?screen_id=<?= $row['screen_id'] ?>" 
                               class="px-4 h-9 rounded-xl bg-red-600/5 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all border border-red-600/10 text-[10px] font-black uppercase tracking-tighter" 
                               title="Configure Seats">
                                <i class="fas fa-couch mr-2"></i> Add Seats
                            </a>

                            <a href="edit_show.php?id=<?= $row['show_id'] ?>" 
                               class="w-9 h-9 rounded-xl bg-blue-500/5 text-blue-400 flex items-center justify-center hover:bg-blue-500 hover:text-white transition-all border border-blue-500/10" 
                               title="Edit Show">
                                <i class="fas fa-edit text-xs"></i>
                            </a>

                            <a href="process_shows.php?delete_id=<?= $row['show_id'] ?>" 
                               onclick="return confirm('Are you sure you want to cancel this show?')" 
                               class="w-9 h-9 rounded-xl bg-red-500/5 text-red-500 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all border border-red-500/10"
                               title="Delete Show">
                                <i class="fas fa-trash-alt text-xs"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php 
                    } 
                } else { 
                    echo "<tr><td colspan='4' class='p-20 text-center text-gray-700 uppercase font-black text-xs italic tracking-widest opacity-30'>No Shows Scheduled</td></tr>";
                } 
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include_once __DIR__ . '/../../inc/footer.php'; ?>