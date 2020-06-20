<div class="modal fade" id="accept-bid-no-escrow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <i class="fa fa-times"></i>
                </button>
                <h4 class="modal-title">
                    <?php echo get_field( 'single_bid_popup_title', 'option' ); ?>
                </h4>
            </div>
            <div class="modal-body">
                <form role="form" id="accept_bid_no_escrow" class="fre-modal-form">
                    <input type="hidden" id="bid_id" name="bid_id">
                    <div class="fre-content-confirm">
                        <?php echo get_field( 'single_bid_popup_content', 'option' ); ?>
                    </div>
                    <div class="fre-form-btn">
                        <button type="submit" class="fre-normal-btn" id="accept_proposal"><?php _e( "Confirm", ET_DOMAIN ) ?></button>
                        <span class="fre-form-close" data-dismiss="modal"><?php _e( 'Cancel', ET_DOMAIN ); ?></span>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog login -->
</div><!-- /.modal -->