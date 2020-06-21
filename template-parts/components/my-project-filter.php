<?php
$role_template = 'employer';

if ( fre_share_role() || ae_user_role( $user_ID ) == FREELANCER ) {
	$role_template = 'freelance';
}
?>

<div class="emp-tabs">
	<?php if ( 'employer' == $role_template ) : ?>
        <ul class="tabs" id="filter-items-row" data-project-holder="employer">
            <li data-status="" class="project-filter active tab"><?php _e( 'All Projects', ET_DOMAIN ) ?></li>
            <li data-status="close" class="project-filter tab"><?php _e( 'Ongoing', ET_DOMAIN ) ?></li>
            <li data-status="publish" class="project-filter tab"><?php _e( 'Pending', ET_DOMAIN ) ?></li>
            <li data-status="complete" class="project-filter tab"><?php _e( 'Completed', ET_DOMAIN ) ?></li>
            <li data-status="disputing" class="project-filter tab"><?php _e( 'Disputed', ET_DOMAIN ) ?></li>
            <li data-status="archive" class="project-filter tab"><?php _e( 'Archived', ET_DOMAIN ) ?></li>
            <li data-status="draft" class="project-filter tab"><?php _e( 'Drafted', ET_DOMAIN ) ?></li>
        </ul>
	<?php else : ?>
        <ul class="tabs" id="filter-items-row" data-project-holder="freelancer">
            <li data-status="" class="project-filter active tab"><?php _e( 'All Projects', ET_DOMAIN ) ?></li>
            <li data-status="accept" class="project-filter tab"><?php _e( 'Ongoing', ET_DOMAIN ) ?></li>
            <li data-status="publish" class="project-filter tab"><?php _e( 'Pending', ET_DOMAIN ) ?></li>
            <li data-status="complete" class="project-filter tab"><?php _e( 'Completed', ET_DOMAIN ) ?></li>
            <li data-status="unaccept" class="project-filter tab"><?php _e( 'Unaccepted', ET_DOMAIN ) ?></li>
            <li data-status="disputing" class="project-filter tab"><?php _e( 'Declined', ET_DOMAIN ) ?></li>
        </ul>
	<?php endif; ?>
    <div class="form-group">
        <form id="my-project-search-form">
            <input type="hidden" id="project-status" name="project-status">
            <input type="search" class="ie-search-form" id="project-search" name="project-search" placeholder="<?php _e( 'Search Projects', ET_DOMAIN ) ?>">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>
</div>