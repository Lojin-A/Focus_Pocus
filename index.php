<?php 
session_start();
include 'Actions/index_data.php'; 
?>
<?php include 'Actions/login-signup.php'; ?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Home</title>
  <link rel="stylesheet" href="Assets/CSS/index.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.1/css/all.css">
</head>
<body>
<div id="account-section">
    <a href="Pages/leaderboard.php" class="Muaccount-button">
        <img src="Assets/Media/Leaderboard.png" alt="Leaderboard">
    </a>
    <?php if (isset($_SESSION['user_id'])): ?>
    <a href="Pages/MyAccount.php" class="Myaccount-button">
        <img src="Assets/Media/MyAccount_Icon .png" alt="My Account">
    </a>
    <a href="Actions/logout.php" class="logout-button">
        <img src="Assets/Media/logout.png" alt="Logout">
    </a>
<?php else: ?>
    <a href="Pages/login-signup.php" class="Myaccount-button">
        <img src="Assets/Media/login.png" alt="Login">
    </a>
<?php endif; ?>
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
                <a href="Pages/whack-a-mole.php" class="btn-rps"> Play Now</a>
                <button class="like-btn" data-game="Whack-a-Mole">
                    <i class="fa-solid fa-heart"></i><span class="count"><?= $likes['Whack-a-Mole'] ?? 0 ?></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Card 2: Memory Match -->
    <div class="card">
        <div class="circle">
            <h2>Memory Match</h2>
        </div>
        <div class="content">
            <div class="icon-container">
            <p>Test your memory and match all the pairs!</p>
            <a href="Pages/MemoryMatch.php" class="btn-rps">Play Now</a>
            <button class="like-btn" data-game="Memory Match">
                <i class="fa-solid fa-heart"></i><span class="count"><?= $likes['Memory Match'] ?? 0 ?></span>
            </button>
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
            <a href="Pages/RPSGame.php" class="btn-rps">Play Now</a>
            <button class="like-btn" data-game="Rock Paper Scissors">
                <i class="fa-solid fa-heart"></i><span class="count"><?= $likes['Rock Paper Scissors'] ?? 0 ?></span>
            </button>
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
            <a href="Pages/guess.html" class="btn-rps">Play Now</a>
            <button class="like-btn" data-game="Guess the Number">
                <i class="fa-solid fa-heart"></i><span class="count"><?= $likes['Guess the Number'] ?? 0 ?></span>
            </button>
            </div>
        </div>
    </div>
</div> 

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="Assets/JavaScript/likes.js"></script>
</body>
</html>
