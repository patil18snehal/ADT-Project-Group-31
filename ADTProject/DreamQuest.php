<?php
// Include your database connection file
include 'php/database.php';

session_start();
$userID = $_SESSION['userID'];

// Prepare SQL statement to fetch wishlist items based on user_id
$stmt = $conn->prepare("SELECT name, Exploration_time, Google_rating, weekly_off, DSLR_allowed FROM wishlist WHERE user_id = :userID");

// Bind the userID parameter
$stmt->bindParam(':userID', $userID);

// Execute the statement
$stmt->execute();

// Fetch wishlist items
$wishlistItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return wishlist items as JSON response
echo json_encode($wishlistItems);
?>

