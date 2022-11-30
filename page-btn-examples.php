<?php

/* Template Name: Buttons Page */

/**
 * The template for displaying the Buttons page.
 *
 * This is the template that displays Buttons by default.
 *
 */

get_header(); 
echo create_breadcrumbs_html();

wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );

?>

    <!-- Page content -->
    <div id="primary" class="content-area no-sidebar">
        <div class="container">
            <h1><?php the_title(); ?></h1>
       
            <h2>large buttons</h2>
            <a href="#" class="btn btn-primary  btn-lg">Button</a>
            <a href="#" class="btn btn-primary btn-icon btn-lg">Button Icon</a>
            <a href="#" class="btn btn-primary btn-lg disabled">Button</a>
            <a href="#" class="btn btn-primary btn-icon btn-lg disabled">Button Icon</a>
            <p>&nbsp;</p>
            <a href="#" class="btn btn-outline-primary btn-lg">Button</a>
            <a href="#" class="btn btn-outline-primary btn-icon btn-lg">Button Icon</a>
            <a href="#" class="btn btn-outline-primary btn-lg disabled">Button</a>
            <a href="#" class="btn btn-outline-primary btn-icon btn-lg disabled">Button Icon</a>
            <h2>Medium buttons</h2>
            <a href="#" class="btn btn-primary ">Button</a>
            <a href="#" class="btn btn-primary btn-icon ">Button Icon</a>
            <a href="#" class="btn btn-primary disabled">Button</a>
            <a href="#" class="btn btn-primary btn-icon disabled">Button Icon</a>
            <p>&nbsp;</p>
            <a href="#" class="btn btn-outline-primary ">Button</a>
            <a href="#" class="btn btn-outline-primary btn-icon ">Button Icon</a>
            <a href="#" class="btn btn-outline-primary disabled">Button</a>
            <a href="#" class="btn btn-outline-primary btn-icon disabled">Button Icon</a>
            <h2>Small buttons</h2>
            <a href="#" class="btn btn-primary btn-sm ">Button</a>
            <a href="#" class="btn btn-primary btn-icon btn-sm ">Button Icon</a>
            <a href="#" class="btn btn-primary btn-sm disabled">Button</a>
            <a href="#" class="btn btn-primary btn-icon btn-sm disabled">Button Icon</a>
            <p>&nbsp;</p>
            <a href="#" class="btn btn-outline-primary btn-sm ">Button</a>
            <a href="#" class="btn btn-outline-primary btn-icon btn-sm ">Button Icon</a>
            <a href="#" class="btn btn-outline-primary btn-sm disabled">Button</a>
            <a href="#" class="btn btn-outline-primary btn-icon btn-sm disabled">Button Icon</a>
            <h2>Tertiary buttons</h2>
            <a href="#" class="btn btn-link btn-sm ">Button</a>
            <a href="#" class="btn btn-link btn-icon btn-sm ">Button Icon</a>
<!--            <a href="#" class="btn btn-link btn-sm disabled">Button</a>
            <a href="#" class="btn btn-link btn-icon btn-sm disabled">Button Icon</a>-->
            <p>&nbsp;</p>
            <?php the_content() ?>
        </div>
    </div>

<?php get_footer(); ?>
