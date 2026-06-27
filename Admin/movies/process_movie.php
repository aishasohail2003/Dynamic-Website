<?php
// 1. Force Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 2. Include Database Connection
$config_path = __DIR__ . '/../../connection/config.php';

if (file_exists($config_path)) {
    include_once $config_path;
} else {
    die("❌ Error: config.php file nahi mili.");
}

if (!$conn) {
    die("❌ Database Connection Failed: " . mysqli_connect_error());
}

// ==========================================
// 3. ADD MOVIE LOGIC
// ==========================================
if (isset($_POST['add_movie'])) {
    
    $title        = trim(mysqli_real_escape_string($conn, $_POST['title']));
    $genre        = trim(mysqli_real_escape_string($conn, $_POST['genre']));
    $duration     = trim(mysqli_real_escape_string($conn, $_POST['duration']));
    $release_date = trim(mysqli_real_escape_string($conn, $_POST['release_date']));
    $status       = trim(mysqli_real_escape_string($conn, $_POST['status']));
    $description  = trim(mysqli_real_escape_string($conn, $_POST['description']));
    $trailer_url  = trim(mysqli_real_escape_string($conn, $_POST['trailer_url']));

    $errors = [];
    if (empty($title))     $errors[] = "Movie title is required.";
    if (empty($duration))  $errors[] = "Duration is required.";

    $newFileName = "";
    if (isset($_FILES['poster']) && $_FILES['poster']['error'] === 0) {
        $posterName    = $_FILES['poster']['name'];
        $posterTmpName = $_FILES['poster']['tmp_name'];
        $fileExt       = strtolower(pathinfo($posterName, PATHINFO_EXTENSION));
        $allowed       = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($fileExt, $allowed)) {
            $newFileName = "MOV_" . uniqid('', true) . "." . $fileExt;
            $targetDir   = "../../uploads/posters/";
            if (!is_dir($targetDir)) { mkdir($targetDir, 0777, true); }
            if (!move_uploaded_file($posterTmpName, $targetDir . $newFileName)) {
                $errors[] = "Failed to move uploaded file.";
            }
        } else {
            $errors[] = "Invalid file type.";
        }
    } else {
        $errors[] = "Please select a valid poster image.";
    }

    if (!empty($errors)) {
        echo "<script>alert('" . $errors[0] . "'); window.history.back();</script>";
        exit();
    }

    $sql = "INSERT INTO movies (title, genre, duration, release_date, status, description, poster) 
            VALUES ('$title', '$genre', '$duration', '$release_date', '$status', '$description', '$newFileName')";

    if (mysqli_query($conn, $sql)) {
        $new_movie_id = mysqli_insert_id($conn);
        if (!empty($trailer_url)) {
            $trailer_title = $title . " Official Trailer";
            mysqli_query($conn, "INSERT INTO trailers (movie_id, trailer_title, trailer_url) VALUES ('$new_movie_id', '$trailer_title', '$trailer_url')");
        }
        echo "<script>alert('🎬 Movie & Trailer Added Successfully!'); window.location.href='manage_movie.php';</script>";
        exit();
    }

// ==========================================
// 4. UPDATE MOVIE LOGIC (NEW & FIXED)
// ==========================================
} elseif (isset($_POST['update_movie'])) {
    
    $movie_id     = mysqli_real_escape_string($conn, $_POST['movie_id']);
    $title        = trim(mysqli_real_escape_string($conn, $_POST['title']));
    $genre        = trim(mysqli_real_escape_string($conn, $_POST['genre']));
    $duration     = trim(mysqli_real_escape_string($conn, $_POST['duration']));
    $release_date = trim(mysqli_real_escape_string($conn, $_POST['release_date']));
    $status       = trim(mysqli_real_escape_string($conn, $_POST['status']));
    $description  = trim(mysqli_real_escape_string($conn, $_POST['description']));
    $trailer_url  = trim(mysqli_real_escape_string($conn, $_POST['trailer_url']));
    $old_poster   = $_POST['old_poster'];

    $image_sql = "";
    if (isset($_FILES['poster']) && $_FILES['poster']['error'] === 0) {
        $fileExt = strtolower(pathinfo($_FILES['poster']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($fileExt, $allowed)) {
            $newFileName = "MOV_" . uniqid('', true) . "." . $fileExt;
            $targetDir   = "../../uploads/posters/";
            
            if (move_uploaded_file($_FILES['poster']['tmp_name'], $targetDir . $newFileName)) {
                $image_sql = ", poster = '$newFileName'";
                // Purani image delete karein
                if (file_exists($targetDir . $old_poster)) { unlink($targetDir . $old_poster); }
            }
        }
    }

    $sql = "UPDATE movies SET 
            title        = '$title', 
            genre        = '$genre',
            duration     = '$duration',
            release_date = '$release_date',
            status       = '$status',
            description  = '$description'
            $image_sql 
            WHERE movie_id = '$movie_id'";

    if (mysqli_query($conn, $sql)) {
        // Trailer table update karein: Pehle check karein wahan entry hai ya nahi
        $check_trailer = mysqli_query($conn, "SELECT * FROM trailers WHERE movie_id = '$movie_id'");
        
        if (mysqli_num_rows($check_trailer) > 0) {
            // Agar pehle se trailer hai to UPDATE
            mysqli_query($conn, "UPDATE trailers SET trailer_url = '$trailer_url' WHERE movie_id = '$movie_id'");
        } else {
            // Agar pehle trailer nahi tha to INSERT
            $trailer_title = $title . " Official Trailer";
            mysqli_query($conn, "INSERT INTO trailers (movie_id, trailer_title, trailer_url) VALUES ('$movie_id', '$trailer_title', '$trailer_url')");
        }

        echo "<script>alert('✅ Movie Details Updated!'); window.location.href='manage_movie.php';</script>";
        exit();
    } else {
        die("❌ Update Failed: " . mysqli_error($conn));
    }

// ==========================================
// 5. DELETE LOGIC
// ==========================================
} elseif (isset($_GET['delete_id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    $res = mysqli_query($conn, "SELECT poster FROM movies WHERE movie_id = '$id'");
    $movie = mysqli_fetch_assoc($res);
    
    if ($movie) {
        $filePath = "../../uploads/posters/" . $movie['poster'];
        if (file_exists($filePath)) { unlink($filePath); }
        
        // Pehle child records delete karein
        mysqli_query($conn, "DELETE FROM trailers WHERE movie_id = '$id'");
        mysqli_query($conn, "DELETE FROM movies WHERE movie_id = '$id'");
        
        echo "<script>alert('Movie deleted successfully!'); window.location.href='manage_movie.php';</script>";
        exit();
    }
} else {
    header("Location: manage_movie.php");
    exit();
}
?>