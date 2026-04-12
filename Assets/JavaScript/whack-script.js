$(document).ready(function() {
    const bonkSound = new Audio('../Assets/Sounds/bonk.mp3');
    let score = 0;
    let timeLeft = 30; 
    let gameTimer;
    let moleTimer;
    let isPlaying = false;
    let lastHole = -1; 

    $('#start-btn').click(function() {
        clearInterval(gameTimer); 
        clearInterval(moleTimer); 
        $('.mole-img').attr('src', '../Assets/Media/hole-empty.png').removeClass('active');
        isPlaying = true;
        score = 0;
        timeLeft = 30; 
        $('#score').text(score);
        $('#time').text(timeLeft);
        $(this).text('Restart');
        gameTimer = setInterval(countDown, 1000); 
        moleTimer = setInterval(showRandomMole, 1200); 
    });

    function countDown() {
        timeLeft--;
        $('#time').text(timeLeft);
        if (timeLeft <= 0) {
            endGame();
        }
    }

    function showRandomMole() {
        $('.mole-img').attr('src', '../Assets/Media/hole-empty.png').removeClass('active');
        let randomNum;
        do {
            randomNum = Math.floor(Math.random() * 6); 
        } while (randomNum === lastHole);
        lastHole = randomNum; 
        $('.mole-img').eq(randomNum).attr('src', '../Assets/Media/mole-happy.png').addClass('active');
    }

    $('.mole-img').click(function() {
        if (!isPlaying) return; 
        if ($(this).hasClass('active')) {
            score += 10; 
            $('#score').text(score); 
            bonkSound.currentTime = 0; 
            bonkSound.play();          
            $(this).attr('src', '../Assets/Media/mole-dead.png');
            $(this).removeClass('active'); 
        }
    });

    function endGame() {
        isPlaying = false;
        clearInterval(gameTimer); 
        clearInterval(moleTimer); 
        $('.mole-img').attr('src', '../Assets/Media/hole-empty.png').removeClass('active');
        $('#start-btn').text('Play New Game!');
        $('#final-score').text(score);
        $('#game-over-modal').removeClass('hidden');
    }

    $('#play-again-btn').click(function() {
        $('#game-over-modal').addClass('hidden'); 
        $('#start-btn').click(); 
    });

    $('#modal-home-btn').click(function() {
        window.location.href = '../index.html'; 
    });

}); 