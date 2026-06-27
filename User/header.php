<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// base URL for building absolute paths (adjust if project folder changes)
$user_base = '/php_project/User/';

// --- 1. YE HAI ASLI FIX (Admin ko User side se rokne ke liye) ---
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    // Agar login banda admin hai aur wo user page khol raha hai
    // To usey User session se logout karke login page pe bhej do
    header("Location: login.php");
    exit();
}

// --- STORE BOOKING REDIRECT ---
if (isset($_POST['store_booking_movie'])) {
    $_SESSION['redirect_booking_movie_id'] = intval($_POST['store_booking_movie']);
    exit;
}

// --- 2. AJAX SEARCH LOGIC ---
if (isset($_GET['ajax_search']) && isset($_GET['q'])) {
    // configuration from root-level connection folder
    include_once __DIR__ . '/../connection/config.php'; 
    $q = mysqli_real_escape_string($conn, $_GET['q']);
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

$current_page = basename($_SERVER['PHP_SELF']);
if($current_page == "login.php" || $current_page == "signup.php"){
    return;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Movixo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { margin: 0; padding: 0; background-color: #000; color: white; font-family: 'Segoe UI', sans-serif; }
        .navbar { display: flex; justify-content: space-between; align-items: center; padding: 20px 5%; background-color: #141414; z-index: 1000; position: sticky; top: 0; box-shadow: 0 4px 15px rgba(0,0,0,0.5); }
        .nav-left, .nav-right { display: flex; align-items: center; }
        .logo { font-size: 36px; font-weight: bold; color: #ff6b00; text-decoration: none; margin-right: 35px; }
        .nav-links { display: flex; list-style: none; gap: 25px; margin: 0; padding: 0; }
        .nav-links li a { color: #e5e5e5; text-decoration: none; font-size: 18px; font-weight: 600; }
        .nav-links li a:hover { color: #ff6b00; }
        .search-box { position: relative; margin-right: 20px; }
        .search-box i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #888; pointer-events: none; }
        .search-box input { background: #1a1a1a; border: 1px solid #333; color: white; padding: 10px 15px 10px 45px; border-radius: 25px; outline: none; width: 220px; transition: 0.3s; font-size: 16px; font-family: inherit; }
        .search-box input:focus { width: 300px; border-color: #ff6b00; }
        .search-dropdown { position: absolute; top: 55px; left: 0; width: 320px; background: #1a1a1a; border: 1px solid #333; border-radius: 12px; display: none; z-index: 9999; max-height: 400px; overflow-y: auto; box-shadow: 0 10px 25px rgba(0,0,0,0.7); }
        .search-item { display: flex; align-items: center; padding: 12px; text-decoration: none; border-bottom: 1px solid #222; transition: 0.2s; }
        .search-item:hover { background: #2f3542; }
        .search-item img { width: 40px; height: 55px; object-fit: cover; border-radius: 6px; margin-right: 12px; background: #333; }
        .search-item .title { color: white; font-weight: 600; font-size: 14px; }
        .search-item .view { color: #ff6b00; font-size: 11px; font-weight: bold; margin-top: 4px; display: block; }
        .btn-login { background: #ff6b00; color: #000 !important; padding: 10px 28px; text-decoration: none; border-radius: 25px; font-weight: bold; font-size: 16px; }
        .user-dropdown { position: relative; display: flex; align-items: center; gap: 15px; }
        .dropbtn { background: #2f3542; color: white; padding: 10px 20px; font-size: 16px; border: 1px solid #444; border-radius: 25px; cursor: pointer; display: flex; align-items: center; gap: 10px; font-weight: 600; }
        .dropdown-content { display: none; position: absolute; right: 0; top: 110%; background-color: #1a1a1a; min-width: 180px; border-radius: 8px; border: 1px solid #333; overflow: hidden; }
        .dropdown-content a { color: #e5e5e5; padding: 12px 16px; text-decoration: none; display: block; font-size: 15px; }
        .dropdown-content a:hover { background-color: #ff6b00; color: white; }
        .user-dropdown:hover .dropdown-content { display: block; }
        .user-profile-avatar { width: 40px; height: 40px; background: #ff6b00; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-weight: bold; color: white; font-size: 18px; }
    </style>
</head>
<body>
<nav class="navbar">
    <div class="nav-left">
        <a href="index.php" class="logo">Movixo</a>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="movie.php">Movies</a></li>
            <li><a href="theatre.php">Theatre</a></li>
            <li><a href="show.php">Shows</a></li>
        </ul>
    </div>
    <div class="nav-right">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="movieSearch" placeholder="Search movies..." autocomplete="off">
            <div id="search-results" class="search-dropdown"></div>
        </div>
        <?php if(isset($_SESSION['user_id'])): 
            $name = $_SESSION['full_name'] ?? 'User';
        ?>
            <div class="user-dropdown">
                <div class="user-profile-avatar"><?php echo strtoupper(substr($name, 0, 1)); ?></div>
                <button class="dropbtn">Hi, <?php echo htmlspecialchars(explode(' ', $name)[0]); ?> <i class="fas fa-chevron-down"></i></button>
                <div class="dropdown-content">
                    <a href="my_profile.php"><i class="fas fa-user"></i> My Profile</a>
                    <a href="my_bookings.php"><i class="fas fa-ticket-alt"></i> My Bookings</a>
                    <a href="logout.php" style="border-top: 1px solid #333; color: #ff4757;"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>
        <?php else: ?>
            <a href="login.php" class="btn-login">Login</a>
        <?php endif; ?>
    </div>
</nav>

<script>
    const searchInput = document.getElementById('movieSearch');
    const resultsBox = document.getElementById('search-results');
    const baseUrlJs = '<?= $user_base ?>'; // JS-friendly base path
    const uploadsJs = '/php_project/uploads/posters/'; // absolute path to posters directory

    if (searchInput && resultsBox) {
        const doSearch = () => {
            let query = searchInput.value.trim();
            fetch(baseUrlJs + 'header.php?ajax_search=1&q=' + encodeURIComponent(query))
                .then(response => response.json())
                .then(data => {
                    resultsBox.innerHTML = '';
                    if (data && data.length > 0) {
                        resultsBox.style.display = 'block';
                        data.forEach(movie => {
                            resultsBox.innerHTML += `
                                <a href="movie_details.php?id=${movie.movie_id}" class="search-item">
                                    <img src="${uploadsJs}${movie.poster}" 
                                         onerror="this.src='https://via.placeholder.com/40x60/222/fff?text=?'">
                                    <div class="info">
                                        <span class="title">${movie.title}</span>
                                        <span class="view">VIEW DETAILS</span>
                                    </div>
                                </a>`;
                        });
                    } else {
                        resultsBox.innerHTML = '<div style="padding:15px; color:#888; text-align:center; font-size:14px;">No movies found</div>';
                        resultsBox.style.display = 'block';
                    }
                })
                .catch(err => {
                    console.error('Search AJAX error:', err);
                });
        };

        searchInput.addEventListener('input', doSearch);
        searchInput.addEventListener('focus', doSearch);
    }

    document.addEventListener('click', (e) => {
        if (!searchInput.contains(e.target) && !resultsBox.contains(e.target)) {
            resultsBox.style.display = 'none';
        }
    });
</script>