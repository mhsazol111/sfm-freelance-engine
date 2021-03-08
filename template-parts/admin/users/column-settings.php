<?php $columns = get_option( 'cso_column' ); ?>
<div class="custom-screen-option">
    <form id="cso-save-form">
        <div class="cso-checkboxes">
            <div class="cso-input">
                <label for="cso-email">
                    <input type="checkbox" value="email" id="cso-email" name="cso-email" <?php echo in_array( 'email', $columns ) ? 'checked' : '' ?>> Email
                </label>
            </div>
            <div class="cso-input">
                <label for="cso-type">
                    <input type="checkbox" value="type" id="cso-type" name="cso-type" <?php echo in_array( 'type', $columns ) ? 'checked' : '' ?>> User Type
                </label>
            </div>
            <div class="cso-input">
                <label for="cso-a-status">
                    <input type="checkbox" value="a-status" id="cso-a-status" name="cso-a-status" <?php echo in_array( 'a-status', $columns ) ? 'checked' : '' ?>> Approval
                    Status
                </label>
            </div>
            <div class="cso-input">
                <label for="cso-category">
                    <input type="checkbox" value="category" id="cso-category" name="cso-category" <?php echo in_array( 'category', $columns ) ? 'checked' : '' ?>> Category
                </label>
            </div>
            <div class="cso-input">
                <label for="cso-skill">
                    <input type="checkbox" value="skill" id="cso-skill" name="cso-skill" <?php echo in_array( 'skill', $columns ) ? 'checked' : '' ?>> Skill
                </label>
            </div>
            <div class="cso-input">
                <label for="cso-country">
                    <input type="checkbox" value="country" id="cso-country" name="cso-country" <?php echo in_array( 'country', $columns ) ? 'checked' : '' ?>> Country
                </label>
            </div>
            <div class="cso-input">
                <label for="cso-city">
                    <input type="checkbox" value="city" id="cso-city" name="cso-city" <?php echo in_array( 'city', $columns ) ? 'checked' : '' ?>> City
                </label>
            </div>
            <div class="cso-input">
                <label for="cso-language">
                    <input type="checkbox" value="language" id="cso-language" name="cso-language" <?php echo in_array( 'language', $columns ) ? 'checked' : '' ?>> Languages
                </label>
            </div>
            <div class="cso-input">
                <label for="cso-p-status">
                    <input type="checkbox" value="p-status" id="cso-p-status" name="cso-p-status" <?php echo in_array( 'p-status', $columns ) ? 'checked' : '' ?>> Profile Status
                </label>
            </div>
            <div class="cso-input">
                <label for="cso-phone">
                    <input type="checkbox" value="phone" id="cso-phone" name="cso-phone" <?php echo in_array( 'phone', $columns ) ? 'checked' : '' ?>> Phone Number
                </label>
            </div>
            <div class="cso-input">
                <label for="cso-company">
                    <input type="checkbox" value="company" id="cso-company" name="cso-company" <?php echo in_array( 'company', $columns ) ? 'checked' : '' ?>> Company Name
                </label>
            </div>
            <div class="cso-input">
                <label for="cso-job-title">
                    <input type="checkbox" value="job-title" id="cso-job-title" name="cso-job-title" <?php echo in_array( 'job-title', $columns ) ? 'checked' : '' ?>> Job Title
                </label>
            </div>
            <div class="cso-input">
                <label for="cso-wage">
                    <input type="checkbox" value="wage" id="cso-wage" name="cso-wage" <?php echo in_array( 'wage', $columns ) ? 'checked' : '' ?>> Daily Wage
                </label>
            </div>
            <div class="cso-input">
                <label for="cso-nationality">
                    <input type="checkbox" value="nationality" id="cso-nationality" name="cso-nationality" <?php echo in_array( 'nationality', $columns ) ? 'checked' : '' ?>> Nationality
                </label>
            </div>
        </div>

        <div class="cso-save-btn">
            <button type="submit">Save</button>
        </div>

    </form>
    <div id="screen-meta-links">
        <button type="button" id="show-col-settings" class="button show-settings">Column Options</button>
    </div>
</div>