<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package wp-alwaysvpn
 */

get_header();
?>

	<main id="primary" class="site-main brad-here-single">
        <div class="container">   
            <div class="row">
                <div class="col">
                    <?php
                    while ( have_posts() ) :
                        the_post();

                        get_template_part( 'template-parts/content', get_post_type() );

                    endwhile; // End of the loop.
				?>
                </div>
            </div>
        </div>
	</main><!-- #main -->

<?php
get_footer();
