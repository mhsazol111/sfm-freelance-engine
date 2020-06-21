<?php
/**
 * the template for displaying the freelancer work (bid success a project)
 *# this template is loaded in template/bid-history-list.php
 * @since 1.0
 * @package FreelanceEngine
 */

$author_id = get_query_var('author');
global $wp_query, $ae_post_factory, $post;
$post_object = $ae_post_factory->get(BID);
$current     = $post_object->current_post;

if(!$current || !isset( $current->project_title )){
    return;
}

$project = Employer::get_project($current->post_parent);
$id = $project->employer_id;
$employer = Employer::get_employer($id);
?>
<div class="fpp-completed-project-items">
    <div class="left-content">
        <div class="reviewer-img">
            <img src="<?php echo $employer->et_avatar_url ?>" alt="">
        </div>
        <h4><?php echo $employer->name ?></h4>
        <span><?php _e( 'Given Ratings', ET_DOMAIN ) ?></span>
        <div class="fpp-reviw-rating">
            <span class="rate-it" data-score="<?php echo $current->rating_score; ?>"></span>
        </div>
        <span class="date"><?php  _e($current->project_post_date,ET_DOMAIN)?></span>
    </div>
    <div class="right-content">
        <h4 class="project-title"><span><?php _e( 'Project:', ET_DOMAIN ) ?></span> <a href="<?php echo $current->project_link; ?>" title="<?php echo esc_attr($current->project_title) ?>"><?php echo $current->project_title ?></a></h4>
        <span><?php _e( 'Client Feedback:', ET_DOMAIN ) ?></span>
        <div class="review-content">
            <p>
            <?php if(isset($current->project_comment) && !empty($current->project_comment)){ ?>
                <?php echo $current->project_comment;?>
	        <?php } ?>
            </p>
        </div>
    </div>
</div>

