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
        data-colname="Email"><?php echo $user->user_email; ?></td>
    <td class="usertype column-usertype"
        data-colname="User Type"
        style="text-transform: capitalize"><?php echo get_userdata( $user->id )->roles[0]; ?></td>
    <td class="status column-status" style="text-transform: capitalize"
        data-colname="Approval Status">
		<?php echo ( get_user_meta( $user->id, 'account_status', true ) == 'active' ) ? 'Approved' : 'Pending'; ?>
    </td>
    <td class="categories column-categories" style="text-transform: capitalize"
        data-colname="Categories">
		<?php
		if ( $categories ) {
			foreach ( $categories as $category ) {
				echo '<span style="display: block">' . $category->name . '</span>';
			}
		} else {
			echo '<span style="text-align: center; display: block">---</span>';
		}
		?>
    </td>
    <td class="skill column-skill" style="text-transform: capitalize"
        data-colname="Skill">
		<?php
		if ( $skills ) {
			foreach ( $skills as $skill ) {
				echo '<span style="display: block">' . $skill->name . '</span>';
			}
		} else {
			echo '<span style="text-align: center; display: block">---</span>';
		}
		?>
    </td>
    <td class="country column-country" style="text-transform: capitalize"
        data-colname="Country">
		<?php
		if ( $country ) {
			echo $country[0]->name;
		} else {
			echo '<span style="text-align: center; display: block">---</span>';
		}
		?>
    </td>
    <td class="language column-language" style="text-transform: capitalize"
        data-colname="Languages">
		<?php
		if ( $languages ) {
			foreach ( $languages as $language ) {
				echo '<span style="display: block">' . $language->name . '</span>';
			}
		} else {
			echo '<span style="text-align: center; display: block">---</span>';
		}
		?>
    </td>
    <td class="profile_status column-profile_status" style="text-transform: capitalize"
        data-colname="Profile Status">
		<?php echo $user_profile_id ? 'Completed' : 'Incomplete'; ?>
    </td>
</tr>