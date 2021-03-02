<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct access, please!' );
}
?>


<div class="fre-page-wrapper list-profile-wrapper">
    <div class="profile_dashboard" id="<?php echo USER_ROLE; ?>-dashboard">

		<?php get_template_part( 'template-parts/sidebar', 'profile' ); // Dashboard Sidebar ?>

        <section id="dashboard_content">
            <div class="dashboard_inn">

                <h4 class="complete-profile-notice">You have to update the profile first to access anything!</h4>

                <div class="dashboard_title">
                    <h2><?php _e( 'Edit Profile', ET_DOMAIN ); ?></h2>
                    <hr>
                </div>

                <div class="project_info">
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
                                               value=""
                                               class="number numberVal" min="320"
                                               required>
                                        <label id="daily_wage-error" class="error"
                                               for="daily_wage"><?php _e( 'This field is required.', ET_DOMAIN ); ?></label>
                                        <p class="input-error"><?php _e( 'Invalid wage, minimum is CHF 320.-', ET_DOMAIN ); ?></p>
                                    </div>
                                    <div class="daily-wage-checkbox">
                                        <label class="container-checkbox">
                                            <input type="checkbox" name="daily_wage_agreed"
                                                   class="freelancer-wage-switch"
                                                   value="agreed">
                                            <span class="checkmark"></span>
                                        </label>
                                        <div class="daily-wage-agreed"><?php _e( 'To be agreed (minimum of CHF 320.-)', ET_DOMAIN ); ?></div>
                                    </div>
                                </div>
                            </div>

                            <div class="input-field fre-input-field">
                                <label class="fre-field-title"
                                       for="language"><?php _e( 'Select Your Language', ET_DOMAIN ); ?></label>
                                <select name="language[]" id="language" class="sfm-select2" multiple required>
                                    <option value=""><?php _e( 'Select All', ET_DOMAIN ) ?></option>
                                </select>
                                <label id="language-error" class="error"
                                       for="language"><?php _e( 'This field is required.', ET_DOMAIN ); ?></label>
                            </div>

                            <div class="input-field fre-input-field full">
                                <label class="fre-field-title"
                                       for="project_category"><?php _e( 'Interested Project Categories', ET_DOMAIN ); ?></label>
                                <select name="project_category[]" id="project_category" class="sfm-select2" multiple
                                        required>
                                    <option value=""><?php _e( 'Select All', ET_DOMAIN ) ?></option>
                                </select>
                                <label id="project_category-error" class="error"
                                       for="project_category"><?php _e( 'This field is required.', ET_DOMAIN ); ?></label>
                            </div>

                            <div class="input-field fre-input-field full">
                                <label for="project_skills"><?php _e( 'Interested Project Skills', ET_DOMAIN ) ?></label>
                                <select name="project_skills[]" id="project_skills" class="sfm-select2" multiple
                                        required>
                                    <option value=""><?php _e( 'Select All', ET_DOMAIN ) ?></option>
                                </select>
                                <label id="project_skills-error" class="error"
                                       for="project_skills"><?php _e( 'This field is required.', ET_DOMAIN ); ?></label>
                            </div>
                        </div>
                        <h3 class="profile-title"><?php _e( 'Personal Details', ET_DOMAIN ) ?></h3>
                        <div class="personal-details">
                            <div class="three-column-row">
                                <div class="input-field">
                                    <label for="first_name"><?php _e( 'First Name', ET_DOMAIN ) ?></label>
                                    <input id="first_name" type="text" name="first_name" placeholder="First Name"
                                           required>
                                    <label id="first_name-error" class="error"
                                           for="first_name"><?php _e( 'This field is required.', ET_DOMAIN ); ?></label>
                                </div>
                                <div class="input-field">
                                    <label for="last_name"><?php _e( 'Last Name', ET_DOMAIN ) ?></label>
                                    <input id="last_name" type="text" name="last_name" placeholder="Last Name" required>
                                    <label id="last_name-error" class="error"
                                           for="last_name"><?php _e( 'This field is required.', ET_DOMAIN ); ?></label>
                                </div>
                                <div class="input-field">
                                    <label for="display_name"><?php _e( 'Display Name', ET_DOMAIN ) ?></label>
                                    <input id="display_name" type="text" name="display_name" placeholder="Public Name"
                                           required>
                                    <label id="display_name-error" class="error"
                                           for="display_name"><?php _e( 'This field is required.', ET_DOMAIN ); ?></label>
                                </div>
                                <div class="input-field">
                                    <label for="nationality_visible"><?php _e( 'Nationality', ET_DOMAIN ) ?></label>
                                    <input id="nationality_visible" type="text" name="nationality_visible"
                                           placeholder="Nationality" value="" readonly>
                                </div>
                                <div class="input-field">
                                    <label for="phone_number"><?php _e( 'Phone Number', ET_DOMAIN ) ?></label>
                                    <input id="phone_number" type="text" name="phone_number"
                                           placeholder="Your Phone Number" required>
                                    <label id="phone_number-error" class="error"
                                           for="phone_number"><?php _e( 'This field is required.', ET_DOMAIN ); ?></label>
                                </div>
                                <div class="input-field">
                                    <label for="job_title"><?php _e( 'Job Title', ET_DOMAIN ) ?></label>
                                    <input id="job_title" type="text" name="job_title" placeholder="Job Title" required>
                                    <label id="job_title-error" class="error"
                                           for="job_title"><?php _e( 'This field is required.', ET_DOMAIN ); ?></label>
                                </div>
                            </div>
                            <div class="input-field details">
                                <label for="describe_more"><?php _e( 'Describe more details about you', ET_DOMAIN ) ?></label>
                                <textarea id="describe_more" name="describe_more" rows="20" cols="20"></textarea>
                            </div>
                        </div>
                        <h3 class="profile-title"><?php _e( 'Social Profiles', ET_DOMAIN ) ?></h3>
                        <div class="social-details">
                            <div class="input-field">
                                <label for="facebook"><?php _e( 'Facebook', ET_DOMAIN ) ?></label>
                                <input id="facebook" type="text" name="facebook"
                                       placeholder="https://facebook.com/yourusername">
                            </div>
                            <div class="input-field">
                                <label for="twitter"><?php _e( 'Twitter', ET_DOMAIN ) ?></label>
                                <input id="twitter" type="text" name="twitter"
                                       placeholder="https://twitter.com/yourusername">
                            </div>
                            <div class="input-field">
                                <label for="linkedin"><?php _e( 'LinkedIn', ET_DOMAIN ) ?></label>
                                <input id="linkedin" type="text" name="linkedin"
                                       placeholder="https://linkedin.com/yourusername">
                            </div>
                            <div class="input-field">
                                <label for="skype"><?php _e( 'Skype', ET_DOMAIN ) ?></label>
                                <input id="skype" type="text" name="skype" placeholder="your_skype_name">
                            </div>
                        </div>
                        <h3 class="profile-title"><?php _e( 'Your Location', ET_DOMAIN ) ?></h3>
                        <div class="location-details">
                            <div class="input-field">
                                <label for="country_you_live"><?php _e( 'Country You Live', ET_DOMAIN ) ?></label>
                                <select name="country_you_live" id="country_you_live" class="sfm-select2" required>
                                    <option value=""><?php _e( 'Select Country', ET_DOMAIN ) ?></option>
                                </select>
                                <label id="country_you_live-error" class="error"
                                       for="country_you_live"><?php _e( 'This field is required.', ET_DOMAIN ); ?></label>
                            </div>
                            <div class="input-field">
                                <label for="city_name"><?php _e( 'City Name', ET_DOMAIN ) ?></label>
                                <input id="city_name" type="text" name="city_name" placeholder="City name" required>
                                <label id="city_name-error" class="error"
                                       for="city_name"><?php _e( 'This field is required.', ET_DOMAIN ); ?></label>
                            </div>
                        </div>
                        <h3 class="profile-title"><?php _e( 'Profile Picture', ET_DOMAIN ) ?></h3>
                        <div class="picture-change">
                            <div class="profile-image">
                            </div>
                            <div class="upload-file">
                                <label for="input-file-now"><?php _e( 'Change your profile picture', ET_DOMAIN ) ?></label>
                                <div class="file-upload-wrapper">
                                    <input type="file" name="profile_image" id="input-file-now"
                                           class="file-upload"/>
                                    <label class="custom-file-label"
                                           for="input-file-now"><?php _e( 'Upload Picture', ET_DOMAIN ) ?></label>
                                </div>
                                <p><?php _e( "Accepted image format: 'png', 'jpg', 'jpeg', 'gif'", ET_DOMAIN ) ?></p>
                            </div>
                        </div>

                        <button class="btn-all ie_btn submit" id="update-freelancer-profile" type="submit"
                                name="submit"><?php _e( 'Save all information', ET_DOMAIN ) ?></button>
                    </form>
                </div><!-- End .project_info -->
            </div>
        </section><!-- End #dashboard_content -->

    </div>
</div>