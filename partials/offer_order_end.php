<?php require_once('end.php'); ?>
<script src="public/js/offer_order.js"></script>
<script>
  exportTableToDIV(false);
  $('.edit_text').change(function() {
      console.log('got here');
      exportTableToDIV(false);
  });
  $('.editable').change(function() {
      console.log('got there');
  });

</script>