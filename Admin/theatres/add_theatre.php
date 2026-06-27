<?php include_once __DIR__ . '/../../inc/header.php'; ?>

<div class="max-w-4xl mx-auto">
    <div class="mb-10 text-center">
        <h2 class="text-4xl font-black text-white tracking-tighter uppercase italic">REGISTER <span class="text-red-600">THEATRE</span></h2>
        <p class="text-gray-500 text-sm font-medium mt-1 uppercase tracking-widest">Add a new cinema branch to the system.</p>
    </div>

    <div class="bg-[#161616] border border-gray-800 rounded-[30px] shadow-2xl overflow-hidden">
        <form action="process_theatre.php" method="POST" class="p-10 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase text-gray-500 tracking-widest">Theatre Name</label>
                    <input type="text" name="name" placeholder="e.g. Nueplex Cinemas" required 
                        class="w-full bg-black/50 border border-gray-800 rounded-2xl py-4 px-5 text-white focus:border-red-600 outline-none transition-all">
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase text-gray-500 tracking-widest">City Location</label>
                    <div class="relative">
                        <select name="city" required class="w-full bg-black/50 border border-gray-800 rounded-2xl py-4 px-5 text-white focus:border-red-600 outline-none appearance-none cursor-pointer">
                            <option value="">Select City...</option>
                            <option value="Karachi">Karachi</option>
                            <option value="Lahore">Lahore</option>
                            <option value="Islamabad">Islamabad</option>
                            <option value="Rawalpindi">Rawalpindi</option>
                            <option value="Faisalabad">Faisalabad</option>
                            <option value="Multan">Multan</option>
                            <option value="Hyderabad">Hyderabad</option>
                            <option value="Quetta">Quetta</option>
                            <option value="Peshawar">Peshawar</option>
                            <option value="Sialkot">Sialkot</option>
                            <option value="Gujranwala">Gujranwala</option>
                            <option value="Sargodha">Sargodha</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-gray-600 pointer-events-none text-xs"></i>
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                <label class="text-[10px] font-black uppercase text-gray-500 tracking-widest">Full Address</label>
                <textarea name="address" rows="3" placeholder="e.g. Myskpa Tower, Phase 8, DHA" required 
                    class="w-full bg-black/50 border border-gray-800 rounded-2xl py-4 px-5 text-white focus:border-red-600 outline-none transition-all resize-none"></textarea>
            </div>

            <div class="pt-4">
                <button type="submit" name="add_theatre" class="w-full bg-gradient-to-r from-red-600 to-red-800 text-white font-black py-5 rounded-2xl shadow-xl hover:from-red-700 hover:to-red-900 transition-all transform hover:-translate-y-1 uppercase tracking-widest text-sm">
                    <i class="fas fa-plus-circle mr-2"></i> Save Theatre Location
                </button>
            </div>
        </form>
    </div>
</div>

<?php include_once __DIR__ . '/../../inc/footer.php'; ?>