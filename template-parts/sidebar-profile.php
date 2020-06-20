<?php
$user_profile = Employer::get_employer( get_current_user_id() );
if ( USER_ROLE == 'freelancer' ) {
	$user_profile = Freelancer::get_freelancer( get_current_user_id() );
}

?>
<section id="sidebar"> <!--Dashboard Sidebar Start-->
    <div class="user_info_background background_position"
         style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/inc/images/img005.jpg');">
    </div>

    <div class="user_info">
        <div class="picture background_position">
            <div class="user-image">
				<?php echo get_avatar( get_current_user_id(), 125 ); ?>
            </div>
        </div>
        <div class="info">
            <h4>
                <?php if( !empty( $user_profile->display_name ) ):
                    echo $user_profile->display_name;
                else: 
                    echo $user_profile->name;
                endif; ?>
            </h4>
            <p>
                <?php if ( USER_ROLE == 'freelancer' ) : ?>
                    <?php if( !empty( $user_profile->job_title ) ):
                        echo $user_profile->job_title;
                    endif; ?>
                <?php else : ?>
                    <?php if( !empty( $user_profile->company_name ) ):
                        echo $user_profile->company_name;
                    endif; ?>
                <?php endif; ?>
            </p>
			<?php if ( USER_ROLE == 'freelancer' ) : ?>
                <a class="ie_btn" href="<?php echo home_url( 'projects' ) ?>">Browse Projects</a>
			<?php else : ?>
                <a class="ie_btn" href="<?php echo home_url( 'post-project' ) ?>">Post a Project</a>
			<?php endif; ?>
        </div>
    </div>
    <hr>

	<?php include( locate_template( 'template-parts/nav-profile.php' ) ); ?>

</section> <!--Dashboard Sidebar End -->
<div class="hamburger-menu-dashbord">
    <div class="hamburger hamburger--elastic" tabindex="0" aria-label="Menu" role="button"
         aria-controls="navigation">
        <div class="hamburger-box">
            <div class="hamburger-inner"></div>
        </div>
    </div>
</div>