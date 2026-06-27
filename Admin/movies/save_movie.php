<?php 
// inc folder se header uthane ke liye

// connection folder se config uthane ke liye
include '../../connection/config.php'; 


if (isset($_POST['submit'])) {
    // Form se data lena
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    $duration = (int)$_POST['duration'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $release_date = $_POST['release_date'];
    $status = 'active';

    // Image Upload Logic
    $target_dir = "uploads/posters/";
    
    // Agar folder nahi hai to create karein
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = time() . "_" . basename($_FILES["poster"]["name"]);
    $target_file = $target_dir . $file_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Image validation (sirf jpg, png, jpeg allowed)
    $extensions_arr = array("jpg", "jpeg", "png", "webp");

    if (in_array($imageFileType, $extensions_arr)) {
        
        if (move_uploaded_file($_FILES["poster"]["tmp_name"], $target_file)) {
            
            // Database mein insert query
            $sql = "INSERT INTO movies (title, description, duration, genre, release_date, poster, status) 
                    VALUES ('$title', '$description', '$duration', '$genre', '$release_date', '$file_name', '$status')";

            if ($conn->query($sql)) {
                $msg = "Movie added successfully!";
                $type = "success";
            } else {
                $msg = "Database Error: " . $conn->error;
                $type = "danger";
            }
        } else {
            $msg = "Error uploading image.";
            $type = "danger";
        }
    } else {
        $msg = "Invalid file type. Only JPG, PNG, WEBP allowed.";
        $type = "danger";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Processing...</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #0c0c0c; color: white; display: flex; align-items: center; justify-content: center; height: 100vh; }
        .alert-card { background: #1a1a1a; border: 1px solid #333; padding: 30px; border-radius: 15px; text-align: center; }
        .btn-red { background-color: #ff4b4b; border: none; padding: 10px 30px; font-weight: bold; color: white; border-radius: 8px; text-decoration: none; }
    </style>
</head>
<body>

    <div class="alert-card shadow-lg">
        <div class="alert alert-<?= $type ?> mb-4" role="alert">
            <?= $msg ?>
        </div>
        <a href="admin_dashboard.php" class="btn-red">Back to Dashboard</a>
        <a href="add_movie.php" class="btn btn-outline-secondary ms-2 text-white">Add Another</a>
    </div>

</body>
</html>