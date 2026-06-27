<?php 
include('config.php'); 
include('header.php'); 

$where_clause = "";
$selected_movie = null;

// URL se movie_id check karna
if (isset($_GET['movie_id']) && !empty($_GET['movie_id'])) {
    $m_id = mysqli_real_escape_string($conn, $_GET['movie_id']);
    $where_clause = " WHERE s.movie_id = '$m_id' ";
    
    // Front pe dikhane ke liye movie ki detail nikalna
    $movie_info = mysqli_query($conn, "SELECT title FROM movies WHERE movie_id = '$m_id'");
    $selected_movie = mysqli_fetch_assoc($movie_info);
}

// Main Query
$query = "SELECT s.*, m.title, m.poster, t.name as theatre_name 
          FROM shows s
          JOIN movies m ON s.movie_id = m.movie_id
          JOIN theatres t ON s.theatre_id = t.theatre_id
          $where_clause 
          ORDER BY s.show_date ASC";

$result = mysqli_query($conn, $query);
?>

<style>
    :root { --accent: #ff6b00; }
    body { background-color: #0c0c0c; color: white; font-family: 'Poppins', sans-serif;
background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                url('https://img.freepik.com/free-photo/dark-vip-cinema-studio-still-life_23-2149500599.jpg?semt=ais_hybrid&w=740&q=80');
    background-size: cover;}
    
    .section-container { padding: 40px 50px; }
    
    /* Front Info Bar */
    .filter-header {
        background: #1a1a1a;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 1px dashed #444;
    }

    .filter-info h2 { margin: 0; font-size: 24px; color: var(--accent); }
    .filter-info p { margin: 5px 0 0; color: #aaa; font-size: 14px; }

    .btn-all-shows {
        background: transparent;
        color: white;
        border: 1px solid white;
        padding: 8px 20px;
        text-decoration: none;
        border-radius: 5px;
        font-size: 14px;
        transition: 0.3s;
    }
    .btn-all-shows:hover { background: white; color: black; }

    .grid-layout {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 25px;
    }

    .show-card {
        background: #161616;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #333;
        transition: 0.3s;
    }

    .show-card:hover { border-color: var(--accent); transform: translateY(-5px); }

    .poster-wrapper { width: 100%; height: 350px; overflow: hidden; }
    .poster-wrapper img { width: 100%; height: 100%; object-fit: cover; }

    .show-details { padding: 15px; }
    .movie-title { font-size: 18px; color: #fff; margin-bottom: 5px; }
    .theatre-name { color: var(--accent); font-size: 14px; margin-bottom: 12px; font-weight: bold; }
    
    .timing-info {
        background: #262626;
        padding: 8px;
        border-radius: 5px;
        font-size: 12px;
        display: flex;
        justify-content: space-between;
        color: #ccc;
    }

    .btn-book {
        display: block;
        text-align: center;
        background: var(--accent);
        color: white;
        text-decoration: none;
        padding: 10px;
        margin-top: 15px;
        border-radius: 6px;
        font-weight: bold;
    }
</style>

<div class="section-container">

    <?php if($selected_movie): ?>
    <div class="filter-header">
        <div class="filter-info">
            <h2>Showing Results for: <?php echo htmlspecialchars($selected_movie['title']); ?></h2>
            <p>Select your preferred theatre and timing below.</p>
        </div>
        <a href="shows.php" class="btn-all-shows">View All Movies</a>
        <a href="movie_details.php?id=<?php echo urlencode($m_id); ?>" class="btn-book">View Details & Seats</a>
    </div>
    <?php else: ?>
    <h2 class="section-title">All Available Shows</h2>
    <?php endif; ?>
    
    <div class="grid-layout">
        <?php 
        if(mysqli_num_rows($result) > 0):
            while($row = mysqli_fetch_assoc($result)): 
                $imagePath = "../uploads/posters/" . $row['poster'];
        ?>
        
        <div class="show-card">
            <div class="poster-wrapper">
                <img src="<?php echo $imagePath; ?>" onerror="this.src='https://via.placeholder.com/300x450?text=No+Poster'">
            </div>

            <div class="show-details">
                <h4 class="movie-title"><?php echo htmlspecialchars($row['title']); ?></h4>
                <div class="theatre-name">
                    <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['theatre_name']); ?>
                </div>
                
                <div class="timing-info">
                    <span><i class="far fa-calendar-alt"></i> <?php echo date('D, d M', strtotime($row['show_date'])); ?></span>
                    <span><i class="far fa-clock"></i> <?php echo date('h:i A', strtotime($row['show_time'])); ?></span>
                </div>

                <a href="booking.php?id=<?php echo urlencode($row['movie_id']); ?>" class="btn-book">Get Tickets</a>
            </div>
        </div>

        <?php 
            endwhile; 
        else: 
            echo "<p style='text-align:center; width:100%; padding:50px;'>No shows found for this movie.</p>";
        endif; 
        ?>
    </div>
</div>

<?php include('footer.php'); ?>