<?php
include('config.php');
include('header.php');

// ensure session started to check login
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['user_id']);

// 1. URL se Movie ID lena
$movie_id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : die("ID Missing");

// 2. Movie aur Trailer ka data JOIN query se nikalna
$query = "SELECT m.*, t.trailer_url 
          FROM movies m 
          LEFT JOIN trailers t ON m.movie_id = t.movie_id 
          WHERE m.movie_id = '$movie_id' 
          LIMIT 1";

$result = mysqli_query($conn, $query);
$movie = mysqli_fetch_assoc($result);

if (!$movie) { die("Movie not found"); }

$title = $movie['title'];
$trailer = "";

// --- TRAILER LOGIC (DB First, then your Links as backup) ---
if (!empty($movie['trailer_url'])) {
    $trailer = $movie['trailer_url'];
} 
// Aapke provided links ka fallback
elseif (stripos($title, 'Harry Potter') !== false) {
    $trailer = "https://www.youtube.com/watch?v=VyHV0BRtdxo";
} elseif (stripos($title, 'Joker') !== false) {
    $trailer = "https://www.youtube.com/watch?v=_OKAwz2MsJs";
} elseif (stripos($title, 'Avenger') !== false) {
    $trailer = "https://www.youtube.com/watch?v=eOrNdBpGMv8";
} elseif (stripos($title, 'Batman') !== false) {
    $trailer = "https://www.youtube.com/watch?v=neY2xVmOfUM";
} elseif (stripos($title, 'Iron Man') !== false || stripos($title, 'iran man') !== false) {
    $trailer = "https://www.youtube.com/watch?v=8ugaeA-nMTc";
} elseif (stripos($title, 'Aladdin') !== false || stripos($title, 'alladin') !== false) {
    $trailer = "https://www.youtube.com/watch?v=VcBllhVj1eA";
} elseif (stripos($title, 'Snister') !== false || stripos($title, 'Sinister') !== false){
    $trailer = "https://www.youtube.com/watch?v=_kbQAJR9YWQ"; 
} elseif (stripos($title, 'Curse of Nun') !== false){
    $trailer = "https://www.youtube.com/watch?v=_bI1hJafWUI"; 
} elseif (stripos($title, 'Twilight') !== false){
    $trailer = "https://www.youtube.com/watch?v=uxjNDE2fMjI"; 
} elseif (stripos($title, 'Aquaman') !== false){
    $trailer = "https://www.youtube.com/watch?v=2wcj6SrX4zw"; 
} elseif (stripos($title, 'Johnny English') !== false){
    $trailer = "https://www.youtube.com/watch?v=wCsSzZU-sQ4"; 
} elseif (stripos($title, 'Beauty and the beast') !== false){
    $trailer = "https://www.youtube.com/watch?v=pnkgw6pAKkM"; 
} elseif (stripos($title, 'SpiderMan 3') !== false){
    $trailer = "https://www.youtube.com/watch?v=e5wUilOeOmg"; 
} elseif (stripos($title, 'X men the last stand') !== false){
    $trailer = "https://www.youtube.com/watch?v=ZQ0v5dXbw7M"; 
} elseif (stripos($title, 'Maleficent') !== false || stripos($title, 'Maleficient') !== false){
    $trailer = "https://www.youtube.com/watch?v=IuY4-6qWm-8"; 
}

// YouTube Embed Link Generator
$embed_url = "";
if (!empty($trailer)) {
    if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $trailer, $match)) {
        $embed_url = "https://www.youtube.com/embed/" . $match[1];
    }
}
?>

<style>
    :root { --primary-red: #e50914; --glass-bg: rgba(20, 20, 20, 0.8); }
    body { background: #000; font-family: 'Inter', 'Segoe UI', sans-serif; color: white; margin: 0; }

    .detail-container {
        display: flex; gap: 50px; padding: 80px 5%; 
        background: linear-gradient(to right, rgba(0,0,0,0.9) 30%, transparent 100%), 
                    url('../uploads/posters/<?php echo $movie['poster']; ?>');
        background-size: cover; background-position: center; min-height: 85vh;
    }

    .poster-side { 
        flex: 0 0 350px; position: relative; height: 500px; 
        border-radius: 12px; overflow: hidden; 
        box-shadow: 0 20px 50px rgba(0,0,0,0.8);
        transition: transform 0.4s ease;
    }

    .poster-side:hover { transform: scale(1.03); }
    .poster-side img { width: 100%; height: 100%; object-fit: cover; }

    .hover-box {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background: #000; opacity: 0; visibility: hidden;
        transition: opacity 0.5s ease; z-index: 10;
    }

    .poster-side:hover .hover-box { opacity: 1; visibility: visible; }
    .mini-video { width: 100%; height: 250px; background: #111; }
    
    .hover-content { 
        padding: 20px; background: var(--glass-bg); height: 250px;
        backdrop-filter: blur(10px); border-top: 2px solid var(--primary-red);
    }

    .info-side { flex: 1; z-index: 2; }
    .movie-title { font-size: 65px; font-weight: 800; margin: 0; text-transform: uppercase; }
    
    .meta-data { margin: 20px 0; font-size: 18px; color: #bbb; display: flex; gap: 20px; align-items: center; }
    .rating-badge { background: #46d369; color: black; padding: 2px 8px; border-radius: 4px; font-weight: bold; }

    .description-text { font-size: 18px; line-height: 1.6; color: #ddd; max-width: 700px; margin-bottom: 40px; }

    .btn-group { display: flex; flex-direction: column; gap: 15px; width: fit-content; }
    
    .btn-main {
        padding: 16px 45px; border-radius: 8px; font-size: 16px; font-weight: bold;
        text-transform: uppercase; transition: 0.3s;
        display: flex; align-items: center; justify-content: center; gap: 10px; text-decoration: none;
    }

    .btn-red { background: var(--primary-red); color: white; }
    .btn-red:hover { background: #b20710; transform: translateY(-2px); }

    .btn-outline { background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.4); }
    .btn-outline:hover { background: rgba(255,255,255,0.2); }
</style>

<div class="detail-container">
    <div class="poster-side" id="movieCard">
        <img src="../uploads/posters/<?php echo $movie['poster']; ?>" alt="Poster">
        
        <div class="hover-box">
            <div class="mini-video" id="videoBox"></div>
            <div class="hover-content">
                <h4 style="margin: 0 0 10px 0; color: var(--primary-red);">Now Previewing</h4>
                <p style="font-size: 13px;"><?php echo htmlspecialchars($movie['description']); ?></p>
            </div>
        </div>
    </div>

    <div class="info-side">
        <h1 class="movie-title"><?php echo htmlspecialchars($title); ?></h1>
        
        <div class="meta-data">
            <span class="rating-badge">98% Match</span>
            <span><?php echo $movie['release_date']; ?></span>
            <span>|</span>
            <span><?php echo $movie['duration']; ?>m</span>
            <span style="border: 1px solid #666; padding: 0 5px; font-size: 12px;">HD</span>
        </div>
        
        <p class="description-text"><?php echo htmlspecialchars($movie['description']); ?></p>

        <div class="btn-group">
            <a href="<?php echo $isLoggedIn ? 'booking.php?id='.$movie_id : '#'; ?>" 
               class="btn-main btn-red" 
               <?php if(!$isLoggedIn): ?>
                   onclick="
                   fetch('header.php', {method: 'POST', headers: {'Content-Type': 'application/x-www-form-urlencoded'}, body: 'store_booking_movie=<?php echo $movie_id; ?>'});
                   alert('You must be logged in to book tickets.');
                   window.location.href = 'login.php';
                   return false;
                   "
               <?php endif; ?>>
                <i class="fas fa-play"></i> Get Tickets
            </a>
            <a href="<?php echo $trailer; ?>" target="_blank" class="btn-main btn-outline">
                <i class="fas fa-info-circle"></i> Watch Full Trailer
            </a>
        </div>
    </div>
</div>

<script>
    const card = document.getElementById('movieCard');
    const videoPlaceholder = document.getElementById('videoBox');
    const vidUrl = "<?php echo $embed_url; ?>?autoplay=1&mute=1&controls=0&rel=0&showinfo=0";

    card.addEventListener('mouseenter', () => {
        if ("<?php echo $embed_url; ?>" !== "") {
            videoPlaceholder.innerHTML = `<iframe width="100%" height="100%" src="${vidUrl}" frameborder="0" allow="autoplay"></iframe>`;
        }
    });

    card.addEventListener('mouseleave', () => {
        videoPlaceholder.innerHTML = "";
    });
</script>

<?php include('footer.php'); ?>