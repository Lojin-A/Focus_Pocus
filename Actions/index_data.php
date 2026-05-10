<?php
require_once 'Includes/db_connect.php';

$database = new Database();
$conn = $database->connect();

if ($conn) {
    $today = date('Y-m-d');
    $stmt = $conn->prepare("SELECT game_name, likes FROM game_likes WHERE like_date = ? ORDER BY likes DESC");
    $stmt->bind_param("s", $today);
    $stmt->execute();
    $result = $stmt->get_result();

    $likes = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $likes[$row['game_name']] = $row['likes'];
        }
    }
} else {
    $likes = [];
}
$top_game = !empty($likes) ? array_search(max($likes), $likes) : '';