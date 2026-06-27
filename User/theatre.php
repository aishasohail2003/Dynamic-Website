<?php 
include('config.php'); 
include('header.php'); 

// Theatre query - sirf 'active' theatres dikhane ke liye
$theatre_query = "SELECT * FROM theatres WHERE status = 'active' ORDER BY theatre_id DESC";
$theatre_result = mysqli_query($conn, $theatre_query);
?>

<style>
    :root { --accent: #ff6b00; }
    body { background-color: #0c0c0c; color: white; font-family: 'Poppins', sans-serif;  
    background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                url('https://img.freepik.com/free-photo/dark-vip-cinema-studio-still-life_23-2149500599.jpg?semt=ais_hybrid&w=740&q=80');
    background-size: cover;}
    
    .section-container { padding: 40px 50px; }
    .section-title { 
        font-size: 28px; 
        margin-bottom: 30px; 
        border-left: 5px solid var(--accent); 
        padding-left: 15px; 
    }

    .grid-layout {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 25px;
    }

    .theatre-card {
        background: #161616;
        border-radius: 15px;
        padding: 20px;
        transition: 0.3s;
        border: 1px solid rgba(255,255,255,0.05);
        text-decoration: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .theatre-card:hover {
        transform: translateY(-8px);
        border-color: var(--accent);
        background: #1c1c1c;
    }

    /* Cinema Icon Box */
    .icon-box {
        width: 80px;
        height: 80px;
        background: rgba(255, 107, 0, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
        color: var(--accent);
        font-size: 30px;
    }

    .theatre-info h4 { 
        margin: 10px 0 5px 0; 
        font-size: 18px; 
        color: white;
        text-transform: uppercase;
    }

    .city-tag {
        color: var(--accent);
        font-size: 13px;
        font-weight: bold;
        margin-bottom: 10px;
        display: block;
    }

    .address-text {
        color: #888;
        font-size: 13px;
        line-height: 1.4;
        margin: 0;
    }

    .btn-book {
        margin-top: 15px;
        background: transparent;
        border: 1px solid var(--accent);
        color: var(--accent);
        padding: 8px 20px;
        border-radius: 5px;
        font-size: 12px;
        font-weight: bold;
        transition: 0.3s;
    }

    .theatre-card:hover .btn-book {
        background: var(--accent);
        color: white;
    }
</style>

<div class="section-container">
    <h2 class="section-title">Select a Theatre</h2>
    <div class="grid-layout">
        <?php 
        if(mysqli_num_rows($theatre_result) > 0) {
            while($row = mysqli_fetch_assoc($theatre_result)): 
        ?>
        
        <a href="booking.php?theatre_id=<?php echo $row['theatre_id']; ?>" class="theatre-card">
            <div class="icon-box">
                <i class="fas fa-film"></i> <img src="https://cdn-icons-png.flaticon.com/512/3172/3172554.png" width="40" style="filter: invert(48%) sepia(79%) saturate(2476%) hue-rotate(1deg) brightness(102%) contrast(105%);">
            </div>

            <div class="theatre-info">
                <span class="city-tag"><?php echo htmlspecialchars($row['city']); ?></span>
                <h4><?php echo htmlspecialchars($row['name']); ?></h4>
                <p class="address-text"><?php echo htmlspecialchars($row['address']); ?></p>
            </div>

            <button class="btn-book">VIEW SHOWTIMES</button>
        </a>

        <?php 
            endwhile; 
        } else { 
            echo "<p style='color: #666;'>Abhi koi theatre active nahi hai.</p>"; 
        } 
        ?>
    </div>
</div>

<?php include('footer.php'); ?>