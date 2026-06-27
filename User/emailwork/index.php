<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Movixo</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body {
            background: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.8)), 
                        url('https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?auto=format&fit=crop&w=1920&q=80');
            background-size: cover; background-position: center; background-attachment: fixed;
            min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px;
        }
        .glass-form {
            background: rgba(255, 255, 255, 0.08); backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1); padding: 40px;
            border-radius: 20px; width: 100%; max-width: 450px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5); text-align: center;
        }
        h2 { color: #fff; margin-bottom: 10px; font-size: 1.8rem; }
        p { color: #ccc; font-size: 0.9rem; margin-bottom: 25px; }
        .input-group { text-align: left; margin-bottom: 15px; }
        label { color: #e50914; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; margin-bottom: 5px; display: block; }
        input, textarea {
            width: 100%; padding: 12px; background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 8px;
            color: #fff; outline: none; transition: 0.3s;
        }
        input:focus, textarea:focus { border-color: #e50914; background: rgba(255, 255, 255, 0.15); }
        .submit-btn {
            width: 100%; padding: 14px; background: #e50914; color: #fff; border: none;
            border-radius: 8px; font-weight: bold; cursor: pointer; text-transform: uppercase;
        }
        @media (max-width: 480px) { .glass-form { padding: 30px 20px; } }
    </style>
</head>
<body>

    <?php include('RealEmailSending.php'); ?>

    <div class="glass-form">
        <h2>Contact Us</h2>
        <p>Have questions about your favorite movies?</p>

        <form action="send_logic.php" method="POST">
            <div class="input-group">
                <label>Name</label>
                <input type="text" name="u_name" placeholder="Your Name" required>
            </div>
            <div class="input-group">
                <label>Email</label>
                <input type="email" name="u_email" placeholder="Email Address" required>
            </div>
            <div class="input-group">
                <label>Message</label>
                <textarea name="u_msg" rows="4" placeholder="How can we help?" required></textarea>
            </div>
            <button type="submit" name="submit_form" class="submit-btn">Send Message</button>
        </form>
    </div>

</body>
</html>