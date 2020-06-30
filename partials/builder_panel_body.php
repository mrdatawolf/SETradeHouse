<div class="panel-body">
    <table style="margin-top: 5em; font-size: smaller" class="table table-bordered table-striped table-condensed">
        <thead>
        <tr>
            <th>Item</th>
            <th>Store Type</th>
            <th>Price Per</th>
            <th>Amount for sale</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($items as $item) {
            if($item->se_name !== 'fillme'){
                $value = $item->getStoreAdjustedValue();
                if($value > 0 && $defaultMultiplier > 0) {
                    ?>
                    <tr>
                        <td><?=$item->se_name;?></td>
                        <td>Offer</td>
                        <td><span class="value editable"><?=round($value*$defaultMultiplier);?></span></td>
                        <td><span class="amount editable"><?=$defaultAmount;?></span></td>
                    </tr>
                    <?php
                }
            }
        }
        ?>
        </tbody>
    </table>
</div>
