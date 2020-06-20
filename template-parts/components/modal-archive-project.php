<div class="modal fade" id="modal_archive_project" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <i class="fa fa-times"></i>
                </button>
                <h4 class="modal-title">
					<?php _e( "Archive Project", ET_DOMAIN ) ?>
                </h4>
            </div>
            <div class="modal-body">
                <form role="form" id="form_archive_project" class="fre-modal-form">
                    <input type="hidden" id="project_id" name="project_id">
                    <div class="fre-content-confirm">
                        <h2><?php _e( 'Are you sure you want to archive this project?', ET_DOMAIN ); ?></h2>
                        <p><?php _e( "Once you archive this project, it'll no longer available to freelancer.", ET_DOMAIN ) ?></p>
                    </div>
                    <div class="fre-form-btn">
                        <button type="submit" class="fre-normal-btn"><?php _e( "Confirm", ET_DOMAIN ) ?></button>
                        <span class="fre-form-close" data-dismiss="modal"><?php _e( 'Cancel', ET_DOMAIN ); ?></span>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog login -->
</div><!-- /.modal -->