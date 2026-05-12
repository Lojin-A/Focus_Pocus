$(document).ready(function () {
    // Set initial state from server (data-liked attribute)
    $('.like-btn').each(function () {
        if ($(this).data('liked') === 1 || $(this).data('liked') === '1') {
            $(this).addClass('liked');
        }
    });

    $('.like-btn').on('click', function () {
        var btn = $(this);
        var gameName = btn.data('game');

        $.post('Actions/like_game.php', { game_name: gameName }, function (response) {
            var data = typeof response === 'string' ? JSON.parse(response) : response;

            if (data.status === 'guest') {
                alert('Please log in to like a game.');
                return;
            }

            if (data.status === 'liked') {
                btn.addClass('liked');
                btn.data('liked', '1');
            } else if (data.status === 'unliked') {
                btn.removeClass('liked');
                btn.data('liked', '0');
            }

            btn.find('.count').text(data.count);
        });
    });
});