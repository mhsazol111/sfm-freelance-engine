<?php
    /**
     * Template Name: FAQ
     */

    get_header();
?>

<?php
    if ( have_rows( 'faq' ) ):
        while ( have_rows( 'faq' ) ): the_row();
        ?>

    <?php if ( 'banner_section' == get_row_layout() ): ?>
        <section class="ie-banner" style="background-image:url(<?php echo get_sub_field( 'background_image' ); ?>);">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ie-banner-content">
                            <h1 class="ie-banner-title" ><?php echo get_sub_field( 'title' ); ?></h1>
                            <p class="ie-banner-description" ><?php echo get_sub_field( 'description' ); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="banner-bottom-coner">
                <a href="#">
                    <div class="bottom-btn-wrapper">
                        <p><?php echo _e( 'SPS', ET_DOMAIN ); ?> </p>
                        <img src="/wp-content/uploads/2020/04/arrow.svg" alt="arrow">
                    </div>
                </a>
            </div>
        </section>
    <?php endif;?>


<?php if ( 'faq_section' == get_row_layout() ): ?>

<section class="faq_section">
    <div class="container">
        <div class="row faq_head">
            <div class="col-md-12">
                <h1><?php echo get_sub_field( 'faq_content' )['title']; ?></h1>
                <hr>
                <h3><?php echo get_sub_field( 'faq_content' )['sub_title']; ?></h3>
            </div>
        </div>

        <div class="row faq_content">
            <div class="col-md-12">
                <?php if ( get_sub_field( 'faq_content' )['question_answer'] ): ?>
                <?php foreach ( get_sub_field( 'faq_content' )['question_answer'] as $question_answer ): ?>

                <div class="faq_row">
                    <div class="q_head">
                        <div class="icon">
                            <i class="fa fa-plus"></i>
                            <i class="fa fa-minus"></i>
                        </div>
                        <div class="q_title">
                            <h2><?php echo $question_answer['question'] ?></h2>
                            <h3 class="sub_q"><?php echo $question_answer['sub_title'] ?></h3>
                        </div>
                    </div>
                    <div class="a_content">
                        <div class="angel_content">
                            <i class="fa fa-angle-down"></i>
                        </div>
                        <p><?php echo $question_answer['answer'] ?></p>
                    </div>
                </div>

                <?php endforeach;?>
                <?php endif;?>
            </div>
        </div>
    </div>
</section>

<?php endif;?>


<?php if ( 'bottom_section' == get_row_layout() ): ?>
<section class="faq_bottom_section">
    <div class="container">
        <div class="row faq_bottom_row">
            <h3><?php echo get_sub_field( 'further_questions' )['title']; ?></h3>
            <a class="ie_btn"
                href="<?php echo get_sub_field( 'further_questions' )['button_url']; ?>"><?php echo get_sub_field( 'further_questions' )['button_text']; ?></a>
        </div>
    </div>
</section>
<?php endif;?>



<?php
    endwhile;
    endif;
?>

<?php
get_footer();