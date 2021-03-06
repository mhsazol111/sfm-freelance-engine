<?php
$author_id            = get_current_user_id();
$user_profile_post_id = get_user_meta( $author_id, 'user_profile_id', true );
$current_lang         = get_locale();
?>
<form action="" method="POST" id="freelancer-profile-edit-form" class="edit-form validation-enabled"
      enctype="multipart/form-data">
    <h3 class="profile-title"><?php _e( 'Work rates and skills', ET_DOMAIN ) ?></h3>
    <div class="work-skil" id="fre-post-project">
        <div class="input-field ">
            <label for="daily_wage_rate">
				<?php _e( 'Daily Wage Rate (minimum of CHF 320.-)', ET_DOMAIN ) ?>
                <span class="label-notice">
                    <i class="icon">?</i>
                    <span><?php _e( 'The minimum of CHF 320.- relates to the Swiss Global Labor Agreement on Temporary work that applies on wage portage', ET_DOMAIN ); ?></span>
                </span>
            </label>
            <div class="fre-daily-wage">
                <div class="daily-input-wrap">
                    <input id="daily_wage" type="number" name="daily_wage_rate"
                           placeholder="<?php _e( 'Daily Wage Rate (minimum of CHF 320.-)', ET_DOMAIN ); ?>"
                           value="<?php echo get_the_author_meta( 'daily_wage_rate', $author_id ); ?>"
                           class="number numberVal" required <?php echo get_the_author_meta( 'daily_wage_rate', $author_id ) == 'agreed' ? 'disabled' : '' ?>>
                </div>
                <div class="daily-wage-checkbox">
                    <label class="container-checkbox">
                        <input type="checkbox" name="daily_wage_agreed" class="freelancer-wage-switch" value="agreed" <?php echo get_the_author_meta( 'daily_wage_rate', $author_id ) == 'agreed' ? 'checked' : '' ?>>
                        <span class="checkmark"></span>
                    </label>
                    <div class="daily-wage-agreed"><?php _e( 'To be agreed (minimum of CHF 320.-)', ET_DOMAIN ); ?></div>
                </div>
            </div>
        </div>

        <div class="input-field fre-input-field">
            <label class="fre-field-title" for="language"><?php _e( 'Select Your Language', ET_DOMAIN ) ?></label>
            <select name="language[]" id="language" class="sfm-select2" multiple required>
				<?php
				$languages = get_terms( array(
					'taxonomy'   => 'language',
					'hide_empty' => false,
				) );

				$user_languages     = get_the_terms( $user_profile_post_id, 'language' );
				$selected_languages = [];
				if ( $user_languages ) {
					foreach ( $user_languages as $language ) {
						$selected_languages[] = $language->term_id;
					}
				}

				foreach ( $languages as $language ) {
					$la_opt_language = get_field( $current_lang . '_label', $language );

					if ( get_locale() == 'en_US' ) :
						if ( in_array( $language->term_id, $selected_languages ) ) {
							echo '<option value="' . $language->term_id . '" selected>' . $language->name . '</option>';
						} else {
							echo '<option value="' . $language->term_id . '">' . $language->name . '</option>';
						}
					else:
						if ( in_array( $language->term_id, $selected_languages ) ) {
							echo '<option class="la-option" value="' . $language->term_id . '" selected>' . $la_opt_language . '</option>';
						} else {
							echo '<option class="la-option" value="' . $language->term_id . '">' . $la_opt_language . '</option>';
						}
					endif;
				}
				?>
            </select>
        </div>

        <div class="input-field fre-input-field full">
            <label class="fre-field-title"
                   for="project_category"><?php _e( 'Interested Project Categories', ET_DOMAIN ) ?></label>
            <select name="project_category[]" id="project_category" class="sfm-select2-limited-category" multiple
                    required>
				<?php
				$categories = get_terms( array(
					'taxonomy'   => 'project_category',
					'hide_empty' => false,
				) );

				$user_category_ids       = unserialize( get_user_meta( get_current_user_id(), 'user_category', true ) );
				$user_profile_categories = get_the_terms( $user_profile_post_id, 'project_category' );

				$selected_categories = [];
				if ( $user_category_ids ) {
					$selected_categories = $user_category_ids;
				} else {
					if ( $user_profile_categories ) {
						foreach ( $user_profile_categories as $category ) {
							$selected_categories[] = $category->term_id;
						}
					}
				}

				foreach ( $categories as $category ) {
					$la_opt_cat = get_field( $current_lang . '_label', $category );

					if ( get_locale() == 'en_US' ) :
						if ( in_array( $category->term_id, $selected_categories ) ) {
							echo '<option value="' . $category->term_id . '" selected>' . $category->name . '</option>';
						} else {
							echo '<option value="' . $category->term_id . '">' . $category->name . '</option>';
						}
					else:
						if ( in_array( $category->term_id, $selected_categories ) ) {
							echo '<option class="la-option" value="' . $category->term_id . '" selected>' . $la_opt_cat . '</option>';
						} else {
							echo '<option class="la-option" value="' . $category->term_id . '">' . $la_opt_cat . '</option>';
						}
					endif;
				}
				?>
            </select>
        </div>

        <div class="input-field fre-input-field full">
            <label for="project_skills"><?php _e( 'Interested Project Skills', ET_DOMAIN ) ?></label>
            <select name="project_skills[]" id="project_skills" class="sfm-select2-limited-skill" multiple required>
				<?php
				$skills = get_terms( array(
					'taxonomy'   => 'skill',
					'hide_empty' => false,
				) );

				$user_skills    = get_the_terms( $user_profile_post_id, 'skill' );
				$selected_skill = [];
				if ( $user_skills ) {
					foreach ( $user_skills as $skill ) {
						$selected_skill[] = $skill->term_id;
					}
				}

				foreach ( $skills as $skill ) {
					$la_opt_skill = get_field( $current_lang . '_label', $skill );

					if ( get_locale() == 'en_US' ) :
						if ( in_array( $skill->term_id, $selected_skill ) ) {
							echo '<option value="' . $skill->term_id . '" selected>' . $skill->name . '</option>';
						} else {
							echo '<option value="' . $skill->term_id . '">' . $skill->name . '</option>';
						}
					else:
						if ( in_array( $skill->term_id, $selected_skill ) ) {
							echo '<option class="la-option" value="' . $skill->term_id . '" selected>' . $la_opt_skill . '</option>';
						} else {
							echo '<option class="la-option" value="' . $skill->term_id . '">' . $la_opt_skill . '</option>';
						}
					endif;
				}
				?>
            </select>
        </div>
    </div>
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
                <label for="nationality_visible"><?php _e( 'Nationality', ET_DOMAIN ) ?></label>
				<?php
				$user_nationality_id  = get_user_meta( get_current_user_id(), 'user_country_id', true );
				$user_profile_country = get_the_terms( $user_profile_post_id, 'country' );
				if ( $user_nationality_id ) {
					$nationality = get_term( $user_nationality_id, 'country' )->name;
				} else {
					$nationality = $user_profile_country[0]->name;
				}
				?>
                <input id="nationality_visible" type="text" name="nationality_visible" placeholder="Nationality"
                       value="<?php echo $nationality; ?>" readonly>
            </div>
            <div class="input-field">
                <label for="phone_number"><?php _e( 'Phone Number', ET_DOMAIN ) ?></label>
                <input id="phone_number" type="text" name="phone_number" placeholder="Your Phone Number"
                       value="<?php echo get_the_author_meta( 'phone_number', $author_id ); ?>" required>
            </div>
            <div class="input-field">
                <label for="job_title"><?php _e( 'Job Title', ET_DOMAIN ) ?></label>
                <input id="job_title" type="text" name="job_title" placeholder="Job Title"
                       value="<?php echo get_the_author_meta( 'job_title', $author_id ); ?>" required>
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

					$selected_country_id = get_the_terms( $user_profile_post_id, 'country' );

					foreach ( $countries as $country ) {
						$la_opt_country = get_field( $current_lang . '_label', $country );

						if ( get_locale() == 'en_US' ) :
							if ( $selected_country_id ) {
								echo '<option value="' . $country->term_id . '" ' . ( $selected_country_id[0]->term_id == $country->term_id ? 'selected' : '' ) . '>' . $country->name . '</option>';
							} else {
								echo '<option value="' . $country->term_id . '">' . $country->name . '</option>';
							}
						else:
							if ( $selected_country_id ) {
								echo '<option class="la-option" value="' . $country->term_id . '" ' . ( $selected_country_id[0]->term_id == $country->term_id ? 'selected' : '' ) . '>' . $la_opt_country . '</option>';
							} else {
								echo '<option class="la-option" value="' . $country->term_id . '">' . $la_opt_country . '</option>';
							}
						endif;
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
			<?php echo get_avatar( $author_id, 150, '', '', array( 'width' => 150, 'height' => 150 ) ); ?>
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

    <button class="btn-all ie_btn submit" id="update-freelancer-profile" type="submit"
            name="submit"><?php _e( 'Save all information', ET_DOMAIN ) ?></button>
</form>