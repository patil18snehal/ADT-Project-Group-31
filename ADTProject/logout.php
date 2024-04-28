<?php
session_start(); // Start the session

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to another page or perform any other action
header('Location: index.html');
exit;
?>
