<?php
$user_profile_id = get_user_meta( get_current_user_id(), 'user_profile_id', true );
$countries = Custom::all_terms( 'country' );

if ( current_user_can( 'administrator' ) ) {
	$categories = Custom::all_terms( 'project_category' );
	$skills     = Custom::all_terms( 'skill' );
} else {
	$categories = get_the_terms( $user_profile_id, 'project_category' );
	$skills     = get_the_terms( $user_profile_id, 'skill' );
}
?>
<div class="search_fields">
    <form id="browse-project-form">
        <div class="form-group">
            <input type="text" class="form-control" id="project-search" name="project-search"
                   placeholder="<?php _e( 'Search Projects by keyword', ET_DOMAIN ) ?>">
            <button type="submit"><i class="fas fa-search"></i></button>
        </div>

        <div class="form-group">
            <select class="custom-select form-control sfm-select2" id="project-skill" name="project-skill">
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
            <select class="custom-select form-control sfm-select2" id="project-category" name="project-category">
                <option value=""><?php _e( 'Select Project Category', ET_DOMAIN ) ?></option>
				<?php
				foreach ( $categories as $category ) {
					$selected = ( $current_category == $category->slug ? 'selected' : '' );
					echo sprintf( '<option value="%s" %s>%s</option>', $category->slug, $selected, $category->name );
				}
				?>
            </select>
        </div>

        <div class="select_box form-group">
            <select class="custom-select form-control sfm-select2" id="project-country" name="project-country">
                <option value=""><?php _e( 'Select Country', ET_DOMAIN ) ?></option>
				<?php
				foreach ( $countries as $country ) {
					echo '<option value="' . $country->slug . '">' . $country->name . '</option>';
				}
				?>
            </select>
        </div>

        <div class="clear_div">
            <button id="clear-browse-form"><?php _e( 'Clear all filters', ET_DOMAIN ) ?></button>
        </div>
    </form>

</div>
<hr class="clear">