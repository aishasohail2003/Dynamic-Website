<?php
$conn = new mysqli("localhost", "root", "", "moviebooking");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
?>