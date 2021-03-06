<?php
function get_users_query( $args ) {
	$columns = get_option( 'cso_column' );
	$order = end( $columns );
	$args['order'] = $order;

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
$completed  = array(
	'role__in'     => [ 'freelancer', 'employer' ],
	'meta_key'     => 'user_profile_id',
	'meta_value'   => '',
	'meta_compare' => 'EXISTS'
);
$incomplete = array(
	'role__in'     => [ 'freelancer', 'employer' ],
	'meta_key'     => 'user_profile_id',
	'meta_value'   => '',
	'meta_compare' => 'NOT EXISTS'
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
} elseif ( isset( $_REQUEST['status'] ) && $_REQUEST['status'] == 'completed' ) {
	$params = $completed;
} elseif ( isset( $_REQUEST['status'] ) && $_REQUEST['status'] == 'incomplete' ) {
	$params = $incomplete;
}
?>

<div class="wrap sfm-admin-email-area-wrap">
	<?php get_template_part( 'template-parts/admin/users/column', 'settings' ); ?>
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
                <li class="completed">
                    <a href="?page=mass_email_to_users&status=completed"
                       class="<?php echo ( isset( $_REQUEST['status'] ) && $_REQUEST['status'] == 'completed' ) ? 'current' : '' ?>"
                       data-type="completed">
                        Completed
                        <span class="count">(<?php echo count( get_users_query( $completed ) ); ?>)</span>
                    </a>
                </li>
                <li class="incomplete">
                    <a href="?page=mass_email_to_users&status=incomplete"
                       class="<?php echo ( isset( $_REQUEST['status'] ) && $_REQUEST['status'] == 'incomplete' ) ? 'current' : '' ?>"
                       data-type="incomplete">
                        Incomplete
                        <span class="count">(<?php echo count( get_users_query( $incomplete ) ); ?>)</span>
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