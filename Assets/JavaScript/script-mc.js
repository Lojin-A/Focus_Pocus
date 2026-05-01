const cards = document.querySelectorAll(".card"),
timeTag = document.querySelector(".time b"),
flipsTag = document.querySelector(".flips b"),
refreshBtn = document.querySelector(".details button");
//const flipSound = new Audio('../Assets/Sounds/flip.mp3');
const matchSound= new Audio('../Assets/Sounds/match.mp3');
const wrongSound = new Audio('../Assets/Sounds/wrong.mp3');
const winSound = new Audio('../Assets/Sounds/win.mp3');
const ringSound= new Audio('../Assets/Sounds/ring.mp3');
let maxTime = 0;
let timeLeft = maxTime;
let flips = 0;
let matchedCard = 0;
let disableDeck = false;
let isPlaying = false;
let cardOne, cardTwo, timer;

function initTimer() {
    if(timeLeft >= 120) {
        ringSound.play();
        endGame(false);
        return clearInterval(timer);
    }
    timeLeft++;
    timeTag.innerText = timeLeft;
}

function flipCard({target: clickedCard}) {
    if(!isPlaying) {
        isPlaying = true;
        timer = setInterval(initTimer, 1000);
    }
    if(clickedCard !== cardOne && !disableDeck && timeLeft < 120) {
        flips++;
        flipsTag.innerText = flips;
        clickedCard.classList.add("flip");
        //flipSound.pause();
        //flipSound.currentTime = 0;
       // flipSound.play();
        if(!cardOne) {
            return cardOne = clickedCard;
        }
        cardTwo = clickedCard;
        disableDeck = true;
        let cardOneImg = cardOne.querySelector(".back-view img").src,
        cardTwoImg = cardTwo.querySelector(".back-view img").src;
        matchCards(cardOneImg, cardTwoImg);
    }
}

function matchCards(img1, img2) {
    if(img1 === img2) {
        matchedCard++;
        matchSound.play();
        if(matchedCard == 6 && timeLeft < 120) {
            winSound.play();
            endGame(true);
            return clearInterval(timer);
        }
        cardOne.removeEventListener("click", flipCard);
        cardTwo.removeEventListener("click", flipCard);
        cardOne = cardTwo = "";
        return disableDeck = false;
    }

    setTimeout(() => {
        wrongSound.play();
        cardOne.classList.add("shake");
        cardTwo.classList.add("shake");
    }, 400);

    setTimeout(() => {
        cardOne.classList.remove("shake", "flip");
        cardTwo.classList.remove("shake", "flip");
        cardOne = cardTwo = "";
        disableDeck = false;
    }, 1200);
}
function endGame(isWin) {
    isPlaying = false;
    cards.forEach(card => {
        card.removeEventListener("click", flipCard);
    });
    const modal = document.getElementById('game-over-modal');
    const modalTitle = modal.querySelector('h2');
    const finalScore = document.getElementById('final-score');
    
    if(isWin) {
        modalTitle.textContent = 'Win!';
finalScore.innerHTML = `Time: ${timeLeft}s &nbsp;&nbsp; | &nbsp;&nbsp; Flips: ${flips}`;    } else {
       modalTitle.textContent= 'Time\'s Up!';
       finalScore.innerHTML = `Score: ${matchedCard}/6 &nbsp;&nbsp;|&nbsp;&nbsp; Flips: ${flips}`;
    }
     modal.classList.remove('hidden');
     }

function shuffleCard() {
    timeLeft = maxTime;
    flips = matchedCard = 0;
    cardOne = cardTwo = "";
    clearInterval(timer);
    timeTag.innerText = timeLeft;
    flipsTag.innerText = flips;
    disableDeck = isPlaying = false;

    let arr = [1, 2, 3, 4, 5, 6, 1, 2, 3, 4, 5, 6];
    arr.sort(() => Math.random() > 0.5 ? 1 : -1);

    cards.forEach((card, index) => {
        card.classList.remove("flip");
        let imgTag = card.querySelector(".back-view img");
        setTimeout(() => {
            imgTag.src = `../Assets/Media/img-${arr[index]}.png`;
        }, 500);
        card.addEventListener("click", flipCard);
    });
    const modal = document.getElementById('game-over-modal');
    modal.classList.add('hidden');
}



refreshBtn.addEventListener("click", shuffleCard);

const playAgainBtn = document.getElementById('play-again-btn');
const modalHomeBtn = document.getElementById('modal-home-btn');

if(playAgainBtn) {
    playAgainBtn.addEventListener('click', () => {
        shuffleCard();
    });
}

if(modalHomeBtn){
    modalHomeBtn.addEventListener('click', () => {
        window.location.href = '../index.html';
    });
}
shuffleCard();