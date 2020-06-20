<div class="modal fade" id="signup_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <i class="fa fa-times"></i>
                </button>
                <h4 class="modal-title">
                    <?php echo get_field( 'terms_and_conditions_title', 'option' ); ?>
                </h4>
            </div>
            <div class="modal-body">
                <form role="form" id="accept_bid_no_escrow" class="fre-modal-form">
                    <div class="fre-content-confirm">
                        <?php echo get_field( 'signup_terms_and_conditions', 'option' ); ?>
                    </div>
                    <div class="fre-form-btn">
                        <button type="button" class="fre-normal-btn" id="accept_signup_modal"><?php _e( "I Accept", ET_DOMAIN ) ?></button>
                        <span class="fre-form-close" data-dismiss="modal"><?php _e( 'Decline', ET_DOMAIN ); ?></span>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog login -->
</div><!-- /.modal -->