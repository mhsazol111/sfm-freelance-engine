<?php $columns = get_option( 'cso_column' ); ?>
<tr>
    <td id="cb" class="manage-column column-cb check-column">
        <label class="screen-reader-text" for="cb-select-all-1">
            Select All
        </label>
        <input id="cb-select-all-1" type="checkbox" value="">
    </td>
    <th scope="col" id="name" class="manage-column column-name column-primary">Name</th>
    <th scope="col" id="email" class="manage-column column-email" style="<?php echo in_array( 'email', $columns ) ? '' : 'display: none' ?>">Email</th>
    <th scope="col" id="usertype" class="manage-column column-usertype" style="<?php echo in_array( 'type', $columns ) ? '' : 'display: none' ?>">User Type</th>
    <th scope="col" id="status" class="manage-column column-status" style="<?php echo in_array( 'a-status', $columns ) ? '' : 'display: none' ?>">Approval Status</th>
    <th scope="col" id="category" class="manage-column column-category" style="<?php echo in_array( 'category', $columns ) ? '' : 'display: none' ?>">Category</th>
    <th scope="col" id="skill" class="manage-column column-skill" style="<?php echo in_array( 'skill', $columns ) ? '' : 'display: none' ?>">Skills</th>
    <th scope="col" id="country" class="manage-column column-country" style="<?php echo in_array( 'country', $columns ) ? '' : 'display: none' ?>">Country</th>
    <th scope="col" id="city" class="manage-column column-city" style="<?php echo in_array( 'city', $columns ) ? '' : 'display: none' ?>">City</th>
    <th scope="col" id="language" class="manage-column column-language" style="<?php echo in_array( 'language', $columns ) ? '' : 'display: none' ?>">Languages</th>
    <th scope="col" id="profile_status" class="manage-column column-profile_status" style="<?php echo in_array( 'p-status', $columns ) ? '' : 'display: none' ?>">Profile Status</th>
    <th scope="col" id="phone" class="manage-column column-phone" style="<?php echo in_array( 'phone', $columns ) ? '' : 'display: none' ?>">Phone Number</th>
    <th scope="col" id="company_name" class="manage-column column-company_name" style="<?php echo in_array( 'company', $columns ) ? '' : 'display: none' ?>">Company Name</th>
    <th scope="col" id="job_title" class="manage-column column-job_title" style="<?php echo in_array( 'job-title', $columns ) ? '' : 'display: none' ?>">Job Title</th>
    <th scope="col" id="wage" class="manage-column column-wage" style="<?php echo in_array( 'wage', $columns ) ? '' : 'display: none' ?>">Daily Wage (CHF)</th>
    <th scope="col" id="nationality" class="manage-column column-nationality" style="<?php echo in_array( 'nationality', $columns ) ? '' : 'display: none' ?>">Nationality</th>
</tr>