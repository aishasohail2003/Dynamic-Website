<?php 
include_once __DIR__ . '/../../inc/header.php'; 
?>

<div class="flex justify-between items-center mb-10">
    <div>
        <h2 class="text-4xl font-black text-white tracking-tighter italic">THEATRE <span class="text-red-600">INVENTORY</span></h2>
        <p class="text-gray-500 text-sm font-medium mt-1">Manage all cinema locations and their operational status.</p>
    </div>
    <a href="add_theatre.php" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-bold flex items-center gap-2 transition-all transform hover:-translate-y-1 shadow-lg shadow-red-600/20">
        <i class="fas fa-plus"></i> Add New Theatre
    </a>
</div>

<div class="bg-[#161616] border border-gray-800 rounded-3xl overflow-hidden shadow-2xl">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-white/5 border-b border-gray-800">
                <th class="p-5 text-[10px] uppercase font-black text-gray-500 tracking-widest">Theatre Info</th>
                <th class="p-5 text-[10px] uppercase font-black text-gray-500 tracking-widest">Location</th>
                <th class="p-5 text-[10px] uppercase font-black text-gray-500 tracking-widest">Status</th>
                <th class="p-5 text-[10px] uppercase font-black text-gray-500 tracking-widest text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-800">
            <?php
            $res = mysqli_query($conn, "SELECT * FROM theatres ORDER BY theatre_id DESC");
            if(mysqli_num_rows($res) > 0) {
                while($row = mysqli_fetch_assoc($res)) {
                    // Status Badge Color Logic
                    $status_class = (strtolower($row['status']) == 'active') ? 'bg-green-500/10 text-green-500' : 'bg-red-500/10 text-red-500';
            ?>
            <tr class="hover:bg-white/[0.02] transition-colors group">
                <td class="p-5">
                    <div class="font-bold text-white group-hover:text-red-500 transition-colors"><?= htmlspecialchars($row['name']) ?></div>
                    <div class="text-[10px] text-gray-600 font-mono mt-1 uppercase">ID: #<?= $row['theatre_id'] ?></div>
                </td>
                <td class="p-5 text-gray-400 text-sm">
                    <i class="fas fa-city mr-1 text-gray-700 text-xs"></i> <?= htmlspecialchars($row['city']) ?>
                </td>
                <td class="p-5">
                    <span class="<?= $status_class ?> px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter">
                        <?= $row['status'] ?>
                    </span>
                </td>
                <td class="p-5">
                    <div class="flex justify-center items-center gap-3">
                        <a href="edit_theatre.php?id=<?= $row['theatre_id'] ?>" 
                           class="w-9 h-9 rounded-lg bg-blue-500/10 text-blue-500 flex items-center justify-center hover:bg-blue-500 hover:text-white transition-all shadow-lg" 
                           title="Edit Theatre">
                            <i class="fas fa-edit text-sm"></i>
                        </a>

                        <a href="process_theatre.php?delete_id=<?= $row['theatre_id'] ?>" 
                           onclick="return confirm('WARNING: Are you sure you want to delete this theatre? This action cannot be undone.')"
                           class="w-9 h-9 rounded-lg bg-red-500/10 text-red-500 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all shadow-lg" 
                           title="Delete Theatre">
                            <i class="fas fa-trash-alt text-sm"></i>
                        </a>
                    </div>
                </td>
            </tr>
            <?php 
                }
            } else {
                echo "<tr><td colspan='4' class='p-10 text-center text-gray-600 italic'>No theatres found in the database.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include_once __DIR__ . '/../../inc/footer.php'; ?>