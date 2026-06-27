<?php
// Command-line job to send booking email in background
// Usage: php send_booking_confirmation_job.php --email="user@domain.com" --name="John Doe" --movie="Guardians" --seats="A1,A2" --amount="1200" --id="123"

$options = getopt('', ['email:', 'name:', 'movie:', 'seats:', 'amount:', 'id:']);

if (empty($options['email']) || empty($options['name']) || empty($options['movie']) || empty($options['seats']) || empty($options['amount']) || empty($options['id'])) {
    $msg = 'Missing arguments. Usage: php send_booking_confirmation_job.php --email="user@example.com" --name="Full Name" --movie="Movie Title" --seats="A1,A2" --amount="1200" --id="45"\n';
    fwrite(STDERR, $msg);
    file_put_contents(__DIR__ . '/email_error.log', date('Y-m-d H:i:s').' ERROR: '.$msg, FILE_APPEND);
    exit(1);
}

require __DIR__ . '/send_booking_confirmation.php';

$user_email  = $options['email'];
$user_name   = $options['name'];
$movie_name  = $options['movie'];
$seats       = $options['seats'];
$amount      = $options['amount'];
$payment_id  = $options['id'];

// no DB connection required for email only
$conn = null;

$result = sendBookingConfirmationEmail($user_email, $user_name, $movie_name, $seats, $amount, $payment_id, $conn);

$result = sendBookingConfirmationEmail($user_email, $user_name, $movie_name, $seats, $amount, $payment_id, $conn);

if ($result['status']) {
    $msg = "Email sent successfully to: " . $user_email . "\n";
    fwrite(STDOUT, $msg);
    file_put_contents(__DIR__ . '/email_error.log', date('Y-m-d H:i:s').' SUCCESS: '.$msg, FILE_APPEND);
    exit(0);
}

$msg = "Email failed for " . $user_email . ": " . $result['message'] . "\n";
fwrite(STDERR, $msg);
file_put_contents(__DIR__ . '/email_error.log', date('Y-m-d H:i:s').' FAILED: '.$msg, FILE_APPEND);
exit(2);
