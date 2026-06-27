<?php 
include_once __DIR__ . '/../../connection/config.php'; 
include_once __DIR__ . '/../../inc/header.php'; 

// Join query taake screen ka naam bhi nazar aaye (agar screen table mein name hai)
$query = "SELECT * FROM seats ORDER BY screen_id ASC, seat_id ASC";
$result = mysqli_query($conn, $query);
?>

<div class="px-8 py-10">
    <div class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-4xl font-black text-white tracking-tighter uppercase italic">MANAGE <span class="text-red-600">SEATS</span></h2>
            <p class="text-gray-500 text-sm font-medium mt-1 uppercase tracking-widest">View and organize all auditorium seating layouts and pricing.</p>
        </div>
        <a href="add_seat.php" class="bg-red-600 hover:bg-red-700 text-white px-8 py-3.5 rounded-2xl font-black uppercase text-xs tracking-widest transition-all shadow-xl shadow-red-600/20">
            <i class="fas fa-plus mr-2"></i> Add New Seat
        </a>
    </div>

    <div class="bg-[#161616] border border-gray-800 rounded-[30px] overflow-hidden shadow-2xl">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white/5 border-b border-gray-800 text-[10px] uppercase font-black text-gray-500 tracking-widest">
                    <th class="p-6">Seat Detail</th>
                    <th class="p-6">Screen</th>
                    <th class="p-6">Category</th>
                    <th class="p-6">Price</th>
                    <th class="p-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr class="hover:bg-white/[0.02] transition-colors group">
                        
                        <td class="p-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-red-600/10 text-red-600 flex items-center justify-center border border-red-600/20">
                                    <i class="fas fa-couch text-xs"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-white group-hover:text-red-500 transition-colors uppercase italic text-sm">
                                        <?= $row['seat_number']; ?>
                                    </div>
                                    <div class="text-[10px] text-gray-600 font-black mt-1 uppercase tracking-tighter">
                                        ID: #ST-0<?= $row['seat_id']; ?>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="p-6">
                            <div class="text-sm text-gray-300 font-semibold italic">
                                <i class="fas fa-desktop text-red-600 mr-1 opacity-50 text-[10px]"></i> 
                                Screen <?= $row['screen_id']; ?>
                            </div>
                        </td>

                        <td class="p-6">
                            <span class="bg-white/5 text-gray-400 border border-gray-800 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-tighter">
                                <?= $row['seat_type']; ?>
                            </span>
                        </td>

                        <td class="p-6">
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] text-red-600 uppercase font-bold italic">PKR</span>
                                <span class="text-sm text-white font-black"><?= number_format($row['price'], 0); ?></span>
                            </div>
                        </td>

                        <td class="p-6 text-center">
                            <div class="flex justify-center items-center gap-3">
                                <a href="edit_seats.php?id=<?= $row['seat_id']; ?>" 
                                   class="w-9 h-9 rounded-xl bg-blue-500/5 text-blue-400 flex items-center justify-center hover:bg-blue-500 hover:text-white transition-all border border-blue-500/10" 
                                   title="Edit Seat">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>

                                <a href="process_seat.php?delete=<?= $row['seat_id']; ?>" 
                                   onclick="return confirm('Delete this seat?')" 
                                   class="w-9 h-9 rounded-xl bg-red-500/5 text-red-500 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all border border-red-500/10"
                                   title="Delete Seat">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </a>
                            </div>
                        </td>

                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="p-20 text-center text-gray-700 uppercase font-black text-xs italic tracking-widest opacity-30">
                            No Seats Configured
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include_once __DIR__ . '/../../inc/footer.php'; ?>