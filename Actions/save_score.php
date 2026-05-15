<?php
require_once '../Includes/db_connect.php';

$db = new Database();
$conn = $db->connect();

$user_id = $_POST['user_id'] ?? null;
$game = $_POST['game'] ?? '';
$is_win = isset($_POST['is_win']) ? intval($_POST['is_win']) : 0;

if ($user_id === null || $user_id === 'null') {
    exit();
}

$add_win = ($is_win == 1) ? 1 : 0;
$add_loss = ($is_win == 0) ? 1 : 0;

// ==========================================
// 1. LOGIC FOR MEMORY MATCH
// ==========================================
if ($game == 'memory') {
    $flips = intval($_POST['score']);  
    $time = intval($_POST['time']);  

    // Step 1: Check if the user has played before
    $check_stmt = $conn->prepare("SELECT fewest_flips, best_time_seconds FROM score_memory WHERE user_id = ?");
    $check_stmt->bind_param("i", $user_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows == 0) {
        $best_flips = ($is_win == 1) ? $flips : 0;
        $best_time = ($is_win == 1) ? $time : 0;

        $insert_stmt = $conn->prepare("INSERT INTO score_memory (user_id, total_played, total_wins, total_losses, fewest_flips, best_time_seconds) VALUES (?, 1, ?, ?, ?, ?)");
        $insert_stmt->bind_param("iiiii", $user_id, $add_win, $add_loss, $best_flips, $best_time);
        $insert_stmt->execute();
    } else {
        $row = $result->fetch_assoc();
        $best_flips = $row['fewest_flips'];
        $best_time = $row['best_time_seconds'];
        
        if ($is_win == 1) {
            if ($best_flips == 0 || $flips < $best_flips) {
                $best_flips = $flips;
            }
            if ($best_time == 0 || $time < $best_time) {
                $best_time = $time;
            }
        }
        
        $update_stmt = $conn->prepare("UPDATE score_memory SET total_played = total_played + 1, total_wins = total_wins + ?, total_losses = total_losses + ?, fewest_flips = ?, best_time_seconds = ? WHERE user_id = ?");
        $update_stmt->bind_param("iiiii", $add_win, $add_loss, $best_flips, $best_time, $user_id);
        $update_stmt->execute();
    }
}

// ==========================================
// 2. LOGIC FOR WHACK-A-MOLE
// ==========================================
if ($game == 'Whack-a-Mole') {
    $score = intval($_POST['score']); 

    $check_stmt = $conn->prepare("SELECT high_score FROM score_whack WHERE user_id = ?");
    $check_stmt->bind_param("i", $user_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows == 0) {
        $insert_stmt = $conn->prepare("INSERT INTO score_whack (user_id, total_played, total_wins, total_losses, high_score) VALUES (?, 1, ?, ?, ?)");
        $insert_stmt->bind_param("iiii", $user_id, $add_win, $add_loss, $score);
        $insert_stmt->execute();
    } else {
        $row = $result->fetch_assoc();
        $best_score = $row['high_score'];
        
        if ($score > $best_score) {
            $best_score = $score;
        }
        
        $update_stmt = $conn->prepare("UPDATE score_whack SET total_played = total_played + 1, total_wins = total_wins + ?, total_losses = total_losses + ?, high_score = ? WHERE user_id = ?");
        $update_stmt->bind_param("iiii", $add_win, $add_loss, $best_score, $user_id);
        $update_stmt->execute();
    }
}



// ==========================================
// 3. LOGIC FOR GUESS THE NUMBER
// ==========================================
if ($game == 'Guess the Number') {

    $score = intval($_POST['score']); // attempts

    $check_stmt = $conn->prepare("SELECT fewest_attempts FROM score_guess WHERE user_id = ?");
    $check_stmt->bind_param("i", $user_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows == 0) {
        $insert_stmt = $conn->prepare("INSERT INTO score_guess (user_id, total_played, fewest_attempts) VALUES (?, 1, ?)");
        $insert_stmt->bind_param("ii", $user_id, $score);
        $insert_stmt->execute();
    } else {
        $row = $result->fetch_assoc();
        $best_attempts = $row['fewest_attempts'];

        if ($best_attempts == 0 || $score < $best_attempts) {
            $best_attempts = $score;
        }

        $update_stmt = $conn->prepare("UPDATE score_guess SET total_played = total_played + 1, fewest_attempts = ? WHERE user_id = ?");
        $update_stmt->bind_param("ii", $best_attempts, $user_id);
        $update_stmt->execute();
    }
}

// ==========================================
// 4. LOGIC FOR ROCK PAPER SCISSORS
// ==========================================
if ($game == 'rps') {
    $check_stmt = $conn->prepare("SELECT total_played FROM score_rps WHERE user_id = ?");
    $check_stmt->bind_param("i", $user_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows == 0) {
        $insert_stmt = $conn->prepare("INSERT INTO score_rps (user_id, total_played, total_wins, total_losses) VALUES (?, 1, ?, ?)");
        $insert_stmt->bind_param("iii", $user_id, $add_win, $add_loss);
        $insert_stmt->execute();
    } else {
        $update_stmt = $conn->prepare("UPDATE score_rps SET total_played = total_played + 1, total_wins = total_wins + ?, total_losses = total_losses + ? WHERE user_id = ?");
        $update_stmt->bind_param("iii", $add_win, $add_loss, $user_id);
        $update_stmt->execute();
    }
}

