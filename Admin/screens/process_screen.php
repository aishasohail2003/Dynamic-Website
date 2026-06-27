<?php
// Database connection include
include_once __DIR__ . '/../../connection/config.php';

// Professional Error Handling enable karna
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// ==========================================
// 1. ACTION: ADD SCREEN
// ==========================================
if (isset($_POST['add_screen'])) {
    // 1. Data Sanitization
    $theatre_id  = mysqli_real_escape_string($conn, $_POST['theatre_id']);
    $screen_name = mysqli_real_escape_string($conn, $_POST['screen_name']);
    $total_seats = mysqli_real_escape_string($conn, $_POST['total_seats']);

    // 2. Empty Field Validation
    if (empty($theatre_id) || empty($screen_name) || empty($total_seats)) {
        echo "<script>alert('⚠️ Error: All fields are required!'); window.history.back();</script>";
        exit();
    }

    try {
        // 3. Duplicate Screen Check (Optional but Recommended)
        // Check karein ke isi theatre mein ye screen name pehle se toh nahi?
        $check_duplicate = mysqli_query($conn, "SELECT * FROM screens WHERE theatre_id = '$theatre_id' AND screen_name = '$screen_name'");
        
        if (mysqli_num_rows($check_duplicate) > 0) {
            echo "<script>alert('❌ Error: This screen name already exists in the selected theatre!'); window.history.back();</script>";
            exit();
        }

        // 4. Final SQL Query
        $sql = "INSERT INTO screens (theatre_id, screen_name, total_seats) 
                VALUES ('$theatre_id', '$screen_name', '$total_seats')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('🚀 Success: Screen added successfully!'); window.location.href='manage_screen.php';</script>";
            exit();
        }

    } catch (mysqli_sql_exception $e) {
        // Foreign Key ya kisi aur DB error ke liye catch block
        $errorMsg = addslashes($e->getMessage());
        echo "<script>
            alert('❌ DATABASE ERROR: Operation failed!\\n\\nSystem says: $errorMsg\\n\\nTIP: Make sure the Theatre exists before adding a screen.');
            window.history.back();
        </script>";
        exit();
    }
}

// ==========================================
// 2. ACTION: DELETE SCREEN
// ==========================================
if (isset($_GET['delete_id'])) {
    try {
        $id = mysqli_real_escape_string($conn, $_GET['delete_id']);
        $sql = "DELETE FROM screens WHERE screen_id = '$id'";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('🗑️ Screen removed successfully!'); window.location.href='manage_screen.php';</script>";
            exit();
        }
    } catch (mysqli_sql_exception $e) {
        echo "<script>alert('Error: Cannot delete this screen.'); window.location.href='manage_screen.php';</script>";
        exit();
    }
}

// Default redirect agar koi seedha file access kare
header("Location: manage_screen.php");
exit();
?>