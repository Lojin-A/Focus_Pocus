<?php 
include '../Includes/db_connect.php'; 

$db = new Database();
$conn = $db->connect();

// Helper function to fetch top 5 for each table
function getTopScores($conn, $table, $stat_col, $order = 'DESC') {
    $query = "SELECT u.username, s.* FROM $table s 
              JOIN users u ON s.user_id = u.user_id 
              ORDER BY $stat_col $order LIMIT 5";
    return $conn->query($query);
}

$memory_scores = getTopScores($conn, 'score_memory', 'best_time_seconds', 'ASC');
$whack_scores  = getTopScores($conn, 'score_whack', 'total_wins'); // Changed from high_score
$rps_scores    = getTopScores($conn, 'score_rps', 'total_wins');
$guess_scores = getTopScores($conn, 'score_guess', 'fewest_attempts', 'ASC'); // Use total_played or check HeidiSQL
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Global Leaderboards</title>
    <link rel="stylesheet" href="../Assets/CSS/leaderboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap" rel="stylesheet">
</head>
<body>
    <a href="../index.php" class="home-button">
        <img src="../Assets/Media/home-icon.png" alt="Home">
    </a>

    <h1 class="page-title">Leaderboards</h1>

    <div class="leaderboard-wrapper">
        <div class="game-card paper-box">
            <div class="card-header">
                <h2>🧠 Memory Match</h2>
            </div>
            <ul class="top-players">
                <?php while($row = $memory_scores->fetch_assoc()): ?>
                    <li>
                        <span class="player-name"><?= htmlspecialchars($row['username']) ?></span>
                        <span class="player-score"><?= $row['best_time_seconds'] ?>s</span>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>

        <div class="game-card paper-box">
            <div class="card-header">
                <h2>🔨 Whack-a-Mole</h2>
            </div>
            <ul class="top-players">
                <?php while($row = $whack_scores->fetch_assoc()): ?>
                    <li>
                        <span class="player-name"><?= htmlspecialchars($row['username']) ?></span>
                        <span class="player-score"><?= $row['total_wins'] ?> Wins</span>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>

        <div class="game-card paper-box">
            <div class="card-header">
                <h2>✂️ RPS</h2>
            </div>
            <ul class="top-players">
                <?php while($row = $rps_scores->fetch_assoc()): ?>
                    <li>
                        <span class="player-name"><?= htmlspecialchars($row['username']) ?></span>
                        <span class="player-score"><?= $row['total_wins'] ?> Wins</span>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>

        <div class="game-card paper-box">
            <div class="card-header">
                <h2>❓ Guess Number</h2>
            </div>
            <ul class="top-players">
                <?php while($row = $guess_scores->fetch_assoc()): ?>
                    <li>
                        <span class="player-name"><?= htmlspecialchars($row['username']) ?></span>
                        <span class="player-score"><?= $row['fewest_attempts'] ?> Guesses</span>                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
</body>
</html>