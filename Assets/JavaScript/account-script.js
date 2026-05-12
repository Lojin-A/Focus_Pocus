google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawAllCharts);

function drawAllCharts() {

    // ==========================================
    // Draws any Pie Chart we want
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
    // Draws any Bar Chart we want
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


  // Chart 1: NumGuess Pro
if (guessData.fewest > 0) {
    makeBarChart('piechart1', 'NumGuess Statistics', ['#06d6a0', '#ffd166'], [
        ['Type', 'Amount'],
        ['Fewest Attempts', guessData.fewest],
        ['Total Played', guessData.played]
    ]);
} else {
    makeBarChart('piechart1', 'NumGuess Statistics', ['#ffd166'], [
        ['Type', 'Amount'],
        ['Total Played', guessData.played]
    ]);
}

    // Chart 2: Whack-a-Mole
    makeBarChart('piechart2', 'Whack-a-Mole Stats', [
        ['Stats', 'Amount', { role: 'style' }],
        ['High Score', whackData.highScore, '#90c2e7'], 
        ['Played', whackData.played, '#ffd166'],     
        ['Wins', whackData.wins, '#06d6a0'],         
        ['Losses', whackData.losses, '#ef476f']     
    ]);

    // Chart 3: Memory Match
    makeBarChart('piechart3', 'Memory Match Stats', [
        ['Stats', 'Amount', { role: 'style' }],
        ['Played', memoryData.played, '#ffd166'],
        ['Wins', memoryData.wins, '#06d6a0'],
        ['Losses', memoryData.losses, '#ef476f'],
        ['Best Time', memoryData.bestTime, '#118ab2'],
        ['Fewest Flips', memoryData.fewestFlips, '#90c2e7']
    ]);

   // Chart 4: Rock Paper Scissors
   let tiesCount = rpsData.played - (rpsData.wins + rpsData.losses);
   makePieChart('piechart4', 'Match Results', ['#90c2e7', '#ef476f', '#ffd166'], [
       ['Result', 'Amount'],
       ['Wins', rpsData.wins],
       ['Losses', rpsData.losses],
       ['Ties', tiesCount > 0 ? tiesCount : 0]
    ]);
}