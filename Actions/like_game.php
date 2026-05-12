<?php
require_once __DIR__ . '/../Includes/db_connect.php';
require_once __DIR__ . '/../Includes/Session.php';
Session::start();

$database = new Database();
$conn = $database->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['game_name'])) {
    $game_name = $_POST['game_name'];
    $today     = date('Y-m-d');
    $user_id   = Session::get('user_id');

    // Guest: no tracking, just return current count
    if (!$user_id) {
        echo json_encode(['status' => 'guest']);
        exit;
    }

    // Check if user already liked this game
    $stmt = $conn->prepare("SELECT 1 FROM user_likes WHERE user_id = ? AND game_name = ?");
    $stmt->bind_param("is", $user_id, $game_name);
    $stmt->execute();
    $already_liked = $stmt->get_result()->num_rows > 0;

    if ($already_liked) {
        // Unlike
        $stmt = $conn->prepare("DELETE FROM user_likes WHERE user_id = ? AND game_name = ?");
        $stmt->bind_param("is", $user_id, $game_name);
        $stmt->execute();

        $stmt = $conn->prepare("UPDATE game_likes SET likes = GREATEST(likes - 1, 0) WHERE game_name = ? AND like_date = ?");
        $stmt->bind_param("ss", $game_name, $today);
        $stmt->execute();

        $action = 'unliked';
    } else {
        // Like
        $stmt = $conn->prepare("INSERT IGNORE INTO user_likes (user_id, game_name) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $game_name);
        $stmt->execute();

        $stmt = $conn->prepare("INSERT INTO game_likes (game_name, likes, like_date) VALUES (?, 1, ?) ON DUPLICATE KEY UPDATE likes = likes + 1");
        $stmt->bind_param("ss", $game_name, $today);
        $stmt->execute();

        $action = 'liked';
    }

    // Get updated count
    $stmt = $conn->prepare("SELECT likes FROM game_likes WHERE game_name = ? AND like_date = ?");
    $stmt->bind_param("ss", $game_name, $today);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $count  = $result ? $result['likes'] : 0;

    echo json_encode(['status' => $action, 'count' => $count]);
}