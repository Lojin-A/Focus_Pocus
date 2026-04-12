let targetNumber = 0;
let attempts = 0;
let isGameOver = false;
let guessHistory = [];

const $guessInput = $("#guessInput");
const $guessForm = $("#guessForm");
const $messageArea = $("#messageArea");
const $attemptsCount = $("#attemptsCount");
const $historySection = $("#historySection");
const $historyList = $("#historyList");
const $playAgainBtn = $("#playAgainBtn");
const $giveUpBtn = $("#giveUpBtn");
const $restartWrapper = $("#restartWrapper");
const $gameContainer = $(".game-container");
const $celebration = $("#celebration");

function initGame() {
    targetNumber = Math.floor(Math.random() * 100) + 1;
    attempts = 0;
    isGameOver = false;
    guessHistory = [];

    $guessInput.val("");
    $messageArea.text("Can you find the magic number? (1-100)");
    $messageArea.attr("class", "message-area");
    $attemptsCount.text("0");
    $historyList.empty();
    $historySection.addClass("hidden");
    $restartWrapper.addClass("hidden");
    $giveUpBtn.addClass("hidden");
    $guessForm.removeClass("hidden");
    $gameContainer.removeClass("win");
    $celebration.empty();
    $celebration.addClass("hidden");

    $guessInput.trigger("focus");
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

    feedback += numGuess < targetNumber ? " Try higher!" : " Try lower!";
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
    $historyList.empty();

    guessHistory.forEach(item => {
        let arrow = "=";
        let arrowClass = "correct";

        if (item.value < targetNumber) {
            arrow = "&uarr;";
            arrowClass = "low";
        } else if (item.value > targetNumber) {
            arrow = "&darr;";
            arrowClass = "high";
        }

        const $item = $(`
            <div class="history-item ${item.type}">
                <span class="history-value">${item.value}</span>
                <span class="history-arrow ${arrowClass}">${arrow}</span>
            </div>
        `);
        $historyList.append($item);
    });

    if (guessHistory.length > 0) {
        $historySection.removeClass("hidden");
    }
}

function launchCelebration() {
    const colors = ["#f97316", "#facc15", "#22c55e", "#38bdf8", "#f472b6", "#a78bfa"];

    $celebration.empty();
    $celebration.removeClass("hidden");

    for (let i = 0; i < 18; i++) {
        const $piece = $("<span></span>", { class: "confetti" }).css({
            left: `${Math.random() * 100}%`,
            backgroundColor: colors[i % colors.length],
            animationDelay: `${i * 0.04}s`,
            animationDuration: `${1.4 + Math.random() * 0.8}s`
        });
        $celebration.append($piece);
    }

    setTimeout(() => {
        $celebration.addClass("hidden");
        $celebration.empty();
    }, 2400);
}

function handleGuess(event) {
    event.preventDefault();

    if (isGameOver) return;

    const numGuess = parseInt($guessInput.val(), 10);

    if (isNaN(numGuess) || numGuess < 1 || numGuess > 100) {
        $messageArea.text("Whoops! Enter a number between 1 and 100.");
        return;
    }

    attempts++;
    $attemptsCount.text(attempts);

    const distance = Math.abs(targetNumber - numGuess);
    const hintType = getHintType(distance);
    const message = getMessage(distance, numGuess);

    guessHistory.unshift({ value: numGuess, type: hintType });

    $messageArea.text(message);
    $messageArea.attr("class", `message-area ${hintType}`);

    renderHistory();

    if (hintType === "correct") {
        isGameOver = true;
        $guessForm.addClass("hidden");
        $restartWrapper.removeClass("hidden");
        $giveUpBtn.addClass("hidden");
        $gameContainer.addClass("win");
        launchCelebration();
    } else if (attempts > 0) {
        $giveUpBtn.removeClass("hidden");
    }

    $guessInput.val("");
    $guessInput.trigger("focus");
}

$(function () {
    $guessForm.on("submit", handleGuess);
    $playAgainBtn.on("click", initGame);
    $giveUpBtn.on("click", initGame);

    initGame();
});
