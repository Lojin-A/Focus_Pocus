<?php
include '../Includes/db_connect.php';
header('Content-Type: application/json');

// Assume user_id is coming from a session or a hidden field
$user_id = $_POST['user_id'] ?? 1; // Replace with actual session user_id
$game = $_POST['game_type'] ?? 'memory'; // e.g., 'memory', 'whack'
$table = "score_" . $game;

$flips = intval($_POST['flips'] ?? 0);
$time = intval($_POST['time'] ?? 0);
$win = isset($_POST['is_win']) ? 1 : 0;

if ($conn = (new Database())->connect()) {
        
        if (isset($_POST['game']) && $_POST['game'] == 'rps') {
            $win = isset($_POST['is_win']) && $_POST['is_win'] == 1 ? 1 : 0;
            $loss = ($win == 0) ? 1 : 0;

            $sql = "INSERT INTO score_rps (user_id, total_played, total_wins, total_losses) 
                    VALUES (?, 1, ?, ?) 
                    ON DUPLICATE KEY UPDATE 
                    total_played = total_played + 1, 
                    total_wins = total_wins + ?, 
                    total_losses = total_losses + ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iiiii", $user_id, $win, $loss, $win, $loss);

            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => $conn->error]);
            }
            exit(); // 
        }
    // This SQL creates a row if it doesn't exist, OR updates it if it does
    $sql = "INSERT INTO $table (user_id, total_played, total_wins, total_losses, fewest_flips, best_time_seconds)
            VALUES (?, 1, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE 
                total_played = total_played + 1,
                total_wins = total_wins + ?,
                total_losses = total_losses + ?,
                fewest_flips = LEAST(fewest_flips, VALUES(fewest_flips)),
                best_time_seconds = LEAST(best_time_seconds, VALUES(best_time_seconds))";

    $stmt = $conn->prepare($sql);
    $loss = ($win == 0) ? 1 : 0;
    
    // Bind all the parameters for both the INSERT and the UPDATE parts
    $stmt->bind_param("iiiiiiii", $user_id, $win, $loss, $flips, $time, $win, $loss);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
}

// ==========================================
// 3. LOGIC FOR GUESS THE NUMBER
// ==========================================
if ($game == 'Guess the Number') {

    $attempts = $_POST['score'];

    $check_stmt = $conn->prepare("SELECT fewest_attempts FROM score_guess WHERE user_id = ?");
    $check_stmt->bind_param("i", $user_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows == 0) {
        $insert_stmt = $conn->prepare("INSERT INTO score_guess (user_id, total_played, fewest_attempts) VALUES (?, 1, ?)");
        $insert_stmt->bind_param("ii", $user_id, $attempts);
        $insert_stmt->execute();
    } else {
        $row = $result->fetch_assoc();
        $best_attempts = $row['fewest_attempts'];

        if ($best_attempts == 0 || $attempts < $best_attempts) {
            $best_attempts = $attempts;
        }

        $update_stmt = $conn->prepare("UPDATE score_guess SET total_played = total_played + 1, fewest_attempts = ? WHERE user_id = ?");
        $update_stmt->bind_param("ii", $best_attempts, $user_id);
        $update_stmt->execute();
    }
}
?>