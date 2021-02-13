<tr>
    <th scope="row" class="check-column">
        <label class="screen-reader-text"
               for="user_<?php echo $user->id; ?>">Select <?php echo $user->user_nicename; ?>
        </label>
        <input type="checkbox" name="users[]" id="user_<?php echo $user->id; ?>"
               value="<?php echo $user->id; ?>">
    </th>
    <td class="name column-username has-row-actions column-primary"
        data-colname="Name">
        <a href="<?php echo esc_url( get_edit_user_link( $user->id ) ); ?>"><?php echo $user->display_name; ?></a>
        <br/>
        <button type="button" class="toggle-row">
            <span class="screen-reader-text">Show more details</span>
        </button>
    </td>
    <td class="email column-email"
        data-colname="Email"><?php echo $user->user_email; ?></td>
    <td class="username column-username"
        data-colname="Username"><?php echo $user->user_nicename; ?></td>
    <td class="status column-status" style="text-transform: capitalize"
        data-colname="Status">
		<?php echo ( get_user_meta( $user->id, 'account_status', true ) == 'active' ) ? 'Approved' : 'Pending'; ?>
    </td>
    <td class="status column-profile_status" style="text-transform: capitalize"
        data-colname="Profile Status">
		<?php echo ( get_user_meta( $user->id, 'user_profile_id', true ) ) ? 'Completed' : 'Incomplete'; ?>
    </td>
</tr>