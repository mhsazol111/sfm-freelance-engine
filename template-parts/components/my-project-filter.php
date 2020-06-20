<?php
$role_template = 'employer';

if ( fre_share_role() || ae_user_role( $user_ID ) == FREELANCER ) {
	$role_template = 'freelance';
}
?>

<div class="emp-tabs">
	<?php if ( 'employer' == $role_template ) : ?>
        <ul class="tabs" id="filter-items-row" data-project-holder="employer">
            <li data-status="" class="project-filter active tab">All Projects</li>
            <li data-status="close" class="project-filter tab">Ongoing</li>
            <li data-status="publish" class="project-filter tab">Pending</li>
            <li data-status="complete" class="project-filter tab">Completed</li>
            <li data-status="disputing" class="project-filter tab">Disputed</li>
            <li data-status="archive" class="project-filter tab">Archived</li>
            <li data-status="draft" class="project-filter tab">Drafted</li>
        </ul>
	<?php else : ?>
        <ul class="tabs" id="filter-items-row" data-project-holder="freelancer">
            <li data-status="" class="project-filter active tab">All Projects</li>
            <li data-status="accept" class="project-filter tab">Ongoing</li>
            <li data-status="publish" class="project-filter tab">Pending</li>
            <li data-status="complete" class="project-filter tab">Completed</li>
            <li data-status="unaccept" class="project-filter tab">Unaccepted</li>
            <li data-status="disputing" class="project-filter tab">Declined</li>
        </ul>
	<?php endif; ?>
    <div class="form-group">
        <form id="my-project-search-form">
            <input type="hidden" id="project-status" name="project-status">
            <input type="search" class="ie-search-form" id="project-search" name="project-search" placeholder="Search Projects">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>
</div>