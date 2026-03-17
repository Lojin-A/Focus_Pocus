let targetNumber = 0;
let attempts = 0;
let isGameOver = false;
let guessHistory = [];

const guessInput = document.getElementById("guessInput");
const guessForm = document.getElementById("guessForm");
const messageArea = document.getElementById("messageArea");
const attemptsCount = document.getElementById("attemptsCount");
const historySection = document.getElementById("historySection");
const historyList = document.getElementById("historyList");
const playAgainBtn = document.getElementById("playAgainBtn");
const giveUpBtn = document.getElementById("giveUpBtn");
const restartWrapper = document.getElementById("restartWrapper");
const gameContainer = document.querySelector(".game-container");
const celebration = document.getElementById("celebration");

function initGame() {
    targetNumber = Math.floor(Math.random() * 100) + 1;
    attempts = 0;
    isGameOver = false;
    guessHistory = [];

    guessInput.value = "";
    messageArea.textContent = "Can you find the magic number? (1-100)";
    messageArea.className = "message-area";
    attemptsCount.textContent = "0";
    historyList.innerHTML = "";
    historySection.classList.add("hidden");
    restartWrapper.classList.add("hidden");
    giveUpBtn.classList.add("hidden");
    guessForm.classList.remove("hidden");
    gameContainer.classList.remove("win");
    celebration.innerHTML = "";
    celebration.classList.add("hidden");

    guessInput.focus();
}


function getMessage(distance, numGuess) {
    if (distance === 0) {
        return `BOOM! ${targetNumber} is the magic number!`;
    }

    let feedback = "";
    if (distance <= 5) {
        feedback = "Ouch! THAT IS RED HOT!";
    } else if (distance <= 10) {
        feedback = "Hot stuff! You are close.";
    } else if (distance <= 20) {
        feedback = "Getting warmer...";
    } else {
        feedback = "Brrr, stone cold.";
    }

    feedback += numGuess < targetNumber ? " Try higher! ⬆️" : " Try lower! ⬇️";
    return feedback;
}

function getHintType(distance) {
    if (distance === 0) {
        return "correct";
    }

    if (distance <= 5) {
        return "very-hot";
    }

    if (distance <= 10) {
        return "hot";
    }

    if (distance <= 20) {
        return "warm";
    }

    return "cold";
}

function renderHistory() {
    historyList.innerHTML = "";

    guessHistory.forEach(item => {
        const div = document.createElement("div");
        div.className = `history-item ${item.type}`;
        div.textContent = item.value;
        historyList.appendChild(div);
    });

    if (guessHistory.length > 0) {
        historySection.classList.remove("hidden");
    }
}

function launchCelebration() {
    const colors = ["#f97316", "#facc15", "#22c55e", "#38bdf8", "#f472b6", "#a78bfa"];

    celebration.innerHTML = "";
    celebration.classList.remove("hidden");

    for (let i = 0; i < 18; i++) {
        const piece = document.createElement("span");
        piece.className = "confetti";
        piece.style.left = `${Math.random() * 100}%`;
        piece.style.backgroundColor = colors[i % colors.length];
        piece.style.animationDelay = `${i * 0.04}s`;
        piece.style.animationDuration = `${1.4 + Math.random() * 0.8}s`;
        celebration.appendChild(piece);
    }

    setTimeout(() => {
        celebration.classList.add("hidden");
        celebration.innerHTML = "";
    }, 2400);
}

function handleGuess(event) {
    event.preventDefault();

    if (isGameOver) return;

    const numGuess = parseInt(guessInput.value);

    if (isNaN(numGuess) || numGuess < 1 || numGuess > 100) {
        messageArea.textContent = "Whoops! Enter a number between 1 and 100.";
        return;
    }

    attempts++;
    attemptsCount.textContent = attempts;

    const distance = Math.abs(targetNumber - numGuess);
    const hintType = getHintType(distance);
    const message = getMessage(distance, numGuess);

    guessHistory.unshift({ value: numGuess, type: hintType });

    messageArea.textContent = message;
    messageArea.className = `message-area ${hintType}`;

    renderHistory();

    if (hintType === "correct") {
        isGameOver = true;
        guessForm.classList.add("hidden");
        restartWrapper.classList.remove("hidden");
        giveUpBtn.classList.add("hidden");
        gameContainer.classList.add("win");
        launchCelebration();
    } else if (attempts > 0) {
        giveUpBtn.classList.remove("hidden");
    }

    guessInput.value = "";
    guessInput.focus();
}

guessForm.addEventListener("submit", handleGuess);
playAgainBtn.addEventListener("click", initGame);
giveUpBtn.addEventListener("click", initGame);

initGame();
