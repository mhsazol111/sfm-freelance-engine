<div id="email-popup-wrap">
    <div class="email-popup-container">
        <span id="email-popup-close">
            <span>x</span>
        </span>
        <h4>Write your email here</h4>
        <div class="email-content-wrapper">
            <form id="sfm-user-mail-form">
				<?php wp_nonce_field( 'email_user_nonce_action', 'email_user_nonce_field' ); ?>
                <input type="hidden" name="selected_user_ids" id="selected_user_ids">

                <div class="sfm-user-input-wrap">
                    <label for="from_email">From Email</label>
                    <input type="email" id="from_email" name="from_email"
                           value="<?php echo get_field( 'from_email', 'option' ); ?>" required/>
                </div>
                <div class="sfm-user-input-wrap">
                    <label for="email_subject">Subject</label>
                    <input type="text" id="email_subject" name="email_subject" required/>
                </div>

                <div class="email-editor-wrap">
					<?php
					$args = array(
						'tinymce'        => array(
							'toolbar1' => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,undo,redo',
						),
						'media_buttons'  => false,
						'default_editor' => 'TinyMCE',
					);
					wp_editor( '', 'user_email_message', $args );
					?>
                </div>
                <button type="submit" class="button" id="send-email-users">Send Email</button>
            </form>
            <div class="params-container">
                <p>
                    <strong>You can use these parameters:
                        <br/>(please don't translate these parameters)
                    </strong>
                    <br/>
                    <br/>{{first_name}}
                    <br/>{{last_name}}
                    <br/>{{email}}
                    <br/>{{registered_as}}
                    <br/>{{user_id}}
                    <br/>{{dashboard_link}}
                </p>
            </div>
        </div>
    </div>
</div>