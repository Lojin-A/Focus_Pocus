<?php
// submit_vote.php
$conn = new mysqli("localhost", "root", "", "focus_pocus_db");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $game = $_POST['game'];
    $user_id = 1; // Temporary: using your GuestPlayer ID

    $stmt = $conn->prepare("INSERT INTO weekly_votes (user_id, game_name) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $game);
    
    if ($stmt->execute()) {
        echo "Success";
    } else {
        http_response_code(500);
        echo "Error";
    }
}
?>