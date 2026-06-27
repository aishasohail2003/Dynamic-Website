<?php
include('config.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password']) || $password == $row['password']) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['full_name'] = $row['full_name'];
            // store profile picture filename for header avatar
            $_SESSION['profile_pic'] = !empty($row['profile_pic']) ? $row['profile_pic'] : '';
            $user_role = strtolower(trim($row['role']));
            $_SESSION['role'] = $user_role;

            if ($_SESSION['role'] == 'admin') {
                header("Location: ../Admin/index.php");
                exit();
            } else {
                // Check if user was trying to book a movie
                if (isset($_SESSION['redirect_booking_movie_id'])) {
                    $movie_id = $_SESSION['redirect_booking_movie_id'];
                    unset($_SESSION['redirect_booking_movie_id']);
                    header("Location: booking.php?id=$movie_id"); 
                } elseif (isset($_SESSION['redirect_after_login']) && $_SESSION['redirect_after_login'] == 'checkout') {
                    header("Location: checkout.php");
                } else {
                    header("Location: index.php"); 
                }
                exit();
            }
        } else {
            $error = "Incorrect Password!!";
        }
    } else {
        $error = "Invalid Email";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Movixo</title>
    <style>
        /* FULL BACKGROUND (Cinema Seats Effect) */
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background: #000 url('https://w0.peakpx.com/wallpaper/452/913/wallpaper-movie-theater-seats.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Roboto, sans-serif;
        }

        /* Overlay for darkness */
        body::before {
            content: "";
            position: absolute;
            top:0; left:0; width:100%; height:100%;
            background: rgba(0, 0, 0, 0.85); /* Dark overlay like your screenshot */
            z-index: 1;
        }

        .auth-container {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 440px; /* Card size from screenshot */
        }

        /* THE CARD BOX (Modern Look) */
        .auth-box {
            background: #141417; /* Very dark grey/black */
            padding: 50px 40px;
            border-radius: 20px; /* Rounded corners like screenshot */
            border: 1px solid #222;
            box-shadow: 0 15px 35px rgba(0,0,0,0.8);
            text-align: center;
        }

        .auth-box h2 {
            color: white;
            font-size: 28px;
            margin-bottom: 5px;
            font-weight: 700;
        }

        .auth-box p {
            color: #aaa;
            font-size: 15px;
            margin-bottom: 30px;
        }

        /* INPUT FIELDS (Modern Bordered Style) */
        .input-group {
            margin-bottom: 20px;
        }

        .auth-box input {
            width: 100%;
            padding: 15px;
            background: #1e1e21; /* Slightly lighter than card */
            border: 1px solid #333;
            border-radius: 8px;
            color: white;
            font-size: 15px;
            box-sizing: border-box;
            outline: none;
            transition: 0.3s;
        }

        .auth-box input:focus {
            border-color: #ff6b00; /* Red focus like screenshot theme */
        }

        /* ERROR MESSAGE */
        .auth-error {
            color: #ff6b00;
            background: rgba(255, 71, 71, 0.1);
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        /* LOGIN BUTTON (Bright Red/Orange from screenshot) */
        .auth-btn {
            width: 100%;
            padding: 15px;
            background: #ff6b00; /* Same Red color from your screenshot button */
            border: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.3s ease;
            margin-top: 10px;
        }

        .auth-btn:hover {
            background: #ff6b00;
            transform: translateY(-2px);
        }

        /* LINKS */
        .auth-links {
            margin-top: 25px;
            color: white;
            font-size: 15px;
            font-weight: 500;
        }

        .auth-links a {
            color: #ff6b00; /* Orange link like your signup screenshot */
            text-decoration: none;
            font-weight: bold;
        }

        .auth-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="auth-container">
    <div class="auth-box">
        <h2>Login 🎬</h2>
        <p>Welcome back! Join Movixo to book your tickets</p>

        <?php if(isset($error)): ?>
            <div class="auth-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="input-group">
                <input type="email" name="email" placeholder="Email Address" 
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            </div>
            
            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button class="auth-btn" type="submit">Login</button>
        </form>

        <div class="auth-links">
            Already have an account? <a href="signup.php">Sign Up</a>
        </div>
    </div>
</div>

</body>
</html>