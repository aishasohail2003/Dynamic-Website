<?php 
include_once __DIR__ . '/../../inc/header.php'; 
?>

<div class="max-w-4xl mx-auto px-4 py-10">
    <div class="mb-10 text-center">
        <h2 class="text-4xl font-black text-white tracking-tighter uppercase italic">CONFIGURE <span class="text-red-600">SCREEN</span></h2>
        <p class="text-gray-500 text-sm font-medium mt-1">Set up seating capacity and auditorium details for your cinema.</p>
    </div>

    <div class="bg-[#161616] border border-gray-800 rounded-[30px] shadow-2xl overflow-hidden border-t-4 border-red-600">
        <form action="process_screen.php" method="POST" class="p-10 space-y-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase text-gray-500 tracking-widest italic flex items-center gap-2">
                        <i class="fas fa-building text-red-600 text-[8px]"></i> Select Theatre Location
                    </label>
                    <div class="relative">
                        <select name="theatre_id" required class="w-full bg-black/50 border border-gray-800 rounded-2xl py-4 px-5 text-white focus:border-red-600 outline-none appearance-none cursor-pointer transition-all">
                            <option value="">Choose a Theatre...</option>
                            <?php 
                            // Fetching theatres dynamically
                            $t_query = "SELECT theatre_id, name, city FROM theatres ORDER BY name ASC";
                            $t_result = mysqli_query($conn, $t_query);

                            // Corrected logic: > 0 (taake single theatre bhi show ho)
                            if (mysqli_num_rows($t_result) > 0) {
                                while($theatre = mysqli_fetch_assoc($t_result)) {
                                    echo "<option value='".$theatre['theatre_id']."'>".$theatre['name']." - ".$theatre['city']."</option>";
                                }
                            } else {
                                echo "<option value='' disabled>No Theatres Found. Add one first!</option>";
                            }
                            ?>
                        </select>
                        <i class="fas fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-gray-600 pointer-events-none text-xs"></i>
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase text-gray-500 tracking-widest italic flex items-center gap-2">
                        <i class="fas fa-desktop text-red-600 text-[8px]"></i> Screen Name / Number
                    </label>
                    <input type="text" name="screen_name" placeholder="e.g. Screen 1, IMAX" required 
                        class="w-full bg-black/50 border border-gray-800 rounded-2xl py-4 px-5 text-white focus:border-red-600 outline-none transition-all">
                </div>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black uppercase text-gray-500 tracking-widest italic flex items-center gap-2">
                    <i class="fas fa-chair text-red-600 text-[8px]"></i> Total Seating Capacity
                </label>
                <div class="relative">
                    <i class="fas fa-chair absolute left-5 top-1/2 -translate-y-1/2 text-gray-600"></i>
                    <input type="number" name="total_seats" placeholder="e.g. 150" min="1" required 
                        class="w-full bg-black/50 border border-gray-800 rounded-2xl py-4 pl-14 pr-5 text-white focus:border-red-600 outline-none transition-all">
                </div>
                <p class="text-[9px] text-gray-600 uppercase font-bold tracking-tight">Note: Minimum 1 seat is required by the system.</p>
            </div>

            <button type="submit" name="add_screen" 
                class="w-full bg-gradient-to-r from-red-600 to-red-800 text-white font-black py-5 rounded-2xl shadow-xl hover:from-red-700 hover:to-red-900 transition-all transform hover:-translate-y-1 uppercase tracking-widest text-sm mt-4 active:scale-95">
                Initialize Screen Configuration
            </button>
        </form>
    </div>
</div>

<?php include_once __DIR__ . '/../../inc/footer.php'; ?>