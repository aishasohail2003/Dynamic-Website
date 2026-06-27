<?php
include('config.php');
include('header.php');

$movie_id = $_GET['id'] ?? 1; // Movie ID fetch
$msg = "";

// Form submit hone par review save karein
if(isset($_POST['submit_review'])) {
    $name = mysqli_real_escape_string($conn, $_POST['user_name']);
    $rating = $_POST['rating'];
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);

    $sql = "INSERT INTO reviews (movie_id, user_name, rating, comment) VALUES ('$movie_id', '$name', '$rating', '$comment')";
    if(mysqli_query($conn, $sql)) {
        $msg = "Review submitted successfully!";
    }
}

// Movie ki details fetch karein
$movie_query = "SELECT title FROM movies WHERE movie_id = '$movie_id'";
$movie_data = mysqli_query($conn, $movie_query);
$movie = mysqli_fetch_assoc($movie_data);
?>

<style>
    :root { --accent: #ff6b00; }
    body { background: #0f1014; color: white; font-family: 'Segoe UI', sans-serif; }
    
    .review-container { max-width: 800px; margin: 50px auto; padding: 20px; }
    
    /* Star Rating Styling */
    .rating-stars { display: flex; flex-direction: row-reverse; justify-content: flex-end; gap: 10px; }
    .rating-stars input { display: none; }
    .rating-stars label { font-size: 30px; color: #444; cursor: pointer; transition: 0.3s; }
    .rating-stars input:checked ~ label,
    .rating-stars label:hover,
    .rating-stars label:hover ~ label { color: var(--accent); }

    .review-form { 
        background: rgba(255,255,255,0.05); 
        padding: 30px; 
        border-radius: 20px; 
        border: 1px solid rgba(255,255,255,0.1);
        margin-bottom: 40px;
    }
    
    .input-field {
        width: 100%; background: rgba(0,0,0,0.3); border: 1px solid #333;
        padding: 12px; border-radius: 10px; color: white; margin-top: 10px;
    }

    .btn-submit {
        background: var(--accent); color: white; border: none; padding: 12px 30px;
        border-radius: 10px; font-weight: bold; cursor: pointer; margin-top: 20px;
    }

    .review-card {
        background: rgba(255,255,255,0.03); padding: 20px; border-radius: 15px;
        margin-bottom: 15px; border-left: 4px solid var(--accent);
    }
    .user-meta { font-size: 14px; color: #888; }
    .star-display { color: var(--accent); margin: 5px 0; }
</style>

<div class="review-container">
    <h2>Reviews for: <span style="color:var(--accent)"><?= $movie['title'] ?? 'Movixo' ?></span></h2>
    
    <?php if($msg): ?>
        <p style="color: #2ecc71; background: rgba(46, 204, 113, 0.1); padding: 10px; border-radius: 5px;"><?= $msg ?></p>
    <?php endif; ?>

    <div class="review-form">
        <h3>Rate your experience</h3>
        <form method="POST">
            <div class="rating-stars">
                <input type="radio" name="rating" value="5" id="5"><label for="5">★</label>
                <input type="radio" name="rating" value="4" id="4"><label for="4">★</label>
                <input type="radio" name="rating" value="3" id="3"><label for="3">★</label>
                <input type="radio" name="rating" value="2" id="2"><label for="2">★</label>
                <input type="radio" name="rating" value="1" id="1" required><label for="1">★</label>
            </div>
            
            <input type="text" name="user_name" placeholder="Your Name" class="input-field" required>
            <textarea name="comment" rows="4" placeholder="Write your review here..." class="input-field" required></textarea>
            
            <button type="submit" name="submit_review" class="btn-submit">Submit Review</button>
        </form>
    </div>

    <div class="reviews-list">
        <h3>User Reviews</h3>
        <?php 
        $fetch_reviews = mysqli_query($conn, "SELECT * FROM reviews WHERE movie_id = '$movie_id' ORDER BY created_at DESC");
        if(mysqli_num_rows($fetch_reviews) > 0) {
            while($rev = mysqli_fetch_assoc($fetch_reviews)) {
                echo "<div class='review-card'>
                        <div class='user-meta'><strong>{$rev['user_name']}</strong> • " . date('M d, Y', strtotime($rev['created_at'])) . "</div>
                        <div class='star-display'>" . str_repeat('★', $rev['rating']) . str_repeat('☆', 5-$rev['rating']) . "</div>
                        <p style='margin:10px 0 0 0'>{$rev['comment']}</p>
                      </div>";
            }
        } else {
            echo "<p style='color:#666'>No reviews yet. Be the first to rate!</p>";
        }
        ?>
    </div>
</div>

<?php include('footer.php'); ?>