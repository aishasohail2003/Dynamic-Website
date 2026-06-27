<?php
// Quick test for email sending
require 'send_booking_confirmation.php';

echo "Testing email send...\n";

$result = sendBookingConfirmationEmail(
    'test@example.com', // Replace with your email for testing
    'Test User',
    'Test Movie',
    'A1,A2',
    500,
    123,
    null
);

if ($result['status']) {
    echo "✅ SUCCESS: " . $result['message'] . "\n";
} else {
    echo "❌ FAILED: " . $result['message'] . "\n";
}
?>