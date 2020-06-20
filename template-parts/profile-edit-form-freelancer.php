<?php
$author_id            = get_current_user_id();
$user_profile_post_id = get_user_meta( $author_id, 'user_profile_id', true );
?>
<form action="" method="POST" id="freelancer-profile-edit-form" class="edit-form validation-enabled"
      enctype="multipart/form-data">
    <h3 class="profile-title">Work rates and skills</h3>
    <div class="work-skil" id="fre-post-project">
        <div class="input-field">
            <label for="daily_wage">Daily wage rate</label>
            <input id="daily_wage" type="number" placeholder="Amount of daily wage" name="daily_wage_rate"
                   value="<?php echo get_the_author_meta( 'daily_wage_rate', $author_id ); ?>" required>
        </div>

        <div class="input-field fre-input-field">
            <div class="select-box">
                <label class="fre-field-title" for="project_category">Interested Project Categories</label>
                <select name="project_category[]" id="project_category" class="sfm-select2" multiple required>
                    <option value="">Select All</option>

			        <?php
			        $categories = get_terms( array(
				        'taxonomy'   => 'project_category',
				        'hide_empty' => false,
			        ) );

			        $user_categories = get_the_terms( $user_profile_post_id, 'project_category' );
			        $selected_cats = [];
			        foreach ($user_categories as $cat) {
			            $selected_cats[] = $cat->term_id;
                    }

			        foreach ( $categories as $cat ) {
				        if ( in_array($cat->term_id, $selected_cats) ) {
					        echo '<option value="' . $cat->term_id . '" selected>' . $cat->name . '</option>';
				        } else {
					        echo '<option value="' . $cat->term_id . '">' . $cat->name . '</option>';
				        }
			        }
			        ?>

                </select>
            </div>
        </div>

        <div class="input-field fre-input-field full">
            <div class="select-box">
                <label for="project_skills">Interested Project Skills</label>
                <select name="project_skills[]" id="project_skills" class="sfm-select2" multiple required>
                    <option value="">Select All</option>

			        <?php
			        $skills = get_terms( array(
				        'taxonomy'   => 'skill',
				        'hide_empty' => false,
			        ) );

			        $user_skills = get_the_terms( $user_profile_post_id, 'skill' );
			        $selected_skill = [];
			        foreach ($user_skills as $skill) {
				        $selected_skill[] = $skill->term_id;
			        }

			        foreach ( $skills as $skill ) {
				        if ( in_array($skill->term_id, $selected_skill) ) {
					        echo '<option value="' . $skill->term_id . '" selected>' . $skill->name . '</option>';
				        } else {
					        echo '<option value="' . $skill->term_id . '">' . $skill->name . '</option>';
				        }
			        }
			        ?>

                </select>
            </div>
        </div>
    </div>
    <h3 class="profile-title">Personal Details</h3>
    <div class="personal-details">
        <div class="input-field">
            <label for="first_name">First Name</label>
            <input id="first_name" type="text" name="first_name" placeholder="First Name"
                   value="<?php echo get_the_author_meta( 'first_name', $author_id ); ?>" required>
        </div>
        <div class="input-field">
            <label for="last_name">Last Name</label>
            <input id="last_name" type="text" name="last_name" placeholder="Last Name"
                   value="<?php echo get_the_author_meta( 'last_name', $author_id ); ?>" required>
        </div>
        <div class="three-column-row">
            <div class="input-field">
                <label for="display_name">Display Name</label>
                <input id="display_name" type="text" name="display_name" placeholder="Public Name"
                       value="<?php echo get_the_author_meta( 'display_name', $author_id ); ?>" required>
            </div>
            <div class="input-field">
                <label for="phone_number">Phone Number</label>
                <input id="phone_number" type="text" name="phone_number" placeholder="Your Phone Number"
                       value="<?php echo get_the_author_meta( 'phone_number', $author_id ); ?>" required>
            </div>
            <div class="input-field">
                <label for="job_title">Job Title</label>
                <input id="job_title" type="text" name="job_title" placeholder="Job Title"
                       value="<?php echo get_the_author_meta( 'job_title', $author_id ); ?>" required>
            </div>
        </div>
        <div class="input-field details">
            <label for="describe_more">Describe more details about you</label>
            <textarea id="describe_more" name="describe_more" rows="20"
                      cols="20"><?php echo get_the_author_meta( 'describe_more', $author_id ); ?></textarea>
        </div>
    </div>
    <h3 class="profile-title">Social Profiles</h3>
    <div class="social-details">
        <div class="input-field">
            <label for="facebook">Facebook</label>
            <input id="facebook" type="text" name="facebook" placeholder="https://facebook.com/yourusername"
                   value="<?php echo get_the_author_meta( 'facebook', $author_id ); ?>">
        </div>
        <div class="input-field">
            <label for="twitter">Twitter</label>
            <input id="twitter" type="text" name="twitter" placeholder="https://twitter.com/yourusername"
                   value="<?php echo get_the_author_meta( 'twitter', $author_id ); ?>">
        </div>
        <div class="input-field">
            <label for="linkedin">LinkedIn</label>
            <input id="linkedin" type="text" name="linkedin" placeholder="https://linkedin.com/yourusername"
                   value="<?php echo get_the_author_meta( 'linkedin', $author_id ); ?>">
        </div>
        <div class="input-field">
            <label for="skype">Skype</label>
            <input id="skype" type="text" name="skype" placeholder="your_skype_name"
                   value="<?php echo get_the_author_meta( 'skype', $author_id ); ?>">
        </div>
    </div>
    <h3 class="profile-title">Your Location</h3>
    <div class="location-details">
        <div class="input-field">
            <label for="country_you_live">Country You Live</label>
            <div class="select-box">
                <select name="country_you_live" id="country_you_live" class="sfm-select2" required>
                    <option value="">Select Country</option>
			        <?php
			        $countries           = get_terms( array(
				        'taxonomy'   => 'country',
				        'hide_empty' => false,
			        ) );
			        $selected_country_id = get_the_terms( $user_profile_post_id, 'country' );
			        foreach ( $countries as $country ) {
				        if ( $selected_country_id ) {
					        echo '<option value="' . $country->term_id . '" ' . ( $selected_country_id[0]->term_id == $country->term_id ? 'selected' : '' ) . '>' . $country->name . '</option>';
				        } else {
					        echo '<option value="' . $country->term_id . '">' . $country->name . '</option>';
				        }
			        }
			        ?>
                </select>
            </div>
        </div>
        <div class="input-field">
            <label for="city_name">City Name</label>
            <input id="city_name" type="text" name="city_name" placeholder="City name"
                   value="<?php echo get_the_author_meta( 'city_name', $author_id ); ?>" required>
        </div>
    </div>
    <h3 class="profile-title">Profile Picture</h3>
    <div class="picture-change">
        <div class="profile-image">
            <img src="<?php echo( get_user_meta( $author_id, 'et_avatar_url', true ) ? get_user_meta( $author_id, 'et_avatar_url', true ) : get_avatar_url( $author_id ) ); ?>"
                 alt="Profile Image">
        </div>
        <div class="upload-file">
            <label for="input-file-now">Change your profile picture</label>
            <div class="file-upload-wrapper">
                <input type="file" onchange="readURL(this);" name="profile_image" id="input-file-now"
                       class="file-upload"/>
                <label class="custom-file-label" for="input-file-now">Upload Picture</label>
            </div>
            <p>Accepted image format: 'png', 'jpg', 'jpeg', 'gif'</p>
        </div>
    </div>

	<?php wp_nonce_field( 'edit_profile', 'edit_profile_nonce' ); ?>

    <button class="btn-all ie_btn submit" id="update-freelancer-profile" type="submit" name="submit">Save all
        information
    </button>
</form>