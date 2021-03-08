<?php
$user_profile_id = get_user_meta( $user->id, 'user_profile_id', true );
$categories      = '';
$skills          = '';
$country         = '';
$languages       = '';
if ( $user_profile_id ) {
	$categories = get_the_terms( $user_profile_id, 'project_category' );
	$skills     = get_the_terms( $user_profile_id, 'skill' );
	$country    = get_the_terms( $user_profile_id, 'country' );
	$languages  = get_the_terms( $user_profile_id, 'language' );
}
$columns = get_option( 'cso_column' );
?>

<tr>
    <th scope="row" class="check-column">
        <label class="screen-reader-text"
               for="user_<?php echo $user->id; ?>">Select <?php echo $user->user_nicename; ?>
        </label>
        <input type="checkbox" name="users[]" id="user_<?php echo $user->id; ?>"
               value="<?php echo $user->id; ?>">
    </th>
    <td class="name column-username has-row-actions column-primary" data-colname="Name">
		<?php echo get_avatar( $user->id, 32 ); ?>
        <strong><a href="<?php echo esc_url( get_edit_user_link( $user->id ) ); ?>"><?php echo $user->display_name; ?></a></strong>
        <br>
        <div class="row-actions">
            <span class="edit"><a href="<?php echo esc_url( get_edit_user_link( $user->id ) ); ?>">Edit</a> | </span>
            <span class="delete"><a class="submitdelete"
                                    href="<?php echo wp_nonce_url( "users.php?action=delete&amp;user={$user->id}", 'bulk-users' ) ?>">Delete</a> | </span>
            <span class="view"><a href="<?php echo get_site_url() . '/author/' . sanitize_title( $user->nickname ); ?>"
                                  aria-label="View posts by <?php echo $user->display_name; ?>">View</a> | </span>
        </div>
        <button type="button" class="toggle-row"><span class="screen-reader-text">Show more details</span></button>
    </td>
    <td class="email column-email"
        data-colname="Email" style="<?php echo in_array('email', $columns ) ? '' : 'display: none' ?>"><?php echo $user->user_email; ?></td>
    <td class="usertype column-usertype"
        data-colname="User Type" style="text-transform: capitalize; <?php echo in_array('type', $columns ) ? '' : 'display: none' ?>"><?php echo get_userdata( $user->id )->roles[0]; ?></td>
    <td class="status column-status" data-colname="Approval Status" style="text-transform: capitalize; <?php echo in_array('a-status', $columns ) ? '' : 'display: none' ?>">
		<?php echo ( get_user_meta( $user->id, 'account_status', true ) == 'active' ) ? 'Approved' : 'Pending'; ?>
    </td>
    <td class="categories column-categories" data-colname="Categories" style="text-transform: capitalize; <?php echo in_array('category', $columns ) ? '' : 'display: none' ?>">
		<?php
		if ( $categories ) {
			foreach ( $categories as $category ) {
				echo '<span style="display: block">' . $category->name . '</span>';
			}
		} else {
			echo '<span style="display: block">---</span>';
		}
		?>
    </td>
    <td class="skill column-skill" data-colname="Skill" style="text-transform: capitalize; <?php echo in_array('skill', $columns ) ? '' : 'display: none' ?>">
		<?php
		if ( $skills ) {
			foreach ( $skills as $skill ) {
				echo '<span style="display: block">' . $skill->name . '</span>';
			}
		} else {
			echo '<span style="display: block">---</span>';
		}
		?>
    </td>
    <td class="country column-country" data-colname="Country" style="text-transform: capitalize; <?php echo in_array('country', $columns ) ? '' : 'display: none' ?>">
		<?php
		if ( $country ) {
			echo $country[0]->name;
		} else {
			echo '<span style="display: block">---</span>';
		}
		?>
    </td>
    <td class="status column-city" data-colname="City" style="text-transform: capitalize; <?php echo in_array('city', $columns ) ? '' : 'display: none' ?>">
		<?php echo( get_user_meta( $user->id, 'city_name', true ) ? get_user_meta( $user->id, 'city_name', true ) : '<span style="display: block">---</span>' ); ?>
    </td>
    <td class="language column-language" data-colname="Languages" style="text-transform: capitalize; <?php echo in_array('language', $columns ) ? '' : 'display: none' ?>">
		<?php
		if ( $languages ) {
			foreach ( $languages as $language ) {
				echo '<span style="display: block">' . $language->name . '</span>';
			}
		} else {
			echo '<span style="display: block">---</span>';
		}
		?>
    </td>
    <td class="profile_status column-profile_status" data-colname="Profile Status" style="text-transform: capitalize; <?php echo in_array('p-status', $columns ) ? '' : 'display: none' ?>">
		<?php echo $user_profile_id ? 'Completed' : 'Incomplete'; ?>
    </td>
    <td class="status column-phone" data-colname="Phone Number" style="<?php echo in_array('phone', $columns ) ? '' : 'display: none' ?>">
		<?php echo( get_user_meta( $user->id, 'phone_number', true ) ? get_user_meta( $user->id, 'phone_number', true ) : '<span style="display: block">---</span>' ); ?>
    </td>
    <td class="company column-company" data-colname="Company Name" style="text-transform: capitalize; <?php echo in_array('company', $columns ) ? '' : 'display: none' ?>">
		<?php echo( get_user_meta( $user->id, 'company_name', true ) ? get_user_meta( $user->id, 'company_name', true ) : '<span style="display: block">---</span>' ); ?>
    </td>
    <td class="job_title column-job_title" data-colname="Job Title" style="text-transform: capitalize; <?php echo in_array('job-title', $columns ) ? '' : 'display: none' ?>">
		<?php echo( get_user_meta( $user->id, 'job_title', true ) ? get_user_meta( $user->id, 'job_title', true ) : '<span style="display: block">---</span>' ); ?>
    </td>
    <td class="wage column-wage" data-colname="Daily Wage" style="text-transform: capitalize; <?php echo in_array('wage', $columns ) ? '' : 'display: none' ?>">
		<?php echo( get_user_meta( $user->id, 'daily_wage_rate', true ) ? get_user_meta( $user->id, 'daily_wage_rate', true ) : '<span style="display: block">---</span>' ); ?>
    </td>
    <td class="wage column-wage" data-colname="Nationality" style="text-transform: capitalize; <?php echo in_array('nationality', $columns ) ? '' : 'display: none' ?>">
		<?php
		$user_nationality_id  = get_user_meta( $user->id, 'user_country_id', true );
		$user_profile_post_id = get_user_meta( $user->id, 'user_profile_id', true );
		$user_profile_country = get_the_terms( $user_profile_post_id, 'country' );
		if ( $user_nationality_id ) {
			$nationality = get_term( $user_nationality_id, 'country' )->name;
		} else {
			$nationality = $user_profile_country[0]->name;
		}
		?>
		<?php echo $nationality; ?>
    </td>
</tr>