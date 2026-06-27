<?php
// Error reporting on taake koi blank page ka issue ho to nazar aaye
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once __DIR__ . '/../../connection/config.php';

// ==========================================
// 1. ACTION: ADD NEW THEATRE
// ==========================================
if (isset($_POST['add_theatre'])) {
    
    // Data fetching and Sanitization (Cleaning)
    $name    = trim(mysqli_real_escape_string($conn, $_POST['name']));
    $city    = trim(mysqli_real_escape_string($conn, $_POST['city']));
    $address = trim(mysqli_real_escape_string($conn, $_POST['address']));

    // --- FULL PHP VALIDATIONS ---
    $errors = [];

    if (empty($name)) { 
        $errors[] = "Theatre Name is mandatory!"; 
    } elseif (strlen($name) < 3) {
        $errors[] = "Theatre Name must be at least 3 characters long.";
    }

    if (empty($city)) { 
        $errors[] = "Please select a City from the dropdown!"; 
    }

    if (empty($address)) { 
        $errors[] = "Full location address is required!"; 
    } elseif (strlen($address) < 10) {
        $errors[] = "Address is too short. Please provide more details.";
    }

    // Check if there are any validation errors
    if (!empty($errors)) {
        // Pehla error alert box mein dikhayega aur pichle page pe bhej dega
        echo "<script>alert('" . $errors[0] . "'); window.history.back();</script>";
        exit();
    }

    // --- DATABASE INSERTION ---
    // Ensure 'city' column exists in your 'theatres' table
    $sql = "INSERT INTO theatres (name, city, address) VALUES ('$name', '$city', '$address')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('🏢 Theatre Location Registered Successfully!'); window.location.href='manage_theatres.php';</script>";
        exit();
    } else {
        // Agar Database mein error ho (e.g. Column name mismatch)
        $db_error = mysqli_error($conn);
        echo "<script>alert('Database Error: $db_error'); window.history.back();</script>";
        exit();
    }
}

// ==========================================
// 2. ACTION: DELETE THEATRE
// ==========================================
if (isset($_GET['delete_id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    
    // Check if ID is numeric for security
    if (!is_numeric($id)) {
        echo "<script>alert('Invalid ID!'); window.location.href='manage_theatres.php';</script>";
        exit();
    }

    $sql = "DELETE FROM theatres WHERE theatre_id = '$id'";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('🗑️ Theatre Removed Successfully!'); window.location.href='manage_theatres.php';</script>";
        exit();
    } else {
        echo "<script>alert('Delete Error: Unable to remove record.'); window.location.href='manage_theatres.php';</script>";
        exit();
    }
}

// Agar koi bina button click kiye is file pe aaye toh redirect back
header("Location: manage_theatres.php");
exit();
?>