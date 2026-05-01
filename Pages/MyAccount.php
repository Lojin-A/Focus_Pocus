<?php
require_once '../Includes/db_connect.php'; 

$database = new Database();
$conn = $database->connect();

$current_user_id = 1; 

$stmt = $conn->prepare("SELECT username, email FROM users WHERE user_id = ?");
$stmt->bind_param("i", $current_user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();

$display_name = $user_data ? htmlspecialchars($user_data['username']) : "Unknown User";
$display_email = $user_data ? htmlspecialchars($user_data['email']) : "No email found";

// ==========================================
// Put your file game here after mine and then create thier object!!!
// ==========================================
require_once '../Actions/WhackStats.php'; 

$whackObj = new WhackStats($conn);

$whackData = $whackObj->getStats($current_user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap" rel="stylesheet">
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" href="../Assets/CSS/account-style.css">
</head>
<body>

     <a href="../index.html" class="home-button">
        <img src="../Assets/Media/home-icon.png" alt="Home">
    </a>

    <div class="profile-tags-container">
        <div class="tag paper-box">
            <img src="../Assets/Media/MyAccount_Icon.png" alt="Profile" class="tag-icon">
            <?php echo $display_name; ?>
        </div>
        
        <div class="tag paper-box">
            <img src="../Assets/Media/email_icon.png" alt="Email" class="tag-icon">
            <?php echo $display_email; ?>
        </div>
    </div>

    <div class="dashboard-grid">
        
        <div class="card paper-box">
            <div id="piechart1" class="chart-area"></div>
            <div class="info-area">
                <h3>✨ NumGuess Pro</h3>
                <p>Total Played: 15 | Fewest Guesses: 3</p>
            </div>
        </div>

        <div class="card paper-box">
            <div id="piechart2" class="chart-area"></div>
            <div class="info-area">
                <h3>🔨 Whack-a-Mole</h3>
                <p>Total Played: <?php echo $whackData['played']; ?> | High Score: <?php echo $whackData['high']; ?></p>
            </div>
        </div>

        <div class="card paper-box">
            <div id="piechart3" class="chart-area"></div>
            <div class="info-area">
                <h3>🃏 Memory Match</h3>
                <p>Total Played: 12 | Fewest Flips: 10</p>
            </div>
        </div>

        <div class="card paper-box">
            <div id="piechart4" class="chart-area"></div>
            <div class="info-area">
                <h3>✂️ Rock Paper Scissors</h3>
                <p>Total Played: 20 | Win Rate: 60%</p>
            </div>
        </div>

    </div>

    <script>
        const whackData = {
            played: <?php echo $whackData['played']; ?>,
            wins: <?php echo $whackData['wins']; ?>,
            losses: <?php echo $whackData['losses']; ?>,
            highScore: <?php echo $whackData['high']; ?>
        };
    </script>

    <script src="../Assets/JavaScript/account-script.js"></script>
</body>
</html>