<?php 
// 1. SESSION START SABSE PEHLE (Iske bagair role check kaam nahi karega)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. STRICT ADMIN CHECK
// Agar session mein role 'admin' nahi hai, to foran login pe bhej do
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// 3. CONNECTION AUR BASE URL
// Path check karlein: Agar ye file 'Admin/includes/header.php' mein hai to '../../' sahi hai
include_once __DIR__ . '/../connection/config.php'; 
$base_url = "/php_project/Admin/"; 

// --- AJAX SEARCH LOGIC ---
if (isset($_GET['ajax_search']) && isset($_GET['q'])) {
    // include_once config is already above, $conn is available
    $q = mysqli_real_escape_string($conn, $_GET['q']);
    // if the query string is empty we still want to return some movies (recent/first 10)
    if ($q === '') {
        $query = "SELECT movie_id, title, poster FROM movies ORDER BY movie_id DESC LIMIT 10";
    } else {
        $query = "SELECT movie_id, title, poster FROM movies WHERE title LIKE '%$q%' ORDER BY movie_id DESC LIMIT 10";
    }
    $result = mysqli_query($conn, $query);
    $search_results = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $search_results[] = $row;
        }
    }
    header('Content-Type: application/json');
    echo json_encode($search_results);
    exit; 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MOVIXO | Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    
    <style>
        body { background-color: #0c0c0c; color: #e5e5e5; font-family: 'Inter', sans-serif; margin: 0; display: flex; }
        .sidebar { background-color: #050505; border-right: 1px solid #1f1f1f; width: 260px; position: fixed; height: 100vh; z-index: 50; top: 0; left: 0; }
        .main-wrapper { margin-left: 260px; width: calc(100% - 260px); min-height: 100vh; display: flex; flex-direction: column; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-thumb { background: #222; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #ff4b4b; }

    </style>
</head>
<body>

<aside class="sidebar flex flex-col">
    <div class="p-8">
        <a href="<?= $base_url ?>index.php" class="group block">
            <h1 class="text-2xl font-black text-red-600 tracking-tighter italic uppercase group-hover:scale-105 transition-transform origin-left">Movixo</h1>
            <p class="text-[9px] text-gray-600 font-bold tracking-[0.3em] uppercase mt-1 group-hover:text-gray-400 transition-colors">Admin Panel</p>
        </a>
    </div>

    <nav class="flex-1 px-4 space-y-1">
        <p class="text-[10px] text-gray-600 uppercase font-bold tracking-widest px-4 mb-4 text-opacity-50">Main Menu</p>
        
        <a href="<?= $base_url ?>index.php" class="flex items-center gap-3 p-4 rounded-xl hover:bg-white/5 text-gray-400 hover:text-white transition-all group">
            <div class="w-8 h-8 rounded-lg bg-gray-900 flex items-center justify-center group-hover:bg-red-600/20 group-hover:text-red-600 transition-all">
                <i class="fas fa-th-large text-xs"></i>
            </div>
            <span class="text-sm font-bold tracking-tight">Dashboard</span>
        </a>

        <a href="<?= $base_url ?>movies/manage_movie.php" class="flex items-center gap-3 p-4 rounded-xl hover:bg-white/5 text-gray-400 hover:text-white transition-all group">
            <div class="w-8 h-8 rounded-lg bg-gray-900 flex items-center justify-center group-hover:bg-red-600/20 group-hover:text-red-600 transition-all">
                <i class="fas fa-film text-xs"></i>
            </div>
            <span class="text-sm font-bold tracking-tight">Movies</span>
        </a>

        <a href="<?= $base_url ?>theatres/manage_theatres.php" class="flex items-center gap-3 p-4 rounded-xl hover:bg-white/5 text-gray-400 hover:text-white transition-all group">
            <div class="w-8 h-8 rounded-lg bg-gray-900 flex items-center justify-center group-hover:bg-red-600/20 group-hover:text-red-600 transition-all">
                <i class="fas fa-building text-xs"></i>
            </div>
            <span class="text-sm font-bold tracking-tight">Theatres</span>
        </a>

        <a href="<?= $base_url ?>screens/manage_screen.php" class="flex items-center gap-3 p-4 rounded-xl hover:bg-white/5 text-gray-400 hover:text-white transition-all group">
            <div class="w-8 h-8 rounded-lg bg-gray-900 flex items-center justify-center group-hover:bg-red-600/20 group-hover:text-red-600 transition-all">
                <i class="fas fa-desktop text-xs"></i>
            </div>
            <span class="text-sm font-bold tracking-tight">Screens</span>
        </a>

        <a href="<?= $base_url ?>shows/manage_show.php" class="flex items-center gap-3 p-4 rounded-xl hover:bg-white/5 text-gray-400 hover:text-white transition-all group">
            <div class="w-8 h-8 rounded-lg bg-gray-900 flex items-center justify-center group-hover:bg-red-600/20 group-hover:text-red-600 transition-all">
                <i class="fas fa-clock text-xs"></i>
            </div>
            <span class="text-sm font-bold tracking-tight">Shows</span>
        </a>
    </nav>

    <div class="p-6 border-t border-gray-900">
        <a href="<?= $base_url ?>logout.php" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-500 hover:bg-red-600/10 hover:text-red-500 transition-all text-xs font-bold uppercase tracking-widest">
            <i class="fas fa-power-off"></i> <span>Log Out</span>
        </a>
    </div>
</aside>

<div class="main-wrapper">
    <header class="flex justify-between items-center py-4 px-8 border-b border-gray-800 bg-[#0c0c0c] sticky top-0 z-50">
        <div class="flex items-center gap-2">
            <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest">System Status</p>
            <div class="flex items-center gap-1.5">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                <span class="text-white text-[10px] font-bold uppercase">Online</span>
            </div>
        </div>



        <!-- top-right user info removed; logout is available in sidebar only -->
        <div class="flex items-center gap-4">
            <!-- placeholder or status can remain if needed -->
        </div>
    </header>

    <main class="p-10 flex-1">

