<?php
if( ! defined( 'ABSPATH' ) ) die( "You can't access this file directly" );
if( isset( $_REQUEST['message_id'] ) && ! empty( $_REQUEST['message_id'] ) ){
    $item = sanitize_text_field( $_REQUEST['message_id'] );
    $itemObj = $pm_list_table->single_item ( $item );

	$time = mysql2date('U', $itemObj->send_date, false);
	$send_time = date( 'h:ia @ M d', $time );

    if( isset($itemObj[0]) ) {
        $itemObj = $itemObj[0];
        $project = get_post( $itemObj->project_id );
        $sender = get_userdata( $itemObj->sender_id );
        if( $itemObj->sender_id == $itemObj->author_id ) {
            $author = $sender;
        } else {
            $author = get_userdata( $itemObj->author_id );
        }
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline"><?php esc_html_e( 'Private message details', ET_DOMAIN); ?></h1>
        <p><a href="<?php echo admin_url('admin.php?page=la-private-messages') ?>" class="page-title-action"><?php esc_html_e( 'Back to the list', ET_DOMAIN); ?></a></p>
        <hr class="wp-header-end">
        <h3><?php esc_html_e( 'Project :', ET_DOMAIN); ?></h3>
        <p><strong><?php echo $project->post_title; ?></strong></p>
        <hr>
        <h3><?php esc_html_e( 'Sender :', ET_DOMAIN); ?></h3>
        <p><?php echo get_username( $sender ); ?></p>
        <hr>
        <h3><?php esc_html_e( 'Author :', ET_DOMAIN); ?></h3>
        <p><?php echo get_username( $author ); ?></p>
        <hr>
        <h3><?php esc_html_e( 'Message :', ET_DOMAIN); ?></h3>
        <?php echo wpautop( $itemObj->message); ?>
        <hr>
        <h3><?php esc_html_e( 'Status :', ET_DOMAIN); ?></h3>
        <p><?php echo strtoupper( $itemObj->status ); ?></p>
        <hr>
        <h3><?php esc_html_e( 'Send Date : ', ET_DOMAIN); ?></h3>
        <p><?php echo $send_time; ?></p>
        <hr>
        <p><a href="<?php echo admin_url('admin.php?page=la-private-messages') ?>" class="page-title-action"><?php esc_html_e( 'Back to the list', ET_DOMAIN); ?></a></p>
    </div>
    <?php
    } else { ?>
        <h3 style="text-align: center;"><?php esc_html_e( 'Item not found! Please try again!' ); ?></h3>
        <p style="text-align: center;"><a href="<?php echo admin_url('admin.php?page=la-private-messages') ?>" class="page-title-action"><?php esc_html_e( 'Back to the list', ET_DOMAIN); ?></a></p>
        <?php
    }
} else { ?>
<div class="wrap">
	<h1 class="wp-heading-inline"><?php esc_html_e( 'Private messages', ET_DOMAIN); ?></h1>
	<hr class="wp-header-end">
    <form action="" method="GET">
		<?php
            $pm_list_table->prepare_items();
            $pm_list_table->search_box('Search', 'search');
		?>
        <input type="hidden" name="page" value="<?= esc_attr($_REQUEST['page']) ?>"/>
    </form>
    <?php
        $pm_list_table->display();
    ?>
</div>
<?php
}