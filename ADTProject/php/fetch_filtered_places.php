<?php
include 'database.php';

if (isset($_POST['state']) && isset($_POST['city'])) {
    $state = $_POST['state'];
    $city = $_POST['city'];

    // Construct SQL query based on filters
    $sql = "SELECT DISTINCT name, time_needed_to_visit_in_hrs as Exploration_time, Google_review_rating as Google_rating, weekly_off, DSLR_allowed FROM indianplaces WHERE state = :state AND city = :city GROUP BY name ORDER BY Google_rating DESC ";

    // Prepare and execute the SQL query
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':state', $state);
    $stmt->bindParam(':city', $city);
    $stmt->execute();
    
    // Fetch the filtered places
    $places = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return filtered places as JSON response
    echo json_encode($places);
} else {
    // If any of the parameters are missing, return an empty array
    echo json_encode([]);
}
?>
