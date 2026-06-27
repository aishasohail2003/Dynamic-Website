<?php 
include_once __DIR__ . '/../../connection/config.php'; 
include_once __DIR__ . '/../../inc/header.php'; 
?>

<style>
    :root {
        --movixo-red: #e50914;
        --dark-bg: #0a0a0a;
        --card-bg: #121212;
    }

    body { background-color: var(--dark-bg); color: #fff; font-family: 'Inter', sans-serif; }

    .setup-container {
        max-width: 900px;
        margin: 50px auto;
        padding: 40px;
        background: var(--card-bg);
        border: 1px solid #222;
        border-radius: 15px;
        position: relative;
    }

    /* Red outline effect like your screenshot */
    .setup-container::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        border: 1px solid rgba(229, 9, 20, 0.3);
        border-radius: 15px;
        pointer-events: none;
    }

    .title-main {
        font-size: 2.5rem;
        font-weight: 900;
        text-transform: uppercase;
        text-align: center;
        letter-spacing: -1px;
    }

    .title-red { color: var(--movixo-red); }

    .sub-text {
        color: #666;
        text-align: center;
        margin-bottom: 40px;
        font-size: 14px;
    }

    .input-label {
        font-size: 12px;
        font-weight: 700;
        color: #888;
        text-transform: uppercase;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }

    .input-label i { color: var(--movixo-red); margin-right: 8px; font-size: 16px; }

    .movixo-input {
        background: #181818;
        border: 1px solid #333;
        border-radius: 10px;
        color: #fff;
        padding: 15px;
        width: 100%;
        transition: 0.3s;
    }

    .movixo-input:focus {
        border-color: var(--movixo-red);
        background: #1a1a1a;
        outline: none;
        box-shadow: 0 0 15px rgba(229, 9, 20, 0.1);
    }

    .btn-initialize {
        background: var(--movixo-red);
        color: #fff;
        border: none;
        width: 100%;
        padding: 18px;
        border-radius: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-top: 30px;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-initialize:hover {
        background: #b20710;
        transform: scale(1.01);
    }

    .note-text {
        font-size: 11px;
        color: #444;
        margin-top: 15px;
        text-transform: uppercase;
        font-weight: 700;
    }
</style>

<div class="container">
    <div class="setup-container">
        <h1 class="title-main text-white">ADD <span class="title-red">SEATS</span></h1>
        <p class="sub-text">Assign seating capacity and pricing for your auditorium.</p>

        <form action="process_seat.php" method="POST">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="input-label"><i class="fas fa-desktop"></i> SELECT SCREEN NUMBER</label>
                    <select name="screen_id" class="movixo-input">
                        <option value="13">Screen 13</option>
                        <option value="1">Screen 01</option>
                        </select>
                </div>

                <div class="col-md-6 mb-4">
                    <label class="input-label"><i class="fas fa-tag"></i> SEAT CATEGORY</label>
                    <select name="seat_type" class="movixo-input">
                        <option value="Platinum">Platinum Class</option>
                        <option value="Gold">Gold Class</option>
                        <option value="Box">Premium Box</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label class="input-label"><i class="fas fa-couch"></i> SEAT NUMBERS / RANGE</label>
                <input type="text" name="seat_number" class="movixo-input" placeholder="e.g. G1, G2, G3 or H1-H10">
                <p class="note-text">Tip: Separate seats with commas for bulk entry.</p>
            </div>

            <div class="mb-4">
                <label class="input-label"><i class="fas fa-dollar-sign"></i> TICKET PRICE (PKR)</label>
                <input type="number" name="price" class="movixo-input" placeholder="e.g. 500">
            </div>

            <button type="submit" name="save_seat" class="btn-initialize">
                INITIALIZE SEAT CONFIGURATION
            </button>
        </form>
    </div>
</div>

<?php include_once __DIR__ . '/../../inc/footer.php'; ?>