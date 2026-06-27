<?php
include('config.php');  
include('header.php');  

// Fetch movies from database
$query = "SELECT * FROM movies ORDER BY release_date DESC";
$result = mysqli_query($conn, $query);
?>

<style>
/* Page Layout */
body { 
    margin: 0;
    padding: 0;
    background: linear-gradient(rgba(0,0,0,0.85), rgba(0,0,0,0.85)), 
                url('https://img.freepik.com/free-photo/dark-vip-cinema-studio-still-life_23-2149500599.jpg?semt=ais_hybrid&w=740&q=80');
    background-size: cover;
    background-position: center;
    background-attachment: fixed; 
    color: white; 
    font-family: 'Poppins', sans-serif; 
}

/* Balanced Container */
.main-content {
    width: 90%; /* Balanced width for perfect card size */
    margin: 0 auto;
    padding: 20px 0;
}

/* Movie Grid - Fixed Column Width for original shape */
.movie-grid {
    display: grid;
    /* Cards ki width fix kar di taake wo patle na hon */
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); 
    gap: 30px; 
    padding: 20px 0 60px 0;
}

/* Movie Card Styling */
.movie-card {
    background: #1a1a1a;
    border-radius: 12px;
    overflow: hidden;
    text-decoration: none;
    transition: transform 0.3s ease;
    border: 1px solid rgba(255,255,255,0.1);
    display: flex;
    flex-direction: column;
}

.movie-card:hover {
    transform: translateY(-8px);
    border-color: #ff6b00;
}

/* Poster Aspect Ratio Fix */
.movie-card img {
    width: 100%;
    height: 320px; /* Poster height adjusted for perfect ratio */
    object-fit: cover;
    display: block;
}

.movie-info {
    padding: 18px;
    background: #1a1a1a;
}

.movie-info h4 {
    margin: 0;
    font-size: 16px;
    color: #fff;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.movie-info p {
    margin: 10px 0 0 0;
    font-size: 12px;
    color: #ff6b00;
    font-weight: 600;
    line-height: 1.4;
}
</style>

<div class="main-content">
    <h1 style="margin: 40px 0 10px 0; font-size: 32px; font-weight: 800; text-transform: uppercase;">
        All Movies
    </h1>

    <div class="movie-grid">
        <?php 
        if(mysqli_num_rows($result) > 0): 
            while($row = mysqli_fetch_assoc($result)): 
                
                $posterName = $row['poster'];
                $imagePath = "../uploads/posters/" . $posterName;

                $displayPath = (empty($posterName) || !file_exists($imagePath)) 
                               ? "https://via.placeholder.com/220x320?text=No+Image" 
                               : $imagePath;
        ?>
            <a href="movie_details.php?id=<?php echo $row['movie_id']; ?>" class="movie-card">
                <img src="<?php echo $displayPath; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                
                <div class="movie-info">
                    <h4><?php echo htmlspecialchars($row['title']); ?></h4>
                    <p>
                        <?php echo date('Y-m-d', strtotime($row['release_date'])); ?> • 
                        <?php echo htmlspecialchars($row['genre']); ?>
                    </p>
                </div>
            </a>

        <?php 
            endwhile; 
        else: 
        ?>
            <div style="grid-column: 1/-1; padding: 40px; color: #666;">No movies found.</div>
        <?php endif; ?>
    </div>
</div>

<?php include('footer.php'); ?>