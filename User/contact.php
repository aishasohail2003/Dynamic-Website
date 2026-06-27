<?php
include('config.php');
include('header.php');

// Initialize variables
$name = $email = $subject = $message = "";
$name_err = $email_err = $subject_err = $message_err = $success_msg = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["name"]))) $name_err = "Please enter your name."; else $name = htmlspecialchars(trim($_POST["name"]));
    if (empty(trim($_POST["email"]))) $email_err = "Please enter your email.";
    elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) $email_err = "Invalid email format.";
    else $email = htmlspecialchars(trim($_POST["email"]));
    if (empty(trim($_POST["subject"]))) $subject_err = "Please enter a subject."; else $subject = htmlspecialchars(trim($_POST["subject"]));
    if (empty(trim($_POST["message"]))) $message_err = "Please enter your message."; else $message = htmlspecialchars(trim($_POST["message"]));

    if (empty($name_err) && empty($email_err) && empty($subject_err) && empty($message_err)) {
        $stmt = $conn->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);
        if ($stmt->execute()) {
            $success_msg = "Your message has been sent successfully!";
            $name = $email = $subject = $message = "";
        } else {
            $success_msg = "Something went wrong. Please try again later.";
        }
        $stmt->close();
    }
}
?>

<!-- <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet"> -->

<div style="background: linear-gradient(135deg, #111 0%, #222 100%); height:200px; display:flex; align-items:center; justify-content:center;">
    <h1 style="color:white; font-size:40px; font-weight:700;">Contact Us</h1>
</div>

<section style="max-width:1200px; margin:50px auto; display:flex; flex-wrap:wrap; gap:50px; padding:0 20px;">
    
    <div style="flex:1 1 500px; background:#161616; padding:40px; border-radius:15px; box-shadow:0 0 25px rgba(0,0,0,0.5);">
        <h2 style="color:white; margin-bottom:30px;">Send a Message</h2>
        <?php if($success_msg) echo "<p style='color:#4CAF50; font-weight:600; margin-bottom:20px;'>$success_msg</p>"; ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <input type="text" name="name" value="<?php echo $name; ?>" required placeholder=" ">
                <label>Name</label>
                <span class="error"><?php echo $name_err; ?></span>
            </div>
            <div class="form-group">
                <input type="email" name="email" value="<?php echo $email; ?>" required placeholder=" ">
                <label>Email</label>
                <span class="error"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <input type="text" name="subject" value="<?php echo $subject; ?>" required placeholder=" ">
                <label>Subject</label>
                <span class="error"><?php echo $subject_err; ?></span>
            </div>
            <div class="form-group">
                <textarea name="message" rows="5" required placeholder=" "><?php echo $message; ?></textarea>
                <label>Message</label>
                <span class="error"><?php echo $message_err; ?></span>
            </div>
            <button type="submit">Send Message</button>
        </form>
    </div>

    <div style="flex:1 1 400px; display:flex; flex-direction:column; gap:25px;">
        <div class="info-card">
            <i class="fas fa-envelope"></i>
            <h4>Email</h4>
            <p>aptech@movixo.com</p>
        </div>
        <div class="info-card">
            <i class="fas fa-phone"></i>
            <h4>Phone</h4>
            <p>+92 2121714</p>
        </div>
        <div class="info-card">
            <i class="fas fa-map-marker-alt"></i>
            <h4>Address</h4>
            <p>North Nazimabad, Cinema City</p>
        </div>
    </div>
</section>

<style>
/* --- SIRF FOOTER KO BOLD AUR POPPINS KARNA HAI --- */
footer, 
footer *, 
.footer-section, 
.footer-section * {
    font-family: 'Poppins', sans-serif !important;
    font-weight: 700 !important; /* Poppins Bold */
}

/* Page Style (Baki Sab Normal) */
.info-card {
    background:#161616; padding:25px; border-radius:15px; box-shadow:0 0 20px rgba(0,0,0,0.5); text-align:center;
}
.info-card i { font-size:24px; color:var(--accent); margin-bottom:10px; }
.info-card h4 { color:white; margin-bottom:5px; }
.info-card p { color:#ccc; }

.form-group { position: relative; margin-bottom: 20px; }
.form-group input, .form-group textarea {
    width: 100%; padding: 15px; background: #222; border-radius:10px; border:none; color:white; outline:none;
}
.form-group label {
    position: absolute; top:50%; left:15px; color:#aaa; transform: translateY(-50%); pointer-events:none; transition:0.3s;
}
.form-group input:focus + label, .form-group input:not(:placeholder-shown) + label,
.form-group textarea:focus + label, .form-group textarea:not(:placeholder-shown) + label {
    top:-10px; left:10px; font-size:12px; color:var(--accent); background:#161616; padding:0 5px;
}
.form-group textarea { resize:none; }
.error { color:#ff6b00; font-size:13px; }
button {
    width:100%; padding:15px; border:none; border-radius:10px; background:var(--accent); color:white; font-weight:600; cursor:pointer; margin-top:10px; transition:0.3s;
}
button:hover { transform: scale(1.03); filter: brightness(1.2); }
</style>

<?php include('footer.php'); ?>