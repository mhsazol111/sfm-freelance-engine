<?php
$skills    = Custom::all_terms( 'skill' );
$languages = Custom::all_terms( 'language' );
$countries = Custom::all_terms( 'country' );

// Labels
$keyword_label  = get_field( 'en_search_keyword' );
$skill_label    = get_field( 'en_select_by_skill' );
$language_label = get_field( 'en_working_languages' );
$country_label  = get_field( 'en_select_by_country' );
?>
<div class="search_fields">
    <form id="browse-freelancer-form" method="POST">
        <div class="form-group">
            <input type="text" class="form-control" id="freelancer-search" name="freelancer-search"
                   placeholder="<?php echo $keyword_label; ?>">
            <button type="submit"><i class="fas fa-search"></i></button>
        </div>

        <div class="form-group">
            <select class="custom-select form-control sfm-select2" id="freelancer-skill" name="freelancer-skill">
                <option value=""><?php echo $skill_label; ?></option>
				<?php
				foreach ( $skills as $skill ) {
					echo '<option value="' . $skill->term_id . '">' . __( $skill->name, ET_DOMAIN ) . '</option>';
				}
				?>
            </select>
        </div>

        <div class="form-group fre-input-field freelancer-language-input">
            <select class="custom-select form-control sfm-select2" id="freelancer-language" name="freelancer-language[]" multiple data-placeholder="<?php echo $language_label; ?>">
				<?php
				foreach ( $languages as $language ) {
					echo '<option value="' . $language->term_id . '">' . __( $language->name, ET_DOMAIN ) . '</option>';
				}
				?>
            </select>
        </div>

        <div class="form-group">
            <select class="custom-select form-control sfm-select2" id="freelancer-country" name="freelancer-country">
                <option value=""><?php echo $country_label; ?></option>
				<?php
				foreach ( $countries as $country ) {
					echo '<option value="' . $country->term_id . '">' . __( $country->name, ET_DOMAIN ) . '</option>';
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
