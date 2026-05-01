<?php
$conn = new mysqli("localhost", "root", "", "focus_pocus_db");

// Helper function to fetch Top 5 for different games
function getTopFive($conn, $table, $column, $order = "DESC") {
    $sql = "SELECT users.username, $column FROM $table 
            JOIN users ON $table.user_id = users.user_id 
            ORDER BY $column $order LIMIT 5";
    return $conn->query($sql);
}

// Fetch data for all 4 games
$whackScores = getTopFive($conn, "score_whack", "score", "DESC");
$guessScores = getTopFive($conn, "score_guess", "attempts", "ASC"); // Lower is better
$memoryScores = getTopFive($conn, "score_memory", "time_elapsed", "ASC"); // Lower is better
$rpsScores = getTopFive($conn, "score_rps", "player_score", "DESC");
?> 