<?php
session_start();

// 1. Saare session variables ko khali karein
$_SESSION = array();

// 2. Agar session cookie exist karti hai to use expire karein
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
}

// 3. Session ko puri tarah khatam karein
session_destroy();

// 4. User ko main login page par bhej dein
header("Location: ../User/login.php");
exit();
?>