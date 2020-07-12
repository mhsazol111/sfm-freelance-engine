<?php
$skills    = Custom::all_terms( 'skill' );
$countries = $terms = get_terms( 'country', array(
	'hide_empty' => false,
) );
?>
<div class="search_fields">
    <form id="browse-freelancer-form" method="POST">
        <div class="form-group">
            <input type="text" class="form-control" id="freelancer-search" name="freelancer-search"
                   placeholder="<?php _e( 'Search freelancers by keyword', ET_DOMAIN ) ?>">
            <button type="submit"><i class="fas fa-search"></i></button>
        </div>

        <div class="form-group">
            <div class="select_icon"
                 style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/inc/images/select-icon.svg');"></div>
            <select class="custom-select form-control sfm-select2" id="freelancer-skill" name="freelancer-skill">
                <option><?php _e( 'Select freelancers by Skill', ET_DOMAIN ) ?></option>
				<?php
				foreach ( $skills as $skill ) {
					echo sprintf( '<option value="%s">%s</option>', $skill->term_id, __( $skill->name, ET_DOMAIN ) );
				}
				?>
            </select>
        </div>

        <div class="form-group">
            <div class="select_icon"
                 style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/inc/images/select-icon.svg');"></div>
            <select class="custom-select form-control sfm-select2" id="freelancer-country" name="freelancer-country">
                <option><?php _e( 'Select freelancers by Country', ET_DOMAIN ) ?></option>
				<?php
				foreach ( $countries as $country ) {
					echo sprintf( '<option value="%s">%s</option>', $country->term_id, __( $country->name, ET_DOMAIN ) );
				}
				?>
            </select>
        </div>

        <div class="clear_div">
            <button id="clear-freelancer-form"><?php _e( 'Clear all filters', ET_DOMAIN ) ?></button>
        </div>
    </form>

</div>
<hr class="clear">
