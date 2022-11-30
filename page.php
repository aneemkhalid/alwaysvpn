<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wp-alwaysvpn
 */

get_header();
?>

    <!-- Page content -->
    <div id="primary" class=" content-area no-sidebar">
        <div class="container">
            <div class="row">
                <main id="main" class="col-md-12 site-main main-content">
                    <?php while ( have_posts() ) : the_post(); ?>

                        <?php get_template_part( 'template-parts/content', 'page' ); ?>

                

                    <?php endwhile; // end of the loop. ?>
                </main>
            </div>
        </div>
    </div>

<?php

get_footer();
