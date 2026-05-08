<?php
session_start();

if (isset($_SESSION['user_id'])) {
    $current_user_id = $_SESSION['user_id'];
} else {
    $current_user_id = 'null';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Focus Pocus - Rock Paper Scissors</title>
    <link rel="stylesheet" href="../Assets/CSS/RPS-style.css">
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div id="effect-container"></div>

    <a href="../index.php" class="home-button">
        <img src="../Assets/Media/home-icon.png" alt="Home">
    </a>
    
    <div class="game-container">
        <h1>Rock Paper Scissors</h1>
        
        <div class="score-board">
            <h3>Best of 3</h3>
            <p>You: <span id="player-score">0</span> | Computer: <span id="comp-score">0</span></p>
        </div>
         <hr class="sketch-line">

        <div class="choices">
            <button class="image-btn" id="rock">
                <img src="../Assets/Media/rockPic.png" alt="Rock">
            </button>
            <button class="image-btn" id="paper">
                <img src="../Assets/Media/paperPic.png" alt="Paper">
            </button>
            <button class="image-btn" id="scissors">
                <img src="../Assets/Media/scissorPic.png" alt="Scissors">
            </button>
        </div>

        <div class="result-area">
            <h2 id="result-text">Make your move!</h2>
            <p id="choice-details"></p>
        </div>
        
       
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
       const realUserId = <?php echo $current_user_id; ?>;
    </script>
    <script src="../Assets/JavaScript/RPS-script.js"></script>
</body>
</html>
