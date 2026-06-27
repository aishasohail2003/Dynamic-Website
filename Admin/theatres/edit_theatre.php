<?php 
// Universal path using __DIR__ - Ye hamesha sahi file uthayega
include_once __DIR__ . '/../../inc/header.php'; 

// ID check aur data fetch
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "SELECT * FROM theatres WHERE theatre_id = '$id'";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Theatre record not found!'); window.location.href='manage_theatres.php';</script>";
        exit();
    }
} else {
    header("Location: manage_theatres.php");
    exit();
}
?>

<div class="max-w-5xl mx-auto">
    <div class="flex justify-between items-end mb-8">
        <div>
            <a href="manage_theatres.php" class="text-gray-500 hover:text-red-500 transition-all flex items-center gap-2 text-xs uppercase font-bold tracking-widest mb-3">
                <i class="fas fa-chevron-left text-[10px]"></i> Back to Inventory
            </a>
            <h2 class="text-4xl font-black text-white tracking-tighter">Edit <span class="text-red-600">Theatre</span></h2>
        </div>
        <div class="text-right hidden md:block">
            <span class="text-[10px] text-gray-600 uppercase font-bold block">Editing Theatre ID</span>
            <span class="text-xl font-mono text-gray-400">#<?= $data['theatre_id'] ?></span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-8">
            <div class="bg-[#161616] border border-gray-800 rounded-3xl p-8 shadow-2xl relative overflow-hidden">
                <i class="fas fa-edit absolute -top-10 -right-10 text-[200px] text-white/[0.02] pointer-events-none"></i>

                <form action="process_theatre.php" method="POST" class="relative space-y-8">
                    <input type="hidden" name="theatre_id" value="<?= $data['theatre_id'] ?>">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-3">
                            <label class="text-xs font-black uppercase text-gray-500 flex items-center gap-2">
                                <i class="fas fa-building text-red-600"></i> Theatre Name
                            </label>
                            <input type="text" name="name" value="<?= htmlspecialchars($data['name']) ?>" required 
                                class="w-full bg-black/50 border border-gray-800 rounded-2xl py-4 px-5 text-white focus:border-red-600 focus:ring-1 focus:ring-red-600 outline-none transition-all">
                        </div>

                        <div class="space-y-3">
                            <label class="text-xs font-black uppercase text-gray-500 flex items-center gap-2">
                                <i class="fas fa-map-marker-alt text-red-600"></i> City
                            </label>
                            <input type="text" name="city" value="<?= htmlspecialchars($data['city']) ?>" required 
                                class="w-full bg-black/50 border border-gray-800 rounded-2xl py-4 px-5 text-white focus:border-red-600 focus:ring-1 focus:ring-red-600 outline-none transition-all">
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label class="text-xs font-black uppercase text-gray-500 flex items-center gap-2">
                            <i class="fas fa-directions text-red-600"></i> Detailed Address
                        </label>
                        <textarea name="address" rows="3" required
                            class="w-full bg-black/50 border border-gray-800 rounded-2xl py-4 px-5 text-white focus:border-red-600 focus:ring-1 focus:ring-red-600 outline-none transition-all"><?= htmlspecialchars($data['address']) ?></textarea>
                    </div>

                    <div class="space-y-3">
                        <label class="text-xs font-black uppercase text-gray-500 flex items-center gap-2">
                            <i class="fas fa-toggle-on text-red-600"></i> Status
                        </label>
                        <div class="relative">
                            <select name="status" class="w-full bg-black/50 border border-gray-800 rounded-2xl py-4 px-5 text-white focus:border-red-600 outline-none appearance-none cursor-pointer">
                                <option value="Active" <?= (strtolower($data['status']) == 'active') ? 'selected' : '' ?>>Active / Open</option>
                                <option value="Inactive" <?= (strtolower($data['status']) == 'inactive') ? 'selected' : '' ?>>Inactive / Under Maintenance</option>
                            </select>
                            <i class="fas fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-gray-600 pointer-events-none"></i>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" name="update_theatre" 
                            class="w-full bg-gradient-to-r from-red-600 to-red-800 hover:from-red-700 hover:to-red-900 text-white font-black py-5 rounded-2xl shadow-xl shadow-red-900/20 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-3">
                            <i class="fas fa-save text-lg"></i> Update Theatre Configuration
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="lg:col-span-4 space-y-6">
            <div class="bg-gradient-to-br from-gray-900 to-black border border-gray-800 p-8 rounded-3xl">
                <h4 class="text-white font-bold mb-4 flex items-center gap-2">
                    <i class="fas fa-info-circle text-red-600"></i> Quick Guide
                </h4>
                <ul class="text-sm text-gray-500 space-y-4">