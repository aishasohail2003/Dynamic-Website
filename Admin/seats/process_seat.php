<?php
session_start();
include_once __DIR__ . '/../../connection/config.php';

// Security Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../User/login.php");
    exit();
}

// --- SEAT INSERT LOGIC ---
if (isset($_POST['save_seat'])) {
    $screen_id   = mysqli_real_escape_string($conn, $_POST['screen_id']);
    $seat_type   = mysqli_real_escape_string($conn, $_POST['seat_type']);
    $price       = mysqli_real_escape_string($conn, $_POST['price']);
    $seat_input  = mysqli_real_escape_string($conn, $_POST['seat_number']);

    $seats_array = explode(',', $seat_input);
    $success_count = 0;

    foreach ($seats_array as $entry) {
        $entry = trim($entry);
        if (strpos($entry, '-') !== false) {
            list($start, $end) = explode('-', $entry);
            $letter = preg_replace('/[0-9]/', '', $start);
            $num_start = (int)preg_replace('/[^0-9]/', '', $start);
            $num_end   = (int)preg_replace('/[^0-9]/', '', $end);

            for ($i = $num_start; $i <= $num_end; $i++) {
                $final_seat = $letter . $i;
                $query = "INSERT INTO seats (screen_id, seat_number, seat_type, price) 
                          VALUES ('$screen_id', '$final_seat', '$seat_type', '$price')";
                if (mysqli_query($conn, $query)) $success_count++;
            }
        } else {
            if (!empty($entry)) {
                $query = "INSERT INTO seats (screen_id, seat_number, seat_type, price) 
                          VALUES ('$screen_id', '$entry', '$seat_type', '$price')";
                if (mysqli_query($conn, $query)) $success_count++;
            }
        }
    }

    if ($success_count > 0) {
        echo "<script>alert('$success_count Seats Added Successfully!'); window.location='manage_seat.php';</script>";
    } else {
        header("Location: manage_seat.php?error=failed");
    }
    exit();
}

// --- DELETE SEAT LOGIC (Aapka diya hua logic) ---
if (isset($_GET['delete_id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    
    // Pehle check karein ke ye seat kisi booking mein toh nahi?
    $check_booking = $conn->query("SELECT * FROM bookings WHERE seat_id = '$id'");
    
    if ($check_booking->num_rows > 0) {
        // Agar seat booked hai toh error message
        header("Location: manage_seat.php?error=already_booked");
    } else {
        $sql = "DELETE FROM seats WHERE seat_id = '$id'";
        if ($conn->query($sql)) {
            header("Location: manage_seat.php?success=deleted");
        } else {
            header("Location: manage_seat.php?error=db_error");
        }
    }
    exit();
}
?>