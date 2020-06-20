<?php
/**
 * The Header for our theme
 * Displays all of the <head> section and everything up till <div id="main">
 * @package WordPress
 * @subpackage FreelanceEngine
 * @since FreelanceEngine 1.0
 */
global $current_user;
?>
    <!DOCTYPE html>
    <!--[if IE 7]>
<html class="ie ie7"                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php language_attributes(); ?>>
<![endif]-->
    <!--[if IE 8]>
<html class="ie ie8"                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php language_attributes(); ?>>
<![endif]-->
    <!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
    <!--<![endif]-->
    <head>
		<?php global $user_ID; ?>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1 ,user-scalable=no">
        <title><?php wp_title( '|', true, 'right' ); ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php ae_favicon(); ?>
		<?php
		wp_head();
		if ( function_exists( 'et_render_less_style' ) ) {
			//et_render_less_style();
		}
		?>
    </head>

<body <?php body_class(); ?>>

<?php
if ( is_page_template( 'page-register.php' ) ) {
	$role = isset($_REQUEST['role']) ? $_REQUEST['role'] : '';
}

$role_template = 'employer';
if ( fre_share_role() || ae_user_role( $user_ID ) == FREELANCER ) {
	$role_template = 'freelance';
}


$header_type = 'header-light';
if ( is_page_template( 'template-home.php' ) || is_page_template( 'template-blog.php' ) || is_page_template( 'template-contact.php' ) || is_page_template( 'page-register.php' ) || is_page_template( 'page-login.php' ) || is_page_template( 'template-faq.php' ) || is_page_template( 'page-account-not-verified.php' ) || is_singular( 'post' ) || is_404() ) {
	$header_type = 'header-transparent';
}
?>

    <header id="<?php echo $role_template; ?>-header-wrap"
            class="fre-header-wrapper smf-header-wrapper <?php echo $header_type ?>">

        <div class="fre-header-wrap" id="main_header">
            <div class="container header-full-width">
                <div class="fre-site-logo">

					<?php if ( 'header-transparent' != $header_type ) : ?>
                        <a class="dark-logo" href="<?php echo home_url(); ?>">
                            <img alt="SFM" src="<?php echo get_theme_mod( 'dark_logo_das' ); ?>">
                        </a>
					<?php else: ?>
                        <a class="default-logo" href="<?php echo home_url(); ?>">
							<?php fre_logo( 'site_logo' ) ?>
                        </a>
					<?php endif; ?>

                    <div class="fre-hamburger">
						<?php if ( is_user_logged_in() ) { ?>
                            <a class="fre-notification notification-tablet smf-notification" href="">
                                <i class="fa fa-bell-o" aria-hidden="true"></i>
								<?php
								if ( function_exists( 'fre_user_have_notify' ) ) {
									$notify_number = fre_user_have_notify();
									if ( $notify_number ) {
										echo '<span class="dot-noti"></span>';
									}
								}
								?>
                            </a>
						<?php } ?>
                        <span class="hamburger-menu">
                        <div class="hamburger hamburger--elastic" tabindex="0" aria-label="Menu" role="button"
                             aria-controls="navigation">
                            <div class="hamburger-box">
                                <div class="hamburger-inner"></div>
                            </div>
                        </div>
                    </span>
                    </div>
                    <div class="fre-search-wrap mobile_phone">
                        <a href="tel:<?php echo get_theme_mod( 'contact_phone' ); ?>"
                           class="smf-phone"><?php _e( "Tel: " . get_theme_mod( 'contact_phone' ) ); ?></a>
                    </div>
                </div>
				<?php if ( is_user_logged_in() ) { ?>
                    <div class="fre-account-tablet">
                        <div class="fre-account-info smf-account-info">
							<?php echo get_avatar( $user_ID ); ?>
                            <span><?php echo $current_user->display_name; ?></span>
                        </div>
                    </div>
				<?php } ?>
                <div class="fre-search-wrap desktop_phone">
                    <a href="tel:<?php echo get_theme_mod( 'contact_phone' ); ?>"
                       class="smf-phone"><?php _e( "Tel: " . get_theme_mod( 'contact_phone' ) ); ?></a>
                </div>
				<?php if ( ! is_user_logged_in() ) { ?>
                    <div class="fre-account-wrap  smf-acc">
                        <div class="fre-login-wrap">
                            <ul class="fre-login">
                                <li>
                                    <a class="log_user_btn" href="<?php echo et_get_page_link( "login" ) ?>"><img
                                                alt="user"
                                                src="<?php echo get_stylesheet_directory_uri() . '/inc/images/user.svg' ?>"><span><?php _e( 'Login', ET_DOMAIN ); ?></span></a>
                                </li>
								<?php if ( fre_check_register() ) { ?>
                                    <li class="<?php print( is_page_template( 'page-register.php' ) && $role != 'freelancer' ) ? "reg-signup" : " "; ?>">
                                        <a href="<?php echo et_get_page_link( "register" ) ?>"><?php _e( 'Sign Up', ET_DOMAIN ); ?></a>
                                    </li>
								<?php } ?>
                            </ul>
                        </div>
                    </div>

				<?php } else { ?>

                    <div class="fre-account-wrap  smf-acc dropdown">
                        <a class="fre-notification smf-notification sfm-header-notifi dropdown-toggle"
                           data-toggle="dropdown" href="">
                            <i class="fa fa-bell-o" aria-hidden="true"></i>
							<?php
							if ( function_exists( 'fre_user_have_notify' ) ) {
								$notify_number = fre_user_have_notify();
								if ( $notify_number ) {
									echo '<span class="dot-noti"></span>';
								}
							}
							?>
                        </a>

						<?php fre_user_notification( $user_ID, 1, 5 ); ?>

                        <div class="fre-account sfm-header-profile dropdown">

                            <div class="fre-account-info dropdown-toggle smf-account-info" data-toggle="dropdown">
								<?php
								if ( get_avatar( $user_ID ) ):
									echo get_avatar( $user_ID );
								else:
									?>
                                    <img class="def_user_pic" alt="user"
                                         src="<?php echo get_stylesheet_directory_uri() . '/inc/images/user.svg' ?>">
								<?php
								endif;
								?>

                                <span><?php echo $current_user->display_name; ?></span>
                                <i class="fa fa-caret-down" aria-hidden="true"></i>
                            </div>

                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo et_get_page_link( "profile" ) ?>"><?php _e( 'Dashboard', ET_DOMAIN ); ?></a>
                                </li>
								<?php do_action( 'fre_header_before_notify' ); ?>
                                <li><a href="<?php echo wp_logout_url(); ?>"><?php _e( 'Logout', ET_DOMAIN ); ?></a>
                                </li>
                            </ul>

                        </div>

                    </div>

				<?php } ?>

                <div class="fre-menu-top smf-top">
                    <!-- Main Menu -->
					<?php if ( ! is_user_logged_in() ): ?>
						<?php if ( has_nav_menu( 'et_header_standard' ) ) {
							$args = array(
								'theme_location'  => 'et_header_standard',
								'menu'            => '',
								'container'       => '',
								'container_class' => '',
								'container_id'    => '',
								'menu_class'      => 'fre-menu-main',
								'menu_id'         => '',
								'echo'            => true,
								'before'          => '',
								'after'           => '',
								'link_before'     => '',
								'link_after'      => '',
							);
							wp_nav_menu( $args );
						} ?>
					<?php endif; ?>
					<?php if ( is_user_logged_in() && $role_template == 'freelance' ): ?>
						<?php if ( has_nav_menu( 'freelance_menu' ) ) {
							$args = array(
								'theme_location'  => 'freelance_menu',
								'menu'            => '',
								'container'       => '',
								'container_class' => '',
								'container_id'    => '',
								'menu_class'      => 'fre-menu-main',
								'menu_id'         => '',
								'echo'            => true,
								'before'          => '',
								'after'           => '',
								'link_before'     => '',
								'link_after'      => '',
							);
							wp_nav_menu( $args );
						} ?>
					<?php endif; ?>
					<?php if ( is_user_logged_in() && ( $role_template == 'employer' || current_user_can( 'administrator' ) ) ): ?>
						<?php if ( has_nav_menu( 'employer_menu' ) ) {
							$args = array(
								'theme_location'  => 'employer_menu',
								'menu'            => '',
								'container'       => '',
								'container_class' => '',
								'container_id'    => '',
								'menu_class'      => 'fre-menu-main',
								'menu_id'         => '',
								'echo'            => true,
								'before'          => '',
								'after'           => '',
								'link_before'     => '',
								'link_after'      => '',
							);
							wp_nav_menu( $args );
						} ?>
					<?php endif; ?>
                </div>

            </div>

        </div>

    </header>

    <!-- MENU DOOR / END -->


<?php

global $user_ID;

if ( $user_ID ) {

	echo '<script type="data/json"  id="user_id">' . json_encode( array(
			'id' => $user_ID,
			'ID' => $user_ID,
		) ) . '</script>';

}
