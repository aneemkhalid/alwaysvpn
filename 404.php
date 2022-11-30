<?php
/**
 * The template for displaying 404 pages (not found).
 *
 */

get_header();
echo create_breadcrumbs_html();
?>




<!-- Remove the current image

Center the existing text 

Update the styling (text & button) to match the style guide -->

	<!-- Page content -->
	<div id="primary" class="content-area">
	    <main id="main" class="error-404-container">
            <div class="error-404-content-container">
                <h2 class="page-title">Sorry, this page does not exist</h2>
                <p class="text-left">Oops, something went wrong! The link you clicked might be corrupted, or the page may have been removed.</p>
                <div class="error-404-button-container">
                    <a class="blue-button" href="<?php echo esc_url(get_site_url()); ?>">Back to Home</a>
                </div>
            </div>
		</main>
	</div>

<?php get_footer(); ?>