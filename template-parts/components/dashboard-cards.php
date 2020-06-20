<div class="project_info">
    <div class="pro_row">
		<?php if ( 'freelance' == $role_template ) : ?>
            <div class="count"><?php echo Custom::query_to_post_count( Freelancer::get_projects( get_current_user_id(), 'accept' ) ); ?></div>
            <div class="info"><?php _e( 'Active Projects', ET_DOMAIN ); ?></div>
		<?php else : ?>
            <div class="count"><?php echo intval( $project_posted ) ?></div>
            <div class="info"><?php _e( 'Posted Projects', ET_DOMAIN ); ?></div>
		<?php endif; ?>
    </div>

    <div class="pro_row">
		<?php if ( 'freelance' == $role_template ) : ?>
            <div class="count"><?php echo intval( $projects_worked ) ?></div>
            <div class="info"><?php _e( 'Completed Projects', ET_DOMAIN ); ?></div>
		<?php else : ?>
            <div class="count"><?php echo Custom::query_to_post_count( Employer::get_projects( get_current_user_id(), 'complete' ) ); ?></div>
            <div class="info"><?php _e( 'Completed Projects', ET_DOMAIN ); ?></div>
		<?php endif; ?>
    </div>

    <div class="pro_row">
		<?php if ( 'freelance' == $role_template ) : ?>
            <div class="count"><?php echo Custom::query_to_post_count( Freelancer::get_projects( get_current_user_id(), 'publish' ) ); ?></div>
            <div class="info"><?php _e( 'Pending Projects', ET_DOMAIN ); ?></div>
		<?php else : ?>
            <div class="count"><?php echo Custom::query_to_post_count( Employer::get_projects( get_current_user_id(), 'close' ) ); ?></div>
            <div class="info"><?php _e( 'Ongoing Projects', ET_DOMAIN ); ?></div>
		<?php endif; ?>
    </div>

    <div class="pro_row">
		<?php if ( 'freelance' == $role_template ) : ?>
            <div class="count"><?php echo Custom::query_to_post_count( Freelancer::get_projects( get_current_user_id(), 'disputing' ) ); ?></div>
            <div class="info"><?php _e( 'Declined Projects', ET_DOMAIN ); ?></div>
		<?php else : ?>
            <div class="count"><?php echo Custom::query_to_post_count( Employer::get_projects( get_current_user_id(), 'publish' ) ); ?></div>
            <div class="info"><?php _e( 'Pending Projects', ET_DOMAIN ); ?></div>
		<?php endif; ?>
    </div>

    <div class="pro_row">
		<?php if ( 'freelance' == $role_template ) : ?>
            <div class="count"><?php echo Custom::query_to_post_count( Freelancer::get_projects( get_current_user_id(), 'disputed' ) ); ?></div>
            <div class="info"><?php _e( 'Resolved Projects', ET_DOMAIN ); ?></div>
		<?php else : ?>
            <div class="count"><?php echo Custom::query_to_post_count( Employer::get_projects( get_current_user_id(), 'disputing' ) ); ?></div>
            <div class="info"><?php _e( 'Cancelled Projects', ET_DOMAIN ); ?></div>
		<?php endif; ?>
    </div>
</div><!-- End .project_info -->