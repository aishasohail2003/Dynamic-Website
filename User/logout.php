<?php
include('config.php');

// Clear all session variables
$_SESSION = array();

// If session uses cookies, expire the cookie
if (ini_get("session.use_cookies")) {
	$params = session_get_cookie_params();
	setcookie(session_name(), '', time() - 42000,
		$params["path"], $params["domain"],
		$params["secure"], $params["httponly"]
	);
}

// Finally destroy the session
session_destroy();

// Redirect to project root (which forwards to User/index.php)
header("Location: /php_project/");
exit();
