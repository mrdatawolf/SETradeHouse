<div class="panel-heading">
    <H2><?=$title;?></H2>
    <div class="pull-right">
        <label for="set_amount">Override all amounts: </label><input id="set_amount" name="set_amount" type="text" value="1000"> <label for="set_modifier">Base Value Modifier: </label><input id="set_modifier" name="set_modifier" type="text" value="<?=$defaultMultiplier;?>" readonly>
    </div>
    <div>
        <button onclick="exportTableToCSV('offer_comps.csv', false)">Make CSV File</button> | <button onclick="exportTableToDIV(false)">Make CSV Data</button>
    </div>
</div>