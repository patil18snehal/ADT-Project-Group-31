<?php
include 'database.php';

if (isset($_POST['state']) && isset($_POST['city'])) {
    $state = $_POST['state'];
    $city = $_POST['city'];
    $bestTime = isset($_POST['bestTime']) ? $_POST['bestTime'] : array();
    $dslrAllowed = isset($_POST['dslrAllowed']) ? $_POST['dslrAllowed'] : '';
    $rating = isset($_POST['rating']) ? $_POST['rating'] : '';
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $significance = isset($_POST['significance']) ? $_POST['significance'] : '';

    // Prepare the SQL query based on selected filters
    $sql = "SELECT DISTINCT name FROM indianplaces WHERE state = :state AND city = :city";

    if (!empty($bestTime)) {
        $sql .= " AND Best_Time_to_visit IN ('" . implode("','", $bestTime) . "')";
    }

    if (!empty($dslrAllowed)) {
        $sql .= " AND DSLR_Allowed = :dslrAllowed";
    }

    if (!empty($rating)) {
        if ($rating === '<1') {
            $sql .= " AND Google_review_rating < 1";
        } else {
            $sql .= " AND Google_review_rating = :rating";
        }
    }

    if (!empty($type)) {
        $sql .= " AND Type = :type";
    }

    if (!empty($significance)) {
        $sql .= " AND Significance = :significance";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':state', $state);
    $stmt->bindParam(':city', $city);
    if (!empty($dslrAllowed)) {
        $stmt->bindParam(':dslrAllowed', $dslrAllowed);
    }
    if (!empty($rating)) {
        if ($rating !== '<1') {
            $stmt->bindParam(':rating', $rating);
        }
    }
    if (!empty($type)) {
        $stmt->bindParam(':type', $type);
    }
    if (!empty($significance)) {
        $stmt->bindParam(':significance', $significance);
    }
    $stmt->execute();
    $places = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo json_encode($places);
} else {
    echo json_encode([]);
}
?>
