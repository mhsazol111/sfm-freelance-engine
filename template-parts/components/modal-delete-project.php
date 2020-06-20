<div class="modal fade" id="modal_delete_project" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <i class="fa fa-times"></i>
                </button>
                <h4 class="modal-title">
					<?php _e( "Delete Project", ET_DOMAIN ) ?>
                </h4>
            </div>
            <div class="modal-body">
                <form role="form" id="form_delete_project" class="fre-modal-form">
                    <input type="hidden" id="project_id" name="project_id">
                    <div class="fre-content-confirm">
                        <h2><?php _e( 'Are you sure you want to delete this project?', ET_DOMAIN ); ?></h2>
                    </div>
                    <div class="fre-form-btn">
                        <button type="submit" class="fre-normal-btn" id="submit_project_action"><?php _e( "Confirm", ET_DOMAIN ) ?></button>
                        <span class="fre-form-close" data-dismiss="modal"><?php _e( 'Cancel', ET_DOMAIN ); ?></span>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog login -->
</div><!-- /.modal -->