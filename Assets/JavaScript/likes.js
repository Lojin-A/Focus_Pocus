$(document).ready(function() {
    $('.like-btn').on('click', function() {
        const button = $(this);
        const gameName = button.data('game');
        const countSpan = button.find('.count');

        $.ajax({
            url: 'Actions/like_game.php',
            type: 'POST',
            data: { game: gameName },
            success: function(newCount) {
                countSpan.text(newCount); // Update the number instantly
                button.addClass('liked'); // Optional: for CSS animations
            }
        });
    });
});