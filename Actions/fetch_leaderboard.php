<?php
require_once __DIR__ . '/../Includes/db_connect.php';
$db = new Database();
$conn = $db->connect();

// Helper function for the standard games
function getTopFiveArray($conn, $table, $column, $order = "DESC") {
    $data = [];
    // Added WHERE total_played > 0 so users who haven't played don't show up with '0' scores
    $sql = "SELECT users.username, $column as score FROM $table 
            JOIN users ON $table.user_id = users.user_id 
            WHERE total_played > 0
            ORDER BY $column $order LIMIT 5";
    $result = $conn->query($sql);
    
    if ($result) {
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

// 1. Fetch Whack-a-Mole (High Score)
$whackScores = getTopFiveArray($conn, "score_whack", "high_score", "DESC");

// 2. Fetch Guess the Number (Fewest Attempts)
$guessScores = getTopFiveArray($conn, "score_guess", "fewest_attempts", "ASC");

// 3. Fetch RPS (Total Wins)
$rpsScores = getTopFiveArray($conn, "score_rps", "total_wins", "DESC");

// 4. Fetch Memory Match (Custom: Flips + Time)
$memoryScores = [];
$sqlMemory = "SELECT users.username, fewest_flips, best_time_seconds 
              FROM score_memory 
              JOIN users ON score_memory.user_id = users.user_id 
              WHERE total_played > 0
              ORDER BY fewest_flips ASC, best_time_seconds ASC 
              LIMIT 5";
$memoryResult = $conn->query($sqlMemory);

if ($memoryResult) {
    while($row = $memoryResult->fetch_assoc()) {
        // We combine flips and time into one string so the JS can just print "score"
        $memoryScores[] = [
            'username' => $row['username'],
            'score' => $row['fewest_flips'] . ' flips in ' . $row['best_time_seconds'] . 's'
        ];
    }
}

// Combine all into one JSON response
$response = [
    'whack' => $whackScores,
    'guess' => $guessScores,
    'memory' => $memoryScores,
    'rps' => $rpsScores
];

header('Content-Type: application/json');
echo json_encode($response);
$conn->close();
?>