<?php 
include('config.php'); 
include('header.php');
// session_start();

// // Agar user login nahi hai, to use login page par bhej do
// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit();
// }

// Agar login hai, to niche ka index page load hoga

$movie_query = "SELECT * FROM movies ORDER BY movie_id DESC LIMIT 12";
$movie_result = mysqli_query($conn, $movie_query);
?>

<style>
:root {
    --accent: #ff6b00;
}

/* --- BACKGROUND IMAGE FIX --- */
body {
    margin: 0;
    padding: 0;
    background-color: #000; /* Fallback color */
    /* VIP Cinema image link added here */
    background-image: url('https://img.freepik.com/free-photo/dark-vip-cinema-studio-still-life_23-2149500599.jpg?semt=ais_hybrid&w=740&q=80');
    background-size: cover;
    background-position: center;
    background-attachment: fixed; /* Screen scroll hone par image fix rahegi */
    background-repeat: no-repeat;
    min-height: 100vh;
    
}

/* Dark overlay taake text saaf nazar aaye */
body::before {
    content: "";
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0, 0, 0, 0.7); /* Background image ko thora dark karne ke liye */
    z-index: -3; /* Sabse peeche rahega */
    
}

/* --- HERO BANNER STYLES --- */
.hero-banner {
    position: relative;
    height: 100vh; 
    display: flex;
    align-items: center;
    padding: 0 100px;
    margin-bottom: 60px;
    overflow: hidden;
    color: white;
    background: transparent; /* Isay transparent kiya taake body ki image dikhe */
}

/* ... Baaki aapki puri CSS yahan se niche same rahegi ... */
/* Background Images */
.slide-bg {
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    z-index: -2;
    opacity: 0;
    transition: opacity 1s ease-in-out;
    object-fit: cover;
}

.slide-bg.active {
    opacity: 1;
}

/* Dark Overlay */
.hero-banner::after {
    content: "";
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: linear-gradient(to right, rgba(0,0,0,0.9) 30%, rgba(0,0,0,0.2) 100%);
    z-index: -1;
}

/* Hero Content Styling & Animation */
.hero-content {
    position: relative;
    max-width: 700px;
    z-index: 1;
    display: none; 
}

.hero-content.active {
    display: block;
    animation: fadeInUp 0.8s ease-out;
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.exclusive-tag {
    background: var(--accent);
    padding: 5px 12px;
    border-radius: 5px;
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    display: inline-block;
}

.hero-content h1 {
    font-size: 65px;
    margin: 20px 0;
    line-height: 1.1;
    font-weight: 900;
}

.hero-content p {
    font-size: 18px;
    margin-bottom: 30px;
    line-height: 1.6;
    color: #ccc;
}

.btn-group {
    display: flex;
    gap: 15px;
}

.btn-play {
    background: var(--accent);
    color: white;
    border: none;
    padding: 15px 35px;
    border-radius: 10px;
    font-weight: 800;
    font-size: 16px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: 0.3s;
    text-decoration: none;
}

.btn-play:hover {
    transform: scale(1.05);
    filter: brightness(1.2);
}

/* --- TRENDING SECTION STYLES --- */
.trending-section {
    padding: 0 50px 50px 50px;
}

.section-title {
    font-size: 24px;
    margin-bottom: 25px;
    border-left: 5px solid var(--accent);
    padding-left: 15px;
    color: white;
}

.movie-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 30px;
}

.movie-card {
    background: #161616;
    border-radius: 15px;
    overflow: hidden;
    transition: 0.4s;
    border: 1px solid rgba(255,255,255,0.05);
    text-decoration: none;
    display: block;
}

.movie-card:hover {
    transform: translateY(-10px);
    border-color: var(--accent);
}

.movie-card img {
    width: 100%;
    aspect-ratio: 2/3;
    object-fit: cover;
    display: block;
}

.movie-info {
    padding: 15px;
}

.movie-info h4 {
    margin: 0;
    font-size: 17px;
    color: white;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.movie-info p {
    color: #777;
    font-size: 14px;
    margin: 5px 0 0 0;
}

@media(max-width:768px){
    .hero-banner { padding: 0 20px; }
    .hero-content h1 { font-size: 40px; }
}
</style>

<div class="hero-banner" id="heroBanner">
    <img src="https://wallpapercat.com/w/full/f/7/4/303520-1920x1080-desktop-1080p-legend-movie-wallpaper-image.jpg" class="slide-bg active" alt="Slide 1">
    <img src="https://m.media-amazon.com/images/I/81JcNd6azCL._AC_UF894,1000_QL80_.jpg" class="slide-bg" alt="Slide 2">
    <img src="https://wallpapers.com/images/hd/avengers-endgame-background-t3ndbh5e6jh8h511.jpg" class="slide-bg" alt="Slide 3">
    <img src="https://wallpapers.com/images/hd/the-twilight-saga-movie-poster-j1wugtlneymqd8vp.jpg" class="slide-bg" alt="Slide 4">

    <div class="hero-content active">
        <span class="exclusive-tag">Exclusive Premiere</span>
        <h1>THE <span style="color: var(--accent);">LEGEND</span></h1>
        <p>Tom Hardy plays the notorious Kray twins in 1960s London. A gripping tale of crime, brotherhood, and the rise of the most feared gangsters in East End history.</p>
    </div>

    <div class="hero-content">
        <span class="exclusive-tag">Trending #1</span>
        <h1>JOKER: <span style="color: var(--accent);">ORIGIN</span></h1>
        <p>In Gotham City, mentally troubled comedian Arthur Fleck is disregarded and mistreated by society. He then embarks on a downward spiral of revolution and bloody crime.</p>
    </div>

    <div class="hero-content">
        <span class="exclusive-tag">New Release</span>
        <h1>AVENGERS: <span style="color: var(--accent);">ENDGAME</span></h1>
        <p>After the devastating events of Infinity War, the universe is in ruins. With the help of remaining allies, the Avengers assemble once more in order to restore balance.</p>
    </div>

    <div class="hero-content">
        <span class="exclusive-tag">New Release</span>
        <h1>TWI<span style="color: var(--accent);">LIGHT</span></h1>
        <p>A teenage girl moves to a rainy Washington town and falls into a perilous romance with a mysterious classmate who reveals himself to be a 108-year-old vampire.</p>
    </div>
</div>

<div class="trending-section">
    <h2 class="section-title">Trending Now</h2>
    <div class="movie-grid">
        <?php 
        if(mysqli_num_rows($movie_result) > 0) {
            while($row = mysqli_fetch_assoc($movie_result)): 
                $imagePath = "../uploads/posters/" . $row['poster'];
        ?>
        <a href="movie_details.php?id=<?php echo $row['movie_id']; ?>" class="movie-card">
            <img src="<?php echo $imagePath; ?>" 
                 onerror="this.src='https://via.placeholder.com/200x300?text=No+Poster'" 
                 alt="<?php echo htmlspecialchars($row['title']); ?>">
            <div class="movie-info">
                <h4><?php echo htmlspecialchars($row['title']); ?></h4>
                <p><?php echo $row['release_year'] ?? '2024'; ?> • Movie</p>
            </div>
        </a>
        <?php 
            endwhile; 
        } else {
            echo "<p style='color: #666;'>No movies found in database.</p>";
        }
        ?>
    </div>
</div>

<script>
let currentSlide = 0;
const images = document.querySelectorAll('.slide-bg');
const contents = document.querySelectorAll('.hero-content');

function showSlide(n) {
    images.forEach(img => img.classList.remove('active'));
    contents.forEach(content => content.classList.remove('active'));

    if (images[n] && contents[n]) {
        images[n].classList.add('active');
        contents[n].classList.add('active');
    }
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % images.length;
    showSlide(currentSlide);
}

setInterval(nextSlide, 5000);
</script>

<?php include('footer.php'); ?>