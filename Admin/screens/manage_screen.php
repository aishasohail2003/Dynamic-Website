<?php 
include_once __DIR__ . '/../../inc/header.php'; 
?>

<div class="flex justify-between items-center mb-10">
    <div>
        <h2 class="text-4xl font-black text-white tracking-tighter uppercase italic">CINEMA <span class="text-red-600">SCREENS</span></h2>
        <p class="text-gray-500 text-sm font-medium mt-1">Manage auditorium layouts and seating capacities.</p>
    </div>
    <a href="add_screen.php" class="bg-red-600 hover:bg-red-700 text-white px-8 py-3.5 rounded-2xl font-black flex items-center gap-3 transition-all transform hover:-translate-y-1 shadow-xl shadow-red-600/20 uppercase text-xs tracking-widest">
        <i class="fas fa-plus"></i> Add New Screen
    </a>
</div>

<div class="bg-[#161616] border border-gray-800 rounded-[30px] overflow-hidden shadow-2xl">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-white/5 border-b border-gray-800">
                <th class="p-6 text-[10px] uppercase font-black text-gray-500 tracking-widest">Screen Info</th>
                <th class="p-6 text-[10px] uppercase font-black text-gray-500 tracking-widest">Theatre Location</th>
                <th class="p-6 text-[10px] uppercase font-black text-gray-500 tracking-widest">Total Seats</th>
                <th class="p-6 text-[10px] uppercase font-black text-gray-500 tracking-widest">Status</th>
                <th class="p-6 text-[10px] uppercase font-black text-gray-500 tracking-widest text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-800">
            <?php
            // Join query taake theatre ka naam bhi show ho
            $query = "SELECT screens.*, theatres.name as theatre_name 
                      FROM screens 
                      JOIN theatres ON screens.theatre_id = theatres.theatre_id 
                      ORDER BY screens.screen_id DESC";
            
            $res = mysqli_query($conn, $query);
            
            if(mysqli_num_rows($res) > 0) {
                while($row = mysqli_fetch_assoc($res)) {
            ?>
            <tr class="hover:bg-white/[0.02] transition-colors group">
                <td class="p-6">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-red-600/10 text-red-600 flex items-center justify-center border border-red-600/20">
                            <i class="fas fa-desktop text-xs"></i>
                        </div>
                        <div>
                            <div class="font-bold text-white group-hover:text-red-500 transition-colors uppercase italic"><?= $row['screen_name'] ?></div>
                            <div class="text-[10px] text-gray-600 font-black mt-1 uppercase tracking-tighter">ID: #SCR-0<?= $row['screen_id'] ?></div>
                        </div>
                    </div>
                </td>
                
                <td class="p-6">
                    <div class="text-sm text-gray-300 font-semibold italic">
                        <i class="fas fa-location-dot text-red-600 mr-1 opacity-50 text-xs"></i> 
                        <?= $row['theatre_name'] ?>
                    </div>
                </td>

                <td class="p-6">
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-white font-black"><?= $row['total_seats'] ?></span>
                        <span class="text-[10px] text-gray-600 uppercase font-bold">Seats</span>
                    </div>
                </td>

                <td class="p-6">
                    <span class="bg-green-500/10 text-green-500 border border-green-500/20 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-tighter">
                        Operational
                    </span>
                </td>

                <td class="p-6 text-center">
                    <div class="flex justify-center items-center gap-3">
                        <a href="edit_screen.php?id=<?= $row['screen_id'] ?>" class="w-9 h-9 rounded-xl bg-blue-500/5 text-blue-400 flex items-center justify-center hover:bg-blue-500 hover:text-white transition-all border border-blue-500/10">
                            <i class="fas fa-edit text-xs"></i>
                        </a>
                        <a href="process_screen.php?delete_id=<?= $row['screen_id'] ?>" onclick="return confirm('Delete this screen configuration?')" class="w-9 h-9 rounded-xl bg-red-500/5 text-red-500 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all border border-red-500/10">
                            <i class="fas fa-trash-alt text-xs"></i>
                        </a>
                    </div>
                </td>
            </tr>
            <?php 
                }
            } else {
                echo "<tr><td colspan='5' class='p-20 text-center text-gray-700 uppercase tracking-widest font-black text-sm italic opacity-30'>No Screens Configured</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include_once __DIR__ . '/../../inc/footer.php'; ?>