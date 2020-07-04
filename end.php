<?php
require_once('menubar.php');
?>
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