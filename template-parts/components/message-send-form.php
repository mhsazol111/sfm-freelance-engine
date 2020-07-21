<?php
global $a_id, $p_id, $showLoader;
$showLoader = isset( $showLoader ) ? $showLoader : true;
?>
<div class="la_author_messages m_c_row">
	<div id="la_message_ajax_container" class="<?php echo $showLoader ? 'la_is_loading' : ''?>">
        <?php if (sfm_is_translating()) : ?>
                <div class="m_c_row">
                    <div class="thumb background_position" style="">
                    </div>
                    <div class="info">
                        <h3>#### ######</h3>
                        <p>####, ###</p>
                    </div>
                    <div class="btn_div">
                        <a class="ie_btn" href="#"><i class="fa fa-check-circle-o" aria-hidden="true"></i> <?php _e('Go to Workroom', ET_DOMAIN); ?></a>
                    </div>
                </div>
        <?php endif; ?>
    </div>
	<div class="la_message_reply_container">
		<form id="la_message_reply_form" class="la_isNewMessage">
			<?php wp_nonce_field( '_la_message_reply', 'reply_nonce' ); ?>
			<input type="hidden" name="project_id" value="<?php echo $p_id; ?>">
			<input type="hidden" name="author_id" value="<?php echo $a_id; ?>">
			<div class="la_message_writer">
				<textarea name="reply_message"
				          placeholder="<?php esc_html_e( 'Write a reply...', ET_DOMAIN ); ?>"
				          id="reply"
				          name="reply" rows="4"></textarea>
			</div>
			<div class="la_message_reply_button workspace-button">
				<button class="ie_btn reply_button"><i class="fa fa-paper-plane-o"></i> <?php _e('Send', 'sfm'); ?>
				</button>
			</div>
		</form>
	</div>
</div>