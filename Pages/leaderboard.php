<?php 
include '../Includes/db_connect.php'; 

$db = new Database();
$conn = $db->connect();

// Default to memory game if nothing is selected
$game = $_GET['game'] ?? 'memory';
$table = "score_" . $game;

// Map the "Best" column name based on the game
$stat_column = ($game == 'memory') ? 'best_time_seconds' : (($game == 'whack') ? 'total_wins' : 'total_played');
$order = ($game == 'memory') ? 'ASC' : 'DESC'; // Lower time is better for memory

$query = "SELECT u.username, s.* 
          FROM $table s 
          JOIN users u ON s.user_id = u.id 
          ORDER BY $stat_column $order LIMIT 10";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Leaderboard</title>
    <link rel="stylesheet" href="../Assets/CSS/leaderboard.css">
</head>
<body>
    <div class="leaderboard-container">
        <h1>Focus Pocus Rankings</h1>
        
        <!-- Filter between your different score tables -->
        <form method="GET">
            <select name="game" onchange="this.form.submit()">
                <option value="memory" <?= $game == 'memory' ? 'selected' : '' ?>>Memory Match</option>
                <option value="whack" <?= $game == 'whack' ? 'selected' : '' ?>>Whack-a-Mole</option>
                <option value="rps" <?= $game == 'rps' ? 'selected' : '' ?>>Rock Paper Scissors</option>
                <option value="guess" <?= $game == 'guess' ? 'selected' : '' ?>>Guess Number</option>
            </select>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Player</th>
                    <th>Played</th>
                    <th>Wins</th>
                    <th><?= ucfirst(str_replace('_', ' ', $stat_column)) ?></th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= $row['total_played'] ?></td>
                    <td><?= $row['total_wins'] ?></td>
                    <td><?= $row['memory' ? $row[$stat_column]."s" : $row[$stat_column]] ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>