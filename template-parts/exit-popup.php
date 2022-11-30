<!-- Exit Warning Popup -->

<div class="modal fade" id="exit-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div>
      <div class="modal-header d-flex justify-content-between border-0 rounded-top-10 p-2 pl-5 pr-3">
        <div>
          <p class="mb-0 text-left">Your IP: <?php echo $_SERVER['REMOTE_ADDR']; ?></p>
          <p class="mb-0 text-left font-weight-bold">Your Location is <span>Unprotected</span></p>
        </div>  
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
          <img width="32" height="32" src="<?php echo get_stylesheet_directory_uri() . '/images/icons/close-white.svg' ?>" alt="close icon"/>
        </button>
      </div>
      <div class="modal-content p-4 p-md-5 border-0 rounded-0 rounded-bottom-10">
        <div class="d-flex align-items-center justify-content-between mb-4">
          <img width="60" height="60" class="caution-icon mr-4" src="<?php echo get_stylesheet_directory_uri() . '/images/icons/caution-icon.svg' ?>" alt="caution icon" />
          <h2 class="modal-title"><?php echo $exit_popup_group['title'] ?></h2>
        </div>
        <div class="exit-modal-body mb-4">
          <?php echo $exit_popup_group['body'] ?>
        </div>
        <div class="d-flex flex-column justify-content-center align-items-center">
          <a href="<?php echo $exit_popup_group['cta_button']['url'] ?>" class="btn btn-primary btn-lg mb-4" target="<?php echo $exit_popup_group['cta_button']['target'] ?>"><?php echo $exit_popup_group['cta_button']['title'] ?></a>
          <a href="#" class="small-p text-decoration-underline continue-to-site" target="_blank"><?php echo $exit_popup_group['hyperlink_text']; ?></a>
        </div>
      </div>
    </div>
  </div>
</div>

