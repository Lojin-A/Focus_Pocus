$(document).ready(function () {

    $('.like-btn').each(function () {
        const gameName = $(this).data('game');
        if (localStorage.getItem('liked_' + gameName) === 'true') {
            $(this).addClass('liked');
        }
    });

    $('.like-btn').on('click', function () {
        const btn = $(this);
        const gameName = btn.data('game');
        const countEl = btn.find('.count');
        const isLiked = btn.hasClass('liked');

        btn.removeClass('pop');
        setTimeout(() => btn.addClass('pop'), 10);

        if (!isLiked) {
            btn.addClass('liked');
            countEl.text(parseInt(countEl.text()) + 1);

            localStorage.setItem('liked_' + gameName, 'true');

            $.ajax({
                url: 'Actions/like_game.php',
                method: 'POST',
                data: { game_name: gameName },
                error: function () {
                    btn.removeClass('liked');
                    countEl.text(parseInt(countEl.text()) - 1);
                    localStorage.removeItem('liked_' + gameName);
                }
            });

        } else {
            btn.removeClass('liked');
            countEl.text(parseInt(countEl.text()) - 1);
            localStorage.removeItem('liked_' + gameName);
            $.ajax({
                url: 'Actions/like_game.php',
                method: 'POST',
                data: { game_name: gameName, action: 'unlike' },
                error: function () {
                    btn.addClass('liked');
                    countEl.text(parseInt(countEl.text()) + 1);
                    localStorage.setItem('liked_' + gameName, 'true');
                }
            });
        }
    });

});