<?php
// 1. Connection include karein
include_once __DIR__ . '/../../connection/config.php';

// --- A. DELETE LOGIC ---
if (isset($_GET['delete_id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    
    $delete_query = "DELETE FROM shows WHERE show_id = '$id'";
    
    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Show deleted successfully!'); window.location.href='manage_show.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error: Could not delete show!'); window.location.href='manage_show.php';</script>";
        exit();
    }
}

// --- B. ADD SHOW LOGIC ---
if (isset($_POST['add_showtime'])) {
    $movie_id   = mysqli_real_escape_string($conn, $_POST['movie_id']);
    $theatre_id = mysqli_real_escape_string($conn, $_POST['theatre_id']);
    $screen_id  = mysqli_real_escape_string($conn, $_POST['screen_id']);
    $show_date  = mysqli_real_escape_string($conn, $_POST['show_date']);
    $show_time  = mysqli_real_escape_string($conn, $_POST['show_time']);

    // Conflict Check
    $check = mysqli_query($conn, "SELECT * FROM shows WHERE screen_id='$screen_id' AND show_date='$show_date' AND show_time='$show_time'");
    
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Slot already booked!'); window.history.back();</script>";
    } else {
        $sql = "INSERT INTO shows (movie_id, theatre_id, screen_id, show_date, show_time) 
                VALUES ('$movie_id', '$theatre_id', '$screen_id', '$show_date', '$show_time')";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Show added successfully!'); window.location.href='manage_show.php';</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.history.back();</script>";
        }
    }
    exit();
}

// --- C. UPDATE SHOW LOGIC ---
if (isset($_POST['update_showtime'])) {
    $show_id    = mysqli_real_escape_string($conn, $_POST['show_id']);
    $movie_id   = mysqli_real_escape_string($conn, $_POST['movie_id']);
    $theatre_id = mysqli_real_escape_string($conn, $_POST['theatre_id']);
    $screen_id  = mysqli_real_escape_string($conn, $_POST['screen_id']);
    $show_date  = mysqli_real_escape_string($conn, $_POST['show_date']);
    $show_time  = mysqli_real_escape_string($conn, $_POST['show_time']);

    // Conflict check (excluding current show)
    $check = mysqli_query($conn, "SELECT * FROM shows WHERE screen_id='$screen_id' AND show_date='$show_date' AND show_time='$show_time' AND show_id != '$show_id'");
    
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Conflict: Slot already booked!'); window.history.back();</script>";
    } else {
        $sql = "UPDATE shows SET movie_id='$movie_id', theatre_id='$theatre_id', screen_id='$screen_id', show_date='$show_date', show_time='$show_time' WHERE show_id='$show_id'";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Show updated successfully!'); window.location.href='manage_show.php';</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.history.back();</script>";
        }
    }
    exit();
}
?>