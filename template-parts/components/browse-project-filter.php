<?php
$user_profile_id = get_user_meta( get_current_user_id(), 'user_profile_id', true );
//$categories      = Custom::all_terms( 'project_category' );
//$skills     = Custom::all_terms( 'skill' );
$categories = get_the_terms( $user_profile_id, 'project_category' );
$skills     = get_the_terms( $user_profile_id, 'skill' );
$countries  = Custom::all_terms( 'country' );

// Getting Min and Max Bids
$bids_range   = Custom::get_project_meta_range( 'total_bids' );
$budget_range = Custom::get_project_meta_range( 'et_budget' );
?>
<div class="search_fields">
    <form id="browse-project-form">
        <div class="form-group">
            <input type="text" class="form-control" id="project-search" name="project-search"
                   placeholder="<?php _e( 'Search Projects by keyword', ET_DOMAIN ) ?>">
            <button type="submit"><i class="fas fa-search"></i></button>
        </div>

        <div class="form-group">
            <div class="select_icon"
                 style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/inc/images/select-icon.svg');"></div>
            <select class="custom-select form-control" id="project-skill" name="project-skill">
                <option value=""><?php _e( 'Select Projects by Skill', ET_DOMAIN ) ?></option>
				<?php
				foreach ( $skills as $skill ) {
					$selected = ( $current_skill == $skill->slug ? 'selected' : '' );
					echo sprintf( '<option value="%s" %s>%s</option>', $skill->slug, $selected, $skill->name );
				}
				?>
            </select>
        </div>

        <div class="select_box form-group">
            <div class="select_icon"
                 style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/inc/images/select-icon.svg');"></div>
            <select class="custom-select form-control" id="project-category" name="project-category">
                <option value=""><?php _e( 'Select Project Category', ET_DOMAIN ) ?></option>
				<?php
				foreach ( $categories as $category ) {
					$selected = ( $current_category == $category->slug ? 'selected' : '' );
					echo sprintf( '<option value="%s" %s>%s</option>', $category->slug, $selected, $category->name );
				}
				?>
            </select>
        </div>

        <!-- <div class="select_box form-group">
            <div class="select_icon"
                 style="background-image: url('<?php //echo get_stylesheet_directory_uri(); ?>/inc/images/select-icon.svg');"></div>
            <select class="custom-select form-control" id="project-bid" name="project-bid">
                <option value=""><?php //_e( 'Number of Bids', ET_DOMAIN ) ?></option>
				<?php
				// foreach ( $bids_range as $br ) {
				// 	echo '<option value="' . $br . '">' . $br . '</option>';
				// }
				?>
            </select>
        </div> -->

        <div class="select_box form-group">
            <div class="select_icon"
                 style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/inc/images/select-icon.svg');"></div>
            <select class="custom-select form-control" id="project-country" name="project-country">
                <option value=""><?php _e( 'Select Country', ET_DOMAIN ) ?></option>
				<?php
				foreach ( $countries as $country ) {
					echo '<option value="' . $country->slug . '">' . $country->name . '</option>';
				}
				?>
            </select>
        </div>

        <!-- <div class="form-group budget_range">
            <span class="d_label"><?php //_e( 'Budget Range', ET_DOMAIN ) ?></span>
            <div id="project-budget-step"></div>

            <input type="hidden" name="project-min-budget" id="project-min-budget"
                   value="">
            <input type="hidden" name="project-max-budget" id="project-max-budget"
                   value="">
        </div> -->

        <div class="clear_div">
            <button id="clear-browse-form"><?php _e( 'Clear all filters', ET_DOMAIN ) ?></button>
        </div>
    </form>
    <!-- <script>
        ;(function ($) {
            $(document).ready(function () {
                let stepSlider = document.getElementById("project-budget-step");

                noUiSlider.create(stepSlider, {
                    start: ['<?php //echo min( $budget_range ); ?>', '<?php //echo max( $budget_range ); ?>'],
                    connect: true,
                    // step: 10,
                    margin: 10,
                    // tooltips: [true, true],
                    tooltips: [wNumb({decimals: 0}), wNumb({decimals: 0})],
                    range: {
                        min: <?php //echo min( $budget_range ); ?>,
                        max: <?php //echo max( $budget_range ); ?>,
                    },
                    format: wNumb({
                        decimals: 0
                    }),
                });

                stepSlider.noUiSlider.on('change', function (values) {
                    $('#project-min-budget').val(values[0]);
                    $('#project-max-budget').val(values[1]);

                    $('#browse-project-form').submit();
                });

            });
        })(jQuery);
    </script> -->
</div>
<hr class="clear">