<?php
$title="Stock Level Data";
$table = "Stock Levels";
require 'stock_start.php';
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<style>
    #rawdataLink {
        background-color: #DDE9FF;
    }
</style>
<article class="tabs">
    <section id="<?=$table;?>" class="simpleDisplay">
        <h2><a class="headerTitle" href="#<?=$table;?>"><?=$table;?></a></h2>
        <div class="tab-content">
            <table>
                <thead>
                <tr>
                    <?php foreach($tableData['headers'] as $header) : ?>
                        <th><?=$header; ?></th>
                    <?php endforeach; ?>
                        <th>Total known</th>
                        <th>% of total</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($tableData['rows'] as $row) : ?>
                    <tr>
                        <?php foreach($row as $cell) : ?>
                            <td><?= $cell; ?></td>
                        <?php endforeach; ?>
                        <td><?=$totalData[$row[6]][$row[7]];?></td>
                        <td><?=round($row[3]/$totalData[$row[6]][$row[7]]*100, 2);?>%</td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
      <div id="barchart_div"></div>
      <div id="piechart_div"></div>
    </section>
</article>
<script type="text/javascript">
    var results = <?=makeChartData($tableData['rows'], $users);?>;
    // Load the Visualization API and the corechart package.
    google.charts.load('current', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart);

    // Callback that creates and populates a data table,
    // instantiates the pie chart, passes in the data and
    // draws it.
    function drawChart() {
        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'User');
        data.addColumn('number', 'Amount');
        data.addRows(results);

        // Set chart options
        var options = {'title':'Gold Ingots Breakdown',
            'width':800,
            'height':300};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.BarChart(document.getElementById('barchart_div'));
        var chart2 = new google.visualization.PieChart(document.getElementById('piechart_div'));
        chart.draw(data, options);
        chart2.draw(data, options);
    }
</script>
<?php
require_once ('end.php');
?>
