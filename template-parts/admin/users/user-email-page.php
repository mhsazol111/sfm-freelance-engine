<?php
function get_users_query( $args ) {
	$users = new WP_User_Query( $args );

	return $users->get_results();
}

$freelancer = array( 'role' => 'freelancer' );
$employer   = array( 'role' => 'employer' );
$pending    = array(
	'meta_key'     => 'account_status',
	'meta_value'   => 'pending',
	'meta_compare' => '='
);
$users      = array( 'role__in' => [ 'freelancer', 'employer' ] );

$params = $users;
if ( isset( $_REQUEST['role'] ) && $_REQUEST['role'] == 'freelancer' ) {
	$params = $freelancer;
} elseif ( isset( $_REQUEST['role'] ) && $_REQUEST['role'] == 'employer' ) {
	$params = $employer;
} elseif ( isset( $_REQUEST['role'] ) && $_REQUEST['role'] == 'pending' ) {
	$params = $pending;
} elseif ( isset( $_REQUEST['role'] ) && $_REQUEST['role'] == 'all' ) {
	$params = $users;
}
?>

<div class="wrap">
    <div class="sfm-admin-email-area">
        <h1 class="wp-heading-inline">Email to Users</h1>
        <div class="sfm-admin-ea-header">
            <ul class="sfm-admin-ea-nav subsubsub">
                <li class="all">
                    <a href="?page=mass_email_to_users" class="current" data-type="all">
                        All
                        <span class="count">(<?php echo count( get_users_query( $users ) ) ?>)</span>
                    </a> |
                </li>
                <li class="freelancer">
                    <a href="?page=mass_email_to_users&role=freelancer"
                       class="<?php echo ( isset( $_REQUEST['role'] ) && $_REQUEST['role'] == 'freelancer' ) ? 'current' : '' ?>"
                       data-type="freelancer">
                        Freelancer
                        <span class="count">(<?php echo count( get_users_query( $freelancer ) ); ?>)</span>
                    </a> |
                </li>
                <li class="employer">
                    <a href="?page=mass_email_to_users&role=employer"
                       class="<?php echo ( isset( $_REQUEST['role'] ) && $_REQUEST['role'] == 'employer' ) ? 'current' : '' ?>"
                       data-type="employer">
                        Employer
                        <span class="count">(<?php echo count( get_users_query( $employer ) ); ?>)</span>
                    </a> |
                </li>
                <li class="pending">
                    <a href="?page=mass_email_to_users&role=pending"
                       class="<?php echo ( isset( $_REQUEST['role'] ) && $_REQUEST['role'] == 'pending' ) ? 'current' : '' ?>"
                       data-type="pending">
                        Pending
                        <span class="count">(<?php echo count( get_users_query( $pending ) ); ?>)</span>
                    </a>
                </li>
            </ul>
			<?php get_template_part( 'template-parts/admin/users/table', 'search' ); ?>
        </div>
        <div class="sfm-admin-ea-body">
            <form action="" id="sfm-admin-mail-form">
                <table class="wp-list-table widefat fixed striped table-view-list users_page_pending_users">
                    <thead>
					<?php get_template_part( 'template-parts/admin/users/table', 'header' ); ?>
                    </thead>
                    <tbody id="the-list">
					<?php
					if ( get_users_query( $params ) ) {
						foreach ( get_users_query( $params ) as $user ) {
							include( locate_template( 'template-parts/admin/users/table-item.php' ) );
						}
					}
					?>
                    </tbody>
                    <tfoot>
					<?php get_template_part( 'template-parts/admin/users/table', 'header' ); ?>
                    </tfoot>
                </table>
                <div class="send-button-wrap">
                    <button id="write-user-email" class="button" type="submit">Write Email</button>
                </div>
            </form>
        </div>
    </div>
	<?php get_template_part( 'template-parts/admin/users/email', 'popup' ); ?>
</div>