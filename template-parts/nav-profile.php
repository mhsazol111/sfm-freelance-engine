<?php
global $wp;
$current_page_url = home_url( $wp->request );
?>
<div class="menu">
    <ul>
        <li class="<?php echo $current_page_url == home_url( 'dashboard' ) ? 'current-page' : ''; ?>">
            <a href="<?php echo esc_url( home_url( 'dashboard' ) ); ?>"><i class="fa fa-dashboard"></i><?php _e( 'Dashboard', ET_DOMAIN ) ?></a>
        </li>
        <li class="<?php echo $current_page_url == home_url( 'my-projects' ) ? 'current-page' : ''; ?>">
            <a href="<?php echo esc_url( home_url( 'my-projects' ) ); ?>"><i class="fa fa-list-ul"></i><?php _e( 'My Projects', ET_DOMAIN ) ?></a>
        </li>
		<?php if ( USER_ROLE == 'freelancer' || sfm_translating_as('freelancer') ) : ?>
            <li class="<?php echo $current_page_url == home_url( 'my-portfolios' ) ? 'current-page' : ''; ?>">
                <a href="<?php echo esc_url( home_url( 'my-portfolios' ) ); ?>"><i class="fa fa-briefcase"></i><?php _e( 'My Portfolios', ET_DOMAIN ) ?></a>
            </li>
		<?php endif; ?>
        <li class="<?php echo $current_page_url == home_url( 'messages' ) ? 'current-page' : ''; ?>">
            <a href="<?php echo esc_url( home_url( 'messages' ) ); ?>"><i class="fa fa-comment"></i><?php _e( 'Messages', ET_DOMAIN ) ?></a>
        </li>
        <li class="<?php echo $current_page_url == home_url( 'edit-profile' ) ? 'current-page' : ''; ?>">
            <a href="<?php echo esc_url( home_url( 'edit-profile' ) ); ?>"><i class="fa fa-cog"></i><?php _e( 'Edit My Profile', ET_DOMAIN ) ?></a>
        </li>
        <li class="<?php echo $current_page_url == home_url( 'notification-settings' ) ? 'current-page' : ''; ?>">
            <a href="<?php echo esc_url( home_url( 'notification-settings' ) ); ?>"><i class="fa fa-bell"></i><?php _e( 'Notification Settings', ET_DOMAIN ) ?></a>
        </li>
        <li class="<?php echo $current_page_url == home_url( 'help-and-support' ) ? 'current-page' : ''; ?>">
            <a href="<?php echo home_url( 'help-and-support' ); ?>"><i class="fa fa-question-circle"></i><?php _e( 'Help and Support', ET_DOMAIN ) ?></a>
        </li>
        <li>
            <a href="<?php echo wp_logout_url( home_url() ); ?>"><i class="fa fa-sign-out"></i><?php _e( 'Logout', ET_DOMAIN ) ?></a>
        </li>
    </ul>
</div>