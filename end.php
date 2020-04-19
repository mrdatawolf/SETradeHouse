<?php
require_once('menubar.php');
?>
<script>
    $('#pick_cluster').val(localStorage.getItem("clusterId"))
                      .on('change', function() {
        localStorage.setItem("clusterId", this.value);
    });
</script>
</body>
</html>