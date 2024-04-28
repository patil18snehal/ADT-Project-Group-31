<?php
include 'database.php';

// Start the session
session_start();

// Check if the request contains place data
if (isset($_POST['name']) && isset($_POST['Exploration_time']) && isset($_POST['Google_rating']) && isset($_POST['weekly_off']) && isset($_POST['DSLR_allowed'])) {
    // Retrieve place data from the request
    $name = $_POST['name'];
    $explorationTime = $_POST['Exploration_time'];
    $googleRating = $_POST['Google_rating'];
    $weeklyOff = $_POST['weekly_off'];
    $dslrAllowed = $_POST['DSLR_allowed'];

    // Retrieve user ID from the session
    $userID = $_SESSION['userID'];

    // Prepare SQL statement to insert data into wishlist table
    $stmt = $conn->prepare("INSERT INTO wishlist (user_id, name, Exploration_time, Google_rating, weekly_off, DSLR_allowed) VALUES (:userID, :name, :explorationTime, :googleRating, :weeklyOff, :dslrAllowed)");
    $stmt->bindParam(':userID', $userID);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':explorationTime', $explorationTime);
    $stmt->bindParam(':googleRating', $googleRating);
    $stmt->bindParam(':weeklyOff', $weeklyOff); 
    $stmt->bindParam(':dslrAllowed', $dslrAllowed);

    // Execute the SQL statement
    if ($stmt->execute()) {
        // If insertion is successful, send success response
        echo json_encode(['success' => true]);
    } else {
        // If insertion fails, send failure response
        echo json_encode(['success' => false]);
    }
} else {
    // If place data is not provided, send failure response
    echo json_encode(['success' => false]);
}
?>