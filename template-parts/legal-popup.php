<?php

?>

<!-- Modal -->
<div class="modal fade legal-modal" id="<?php echo $args['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="legal-modal-header">
      	<button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
      		<span aria-hidden="true">×</span> 
      	</button>
        <h3 class="modal-title">Terms &amp; Conditions</h3>
      </div>
      <div class="legal-modal-body">
        <?php echo $args['legal-copy']; ?>
      </div>
    </div>
  </div>
</div>

<script>
    
    var legalPopUpIdModal = <?php echo $args['id']; ?>

</script>