<?php
$skills     = Custom::all_terms( 'skill' );
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
            <select class="custom-select form-control" id="freelancer-skill" name="freelancer-skill">
                <option><?php _e( 'Select freelancers by Skill', ET_DOMAIN ) ?></option>
				<?php
				foreach ( $skills as $skill ) {
					$selected = ( $current_skill == $skill->term_id ? 'selected' : '' );
					echo sprintf( '<option value="%s" %s>%s</option>', $skill->term_id, $selected, $skill->name );
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
