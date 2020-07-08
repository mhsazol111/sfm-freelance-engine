<?php
if( ! defined('ABSPATH') ) die('No direct access, please!');
?>

<div class="fre-page-wrapper post-project-wrapper">
	<div class="profile_dashboard"
	     id="<?php echo $role_template; ?>-dashboard">
		<?php include( locate_template( 'template-parts/sidebar-profile.php' ) ); // Dashboard Sidebar ?>
		<section
			id="dashboard_content">
			<div class="dashboard_inn">

				<div class="fre-page-section list-profile-wrapper sfm-my-portfolios-wrapper">
						<div class="fre-profile-boxx">
							<div class="portfolio-container">
								<div class="profile-freelance-portfolio">
									<div class="my-portfolio-bar">
										<div class="m-p-left">
											<h2 class="freelance-portfolio-title"><?php _e( 'My Portfolios', ET_DOMAIN ) ?></h2>
										</div>

											<div class="m-p-right">
												<div class="freelance-portfolio-add">
													<a href="#"
													   class="fre-normal-btn-o portfolio-add-btn add-portfolio"><?php _e( 'Add new', ET_DOMAIN ); ?></a>
												</div>
											</div>

									</div>


										<p class="fre-empty-optional-profile"><?php _e( 'Add portfolio to your profile. (optional)', ET_DOMAIN ) ?></p>

										<ul class="freelance-portfolio-list row fpp-portfolio-wrap">
											<li class="col-md-4 col-sm-6 col-sx-12">
												<div class="freelance-portfolio-wrap" id="portfolio_item_00">

													<div class="portfolio-title">
														<a class="fre-view-portfolio-new" href="javascript:void(0)"
														   data-id="00"> ###### </a>
													</div>

														<div class="portfolio-action">
															<a href="javascript:void(0)" class="edit-portfolio" data-id="00"><i
																	class="fa fa-pencil-square-o" aria-hidden="true"></i><?php _e( 'Edit', ET_DOMAIN ) ?></a>

															<a href="javascript:void(0)" class="remove_portfolio" data-portfolio_id="00"><i
																	class="fa fa-trash-o" aria-hidden="true"></i><?php _e( 'Remove', ET_DOMAIN ) ?></a>
														</div>

												</div>
											</li>
										</ul>

									<?php


										echo '<div class="freelance-portfolio-loadmore">';
											_e('View more');
										echo '</div>';

									?>
								</div>
							</div>
						</div>

				</div>

			</div>
		</section>

	</div>
</div>
