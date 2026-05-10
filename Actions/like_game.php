<?php
require_once __DIR__ . '/../Includes/db_connect.php';

$database = new Database();
$conn = $database->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['game_name'])) {
    $game_name = $_POST['game_name'];
    $action    = $_POST['action'] ?? 'like';
    $today     = date('Y-m-d');

    $stmt = $conn->prepare("INSERT IGNORE INTO game_likes (game_name, likes, like_date) VALUES (?, 0, ?)");
    $stmt->bind_param("ss", $game_name, $today);
    $stmt->execute();

    if ($action === 'unlike') {
        $stmt = $conn->prepare("UPDATE game_likes SET likes = GREATEST(likes - 1, 0) WHERE game_name = ? AND like_date = ?");
    } else {
        $stmt = $conn->prepare("UPDATE game_likes SET likes = likes + 1 WHERE game_name = ? AND like_date = ?");
    }

    $stmt->bind_param("ss", $game_name, $today);
    echo $stmt->execute() ? "success" : "error";
}