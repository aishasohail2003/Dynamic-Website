<?php
/**
 * BOOKING CONFIRMATION EMAIL SENDER
 * Usage: sendBookingConfirmationEmail($user_email, $user_name, $movie_name, $seats, $amount, $payment_id, $conn)
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendBookingConfirmationEmail($user_email, $user_name, $movie_name, $seats, $amount, $payment_id, $conn) {
    // Try PHPMailer first
    $result = sendBookingConfirmationEmailSMTP($user_email, $user_name, $movie_name, $seats, $amount, $payment_id);

    // If SMTP fails, try PHP mail() as fallback
    if (!$result['status']) {
        $result = sendBookingConfirmationEmailFallback($user_email, $user_name, $movie_name, $seats, $amount, $payment_id);
    }

    return $result;
}

function sendBookingConfirmationEmailSMTP($user_email, $user_name, $movie_name, $seats, $amount, $payment_id) {
    try {
        // Load PHPMailer
        require 'PHPMailer-master/src/Exception.php';
        require 'PHPMailer-master/src/PHPMailer.php';
        require 'PHPMailer-master/src/SMTP.php';

        $mail = new PHPMailer(true);

        // SMTP Configuration - Gmail with SSL (more reliable for XAMPP)
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'mominaasim666@gmail.com';
        $mail->Password   = 'qnqudfxaxurirmtd'; // App Password - regenerate if needed
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Use SSL instead of TLS
        $mail->Port       = 465; // SSL port
        $mail->SMTPDebug  = 0; // Set to 2 for debugging, 0 for production

        // SSL Options for localhost/XAMPP
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        // Sender Details
        $mail->setFrom('mominaasim666@gmail.com', 'Movixo - Cinema Booking');
        $mail->addAddress($user_email, $user_name);

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = '🎬 Aapka Ticket Book Ho Gaya! - Movixo';

        // Email Body (HTML Template)
        $booking_date = date('d M, Y');
        $booking_time = date('h:i A');

        $emailBody = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <style>
                body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
                .container { max-width: 600px; margin: 20px auto; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
                .header { background: linear-gradient(135deg, #ff6b00 0%, #ff0000 100%); color: white; padding: 30px 20px; text-align: center; }
                .header h2 { margin: 0; font-size: 28px; }
                .content { padding: 30px 20px; }
                .success-badge { background: #4caf50; color: white; padding: 10px 20px; border-radius: 25px; display: inline-block; margin-bottom: 20px; font-weight: bold; }
                .booking-details { background: #f9f9f9; padding: 20px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #ff6b00; }
                .detail-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #eee; }
                .detail-row:last-child { border-bottom: none; }
                .detail-label { color: #666; font-size: 14px; }
                .detail-value { font-weight: bold; color: #333; }
                .price-section { background: linear-gradient(135deg, #fff5f0 0%, #ffe8e0 100%); padding: 20px; border-radius: 8px; text-align: center; margin-bottom: 20px; }
                .price-amount { font-size: 32px; color: #ff6b00; font-weight: bold; margin: 10px 0; }
                .button { display: inline-block; background: #ff6b00; color: white; padding: 12px 30px; border-radius: 6px; text-decoration: none; font-weight: bold; margin-top: 15px; }
                .footer { background: #f4f4f4; padding: 20px; text-align: center; font-size: 12px; color: #666; border-top: 1px solid #ddd; }
                .footer p { margin: 5px 0; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>🎬 Ticket Booking Confirmed!</h2>
                    <p style='margin: 10px 0 0 0; font-size: 14px;'>Aapka show book ho gaya!</p>
                </div>

                <div class='content'>
                    <div class='success-badge'>✓ BOOKING SUCCESSFUL</div>

                    <h3 style='color: #333; margin-top: 0;'>Namaskar " . htmlspecialchars($user_name) . "!</h3>
                    <p style='color: #666; line-height: 1.6;'>Aapka cinema ticket successfully book ho chuka hai. Neeche apne booking ki details dekh sakte ho:</p>

                    <div class='booking-details'>
                        <div class='detail-row'>
                            <span class='detail-label'>🎥 Movie</span>
                            <span class='detail-value'>" . htmlspecialchars($movie_name) . "</span>
                        </div>
                        <div class='detail-row'>
                            <span class='detail-label'>🪑 Seats</span>
                            <span class='detail-value'>" . htmlspecialchars($seats) . "</span>
                        </div>
                        <div class='detail-row'>
                            <span class='detail-label'>📅 Booking Date</span>
                            <span class='detail-value'>" . $booking_date . "</span>
                        </div>
                        <div class='detail-row'>
                            <span class='detail-label'>⏰ Booking Time</span>
                            <span class='detail-value'>" . $booking_time . "</span>
                        </div>
                        <div class='detail-row'>
                            <span class='detail-label'>🎟️ Booking ID</span>
                            <span class='detail-value'>#" . $payment_id . "</span>
                        </div>
                        <div class='detail-row'>
                            <span class='detail-label'>📧 Email</span>
                            <span class='detail-value'>" . htmlspecialchars($user_email) . "</span>
                        </div>
                    </div>

                    <div class='price-section'>
                        <p style='margin: 0 0 5px 0; color: #666; font-size: 14px;'>Total Amount Paid</p>
                        <div class='price-amount'>PKR " . number_format($amount) . "</div>
                        <p style='margin: 0; color: #666; font-size: 12px;'>Payment Status: <span style='color: #4caf50; font-weight: bold;'>✓ PAID</span></p>
                    </div>

                    <p style='background: #e3f2fd; padding: 15px; border-radius: 6px; color: #1565c0; font-size: 13px; line-height: 1.6;'>
                        <strong>ⓘ Important:</strong> Theatre mein 10-15 minutes pehle aa jayein. Aapka ticket digital hai, kripya apna email ya SMS dikhayein.
                    </p>

                    <center>
                        <a href='http://localhost/php_project/User/ticket.php?payment_id=" . $payment_id . "' class='button'>View Digital Ticket</a>
                    </center>
                </div>

                <div class='footer'>
                    <p><strong>Movixo Cinema Booking</strong></p>
                    <p>Support: support@movixo.com | Phone: +92-XXX-XXXXXXX</p>
                    <p>© 2026 Movixo. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>
        ";

        $mail->Body = $emailBody;
        // No embedded image in template as image path is not provided

        // Send Email
        if ($mail->send()) {
            return array('status' => true, 'message' => 'Email sent successfully');
        } else {
            return array('status' => false, 'message' => 'Failed to send email: '.$mail->ErrorInfo);
        }

    } catch (Exception $e) {
        return array('status' => false, 'message' => 'Mailer Error: ' . $e->getMessage());
    }
}

function sendBookingConfirmationEmailFallback($user_email, $user_name, $movie_name, $seats, $amount, $payment_id) {
    try {
        $subject = '🎬 Aapka Ticket Book Ho Gaya! - Movixo';
        $booking_date = date('d M, Y');
        $booking_time = date('h:i A');

        $message = "
        <!DOCTYPE html>
        <html>
        <head><meta charset='UTF-8'><title>Ticket Confirmation</title></head>
        <body style='font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px;'>
            <div style='max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px;'>
                <h2 style='color: #ff6b00; text-align: center;'>🎬 Ticket Booking Confirmed!</h2>
                <p style='text-align: center; color: #666;'>Aapka show book ho gaya!</p>

                <div style='background: #f9f9f9; padding: 20px; border-radius: 8px; margin: 20px 0;'>
                    <p><strong>🎥 Movie:</strong> " . htmlspecialchars($movie_name) . "</p>
                    <p><strong>🪑 Seats:</strong> " . htmlspecialchars($seats) . "</p>
                    <p><strong>📅 Date:</strong> " . $booking_date . "</p>
                    <p><strong>⏰ Time:</strong> " . $booking_time . "</p>
                    <p><strong>🎟️ Booking ID:</strong> #" . $payment_id . "</p>
                    <p><strong>💰 Amount:</strong> PKR " . number_format($amount) . "</p>
                </div>

                <p style='text-align: center; color: #1565c0;'>
                    <strong>ⓘ Important:</strong> Theatre mein 10-15 minutes pehle aa jayein.
                </p>

                <p style='text-align: center; margin-top: 30px;'>
                    <a href='http://localhost/php_project/User/ticket.php?payment_id=" . $payment_id . "'
                       style='background: #ff6b00; color: white; padding: 12px 30px; text-decoration: none; border-radius: 6px;'>
                       View Digital Ticket
                    </a>
                </p>
            </div>
        </body>
        </html>
        ";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: Movixo Cinemas <noreply@movixo.com>" . "\r\n";

        if (mail($user_email, $subject, $message, $headers)) {
            return array('status' => true, 'message' => 'Email sent via PHP mail() fallback');
        } else {
            return array('status' => false, 'message' => 'PHP mail() also failed');
        }

    } catch (Exception $e) {
        return array('status' => false, 'message' => 'Fallback mail error: ' . $e->getMessage());
    }
}