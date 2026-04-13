let playerScore = 0;
let compScore = 0;
const choices = ['rock', 'paper', 'scissors'];

// Attach click events to the image buttons
document.querySelectorAll('.image-btn').forEach(button => {
    button.addEventListener('click', () => playRound(button.id));
});

function playRound(playerChoice) {
    const compChoice = choices[Math.floor(Math.random() * choices.length)];
    const resultText = document.getElementById('result-text');
    const choiceDetails = document.getElementById('choice-details');

    choiceDetails.innerText = `You chose ${playerChoice.toUpperCase()}. Computer chose ${compChoice.toUpperCase()}.`;

    if (playerChoice === compChoice) {
        resultText.innerText = "IT'S A TIE!";
    } else if (
        (playerChoice === 'rock' && compChoice === 'scissors') ||
        (playerChoice === 'paper' && compChoice === 'rock') ||
        (playerChoice === 'scissors' && compChoice === 'paper')
    ) {
        resultText.innerText = "YOU WIN!";
        playerScore++;
    } else {
        resultText.innerText = "COMPUTER WINS!";
        compScore++;
    }

    updateScore();
    checkMatchWinner();
}

function updateScore() {
    document.getElementById('player-score').innerText = playerScore;
    document.getElementById('comp-score').innerText = compScore;
}

function checkMatchWinner() {
    if (playerScore === 2) {
        // Using innerHTML to render the FontAwesome party horn icon
        setTimeout(() => { showFinalScreen("MATCH WON!"); }, 400);
    } else if (compScore === 2) {
        setTimeout(() => { showFinalScreen("MATCH LOST! "); }, 400);
    }
}

function showFinalScreen(message) {
    // Hide the game buttons and the scoreboard
    document.querySelector('.choices').style.display = 'none';
    document.querySelector('.score-board').style.display = 'none';

    // Show the final Match message (innerHTML allows the icon to render)
    document.getElementById('result-text').innerHTML = message;

    // Replace the details text with a Play Again button
    document.getElementById('choice-details').innerHTML = `
        <button onclick="resetGame()" style="
            font-family: 'Caveat', cursive;
            font-size: 2rem;
            padding: 10px 30px;
            background-color: #ffd166;
            border: 2px solid #2b2b2b;
            border-radius: 255px 15px 225px 15px/15px 225px 15px 255px;
            cursor: pointer;
            margin-top: 20px;
            color: #2b2b2b;
            box-shadow: 4px 4px 0px #2b2b2b;
        ">Play Again!</button>
    `;
}

function resetGame() {
    playerScore = 0;
    compScore = 0;
    updateScore();

    // Bring back the game buttons and scoreboard
    document.querySelector('.choices').style.display = '';
    document.querySelector('.score-board').style.display = '';

    // Reset the text areas
    document.getElementById('result-text').innerText = "Make your move!";
    document.getElementById('choice-details').innerText = "";
}

