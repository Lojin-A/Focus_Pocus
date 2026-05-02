$(document).ready(function() {
    function loadLeaderboards() {
        $.ajax({
            url: 'fetch_leaderboard.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                // Helper to populate lists
                updateList('#whack-list', data.whack, 'pts');
                updateList('#guess-list', data.guess, 'tries');
                updateList('#memory-list', data.memory, '');
                updateList('#rps-list', data.rps, 'wins');
            }
        });
    }

    function updateList(selector, scores, unit) {
        const list = $(selector);
        list.empty();
        scores.forEach(row => {
            list.append(`<li><span>${row.username}</span> <span>${row.score} ${unit}</span></li>`);
        });
    }

    loadLeaderboards(); // Initial load
    // Optional: Refresh every 30 seconds
    setInterval(loadLeaderboards, 30000);
});