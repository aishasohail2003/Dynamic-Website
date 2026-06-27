<?php
include('config.php');

if(isset($_POST['signup'])) {
    // 1. Data sanitize aur trim karna
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $plain_password = $_POST['password'];

    // --- Normal Validations ---
    if(strlen($name) < 3) {
        $error = "Name is too short (min 3 characters).";
    }
    elseif(preg_match('/\d/', $name)) {
        $error = "Name should not contain numbers.";
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    }
    elseif(strlen($plain_password) < 6) {
        $error = "Password must be at least 6 characters.";
    }
    else {
        // 2. Email duplication check
        $check = mysqli_query($conn, "SELECT user_id FROM users WHERE email='$email' LIMIT 1");
        
        if(mysqli_num_rows($check) > 0) {
            $error = "This email is already registered. Please Login.";
        } else {
            // 3. Password Hash aur Insert (Default role 'User' database level pe handle hona chahiye)
            $hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);
            $insert_query = "INSERT INTO users (full_name, email, password) VALUES ('$name', '$email', '$hashed_password')";
            
            if(mysqli_query($conn, $insert_query)) {
                header("Location: login.php?msg=account_created");
                exit;
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Movixo</title>
    <link rel="stylesheet" href="auth.css?v=<?php echo time(); ?>">
    <style>
        .auth-page { background-color: #0c0c0c; color: white; font-family: 'Segoe UI', Tahoma, sans-serif; }
        
        /* Error Box Styling */
        .auth-error {
            background: #ff6b00;
            color: white; /* Text color white kiya taake orange pe dikhe */
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 14px;
            text-align: center;
        }

        /* --- BUTTON COLOR CHANGED TO #ff6b00 --- */
        .auth-btn {
            background-color: #ff6b00;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 4px;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }
        .auth-btn:hover {
            background-color: #e66000; /* Thoda dark shade hover pe */
            transform: scale(1.01);
        }

        /* Input styling for consistency */
        .auth-box input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            background: #1a1a1a;
            border: 1px solid #333;
            color: white;
            border-radius: 4px;
            box-sizing: border-box;
        }
    </style>
</head>
<body class="auth-page">

<div class="auth-container">
    <form method="post" class="auth-box">
        <h2 style="text-align: center; color: #ff6b00;">Create Account</h2>
        <p style="text-align: center; color: #888; margin-bottom: 20px;">Join Movixo to book your tickets</p>

        <?php if(isset($error)): ?>
            <div class="auth-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <input type="text" name="name" placeholder="Full Name" 
               value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
        
        <input type="email" name="email" placeholder="Email Address" 
               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
        
        <input type="password" name="password" placeholder="Password (Min 6 chars)" required>

        <button class="auth-btn" name="signup" type="submit">Sign Up</button>

        <div class="auth-links" style="text-align: center; margin-top: 15px; font-size: 14px;">
            Already have an account? <a href="login.php" style="color: #ff6b00; text-decoration: none;">Login</a>
        </div>
    </form>
</div>

</body>
</html>