<?php
require_once('menubar.php');
?>
<script src="public/js/to_csv.js"></script>
<script src="public/js/offer_order.js"></script>
<script src="dist/clipboard.min.js"></script>
<script>
    $('#pick_cluster').val(localStorage.getItem("clusterId"))
                      .on('change', function() {
        localStorage.setItem("clusterId", this.value);
    });
    var clipboard = new ClipboardJS('.btn');
</script>
</body>
</html>