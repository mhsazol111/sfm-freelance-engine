<?php
$author_id            = get_current_user_id();
$user_profile_post_id = get_user_meta( $author_id, 'user_profile_id', true );
?>
<form action="" method="POST" id="employer-profile-edit-form" class="edit-form validation-enabled"
      enctype="multipart/form-data">
    <h3 class="profile-title"><?php _e( 'Personal Details', ET_DOMAIN ) ?></h3>
    <div class="personal-details">
        <div class="three-column-row">
            <div class="input-field">
                <label for="first_name"><?php _e( 'First Name', ET_DOMAIN ) ?></label>
                <input id="first_name" type="text" name="first_name" placeholder="First Name"
                       value="<?php echo get_the_author_meta( 'first_name', $author_id ); ?>" required>
            </div>
            <div class="input-field">
                <label for="last_name"><?php _e( 'Last Name', ET_DOMAIN ) ?></label>
                <input id="last_name" type="text" name="last_name" placeholder="Last Name"
                       value="<?php echo get_the_author_meta( 'last_name', $author_id ); ?>" required>
            </div>
            <div class="input-field">
                <label for="display_name"><?php _e( 'Display Name', ET_DOMAIN ) ?></label>
                <input id="display_name" type="text" name="display_name" placeholder="Public Name"
                       value="<?php echo get_the_author_meta( 'display_name', $author_id ); ?>" required>
            </div>
            <div class="input-field">
                <label for="phone_number"><?php _e( 'Phone Number', ET_DOMAIN ) ?></label>
                <input id="phone_number" type="text" name="phone_number" placeholder="Your Phone Number"
                       value="<?php echo get_the_author_meta( 'phone_number', $author_id ); ?>" required>
            </div>
            <div class="input-field">
                <label for="company_name"><?php _e( 'Company Name', ET_DOMAIN ) ?></label>
                <input id="company_name" type="text" name="company_name" placeholder="Company Name"
                       value="<?php echo get_the_author_meta( 'company_name', $author_id ); ?>" required>
            </div>
            <div class="input-field">
                <label for="job_title"><?php _e( 'Job Title', ET_DOMAIN ) ?></label>
                <input id="job_title" type="text" name="job_title" placeholder="Job Title"
                       value="<?php echo get_the_author_meta( 'job_title', $author_id ); ?>" required>
            </div>
        </div>

        <div class="input-field fre-input-field details">
            <div class="select-box">
                <label class="fre-field-title"
                       for="project_category"><?php _e( 'Interested Project Categories', ET_DOMAIN ) ?></label>
                <select name="project_category[]" id="project_category" class="sfm-select2" multiple required>
                    <option value=""><?php _e( 'Select All', ET_DOMAIN ) ?></option>

					<?php
					$categories = get_terms( array(
						'taxonomy'   => 'project_category',
						'hide_empty' => false,
					) );

					$user_categories = get_the_terms( $user_profile_post_id, 'project_category' );
					$selected_cats   = [];
					if ( $user_categories ) {
						foreach ( $user_categories as $cat ) {
							$selected_cats[] = $cat->term_id;
						}
					}

					foreach ( $categories as $cat ) {
						if ( in_array( $cat->term_id, $selected_cats ) ) {
							echo '<option value="' . $cat->term_id . '" selected>' . $cat->name . '</option>';
						} else {
							echo '<option value="' . $cat->term_id . '">' . $cat->name . '</option>';
						}
					}
					?>

                </select>
            </div>
        </div>

        <div class="input-field details">
            <label for="describe_more"><?php _e( 'Describe more details about you', ET_DOMAIN ) ?></label>
            <textarea id="describe_more" name="describe_more" rows="20"
                      cols="20"><?php echo get_the_author_meta( 'describe_more', $author_id ); ?></textarea>
        </div>
    </div>
    <h3 class="profile-title"><?php _e( 'Social Profiles', ET_DOMAIN ) ?></h3>
    <div class="social-details">
        <div class="input-field">
            <label for="facebook"><?php _e( 'Facebook', ET_DOMAIN ) ?></label>
            <input id="facebook" type="text" name="facebook" placeholder="https://facebook.com/yourusername"
                   value="<?php echo get_the_author_meta( 'facebook', $author_id ); ?>">
        </div>
        <div class="input-field">
            <label for="twitter"><?php _e( 'Twitter', ET_DOMAIN ) ?></label>
            <input id="twitter" type="text" name="twitter" placeholder="https://twitter.com/yourusername"
                   value="<?php echo get_the_author_meta( 'twitter', $author_id ); ?>">
        </div>
        <div class="input-field">
            <label for="linkedin"><?php _e( 'LinkedIn', ET_DOMAIN ) ?></label>
            <input id="linkedin" type="text" name="linkedin" placeholder="https://linkedin.com/yourusername"
                   value="<?php echo get_the_author_meta( 'linkedin', $author_id ); ?>">
        </div>
        <div class="input-field">
            <label for="skype"><?php _e( 'Skype', ET_DOMAIN ) ?></label>
            <input id="skype" type="text" name="skype" placeholder="your_skype_name"
                   value="<?php echo get_the_author_meta( 'skype', $author_id ); ?>">
        </div>
    </div>
    <h3 class="profile-title"><?php _e( 'Your Location', ET_DOMAIN ) ?></h3>
    <div class="location-details">
        <div class="input-field">
            <label for="country_you_live"><?php _e( 'Country You Live', ET_DOMAIN ) ?></label>
            <div class="select-box">
                <select name="country_you_live" id="country_you_live" class="sfm-select2" required>
                    <option value=""><?php _e( 'Select Country', ET_DOMAIN ) ?></option>
					<?php
					$countries = get_terms( array(
						'taxonomy'   => 'country',
						'hide_empty' => false,
					) );

					$user_country_id         = get_user_meta( get_current_user_id(), 'user_country_id', true );
					$user_profile_country = get_the_terms( $user_profile_post_id, 'country' );
					$user_profile_country_id = $user_profile_country != '' ? $user_profile_country[0]->term_id : '';

					$selected_country_id = $user_country_id ? $user_country_id : $user_profile_country_id;

					foreach ( $countries as $country ) {
						if ( $selected_country_id ) {
							echo '<option value="' . $country->term_id . '" ' . ( $selected_country_id == $country->term_id ? 'selected' : '' ) . '>' . $country->name . '</option>';
						} else {
							echo '<option value="' . $country->term_id . '">' . $country->name . '</option>';
						}
					}
					?>
                </select>
            </div>
        </div>
        <div class="input-field">
            <label for="city_name"><?php _e( 'City Name', ET_DOMAIN ) ?></label>
            <input id="city_name" type="text" name="city_name" placeholder="City name"
                   value="<?php echo get_the_author_meta( 'city_name', $author_id ); ?>" required>
        </div>
    </div>
    <h3 class="profile-title"><?php _e( 'Profile Picture', ET_DOMAIN ) ?></h3>
    <div class="picture-change">
        <div class="profile-image">
            <img src="<?php echo( get_user_meta( $author_id, 'et_avatar_url', true ) ? get_user_meta( $author_id, 'et_avatar_url', true ) : get_avatar_url( $author_id ) ); ?>"
                 alt="Profile Image">
        </div>
        <div class="upload-file">
            <label for="input-file-now"><?php _e( 'Change your profile picture', ET_DOMAIN ) ?></label>
            <div class="file-upload-wrapper">
                <input type="file" onchange="readURL(this);" name="profile_image" id="input-file-now"
                       class="file-upload"/>
                <label class="custom-file-label" for="input-file-now"><?php _e( 'Upload Picture', ET_DOMAIN ) ?></label>
            </div>
            <p><?php _e( "Accepted image format: 'png', 'jpg', 'jpeg', 'gif'", ET_DOMAIN ) ?></p>
        </div>
    </div>

	<?php wp_nonce_field( 'edit_profile', 'edit_profile_nonce' ); ?>

    <button class="btn-all ie_btn submit" type="submit" name="submit"><?php _e( 'Save all information', ET_DOMAIN ) ?></button>
</form>