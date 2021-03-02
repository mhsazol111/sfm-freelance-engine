<?php
$skills     = Custom::all_terms( 'skill' );
$languages  = Custom::all_terms( 'language' );
$countries  = Custom::all_terms( 'country' );
$categories = Custom::all_terms( 'project_category' );

$user_profile_id = get_user_meta( get_current_user_id(), 'user_profile_id', true );
$categories      = get_the_terms( $user_profile_id, 'project_category' );

// Labels
$keyword_label  = get_field( 'en_search_keyword' );
$skill_label    = get_field( 'en_select_by_skill' );
$language_label = get_field( 'en_working_languages' );
$country_label  = get_field( 'en_select_by_country' );
$category_label = get_field( 'en_select_by_category' );

$current_lang = get_locale();
?>
<div class="search_fields">
    <form id="browse-freelancer-form" method="POST">
        <div class="form-group">
            <input type="text" class="form-control" id="freelancer-search" name="freelancer-search"
                   placeholder="<?php echo $keyword_label; ?>">
            <button type="submit"><i class="fas fa-search"></i></button>
        </div>

        <div class="form-group fre-input-field freelancer-language-input with-and-or">
            <select class="custom-select form-control sfm-select2" id="freelancer-category" name="freelancer-category[]"
                    multiple data-placeholder="<?php echo $category_label; ?>">
				<?php
				foreach ( $categories as $category ) {
					$la_opt_category = get_field( $current_lang . '_label', $category );

					if ( get_locale() == 'en_US' ) :
						echo '<option value="' . $category->term_id . '">' . __( $category->name, ET_DOMAIN ) . '</option>';
					else:
						echo '<option class="la-option" value="' . $category->term_id . '">' . __( $la_opt_category, ET_DOMAIN ) . '</option>';
					endif;
				}
				?>
            </select>
            <div class="and-or-selector">
                <label for="or-category">
                    <input type="radio" name="and-or-category" value="or" id="or-category" class="custom-select"
                           checked> <?php _e( 'Or', ET_DOMAIN ); ?>
                </label>
                <label for="and-category">
                    <input type="radio" name="and-or-category" value="and" id="and-category"
                           class="custom-select"> <?php _e( 'And', ET_DOMAIN ); ?>
                </label>
            </div>
        </div>

        <div class="form-group fre-input-field freelancer-language-input with-and-or">
            <select class="custom-select form-control sfm-select2" id="freelancer-skill" name="freelancer-skill[]"
                    multiple data-placeholder="<?php echo $skill_label; ?>">
				<?php
				foreach ( $skills as $skill ) {
					$la_opt_skill = get_field( $current_lang . '_label', $skill );

					if ( get_locale() == 'en_US' ) :
						echo '<option value="' . $skill->term_id . '">' . __( $skill->name, ET_DOMAIN ) . '</option>';
					else:
						echo '<option class="la-option" value="' . $skill->term_id . '">' . __( $la_opt_skill, ET_DOMAIN ) . '</option>';
					endif;
				}
				?>
            </select>
            <div class="and-or-selector">
                <label for="or-skill">
                    <input type="radio" name="and-or-skill" value="or" id="or-skill" class="custom-select"
                           checked> <?php _e( 'Or', ET_DOMAIN ); ?>
                </label>
                <label for="and-skill">
                    <input type="radio" name="and-or-skill" value="and" id="and-skill"
                           class="custom-select"> <?php _e( 'And', ET_DOMAIN ); ?>
                </label>
            </div>
        </div>

        <div class="form-group fre-input-field freelancer-language-input with-and-or">
            <select class="custom-select form-control sfm-select2" id="freelancer-language" name="freelancer-language[]"
                    multiple data-placeholder="<?php echo $language_label; ?>">
				<?php
				foreach ( $languages as $language ) {
					$la_opt_language = get_field( $current_lang . '_label', $language );

					if ( get_locale() == 'en_US' ) :
						echo '<option value="' . $language->term_id . '">' . __( $language->name, ET_DOMAIN ) . '</option>';
					else:
						echo '<option class="la-option" value="' . $language->term_id . '">' . __( $la_opt_language, ET_DOMAIN ) . '</option>';
					endif;
				}
				?>
            </select>
            <div class="and-or-selector">
                <label for="or-language">
                    <input type="radio" name="and-or-language" value="or" id="or-language" class="custom-select"
                           checked> <?php _e( 'Or', ET_DOMAIN ); ?>
                </label>
                <label for="and-language">
                    <input type="radio" name="and-or-language" value="and" id="and-language"
                           class="custom-select"> <?php _e( 'And', ET_DOMAIN ); ?>
                </label>
            </div>
        </div>

        <div class="form-group fre-input-field freelancer-language-input with-and-or">
            <select class="custom-select form-control sfm-select2" id="freelancer-country" name="freelancer-country[]"
                    multiple data-placeholder="<?php echo $country_label; ?>">
				<?php
				foreach ( $countries as $country ) {
					$la_opt_country = get_field( $current_lang . '_label', $country );

					if ( get_locale() == 'en_US' ) :
						echo '<option value="' . $country->term_id . '">' . __( $country->name, ET_DOMAIN ) . '</option>';
					else:
						echo '<option class="la-option" value="' . $country->term_id . '">' . __( $la_opt_country, ET_DOMAIN ) . '</option>';
					endif;
				}
				?>
            </select>
            <div class="and-or-selector">
                <label for="or-country">
                    <input type="radio" name="and-or-country" value="or" id="or-country" class="custom-select"
                           checked> <?php _e( 'Or', ET_DOMAIN ); ?>
                </label>
                <label for="and-country">
                    <input type="radio" name="and-or-country" value="and" id="and-country"
                           class="custom-select"> <?php _e( 'And', ET_DOMAIN ); ?>
                </label>
            </div>
        </div>

        <div class="clear_div">
            <button id="clear-freelancer-form"><?php _e( 'Clear all filters', ET_DOMAIN ) ?></button>
        </div>
    </form>

</div>
<hr class="clear">
