<?php
$title="Stock Level Data";
$table = "Stock Levels";
require 'start.php';

function read() {
    $stockLevels = new \Controllers\StockLevels();
    $headers  = $stockLevels->headers();
    $rows     = $stockLevels->rows();

    return ['headers' => $headers, 'rows' => $rows];
}
$tableData = read();
?>
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
                </tr>
                </thead>
                <tbody>
                <?php foreach($tableData['rows'] as $data) : ?>
                    <tr>
                        <?php foreach($data as $row) : ?>
                            <td><?= $row; ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</article>
<?php
require_once ('end.php');
?>