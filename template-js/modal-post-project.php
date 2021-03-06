<div class="modal fade" id="modal_post_project">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <i class="fa fa-times"></i>
                </button>
                <h4 class="modal-title">
                    <?php echo get_field( 'post_project_pop_title', 'option' ); ?>
                    <?php //_e( "Bid Retraction new", ET_DOMAIN ) ?>
                </h4>
            </div>
            <div class="modal-body">
                <form role="form" id="form-post-project" class="form-post-project fre-modal-form">
                    <div class="fre-content-confirm">
                        <?php echo get_field( 'post_project_pop_content', 'option' ); ?>
                        <!-- <h2><?php //_e( 'Are you sure you want to cancel your bid on this project?', ET_DOMAIN ); ?></h2>
                        <p><?php //_e( 'Once you cancel the bid, this project will be removed from your working list. However, you can bid this project again after canceling.', ET_DOMAIN ); ?></p> -->
                    </div>
                    <input type="hidden" id="bid-id" value="">
                    <div class="fre-form-btn">
                        <button type="submit" class="fre-normal-btn btn-submit btn-post-project" id="accept-post-project-pop"><?php _e('Got It', ET_DOMAIN) ?></button>
                        <!-- <span class="fre-form-close" data-dismiss="modal"><?php //_e( 'Cancel', ET_DOMAIN ); ?></span> -->
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->