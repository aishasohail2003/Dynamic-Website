<?php 
include('config.php'); 
include('header.php'); 

// 1. Movie details fetch
$id = isset($_GET['id']) ? intval($_GET['id']) : 1; 
$query = "SELECT * FROM movies WHERE movie_id = $id";
$result = mysqli_query($conn, $query);
$movie = mysqli_fetch_assoc($result);

if (!$movie) {
    die("<div style='color:white; text-align:center; padding:100px;'><h3>Movie Not Found!</h3></div>");
}

// 2. Booked Seats Fetch
$booked_seats = [];
$booked_query = mysqli_query($conn, "SELECT seat_id FROM booking_seats");
while($row = mysqli_fetch_assoc($booked_query)) {
    $booked_seats[] = $row['seat_id'];
}

// 3. Seats Fetch
$all_seats_query = mysqli_query($conn, "SELECT * FROM seats ORDER BY seat_id ASC");
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --accent: #ff6b00;
        --platinum: #00d4ff;
        --gold: #ffd700;
        --card-bg: #111;
        --seat-size: 50px; /* Size bada kiya gaya hai */
    }
    
    body { background: #080808; color: white; font-family: 'Poppins', sans-serif; margin: 0; }

    .booking-container { 
        display: flex; 
        flex-direction: column; 
        align-items: center; 
        padding: 50px 20px;
        max-width: 1400px; /* Container ko mazeed wide kiya hai */
        margin: 0 auto;
    }

    /* Modern Curved Wide Screen */
    .screen-container {
        perspective: 1000px;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 60px;
    }

    .screen { 
        width: 85%; 
        height: 15px; 
        background: #fff; 
        box-shadow: 0 15px 40px rgba(255,255,255,0.5); 
        border-radius: 50% / 100% 100% 0 0;
        transform: rotateX(-10deg);
    }

    .screen-text {
        color: #444;
        font-size: 12px;
        letter-spacing: 5px;
        margin-top: 15px;
        text-transform: uppercase;
    }
    
    /* HORIZONTAL WIDE SEAT LAYOUT */
    .seat-area { 
        display: grid; 
        /* repeat(12) ko aap change kar sakte hain jitni seats ek line mein dikhani hain */
        grid-template-columns: repeat(auto-fit, minmax(var(--seat-size), 1fr)); 
        gap: 15px; 
        width: 100%; /* Side tak phelane ke liye */
        padding: 20px;
        justify-content: center;
    }

    .seat {
        width: var(--seat-size); 
        height: var(--seat-size); 
        background: #1a1a1a;
        border-radius: 8px; 
        cursor: pointer;
        display: flex; 
        align-items: center; 
        justify-content: center;
        font-size: 12px; 
        font-weight: 700;
        border-bottom: 4px solid rgba(0,0,0,0.5); /* 3D look */
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    /* Category Borders with Glow */
    .seat.Gold { border: 2px solid var(--gold); box-shadow: 0 0 5px rgba(255, 215, 0, 0.2); }
    .seat.Platinum { border: 2px solid var(--platinum); box-shadow: 0 0 5px rgba(0, 212, 255, 0.2); }

    .seat:hover {
        transform: scale(1.15) translateY(-5px);
        background: #222;
    }

    .seat.selected { 
        background: var(--accent) !important; 
        border-color: var(--accent) !important; 
        color: white; 
        box-shadow: 0 0 15px var(--accent);
    }

    .seat.occupied { 
        background: #222 !important; 
        opacity: 0.2; 
        cursor: not-allowed; 
        pointer-events: none; 
        border-color: #333 !important; 
    }
    
    .legend { display: flex; gap: 30px; margin: 40px 0; }
    .legend div { display: flex; align-items: center; gap: 10px; font-weight: 600; font-size: 14px; }
    .dot { width: 12px; height: 12px; border-radius: 50%; display: inline-block; }

    .booking-summary { 
        background: var(--card-bg); 
        padding: 35px; 
        border-radius: 20px; 
        width: 100%; 
        max-width: 500px; 
        margin-top: 50px; 
        border: 1px solid #222; 
        text-align: center;
        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
    }

    .btn-confirm { 
        background: var(--accent); 
        color: white; 
        border: none; 
        padding: 18px; 
        width: 100%; 
        border-radius: 12px; 
        font-weight: 700; 
        font-size: 16px;
        cursor: pointer; 
        margin-top: 20px; 
        transition: 0.4s;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .btn-confirm:hover { 
        box-shadow: 0 10px 20px rgba(255, 107, 0, 0.4);
        transform: translateY(-2px);
    }

    /* Footer Poppins Bold */
    footer, footer * { font-family: 'Poppins', sans-serif !important; font-weight: 700 !important; }
</style>

<div class="booking-container">
    <h1 style="color:var(--accent); font-weight:700; font-size: 36px; margin-bottom: 5px;">
        <?php echo htmlspecialchars($movie['title']); ?>
    </h1>
    <p style="color:#666; font-weight: 600;">Choose your seats for an immersive experience</p>
    
    <div class="screen-container">
        <div class="screen"></div>
        <div class="screen-text">SCREEN THIS WAY</div>
    </div>

    <div class="legend">
        <div><span class="dot" style="background:var(--gold)"></span> Gold</div>
        <div><span class="dot" style="background:var(--platinum)"></span> Platinum</div>
        <div><span class="dot" style="background:var(--accent)"></span> Selected</div>
        <div><span class="dot" style="background:#222"></span> Occupied</div>
    </div>

    <div class="seat-area">
        <?php 
        if(mysqli_num_rows($all_seats_query) > 0) {
            while($seat = mysqli_fetch_assoc($all_seats_query)) {
                $s_id = $seat['seat_id'];
                $s_num = $seat['seat_number'];
                $s_type = $seat['seat_type']; 
                $s_price = $seat['price'];

                $isOccupied = in_array($s_id, $booked_seats);
                $class = "seat $s_type " . ($isOccupied ? "occupied" : "");

                echo "<div class='$class' data-id='$s_id' data-num='$s_num' data-price='$s_price' title='$s_type Row - Rs $s_price'>$s_num</div>";
            }
        } else {
            echo "<p style='grid-column: 1/-1;'>No seats configured by Admin.</p>";
        }
        ?>
    </div>

    <div class="booking-summary">
        <h3 style="margin:0 0 20px 0; font-weight:700; font-size: 22px;">Order Summary</h3>
        <div style="display:flex; justify-content: space-between; margin-bottom: 10px; color: #888;">
            <span>Selected Seats:</span>
            <span id="seat-list" style="color:white; font-weight: 700;">-</span>
        </div>
        <div style="display:flex; justify-content: space-between; border-top: 1px solid #222; padding-top: 15px;">
            <span style="font-size: 18px; font-weight: 600;">Total Amount:</span>
            <span style="font-size: 20px; font-weight: 700; color:var(--accent)">Rs <span id="total-val">0</span></span>
        </div>

        <form action="checkout.php" method="POST" id="seatForm">
            <input type="hidden" name="movie_id" value="<?php echo $id; ?>">
            <input type="hidden" name="selected_seats" id="input_seats">
            <input type="hidden" name="total_amount" id="input_total">
            <button type="submit" class="btn-confirm">Book My Tickets Now</button>
        </form>
    </div>
</div>

<script>
    const seats = document.querySelectorAll('.seat:not(.occupied)');
    const seatListDisplay = document.getElementById('seat-list');
    const totalDisplay = document.getElementById('total-val');
    const inputSeats = document.getElementById('input_seats');
    const inputTotal = document.getElementById('input_total');

    let selectedSeatsData = [];

    seats.forEach(seat => {
        seat.addEventListener('click', () => {
            seat.classList.toggle('selected');
            
            const sId = seat.getAttribute('data-id');
            const sNum = seat.getAttribute('data-num');
            const sPrice = parseFloat(seat.getAttribute('data-price'));

            if(seat.classList.contains('selected')) {
                selectedSeatsData.push({ id: sId, num: sNum, price: sPrice });
            } else {
                selectedSeatsData = selectedSeatsData.filter(s => s.id !== sId);
            }

            updateUI();
        });
    });

    function updateUI() {
        let names = selectedSeatsData.map(s => s.num);
        let totalPrice = selectedSeatsData.reduce((sum, s) => sum + s.price, 0);

        seatListDisplay.innerText = names.length > 0 ? names.join(', ') : '-';
        totalDisplay.innerText = totalPrice;

        inputSeats.value = selectedSeatsData.map(s => s.id).join(',');
        inputTotal.value = totalPrice;
    }

    document.getElementById('seatForm').onsubmit = function(e) {
        if(selectedSeatsData.length === 0) {
            alert("Please select at least one seat to proceed.");
            e.preventDefault();
        }
    };
</script>

<?php include('footer.php'); ?>