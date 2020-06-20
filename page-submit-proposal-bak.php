<?php
/**
 * Template Name: Submit Proposal
 */

// Redirects an user back to their edit profile to update the profile first
if ( ! get_user_meta( get_current_user_id(), 'user_profile_id', true ) ) {
	wp_redirect( home_url() . '/edit-profile' );
}

global $wpdb, $current_user, $user_ID;

//convert current user
$ae_users  = AE_Users::get_instance();
$user_data = $ae_users->convert( $current_user->data );
$user_role = ae_user_role( $current_user->ID );
//convert current profile
$post_object = $ae_post_factory->get( PROFILE );
$profile_id  = get_user_meta( $user_ID, 'user_profile_id', true );
$profile     = array();
if ( $profile_id ) {
	$profile_post = get_post( $profile_id );
	if ( $profile_post && ! is_wp_error( $profile_post ) ) {
		$profile = $post_object->convert( $profile_post );
	}
}

$display_name = $user_data->display_name;
$job_title    = isset( $profile->et_professional_title ) ? $profile->et_professional_title : '';

if ( isset( $_GET['id'] ) ) {
	$project_id = $_GET['id'];

	if ( isset( $_POST['submit'] ) ) {

		$the_title   = sanitize_text_field( $_POST['hidden_the_title'] );
		$bid_content = sanitize_text_field( $_POST['bid_content'] );
		$post_parent = sanitize_text_field( $_POST['post_parent'] );

		if ( isset( $_GET['bid'] ) ) {
			return false;
			// $my_cptpost_args = array(
			//     'post_title'    => $the_title,
			//     'post_content'  => $bid_content,
			//     'post_type'     => 'bid',
			//     'ID'            => $_GET['bid'],
			// );
			// $cpt_id = wp_update_post( $my_cptpost_args, $wp_error );
		} else {
			$my_cptpost_args = array(
				'post_title'   => $the_title,
				'post_content' => $bid_content,
				'post_status'  => 'publish',
				'post_type'    => 'bid',
				'post_parent'  => $post_parent,
			);
			$cpt_id          = wp_insert_post( $my_cptpost_args, $wp_error );
		}

		if ( $cpt_id ) {

			// Custom Meta fields
			$metas = array(
				'bid_budget' => sanitize_text_field( $_POST['bid_budget'] ),
				'bid_time'   => sanitize_text_field( $_POST['bid_time'] ),
				'type_time'  => sanitize_text_field( $_POST['type_time'] ),
				'project_id' => $project_id,
			);

			// update Custom Meta fields
			foreach ( $metas as $key => $value ) {
				if ( isset( $_GET['bid'] ) ) {
					return false;
					//update_metadata( 'post', $cpt_id, $key, $value );
				} else {
					add_metadata( 'post', $cpt_id, $key, $value );
				}
			}

			// Increase Number of Bids when freelancer submit a proposal
			$results             = $wpdb->get_row( "SELECT * FROM {$wpdb->prefix}postmeta WHERE post_id = $project_id AND meta_key = 'total_bids'", OBJECT );
			$increase_meta_value = $results->meta_value + 1;

			$table = $wpdb->prefix . 'postmeta';
			$wpdb->update( $table,
				array( 'meta_value' => $increase_meta_value ),
				array( 'meta_id' => $results->meta_id )
			);


			// Client get notification when place a bid
			$project_post = get_post( $project_id );
			$content      = 'type=new_bid&project=' . $project_id . '&bid=' . $cpt_id;

			// Insert notification
			$notification = array(
				'post_type'    => 'notify',
				'post_content' => $content,
				'post_excerpt' => $content,
				'post_author'  => $project_post->post_author,
				'post_title'   => sprintf( __( "New bid on %s", ET_DOMAIN ), get_the_title( $project_post->ID ) ),
				'post_status'  => 'publish',
				'post_parent'  => $project_post->ID
			);
			$notify_id    = wp_insert_post( $notification, $wp_error );
			update_post_meta( $cpt_id, 'notify_id', $notify_id );


			// File upload max 5
			$xox   = 0;
			$files = $_FILES["my_image_upload"];
			foreach ( $files['name'] as $key => $value ) {

				foreach ( $_POST['my_image_verify'] as $verify ) {

					if ( $value == $verify ) {
						if ( $files['name'][ $key ] ) {
							$file   = array(
								'name'     => $files['name'][ $key ],
								'type'     => $files['type'][ $key ],
								'tmp_name' => $files['tmp_name'][ $key ],
								'error'    => $files['error'][ $key ],
								'size'     => $files['size'][ $key ]
							);
							$_FILES = array( "my_file_upload" => $file );

							foreach ( $_FILES as $file => $array ) {
								$xox ++;

								$attachment_id = multiple_handle_attachment( $file, $cpt_id );

								if ( isset( $_GET['bid'] ) ) {
									return false;
									//update_metadata('post', $cpt_id, 'bid_attachment_file_'.$xox, $attachment_id);
								} else {
									add_metadata( 'post', $cpt_id, 'bid_attachment_file_' . $xox, $attachment_id );
								}

								// if file have any error then show error message then redirect home page
								if ( is_wp_error( $attachment_id ) ) {

									?>
                                    <script type="text/javascript">
                                        if (!alert('File upload error')) {
                                            window.location.href = window.location.href;
                                        }
                                    </script><?php

									return;
								}
							}
						}
					}
				}
			}

			// all is done then redirect
			// header("Location: ".home_url('/submit-proposal/?id='.$project_id.'&bid='.$cpt_id));
			header( "Location: " . home_url( '/my-projects/' ) );
		} else {
			header( "Location: " . home_url( '/submit-proposal/?id=' . $project_id ) );
		}

	}


	// Chenck Unauthorized people
	$inp_st = '';
	if ( isset( $_GET['bid'] ) ) {
		$inp_st = 'disabled';
	} else {
		$b_post = new WP_Query( array(
			'post_type'  => 'bid',
			'author'     => $current_user->ID,
			'meta_query' => array(
				array(
					'key'     => 'project_id',
					'compare' => '==',
					'value'   => $project_id,
					'type'    => 'text',
				),
			),
		) );

		if ( $b_post->have_posts() ) :
			if ( $b_post->post->post_author == $current_user->data->ID ) :
				header( "Location: " . home_url( '/submit-proposal/?id=' . $project_id . '&bid=' . $b_post->post->ID ) );
			endif;
		endif;
	}
} else {
	?>
    <script type="text/javascript">
        if (!alert('Unauthorized entry')) {
            window.location.href = '<?php echo home_url(); ?>';
        }
    </script>
	<?php
}


get_header();

$role_template = 'employer';
if ( fre_share_role() || ae_user_role( $user_ID ) == FREELANCER ) {
	$role_template = 'freelance';
}
?>

<div class="fre-page-wrapper submit-proposal-wrapper">
    <div class="profile_dashboard" id="<?php echo $role_template; ?>-dashboard">
		<?php include( locate_template( 'template-parts/sidebar-profile.php' ) ); // Dashboard Sidebar ?>
        <section id="dashboard_content">
            <div class="dashboard_inn" id="modal_bid">

                <div class="dashboard_title">
                    <h2><?php _e( 'Submit your proposal', ET_DOMAIN ); ?></h2>
                    <hr>
                </div>

                <div class="fre-page-section">
                    <div class="page-submit-proposal-wrap">
						<?php
						$id = isset( $_REQUEST['id'] ) ? $_REQUEST['id'] : 0;
						if ( $id ) {
							$post = get_post( $id );
							if ( $post ) {
								global $ae_post_factory;
								$post_object  = $ae_post_factory->get( $post->post_type );
								$post_convert = $post_object->convert( $post );
								// echo "<pre>";
								// print_r( $post_convert );
								// echo "</pre>";
								echo '<script type="data/json"  id="edit_postdata">' . json_encode( $post_convert ) . '</script>';
							}
							//get skills
							$current_skills = get_the_terms( $_REQUEST['id'], 'skill' );
						}
						?>
                        <div class="proposal-short-description">
                            <h3><?php echo $post_convert->post_title; ?></h3>
                            <div class="e_nav">
                                <p>Posted on:
                                    <span><?php echo date( 'F j, Y', strtotime( $post_convert->post_date ) ); ?></p> |
                                <p>Categories:
									<?php
									$categories = Employer::get_project_terms( $post_convert->id, 'project_category', true, 'span', true );
									echo $categories;
									?>
                                </p>
                            </div>
                            <div class="content">
								<?php
								$str = strip_tags( $post_convert->post_content );
								if ( strlen( $str ) > 400 ) {
									$str = substr( $str, 0, 400 ) . '...<span class="proposal-show-more">more</span>';
								}
								echo $str;
								?>
                            </div>
                            <div class="read-more">
                                <a href="<?php echo $post_convert->permalink; ?>" target="_blank">View full project</a>
                            </div>
                        </div>
                        <div class="proposal-meta-description">
                            <div class="proposal-skill">
                                <h5>Required Skills</h5>
                                <div class="skills">
									<?php
									$skills = Employer::get_project_terms( $post_convert->id, 'skill', 'true' );
									echo $skills;
									?>
                                </div>
                            </div>
                            <div class="locations">
                                <h5>Preferred Location</h5>
                                <p><?php echo $post_convert->text_country; ?></p>
                            </div>
                        </div>

						<?php
						// if(isset($_GET['id'])):
						//     $project_id = $_GET['id'];

						//     $s_i_posts = new WP_Query(array(
						//         'posts_per_page'    => 1,
						//         'post_type'         => 'project',
						//         'p'                 => $project_id,
						//     ));

						//     if($s_i_posts->have_posts()):
						//         while ( $s_i_posts->have_posts() ):
						//             $s_i_posts->the_post();
						//             global $wp_query, $ae_post_factory, $post, $user_ID;
						//             $post_object = $ae_post_factory->get( PROJECT );
						//             $convert = $project = $post_object->convert( $post );
						?>
                        <!-- <div class="project_info">
                                    <div class="proposal-info-area">
                                        <h2 class="proposal-heading"><?php //echo get_the_title();?></h2>
                                        <h2><?php //echo get_post_meta(get_the_ID(), 'title', true); ?></h2>
                                        <div class="proposal-meta">
                                            <span>Posted on: <a href="#"> <?php //echo $project->post_date; ?></a> &nbsp; | &nbsp; </span>
                                            <span><?php //if ( !empty( $convert->project_category ) ) {
						//list_tax_of_project( get_the_ID(), __( 'Categories: ', ET_DOMAIN ), 'project_category' );
						//} ?></span>
                                        </div>
                                        <div class="proposal-details"><?php //the_content();?> <span><a href="#">more</a></span>
                                            <a href="<?php //echo get_the_permalink(); ?>" class="view_more">View full project</a>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="proposal-skill">
                                        <div class="skill-col">
                                            <h2>Required Skills</h2>
                                            <div class="skils-list">
                                                <?php //if ( !empty( $convert->skill ) ) {
						//list_tax_of_project( get_the_ID(), __( '', ET_DOMAIN ), 'skill' );
						//} ?>
                                            </div>
                                        </div>
                                        <div class="location-col">
                                            <h2>Preferred Location</h2>
                                            <p class="location">
                                            <?php //if ( ! empty( $convert->tax_input['country'] ) ) {
						//foreach ($convert->tax_input['country'] as $key => $value) {
						//echo '<span>' . $value->name . '<com>, </com></span>';
						// }
						//} ?>
                                            </p>
                                        </div>
                                        <hr>
                                    </div> -->


						<?php

						$bid_budget     = "";
						$bid_time       = "";
						$bid_time       = "";
						$bid_content    = "";
						$img_title      = array();
						$img_url        = array();
						$att_id         = array();
						$img_meta_field = array();

						if ( isset( $_GET['bid'] ) ) {

							$bid       = $_GET['bid'];
							$b_i_posts = new WP_Query( array(
								'posts_per_page' => 1,
								'post_type'      => 'bid',
								'p'              => $bid,
							) );

							if ( $b_i_posts->have_posts() ) {
								while ( $b_i_posts->have_posts() ) {
									$b_i_posts->the_post();

									$bid_budget  = get_post_meta( get_the_ID(), 'bid_budget', true );
									$bid_time    = get_post_meta( get_the_ID(), 'bid_time', true );
									$type_time   = get_post_meta( get_the_ID(), 'type_time', true );
									$bid_content = get_the_content();

									for ( $i = 1; $i <= 5; $i ++ ) {
										$attached_id = get_post_meta( get_the_ID(), 'bid_attachment_file_' . $i, true );

										$att_id[]         = $attached_id;
										$img_title[]      = get_the_title( $attached_id );
										$img_url[]        = wp_get_attachment_url( $attached_id );
										$img_meta_field[] = 'bid_attachment_file_' . $i;
									}

								}
							} else {
								?>
                                <script type="text/javascript">
                                    if (!alert('Unauthorized entry')) {
                                        window.location.href = '<?php echo home_url(); ?>';
                                    }
                                </script>
								<?php
							}

						}
						?>

                        <form method="POST" class="proposal-form" enctype="multipart/form-data" action="">
                            <h3 class="profile-title">Project Terms</h3>
                            <div class="project-terms">
                                <div class="input-field">
                                    <label for="bid_budget">Daily wage for this project</label>
                                    <input type="number" name="bid_budget" id="bid_budget"
                                           class="form-control number numberVal" min="0"
                                           placeholder="Amount of daily wage"
                                           value="<?php echo $bid_budget; ?>" <?php echo $inp_st; ?> />
                                </div>
                                <div class="input-field">
                                    <label for="bid_time">Number of days you’ll work</label>
                                    <input type="number" name="bid_time" id="bid_time"
                                           class="form-control number numberVal" min="1"
                                           value="<?php echo $bid_time; ?>" <?php echo $inp_st; ?> />
                                </div>
                                <div class="input-field">
                                    <label for="type_time">How long will this project take?</label>
                                    <div class="select-box">
                                        <div class="select_icon"
                                             style="background-image: url('http://sfm.idevs.site/wp-content/themes/freelanceengine-child/inc/images/select-icon.svg');">
                                        </div>
                                        <select id="type_time" name="type_time" <?php echo $inp_st; ?>>
                                            <option <?php if ( get_post_meta( get_the_ID(), 'type_time', true ) == 'day' ) {
												echo "selected";
											} ?> value="day"><?php _e( 'Days', ET_DOMAIN ); ?></option>
                                            <option <?php if ( get_post_meta( get_the_ID(), 'type_time', true ) == 'week' ) {
												echo "selected";
											} ?> value="week"><?php _e( 'Week', ET_DOMAIN ); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="input-field full">
                                    <label for="bid_content">Message to client</label>
                                    <textarea id="bid_content" name="bid_content" rows="20" cols="20"
                                              placeholder="Add detail message for client" <?php echo $inp_st; ?>><?php echo $bid_content; ?></textarea>
                                </div>
                            </div>

                            <div class="file-upload-optional">
								<?php if ( $inp_st == "" ): ?>
                                    <div class="upload-file">
                                        <label for="input-file-now">Add attachment (Optional)</label>
                                        <div class="file-upload-wrapper">
                                            <input type="file" id="input-file-now" class="file-upload"
                                                   name="my_image_upload[]" multiple/>
                                            <label class="custom-file-label" for="input-file-now">Upload Picture</label>
                                        </div>
                                    </div>
								<?php endif; ?>

                                <div id="append_img"></div>

								<?php
								for ( $i = 0; $i < count( $img_url ); $i ++ ) {
									if ( ! empty( $img_url[ $i ] ) ):
										?>
                                        <div class="file_attached">
                                            <a href="<?php echo $img_url[ $i ]; ?>" download=""><i
                                                        class="fas fa-paperclip"
                                                        aria-hidden="true"></i><span><?php echo $img_title[ $i ]; ?></span><i
                                                        class="fas fa-download" aria-hidden="true"></i></a>
                                        </div>
									<?php
									endif;
								}
								?>
                                <div class="apn"></div>
                            </div>

                            <input type="hidden" name="hidden_the_title" value="<?php echo get_the_title(); ?>"/>
                            <input type="hidden" name="post_parent" value="<?php echo $project_id; ?>"/>
							<?php if ( $inp_st == "" ): ?>
                                <p class="upload-massage">Upload maximum 5 files with extensions including png, jpg,
                                    pdf, xls and doc format</p>
                                <button class="btn-all ie_btn" type="submit" name="submit">Submit Proposal</button>
							<?php endif; ?>
                        </form>

                    </div><!-- End .project_info -->


					<?php //endwhile; ?>

					<?php //endif; ?>

					<?php //endif; ?>

                </div>
            </div>

    </div>
    </section>

</div>
</div>


<?php get_footer(); ?>

<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('#input-file-now').change(function (e) {
            for (var i = 0; i < e.target.files.length; i++) {
                jQuery('#append_img').append('<div class="file_attached up_content"><a href="#"><i class="fas fa-paperclip" aria-hidden="true"></i><span>' + e.target.files[i].name + '</span> <i class="fas fa-times"></i></a><input value="' + e.target.files[i].name + '" name="my_image_verify[]" type="text" class="file-upload dis_none" /></div>');
            }
        });
        jQuery('body').on('click', '.file_attached a i.fa-times', function () {
            jQuery(this).parent().parent().remove();
        });
    });
</script>