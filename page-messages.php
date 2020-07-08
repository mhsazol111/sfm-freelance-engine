<?php
/**
 * Template Name: Messages
 */


add_filter( 'body_class', 'la_body_class_for_pm_page', 10, 2 );
function la_body_class_for_pm_page( $classes, $class ) {
	$classes[] = 'dashboard';
	$classes[] = 'private-messages';

	return $classes;
}

global $wp_query, $ae_post_factory, $post, $current_user, $user_ID;
$user_role = ae_user_role( $current_user->ID );
$a_id      = isset( $_GET['a_id'] ) ? sanitize_text_field( $_GET['a_id'] ) : '';
$p_id      = isset( $_GET['p_id'] ) ? sanitize_text_field( $_GET['p_id'] ) : '';

if ( FREELANCER == ae_user_role() && ! empty( $a_id ) ) {
	if ( $user_ID != $a_id ) {
		wp_redirect( get_site_url() . '/dashboard' );
	}
}

if ( EMPLOYER == ae_user_role() && ! empty( $p_id ) ) {
	$p_author = get_post_field( 'post_author', $p_id );
	if ( $user_ID != $p_author ) {
		wp_redirect( get_site_url() . '/dashboard' );
	}
}

if ( ! is_user_logged_in() ) {
	$current_url = $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
	wp_redirect( get_home_url() . '/login' . '?redirect_to=' . $current_url );
}

if ( $user_role == 'freelancer' ) {
	add_filter( 'wp_title', 'my_tpl_wp_title', 100 );
}

function my_tpl_wp_title( $title ) {
	$title = 'Messages';

	return $title;
}

$message_titles = get_user_messages();

// if( $author->ID == $message->sender_id ){
//  $sender = $author;
// } else {
//  $sender = get_userdata( $message->sender_id );
// }


get_header();
?>

    <div class="fre-page-wrapper messages-page-wrapper">
        <div class="profile_dashboard" id="<?php echo $role_template; ?>-dashboard">
			<?php get_template_part( 'template-parts/sidebar', 'profile' ); // Dashboard Sidebar ?>

            <section id="dashboard_content">
                <div class="dashboard_inn">

                    <div class="dashboard_title">
                        <h2><?php _e( 'Messages', ET_DOMAIN ); ?></h2>
                        <hr>
                    </div>

                    <div class="message_container">
						<?php
						$is_new_message = ! empty( $a_id ) && ! empty( $p_id );
						$check_url      = array_filter( $message_titles, function ( $mt ) use ( $a_id, $p_id ) {
							return ( $mt->ID == $p_id ) && ( $mt->author_id == $a_id );
						} );
						$has_active     = count( $check_url ) > 0;

						if ( count( $message_titles ) > 0 ) : ?>
                            <div class="message_title">

                                <div class="la_message_inn">
									<?php
									if ( ! $has_active && $is_new_message ) {
										$proj     = get_post( $p_id );
										$userdata = EMPLOYER == ae_user_role() ? get_userdata( $a_id ) : '';
										if ( EMPLOYER == ae_user_role() ) {
											$avater_user = $proj->post_author;
										} else {
											$avater_user = $a_id;
										}
										?>
                                        <div class="m_t_row active">
                                            <a href="javascript:void(0)" class="laSidebarMessage"
                                               data-project="<?= $proj->ID; ?>" data-author="<?= $a_id; ?>">
												<?php // echo get_avatar( $avater_user, 35 ); ?>
                                                <h3><?php if ( EMPLOYER == ae_user_role() ) { ?><?= get_the_author_meta( 'display_name', $avater_user ); ?><?php } ?></h3>
                                                <p><?= wp_strip_all_tags( $proj->post_title ); ?></p>
                                            </a>
                                        </div>
										<?php
									}
									$inc = 1;
									foreach ( $message_titles as $mt ) {
										$isRead          = true;
										$isActive        = false;
										$current_user_id = $current_user->ID;
										$userdata        = EMPLOYER == ae_user_role() ? get_userdata( $mt->author_id ) : '';
										if ( 'unread' == $mt->status ) {
											if ( $current_user_id == $mt->sender ) {
												$isRead = false;
											} else {
												$isRead = true;
											}
										}
										if ( $has_active ) {
											$isActive = false;
											if ( $mt->ID == $p_id && $mt->author_id == $a_id ) {
												$isActive = true;
											}
										} else {
											if ( $inc === 1 && ! $is_new_message ) {
												$isActive = true;
											}
										}
										if ( FREELANCER == ae_user_role() ) {
											$proj        = get_post( $mt->ID );
											$avater_user = $proj->post_author;
										} else {
											$avater_user = $mt->author_id;
										}
										?>

                                        <div class="m_t_row <?= $isActive ? 'active' : ''; ?>">
                                            <a href="javascript:void(0)"
                                               class="laSidebarMessage <?= $isActive ? 'active' : ''; ?> <?= 'unread' == $mt->status ? 'strong' : ''; ?> "
                                               data-project="<?= $mt->ID; ?>" data-author="<?= $mt->author_id; ?>">
												<?php //echo get_avatar( $avater_user, 35 ); ?>
                                                <h3><?= get_the_author_meta( 'display_name', $avater_user ); ?></h3>
                                                <p><?= wp_strip_all_tags( $mt->post_title ); ?></p>
                                            </a>
                                        </div><!-- End .m_t_row -->

										<?php
										$isActive = false;
										$inc ++;
									}
									?>

                                </div>
                            </div><!-- .message_title -->
						<?php
							$showLoader = true;
							get_template_part('template-parts/components/message', 'send-form');

                        else :
                            if( ( !empty( $a_id ) && !empty( $p_id ) ) || sfm_is_translating() ) {
	                            if( ! sfm_is_translating() ) {
		                            $proj = get_post( $p_id );
		                            $userdata = EMPLOYER == ae_user_role() ? get_userdata( $a_id ) : '';
		                            if ( EMPLOYER == ae_user_role() ) {
			                            $avater_user = $proj->post_author;
		                            } else {
			                            $avater_user = $a_id;
		                            }
                                    $emp_dis_name = get_the_author_meta( 'display_name', $avater_user );
		                            $pro_ID = $proj->ID;
		                            $pro_title = wp_strip_all_tags( $proj->post_title );
                                } else {
		                            $pro_ID = 00;
		                            $pro_title = '########';
                                }

	                            ?>
                                <div class="message_title">
                                    <div class="la_message_inn">
                                        <div class="m_t_row active">
                                            <a href="javascript:void(0)" class="laSidebarMessage"
                                               data-project="<?= $pro_ID; ?>" data-author="<?= $a_id; ?>">
                                                <h3><?php if ( EMPLOYER == ae_user_role() || sfm_is_translating() ) { ?><?= $emp_dis_name; ?><?php } ?></h3>
                                                <p><?= $pro_title; ?></p>
                                            </a>
                                        </div>
                                    </div>
                                </div><?php
                                $showLoader = false;
                                get_template_part('template-parts/components/message', 'send-form');
                            } else {
                            ?>
                            <div class="well no-message-found" style="width: 100%;margin-bottom: 0;">
                                <p class="alert alert-info text-center"
                                   style="margin-bottom: 0"><?php esc_html_e( 'No messages found!', ET_DOMAIN ); ?></p>
                            </div>
						<?php }
                            if( sfm_is_translating() ) { ?>
                                <div class="well no-message-found" style="width: 100%;margin-bottom: 0;">
                                    <p class="alert alert-info text-center"
                                       style="margin-bottom: 0"><?php esc_html_e( 'No messages found!', ET_DOMAIN ); ?></p>
                                </div>
                                <?php
                            }
                        endif; // if has message_titles ?>

                    </div> <!-- ./message-container -->
                </div>

            </section>
        </div>
    </div>
    <?php if (isset($p_id) && isset($a_id)) ?>
    <script>
        ;(function ($) {
            $(document).ready(function () {
                setTimeout(function() {
                    $(".m_t_row.active .laSidebarMessage").click();
                },10);
            });
        })(jQuery);
    </script>
<?php
get_footer();