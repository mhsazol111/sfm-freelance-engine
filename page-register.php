<?php

/**
 * Template Name: Register Page Template
 */

global $post;
get_header();

$role   = isset($_REQUEST['role']) ? $_REQUEST['role'] : '';


$freelancer_banner       = get_field( 'freelancer_banner_image' );

$ie_signup_title       = get_field( 'sign_up_title' );
$ie_signup_sub_title   = get_field( 'sign_up_sub_title' );

$ie_employer_title       = get_field( 'employer_title' );
$ie_employer_sub_title   = get_field( 'employer_sub_title' );
$employer_singup_img     = get_field( 'employer_signup_image' );

$ie_freelancer_title     = get_field( 'freelancer_title' );
$ie_freelancer_sub_title = get_field( 'freelancer_sub_title' );
$freelancer_singup_img   = get_field( 'freelancer_signup_image' );

$current_lang = get_locale();

?>


<div class="<?php print( is_page_template( 'page-register.php' ) && $role != 'freelancer' ) ? "reg-wrapper" : " "; ?> fre-page-wrapper">

    <section class="ie-banner registration_banner"
             style="background-image:url(<?php echo esc_url( $freelancer_banner['url'] ); ?>);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="registration-banner-content">
                        <!-- if user role is freelancer -->
                        <?php if ( $role == 'freelancer' ): ?>
                            <?php if ( !empty( $ie_freelancer_title ) ) : ?>
                                <h1 class="ie-banner-title"><?php _e( $ie_freelancer_title, ET_DOMAIN ); ?></h1>
                            <?php else : ?>
                                <h1 class="ie-banner-title"><?php _e( 'Sign up as a freelancer, it’s free!', ET_DOMAIN ); ?></h1>
                            <?php endif;?>

                            <?php if ( !empty( $ie_freelancer_sub_title ) ) : ?>
                                <p class="ie-banner-description"><?php _e( $ie_freelancer_sub_title, ET_DOMAIN ); ?></p>
                            <?php else : ?>
                                <p class="ie-banner-description"><?php _e( 'Contrary to popular belief, Lorem Ipsum is not simply random text.', ET_DOMAIN ); ?></p>
                            <?php endif; ?>

                        <!-- if user role is employer -->
                        <?php elseif ( $role == 'employer' ) : ?>
                            <?php if ( !empty( $ie_employer_title ) ) : ?>
                                <h1 class="ie-banner-title"><?php _e( $ie_employer_title, ET_DOMAIN ); ?></h1>
                            <?php else : ?>
                                <h1 class="ie-banner-title"><?php _e( 'Sign up as a freelancer, it’s free!', ET_DOMAIN ); ?></h1>
                            <?php endif; ?>

                            <?php if ( !empty( $ie_employer_sub_title ) ) : ?>
                                <p class="ie-banner-description"><?php _e( $ie_employer_sub_title, ET_DOMAIN ); ?></p>
                            <?php else : ?>
                                <p class="ie-banner-description"><?php _e( 'Contrary to popular belief, Lorem Ipsum is not simply random text.', ET_DOMAIN ); ?></p>
                            <?php endif; ?>
                            
                        <!-- if new to sign up -->
                        <?php else : ?>
                            <?php if ( !empty( $ie_signup_title ) ) : ?>
                                <h1 class="ie-banner-title"><?php _e( $ie_signup_title, ET_DOMAIN ); ?></h1>
                            <?php else : ?>
                                <h1 class="ie-banner-title"><?php _e( 'Welcome to sign up, it’s free!', ET_DOMAIN ); ?></h1>
                            <?php endif;?>

                            <?php if ( !empty( $ie_signup_sub_title ) ) : ?>
                                <p class="ie-banner-description"><?php _e( $ie_signup_sub_title, ET_DOMAIN ); ?></p>
                            <?php else : ?>
                                <p class="ie-banner-description"><?php _e( 'Contrary to popular belief, Lorem Ipsum is not simply random text.', ET_DOMAIN ); ?></p>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php if ( ! isset( $_REQUEST['role'] ) ) : ?>
    <div class="fre-page-section">
        <div class="container">
            <div class="fre-authen-wrapper">
                <div class="fre-register-default">
                    <h2><?php _e( 'Sign Up Free Account', ET_DOMAIN ) ?></h2>
                    <div class="fre-register-wrap">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="register-employer">
                                    <h3><?php _e( 'Company', ET_DOMAIN ); ?></h3>
                                    <p><?php _e( 'Post project, find freelancers and hire favorite to work.', ET_DOMAIN ); ?></p>
                                    <a class="fre-small-btn primary-bg-color"
                                       href="<?php echo et_get_page_link( 'register', array( 'role' => EMPLOYER ) ); ?>"><?php _e( 'Sign Up', ET_DOMAIN ); ?></a>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="register-freelancer">
                                    <h3><?php _e( 'Freelancer', ET_DOMAIN ); ?></h3>
                                    <p><?php _e( 'Create professional profile and find freelance jobs to work.', ET_DOMAIN ); ?></p>
                                    <a class="fre-small-btn primary-bg-color"
                                       href="<?php echo et_get_page_link( 'register', array( 'role' => FREELANCER ) ); ?>"><?php _e( 'Sign Up', ET_DOMAIN ); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="fre-authen-footer">
						<?php
						if ( fre_check_register() && function_exists( 'ae_render_social_button' ) ) {
							$before_string = __( "You can use social account to login", ET_DOMAIN );
							ae_render_social_button( array(), array(), $before_string );
						}
						?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else : ?>

	<?php
	$role   = $_REQUEST['role'];
	$re_url = '';
	if ( isset( $_GET['ae_redirect_url'] ) ) {
		$re_url = $_GET['ae_redirect_url'];
    }
	?>

    <div class="fre-page-section">
        <div class="container">
            <div class="row registration_row">
				<?php if ( $role == 'freelancer' ): ?>
                    <div class="col-md-6 col-sm-12 col-xs-12 left_area background_position"
                         style="background-image:url(<?php echo $freelancer_singup_img['url']; ?>);">
                    </div>
				<?php else: ?>
                    <div class="col-md-6 col-sm-12 col-xs-12 left_area background_position"
                         style="background-image:url(<?php echo $employer_singup_img['url']; ?>);">
                    </div>
				<?php endif; ?>
                <div class="col-md-6 col-sm-12 col-xs-12 right_area">
                    <div class="">
						<?php if ( $role == 'employer' ) { ?>
                            <h2><?php _e( 'Sign Up Company Account', ET_DOMAIN ); ?></h2>
						<?php } else { ?>
                            <h2><?php _e( 'Sign Up Freelancer Account', ET_DOMAIN ); ?></h2>
						<?php } ?>
                        <form method="POST" id="sfm_sign_up_form" class="validation-enabled">
                            <input type="hidden" name="ae_redirect_url" value="<?php echo $re_url ?>"/>
                            <input type="hidden" name="role" id="role" value="<?php echo $role; ?>"/>
                            <?php if ( $role == 'employer' ) { ?>
                                <div class="fre-input-field">
                                    <input type="text" name="company_name" id="company_name"
                                        placeholder="<?php _e('Company Name', ET_DOMAIN); ?>" required>
                                </div>
                            <?php } ?>
                            <div class="fre-input-field">
                                <input type="text" name="first_name" id="first_name"
                                       placeholder="<?php _e( 'First Name', ET_DOMAIN ); ?>" required>
                            </div>
                            <div class="fre-input-field">
                                <input type="text" name="last_name" id="last_name"
                                       placeholder="<?php _e( 'Last Name', ET_DOMAIN ); ?>" required>
                            </div>
                            <div class="fre-input-field">
                                <input type="text" name="user_email" id="user_email"
                                       placeholder="<?php _e( 'Email', ET_DOMAIN ); ?>" required>
                            </div>
                            <div class="fre-input-field">
                                <input type="text" name="user_login" id="user_login"
                                       placeholder="<?php _e( 'Username', ET_DOMAIN ); ?>" required>
                            </div>
                            <div class="fre-input-field">
                                <input type="password" name="user_pass" id="user_pass"
                                       placeholder="<?php _e( 'Password', ET_DOMAIN ); ?>" required>
                            </div>
                            <div class="fre-input-field">
                                <input type="password" name="repeat_pass" id="repeat_pass"
                                       placeholder="<?php _e( 'Confirm Your Password', ET_DOMAIN ); ?>" required>
                            </div>
                            <div class="fre-input-field">
                                <div class="select-box">
                                    <select name="user_country" id="user_country" class="sfm-select2" required>
                                        <?php if ($role == 'freelancer') : ?>
                                            <option value=""><?php _e( 'Nationality', ET_DOMAIN ); ?></option>
                                        <?php else : ?>
                                            <option value=""><?php _e( 'Country', ET_DOMAIN ); ?></option>
                                        <?php endif; ?>
                                        <?php
                                         $countries           = get_terms( array(
                                             'taxonomy'   => 'country',
                                             'hide_empty' => false,
                                         ) );
                                         $selected_country_id = get_the_terms( $user_profile_post_id, 'country' );
                                         foreach ( $countries as $country ) {
                                            $la_opt_country = get_field( $current_lang . '_label', $country );

                                            if ( get_locale() == 'en_US' ) :
                                                echo '<option value="' . $country->term_id . '">' . $country->name . '</option>';
                                            else:
                                                echo '<option class="la-option" value="' . $country->term_id . '">' . __( $la_opt_country, ET_DOMAIN ) . '</option>';
                                            endif;
                                         }
                                        ?>
                                    </select>
                                </div>
                            </div>
							<?php ae_gg_recaptcha( $container = 'fre-input-field' ); ?>
							<?php
							$tos      = et_get_page_link( 'tos', array(), false );
							$checkbox = '<input type="checkbox" class="custom-control-input" id="customCheck" name="example1"> <span class="checkmark"></span> ';
							$url_tos  = '<a href="' . et_get_page_link( 'tos' ) . '" class="secondary-color" rel="noopener noreferrer" target="_Blank">' . __( 'Term of Use and Privacy policy', ET_DOMAIN ) . '</a>';
							if ( $tos ) {
								echo '<p> <label class="custom-control-label" for="customCheck">';
								printf( __( '%s I agree to the %s', ET_DOMAIN ), $checkbox, $url_tos );
								echo "</label></p>";
							}
							?>
                            <div class="fre-input-field">
                                <button class="fre-btn btn-submit primary-bg-color submit" type="submit" name="submit"><?php _e( 'Sign Up', ET_DOMAIN ); ?></button>
                            </div>
                        </form>

                        <div class="fre-authen-footer">
                            <hr class="bt_hr">
                            <p class="log_here"><?php _e( 'Already have an account?', ET_DOMAIN ); ?> <a
                                        href="<?php echo et_get_page_link( "login" ) ?>"
                                        class="secondary-color"><?php _e( 'Log In here', ET_DOMAIN ); ?></a></p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <?php get_template_part('template-parts/components/modal', 'signup'); ?>

<?php
    endif;
    get_footer();
?>