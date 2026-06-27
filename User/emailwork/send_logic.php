<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

if (isset($_POST['submit_form'])) {
    $name    = htmlspecialchars($_POST['u_name']);
    $email   = htmlspecialchars($_POST['u_email']);
    $message = htmlspecialchars($_POST['u_msg']);

    $mail = new PHPMailer(true);

    try {
        // --- SMTP Settings ---
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'mominaasim666@gmail.com';
        $mail->Password   = 'uqwnpozecvpdrhsk'; // ✅ App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // --- Email Headers ---
        $mail->setFrom('mominaasim666@gmail.com', 'Movixo Admin');
        $mail->addAddress('mominaasim666@gmail.com'); // Admin ko email milegi
        $mail->addReplyTo($email, $name); // Jab admin reply karega to user ko jayega

        // --- Content ---
        $mail->isHTML(true);
        $mail->Subject = 'New Contact Message: ' . $name;
        
        // Email Body Design
        $mail->Body    = "
            <h3>New Message from Contact Form</h3>
            <p><b>Name:</b> $name</p>
            <p><b>Email:</b> $email</p>
            <p><b>Message:</b><br>$message</p>
        ";

        $mail->send();
        echo "<script>alert('Shukriya! Aapka message bhej diya gaya hai.'); window.location.href='index.php';</script>";

    } catch (Exception $e) {
        // Agar error aaye to alert me dikhaye
        echo "<script>alert('Email nahi ja saki. Error: {$mail->ErrorInfo}'); window.history.back();</script>";
    }
}
?>