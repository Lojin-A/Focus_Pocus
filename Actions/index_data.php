<?php
require_once 'Includes/db_connect.php';$database = new Database();
$conn = $database->connect();

// Check if $conn is actually an object before calling query()
if ($conn) {
    $sql = "SELECT game_name, likes FROM game_likes";
    $result = $conn->query($sql);
    
    $likes = [];
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $likes[$row['game_name']] = $row['likes'];
        }
    }
} else {
    // If connection failed, initialize $likes as empty so index.php doesn't crash
    $likes = [];
}

