<?php
require_once 'Includes/db_connect.php';
require_once 'Includes/Session.php';
Session::start();

$database = new Database();
$conn = $database->connect();

$likes = [];
$user_liked = [];

if ($conn) {
    $today = date('Y-m-d');

    // Get like counts
    $stmt = $conn->prepare("SELECT game_name, likes FROM game_likes WHERE like_date = ? ORDER BY likes DESC");
    $stmt->bind_param("s", $today);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $likes[$row['game_name']] = $row['likes'];
        }
    }

    // Get which games current user liked
    $user_id = Session::get('user_id');
    if ($user_id) {
        $stmt = $conn->prepare("SELECT game_name FROM user_likes WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $user_liked[] = $row['game_name'];
        }
    }
}

$top_game = !empty($likes) ? array_search(max($likes), $likes) : '';