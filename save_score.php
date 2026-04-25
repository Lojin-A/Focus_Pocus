<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "focus_pocus_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed"]));
}

$game = $_POST['game'] ?? '';
$user_id = 1; // Hardcoded to your test user (ID: 1) until you build a login system

if ($game === 'Whack-a-Mole') {
    $score = $_POST['score'];
    $stmt = $conn->prepare("INSERT INTO score_whack (user_id, score) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $score);
    $stmt->execute();
} 
elseif ($game === 'Guess the Number') {
    $attempts = $_POST['score'];
    $stmt = $conn->prepare("INSERT INTO score_guess (user_id, attempts) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $attempts);
    $stmt->execute();
} 
elseif ($game === 'Memory Match') {
    $time = $_POST['score'];
    $flips = $_POST['flips'];
    $stmt = $conn->prepare("INSERT INTO score_memory (user_id, time_elapsed, flips) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $user_id, $time, $flips);
    $stmt->execute();
} 
elseif ($game === 'Rock Paper Scissors') {
    $score = $_POST['score'];
    $stmt = $conn->prepare("INSERT INTO score_rps (user_id, player_score) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $score);
    $stmt->execute();
}

echo json_encode(["status" => "success"]);
$conn->close();
?>