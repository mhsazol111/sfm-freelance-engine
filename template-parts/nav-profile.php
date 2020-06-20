<?php
global $wp;
$current_page_url = home_url( $wp->request );
?>
<div class="menu">
    <ul>
        <li class="<?php echo $current_page_url == home_url( 'dashboard' ) ? 'current-page' : ''; ?>">
            <a href="<?php echo esc_url( home_url( 'dashboard' ) ); ?>"><i class="fa fa-dashboard"></i>Dashboard</a>
        </li>
        <li class="<?php echo $current_page_url == home_url( 'my-projects' ) ? 'current-page' : ''; ?>">
            <a href="<?php echo esc_url( home_url( 'my-projects' ) ); ?>"><i class="fa fa-list-ul"></i>My Projects</a>
        </li>
		<?php if ( USER_ROLE == 'freelancer' ) : ?>
            <li class="<?php echo $current_page_url == home_url( 'my-portfolios' ) ? 'current-page' : ''; ?>">
                <a href="<?php echo esc_url( home_url( 'my-portfolios' ) ); ?>"><i class="fa fa-briefcase"></i>My Portfolios</a>
            </li>
		<?php endif; ?>
        <li class="<?php echo $current_page_url == home_url( 'messages' ) ? 'current-page' : ''; ?>">
            <a href="<?php echo esc_url( home_url( 'messages' ) ); ?>"><i class="fa fa-comment"></i>Messages</a>
        </li>
        <li class="<?php echo $current_page_url == home_url( 'edit-profile' ) ? 'current-page' : ''; ?>">
            <a href="<?php echo esc_url( home_url( 'edit-profile' ) ); ?>"><i class="fa fa-cog"></i>Edit My Profile</a>
        </li>
        <li class="<?php echo $current_page_url == home_url( 'help-and-support' ) ? 'current-page' : ''; ?>"><a href="/help-and-support/"><i class="fa fa-question-circle"></i>Help and Support</a></li>
        <li><a href="<?php echo wp_logout_url( home_url() ); ?>"><i class="fa fa-sign-out"></i>Logout</a></li>
    </ul>
</div>