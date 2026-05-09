<?php
session_start(); 

if (isset($_SESSION['user_id'])) {
    $current_user_id = $_SESSION['user_id'];
} else {
    $current_user_id = 'null';
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">  
    <title>Memory Card Game</title>
    <link rel="stylesheet" href="../Assets/css/style-mc.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </head>
  <body>
    <a href="../index.php" class="home-button">
    <img src="../Assets/Media/home-icon.png" alt="Home">
    </a>
    <div class="wrapper">
      <h1 class="game-title">
     <img src="../Assets/Media/title-icon.png" alt="icon" class="title-icon">
        Memory Card Game
      </h1>
      <ul class="cards">
        <li class="card">
          <div class="view front-view">
            <img src="../Assets/Media/que_icon.png" alt="icon">
          </div>
          <div class="view back-view">
            <img src="../Assets/Media/img-1.png" alt="card-img">
          </div>
        </li>
        <li class="card">
          <div class="view front-view">
            <img src="../Assets/Media/que_icon.png" alt="icon">
          </div>
          <div class="view back-view">
            <img src="../Assets/Media/img-2.png" alt="card-img">
          </div>
        </li>
        <li class="card">
          <div class="view front-view">
            <img src="../Assets/Media/que_icon.png" alt="icon">
          </div>
          <div class="view back-view">
            <img src="../Assets/Media/img-3.png" alt="card-img">
          </div>
        </li>
        <li class="card">
          <div class="view front-view">
            <img src="../Assets/Media/que_icon.png" alt="icon">
          </div>
          <div class="view back-view">
            <img src="../Assets/Media/img-4.png" alt="card-img">
          </div>
        </li>
        <li class="card">
          <div class="view front-view">
            <img src="../Assets/Media/que_icon.png" alt="icon">
          </div>
          <div class="view back-view">
            <img src="../Assets/Media/img-5.png" alt="card-img">
          </div>
        </li>
        <li class="card">
          <div class="view front-view">
            <img src="../Assets/Media/que_icon.png" alt="icon">
          </div>
          <div class="view back-view">
            <img src="../Assets/Media/img-6.png" alt="card-img">
          </div>
        </li>
        <li class="card">
          <div class="view front-view">
            <img src="../Assets/Media/que_icon.png" alt="icon">
          </div>
          <div class="view back-view">
            <img src="../Assets/Media/img-5.png" alt="card-img">
          </div>
        </li>
        <li class="card">
          <div class="view front-view">
            <img src="../Assets/Media/que_icon.png" alt="icon">
          </div>
          <div class="view back-view">
            <img src="../Assets/Media/img-6.png" alt="card-img">
          </div>
        </li>
        <li class="card">
          <div class="view front-view">
            <img src="../Assets/Media/que_icon.png" alt="icon">
          </div>
          <div class="view back-view">
            <img src="../Assets/Media/img-1.png" alt="card-img">
          </div>
        </li>
        <li class="card">
          <div class="view front-view">
            <img src="../Assets/Media/que_icon.png" alt="icon">
          </div>
          <div class="view back-view">
            <img src="../Assets/Media/img-2.png" alt="card-img">
          </div>
        </li>
        <li class="card">
          <div class="view front-view">
            <img src="../Assets/Media/que_icon.png" alt="icon">
          </div>
          <div class="view back-view">
            <img src="../Assets/Media/img-3.png" alt="card-img">
          </div>
        </li>
        <li class="card">
          <div class="view front-view">
            <img src="../Assets/Media/que_icon.png" alt="icon">
          </div>
          <div class="view back-view">
            <img src="../Assets/Media/img-4.png" alt="card-img">
          </div>
        </li>
        <div class="details">
          <p class="time">Time: <span><b>20</b>s</span></p>
          <p class="flips">Flips: <span><b>0</b></span></p>
          <button>Refresh</button>
        </div>
      </ul>
    </div>
    <div id="game-over-modal" class="modal hidden">
        <div class="modal-content">
            <h2></h2>
            <p><span id="final-score">0</span></p>
            
            <div class="modal-buttons">
                <button id="play-again-btn">Play Again</button>
                <button id="modal-home-btn"> Go Home</button>
            </div>
        </div>
    </div>
    
    <script>
    const realUserId = <?php echo $current_user_id; ?>; 
    </script>
    <script src="../Assets/JavaScript/script-mc.js"></script>
  </body>
</html>