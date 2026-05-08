let playerScore = 0;
let compScore = 0;
const choices = ['rock', 'paper', 'scissors'];
const winSound = new Audio('../Assets/Sounds/happygame.mp3');
const loseSound = new Audio('../Assets/Sounds/sadgame.mp3');

$(document).ready(function() {
    $('.image-btn').click(function() {
        playRound(this.id);
    });
});

function playRound(playerChoice) {
    const compChoice = choices[Math.floor(Math.random() * choices.length)];
    const $resultText = $('#result-text');
    const $choiceDetails = $('#choice-details');

    $choiceDetails.text(`You chose ${playerChoice.toUpperCase()}. Computer chose ${compChoice.toUpperCase()}.`);

    // Determine round winner
    if (playerChoice === compChoice) {
        $resultText.html(`<span class="highlighter">IT'S A TIE!</span>`);
    } else if (
        (playerChoice === 'rock' && compChoice === 'scissors') ||
        (playerChoice === 'paper' && compChoice === 'rock') ||
        (playerChoice === 'scissors' && compChoice === 'paper')
    ) {
        $resultText.html(`<span class="highlighter">YOU WIN!</span>`);
        playerScore++;
    } else {
        $resultText.html(`<span class="highlighter">COMPUTER WINS!</span>`);
        compScore++;
    }

    updateScore();
    checkMatchWinner();
}

function updateScore() {
    $('#player-score').text(playerScore);
    $('#comp-score').text(compScore);
}

function checkMatchWinner() {
    // Check for best of 3 winner
    if (playerScore === 2) {
        winSound.play();
        saveRpsScore(true); 
        createWinEffect();
        setTimeout(() => { showFinalScreen("MATCH WON!"); }, 2000);
    } else if (compScore === 2) {
        loseSound.play();
        saveRpsScore(false); 
        createLoseEffect();
        setTimeout(() => { showFinalScreen("MATCH LOST!"); }, 2000);
    }
}

function saveRpsScore(isWin) {
    if (typeof realUserId !== 'undefined' && realUserId !== null && realUserId !== 'null') {
        $.ajax({
            type: "POST",
            url: "../Actions/save_score.php",
            data: {
                user_id: realUserId,
                game: "rps",
                score: isWin ? 1 : 0, 
                is_win: isWin ? 1 : 0
            },
            success: function(response) {
                console.log("Score successfully sent to the vault!", response);
            },
            error: function() {
                console.log("Oh no, the waiter dropped the score!");
            }
        });
    } else {
        console.log("Guest Player: Score was not saved.");
    }
}

function showFinalScreen(message) {
    // Hide game area
    $('.choices').hide();
    $('.score-board').hide();

    // Display final result
    $('#result-text').html(message);
    // Render Play Again button
    $('#choice-details').html(`
        <button onclick="resetGame()" style="
            font-family: 'Caveat', cursive;
            font-size: 2rem;
            padding: 10px 30px;
            background-color: #cdded5;
            border: 2px solid #2b2b2b;
            border-radius: 255px 15px 225px 15px/15px 225px 15px 255px;
            cursor: pointer;
            margin-top: 20px;
            color: #2b2b2b;
            box-shadow: 4px 4px 0px #2b2b2b;
        ">Play Again!</button>
    `);
}

function resetGame() {
    playerScore = 0;
    compScore = 0;
    updateScore();

    // Restore game area
    $('.choices').show();
    $('.score-board').show();

    // Clear text
    $('#result-text').text("Make your move!");
    $('#choice-details').text("");
}

function createWinEffect() {
    const $container = $('#effect-container');
    const colors = ['#ffd166', '#ef476f', '#06d6a0', '#118ab2']; 

    for (let i = 0; i < 30; i++) {
        let $star = $('<div class="star-particle"></div>');
        
        // Apply random styles
        $star.css({
            'background-color': colors[Math.floor(Math.random() * colors.length)],
            'left': Math.random() * 100 + 'vw',
            'top': Math.random() * 100 + 'vh',
            'animation-delay': Math.random() * 0.5 + 's'
        });
        $container.append($star);
        // Clear DOM after animation
        setTimeout(() => $star.remove(), 7000); 
    }
}

function createLoseEffect() {
    const $container = $('#effect-container');

    for (let i = 0; i < 40; i++) {
        let $rain = $('<div class="rain-particle"></div>');
        
        $rain.css({
            'left': Math.random() * 100 + 'vw',
            'animation-duration': (Math.random() * 2 + 2) + 's'
        });
        
        $container.append($rain);
        
        // Clear DOM after animation
        setTimeout(() => $rain.remove(), 7000);
    }
}