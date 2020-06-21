<?php
    /**
     * Template Name: Help and Support
     */
    if ( ! get_user_meta( get_current_user_id(), 'user_profile_id', true ) ) {
        wp_redirect( home_url() . '/edit-profile' );
    }

    get_header();

    $role_template = 'employer';
    if ( fre_share_role() || ae_user_role( $user_ID ) == FREELANCER ) {
        $role_template = 'freelance';
    }
    $user_profile = Employer::get_employer( get_current_user_id() );
    if ( USER_ROLE == 'freelancer' ) {
        $user_profile = Freelancer::get_freelancer( get_current_user_id() );
    }

    $user_info = get_userdata( get_current_user_id() );
    $h_d_name = $user_profile->display_name;
    $h_phone = $user_profile->phone_number;
    $user_email = $user_info->user_email;
    // $h_email = get_the_author_meta( 'user_email' );
    //$h_email = get_the_author_meta( 'user_email', $author_id );

    //print_r($user_info);
    

?>

<div class="fre-page-wrapper help-support-wrapper">
    <div class="profile_dashboard" id="<?php echo $role_template; ?>-dashboard">
        <?php include( locate_template( 'template-parts/sidebar-profile.php' ) ); // Dashboard Sidebar ?>
        <section id="dashboard_content">
            <div class="dashboard_inn">
                <div class="dashboard_title">
                    <h2><?php _e( 'Help and Support', ET_DOMAIN ); ?></h2>
                    <hr>
                </div>
                <div class="help-support-content">

                    <div class="help-support-form">
                        <?php echo do_shortcode( '[contact-form-7 id="544" title="Help & Support" your-name="'. $h_d_name .'" your-email="'. $user_email .'" tel-866="'. $h_phone .'"]' ); ?>
                    </div>

                </div>
            </div>
        </section>
    </div>
</div>

<?php

get_footer();