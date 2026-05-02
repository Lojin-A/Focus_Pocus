<?php
require_once __DIR__ . '/../Includes/db_connect.php';
$db = new Database();
$conn = $db->connect();

$user_id = $_POST['user_id'];
$game = $_POST['game']; // e.g., 'memory'
$new_score = $_POST['score']; // For memory, this would be flips
$new_time = $_POST['time'];  // Only for memory match

if ($game == 'memory') {
    $stmt = $conn->prepare("INSERT INTO score_memory (user_id, total_played, fewest_flips, best_time_seconds) 
        VALUES (?, 1, ?, ?) 
        ON DUPLICATE KEY UPDATE 
        total_played = total_played + 1,
        fewest_flips = CASE WHEN ? < fewest_flips OR fewest_flips = 0 THEN ? ELSE fewest_flips END,
        best_time_seconds = CASE WHEN ? < best_time_seconds OR best_time_seconds = 0 THEN ? ELSE best_time_seconds END");
    $stmt->bind_param("iiiiiiii", $user_id, $new_score, $new_time, $new_score, $new_score, $new_time, $new_time);
    $stmt->execute();
}
// Add similar blocks for other games here...
?>