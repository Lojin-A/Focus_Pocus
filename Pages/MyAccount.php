<?php
require_once __DIR__ . '/../Includes/Session.php';
Session::start();

if (Session::get('user_id') === null) {
    header("Location: ../login.php");
    exit();
}
require_once '../Includes/db_connect.php';

$database = new Database();
$conn = $database->connect();

$current_user_id = Session::get('user_id');

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

require_once '../Actions/MemoryStats.php'; 
$memoryObj = new MemoryStats($conn);
$memoryData = $memoryObj->getStats($current_user_id);

require_once '../Actions/GuessStats.php';
$guessObj = new GuessStats($conn);
$guessData = $guessObj->getStats($current_user_id);

require_once '../Actions/RpsStats.php';
$rpsObj = new RpsStats($conn);
$rpsData = $rpsObj->getStats($current_user_id);

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

     <a href="../index.php" class="home-button">
        <img src="../Assets/Media/home-icon.png" alt="Home">
    </a>

<form action="../Actions/delete_account.php"
      method="POST"
      class="delete-button"
      onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">

    <button type="submit">
        <img src="../Assets/Media/skull.png" alt="Delete Account">
    </button>
</form>


    <div class="profile-tags-container">
        <div class="tag paper-box">
            <img src="../Assets/Media/MyAccount1.png" alt="Profile" class="tag-icon">
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
        <p>
    Total Played: <?php echo $guessData['played']; ?> |
    Fewest Guesses:
    <?php echo ($guessData['fewest'] == 0) ? "No wins yet" : $guessData['fewest']; ?>
       </p>
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
                <p>Total Played: <?php echo $memoryData['played']; ?> | Fewest Flips: <?php echo $memoryData['fewest_flips']; ?></p>
            </div>
        </div>

        <div class="card paper-box">
            <div id="piechart4" class="chart-area"></div>
            <div class="info-area">
                <h3>✂️ Rock Paper Scissors</h3>
                <p>Total Played: <?php echo $rpsData['played'] ?? 0; ?> | Wins: <?php echo $rpsData['wins'] ?? 0; ?></p>
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

        const memoryData = {
        played: <?php echo $memoryData['played']; ?>,
        wins: <?php echo $memoryData['wins']; ?>,
        losses: <?php echo $memoryData['losses']; ?>,
        fewestFlips: <?php echo $memoryData['fewest_flips']; ?>,
        bestTime: <?php echo $memoryData['best_time']; ?>
    };

     const guessData = {
     played: <?php echo $guessData['played']; ?>,
     fewest: <?php echo $guessData['fewest']; ?>
     };

     const rpsData = {
        played: <?php echo $rpsData['played'] ?? 0; ?>,
        wins: <?php echo $rpsData['wins'] ?? 0; ?>,
        losses: <?php echo $rpsData['losses'] ?? 0; ?>
    };
    
    </script>

    <script src="../Assets/JavaScript/account-script.js"></script>
</body>
</html>