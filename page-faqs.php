<?php

/* Template Name: FAQPage */

/**
 * The template for displaying the FAQ page.
 *
 * This is the template that displays FAQs by default.
 *
 */

get_header(); 
echo create_breadcrumbs_html();

wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );

?>

    <!-- Page content -->
    <div id="primary" class="content-area no-sidebar">
        <div class="container faq-container">
            <h1 class="faq-page-title"><?php the_title(); ?></h1>
            <?php the_content() ?>
        </div>
    </div>

<?php get_footer(); ?>
