<?php
if( ! defined('ABSPATH') ) die('No direct access, please!'); ?>

<div class="fre-page-wrapper">

	<div class="my_projects profile_dashboard"
	     id="employer-projects">

		<?php get_template_part( 'template-parts/sidebar', 'profile' ); // Dashboard Sidebar ?>

		<section
			id="dashboard_content">
			<div class="dashboard_inn">

				<div class="dashboard_title">
					<h2><?php _e( 'My Projects', ET_DOMAIN ); ?></h2>
					<hr>
				</div>

				<div class="main-dashboard-content dashboard-landing inner-dashboard">
					<div class="emp-tab-content">

						<div class="emp-tabs">
							<ul class="tabs" id="filter-items-row" data-project-holder="employer">
								<li data-status="" class="project-filter active tab"><?php _e( 'All Projects', ET_DOMAIN ) ?></li>
								<li data-status="close" class="project-filter tab"><?php _e( 'Ongoing', ET_DOMAIN ) ?></li>
								<li data-status="publish" class="project-filter tab"><?php _e( 'Published', ET_DOMAIN ) ?></li>
								<li data-status="complete" class="project-filter tab"><?php _e( 'Completed', ET_DOMAIN ) ?></li>
								<li data-status="draft" class="project-filter tab"><?php _e( 'Pending', ET_DOMAIN ) ?></li>
								<li data-status="archive" class="project-filter tab"><?php _e( 'Archived', ET_DOMAIN ) ?></li>
								<li data-status="disputing" class="project-filter tab"><?php _e( 'Cancelled', ET_DOMAIN ) ?></li>
							</ul>

							<div class="form-group" style="display: none;">
								<form id="my-project-search-form">
									<input type="search" class="ie-search-form" id="project-search" name="project-search" placeholder="<?php _e( 'Search Projects', ET_DOMAIN ) ?>">
								</form>
							</div>
						</div>

						<div id="projects-wrapper"
						     class="my-projects-wrapper">
							<div class="projects-wrapper-content">

								<div class="project_posts employer-my-project">
									<div class="project_row">
										<div class="d_head">
											<div class="head_left">
												<h3><a href="#">##########</h3>
												<div class="e_nav">
													<?php _e( 'Posted on:', ET_DOMAIN ) ?> <span>00-00-00</span> &nbsp;|&nbsp;
													<?php _e( 'Categories:', ET_DOMAIN ) ?>
													<div class="cats">###</div> &nbsp;|&nbsp;
													<?php _e( 'Bids:', ET_DOMAIN ) ?> <span>0</span> &nbsp;|&nbsp;
													<?php _e( 'Budget:', ET_DOMAIN ) ?> <span>000</span> &nbsp;|&nbsp;
													<?php _e( 'Deadline:', ET_DOMAIN ) ?> <span>00-00-00</span>
													<?php
														printf(
															"&nbsp;|&nbsp;%s <span>%d</span>",
															__('Invited:', ET_DOMAIN ),
															0
														);
													?>
												</div>
											</div>
											<div class="head_right">
												<?php
												echo '<span class="ie_btn_small ie_btn_green">Ongoing</span>';
												echo '<span class="ie_btn_small ie_btn_yellow">Published</span>';
												echo '<span class="ie_btn_small ie_btn_purple">Completed</span>';
												echo '<span class="ie_btn_small ie_btn_orange">Archived</span>';
												echo '<span class="ie_btn_small ie_btn_red">Pending</span>';
												echo '<span class="ie_btn_small ie_btn_red">Cancelled</span>';
												?>
												<h3><?php _e('CHF', ET_DOMAIN );?></h3>
												<span>00-00-00</span>
											</div>
										</div>
										<div class="content">############</div>
										<div class="d_footer">
											<div class="footer_left">#####</div>
											<div class="footer_right">
												<a class="ie_btn ie_btn_blue" href="#">
													<i class="far fa-eye" aria-hidden="true"></i> <?php _e( 'View Project', ET_DOMAIN ) ?>
												</a>

												<a class="ie_btn ie_btn_green" href="#">
													<i class="far fa-edit" aria-hidden="true"></i> <?php _e( 'Edit', ET_DOMAIN ) ?>
												</a>

												<a id="project-delete" class="ie_btn ie_btn_red custom-project-action" data-action="delete" data-project-id="00">
													<i class="fas fa-archive" aria-hidden="true"></i> <?php _e( 'Delete', ET_DOMAIN ) ?>
												</a>
												<a id="project-archive" class="ie_btn ie_btn_red custom-project-action" data-action="archive" data-project-id="0">
													<i class="fas fa-archive" aria-hidden="true"></i> <?php _e( 'Archive', ET_DOMAIN ) ?>
												</a>
											</div>
										</div>
									</div><!-- End .project_row -->
								</div>

								<h4><?php _e( 'No Project Found!', ET_DOMAIN ) ?></h4>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>