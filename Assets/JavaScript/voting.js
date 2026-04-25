$(document).ready(function() {
    // 1. Detect the click
    $('.vote-btn').on('click', function() {
        const button = $(this);
        const gameName = button.val(); // e.g., "Whack-a-Mole"

        // 2. Visual feedback (Disable button so they don't click twice)
        button.prop('disabled', true).text('Saving...');

        // 3. The Connection (AJAX)
        $.ajax({
            url: '../submit_vote.php', // Path to your backend PHP script
            type: 'POST',
            data: { game: gameName },
            success: function(response) {
                // Change button to show it worked
                button.text('Voted! ✅');
            },
            error: function() {
                // If the server is down or path is wrong
                alert("Couldn't save vote. Check your connection!");
                button.prop('disabled', false).text('Vote!');
            }
        });
    });
});