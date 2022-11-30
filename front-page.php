<?php
/**
 * The template for displaying the front page.
 */

get_header(); 
?>

<!-- Page content -->
<div id="primary" class="homepage-content-container content-area no-sidebar">
    <?php while ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
    <?php endwhile; ?>
</div>

<?php get_footer(); ?>
