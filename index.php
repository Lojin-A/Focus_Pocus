<?php include 'Actions/index_data.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Focus Pocus - Home</title>
    <link rel="stylesheet" href="Assets/CSS/index.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Updated Navigation Container to prevent overlapping -->
    <div class="top-nav-container">
        <a href="Pages/MyAccount.html" class="nav-icon">
            <img src="Assets/Media/MyAccount_Icon.png" alt="My Account">
        </a>
        <a href="Pages/leaderboard.php" class="nav-icon">
            <img src="Assets/Media/Leaderboard.png" alt="Leaderboard"> 
        </a>
    </div>

    <h1 class="title">Focus Pocus</h1>
    
    <div class="container">
        <!-- Card 1: Whack-a-Mole -->
        <div class="card">
            <div class="circle">
                <h2>Whack a Mole</h2>
            </div>
            <div class="content">
                <div class="icon-container">
                    <p>Test your reflexes and smash those moles before they disappear!</p>
                    <div class="action-buttons">
                        <a href="Pages/whack-a-mole.html" class="btn-rps">Play Now</a>
                        <button class="like-btn" data-game="Whack-a-Mole">
                            ❤️ <span class="count"><?= $likes['Whack-a-Mole'] ?? 0; ?></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Repeat for other cards (Memory Match, RPS, Guess) -->
        <!-- Ensure you use the exact game names as they appear in your database 'game_likes' table -->
    </div> 

</body>
</html>

        <!-- Card 2: Memory Match -->
        <div class="card">
            <div class="circle">
                <h2>Memory Match</h2>
            </div>
            <div class="content">
                <div class="icon-container">
                <p>Test your memory and match all the pairs!</p>
                    <div class="action-buttons">
                        <a href="Pages/MemoryMatch.html" class="btn-rps">Play Now</a>
                        <button class="like-btn" data-game="Memory Match">
                            ❤️ <span class="count"><?= $likes['Memory Match'] ?? 0; ?></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Rock Paper Scissors -->
        <div class="card">
            <div class="circle">
                <h2>Rock Paper Scissors</h2>
            </div>
            <div class="content">
                <div class="icon-container">
                <p>Challenge the computer in this classic game!</p>
                    <div class="action-buttons">
                        <a href="Pages/RPSGame.html" class="btn-rps">Play Now</a>
                        <button class="like-btn" data-game="Rock Paper Scissors">
                            ❤️ <span class="count"><?= $likes['Rock Paper Scissors'] ?? 0; ?></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4: Guess the Number -->
        <div class="card">
            <div class="circle">
                <h2>Guess the Number</h2>
            </div>
            <div class="content">
                <div class="icon-container">
                <p>Pick a number and see if you can guess the secret!</p>
                    <div class="action-buttons">
                        <a href="Pages/guess.html" class="btn-rps">Play Now</a>
                        <button class="like-btn" data-game="Guess the Number">
                            ❤️ <span class="count"><?= $likes['Guess the Number'] ?? 0; ?></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div> 
       <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="Assets/JavaScript/likes.js"></script>
</body>
</html>
