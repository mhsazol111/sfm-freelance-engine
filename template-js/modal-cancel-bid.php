<div class="modal fade" id="modal_cancel_bid">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <i class="fa fa-times"></i>
                </button>
                <h4 class="modal-title">
					<?php
					if ( USER_ROLE == FREELANCER || sfm_translating_as('freelancer')) :
						echo get_field( 'bid_retraction_title', 'option' );
					else :
						echo get_field( 'decline_proposal_title', 'option' );
					endif;
					?>
                </h4>
            </div>
            <div class="modal-body">
                <form role="form" id="sfm-cancel-bid-form" class="sfm-cancel-bid-form fre-modal-form">
                    <div class="fre-content-confirm">
						<?php
						if ( USER_ROLE == FREELANCER || sfm_translating_as('freelancer') ) :
							echo get_field( 'bid_retraction_content', 'option' );
						else :
							echo get_field( 'decline_proposal_content', 'option' );
						endif;
						?>
                    </div>
                    <input type="hidden" id="bid-id" name="bid_id" value="">
                    <div class="fre-form-btn">
                        <button type="submit"
                                class="fre-normal-btn btn-submit btn-cancel-bid"><?php _e( 'Confirm', ET_DOMAIN ) ?></button>
                        <span class="fre-form-close" data-dismiss="modal"><?php _e( 'Cancel', ET_DOMAIN ); ?></span>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->