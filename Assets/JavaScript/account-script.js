google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawAllCharts);

function drawAllCharts() {

    // ==========================================
    // HELPER 1: Draws any Pie Chart we want
    // ==========================================
    function makePieChart(elementId, chartTitle, chartColors, chartData) {
        var data = google.visualization.arrayToDataTable(chartData);
        var options = {
            title: chartTitle,
            colors: chartColors,
            backgroundColor: 'transparent',
            chartArea: {width: '80%', height: '75%'},
            titleTextStyle: { fontName: 'Patrick Hand', fontSize: 18, color: '#333' },
            legend: { textStyle: { fontName: 'Patrick Hand', fontSize: 14 } }
        };
        var chart = new google.visualization.PieChart(document.getElementById(elementId));
        chart.draw(data, options);
    }

    // ==========================================
    // HELPER 2: Draws any Bar Chart we want
    // ==========================================
    function makeBarChart(elementId, chartTitle, chartData) {
        var data = google.visualization.arrayToDataTable(chartData);
        var options = {
            title: chartTitle,
            backgroundColor: 'transparent',
            legend: { position: "none" },
            chartArea: {width: '70%', height: '70%'},
            titleTextStyle: { fontName: 'Patrick Hand', fontSize: 18, color: '#333' },
            hAxis: { textStyle: { fontName: 'Patrick Hand' } },
            vAxis: { textStyle: { fontName: 'Patrick Hand' }, viewWindow: { min: 0 } }
        };
        var chart = new google.visualization.ColumnChart(document.getElementById(elementId));
        chart.draw(data, options);
    }

    // ==========================================
    // NOW WE JUST CALL THE HELPERS! (So clean!)
    // ==========================================

    // Chart 1: NumGuess Pro
    makePieChart('piechart1', 'Win/Loss Ratio', ['#ffd166', '#ef476f'], [
        ['Result', 'Amount'], 
        ['Wins', 10], 
        ['Losses', 5]
    ]);

    // Chart 2: Whack-a-Mole
    makeBarChart('piechart2', 'Player Stats', [
        ['Stats', 'Amount', { role: 'style' }],
        ['High Score', 150, '#90c2e7'],
        ['Total Played', 8, '#ffd166']
    ]);

    // Chart 3: Memory Match
    makeBarChart('piechart3', 'Matching Efficiency', [
        ['Stats', 'Amount', { role: 'style' }],
        ['Total Played', 12, '#ffd166'],
        ['Fewest Flips', 10, '#06d6a0']
    ]);

    // Chart 4: Rock Paper Scissors
    makePieChart('piechart4', 'Match Results', ['#90c2e7', '#ef476f', '#ffd166'], [
        ['Result', 'Amount'], 
        ['Wins', 12], 
        ['Losses', 5], 
        ['Ties', 3]
    ]);
}