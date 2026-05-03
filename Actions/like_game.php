<?php
require_once __DIR__ . '/../Includes/db_connect.php';

$database = new Database();
$conn = $database->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['game_name'])) {
    $game_name = $_POST['game_name'];
    $action = $_POST['action'] ?? 'like';

    if ($action === 'unlike') {
        $stmt = $conn->prepare("UPDATE game_likes SET likes = GREATEST(likes - 1, 0) WHERE game_name = ?");
    } else {
        $stmt = $conn->prepare("UPDATE game_likes SET likes = likes + 1 WHERE game_name = ?");
    }

    $stmt->bind_param("s", $game_name);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
}
?>