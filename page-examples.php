<?php
/**
 * Template Name: Examples of elements
 *
 * This is the template that displays various elemetns and typography you create
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
<main id="primary" class="site-main ">
  <div class="container">
    <div class="row">
      <div class="col">
        <?php
        while ( have_posts() ):
          the_post();

        get_template_part( 'template-parts/content', 'page' );

        endwhile;
        ?>
        <hr>  
        <h1>Icons</h1>
        <hr>  
         
        <div class="icon-home"></div>
          
        <div class="icon-chevron-right"></div>     
          
        <hr>
          
        <h1>Typography</h1>
        
        <hr>  
          
        <h1>H1 Heading</h1>

        <h2>H2 Heading</h2>

        <h3>H3 Heading</h3>

        <h4>H4 Heading</h4>
        
        <h5>H5 Heading</h5> 
          
        <h6>H6 Heading</h6>  

        <p>Et, eget nunc risus a. Integer est dui augue viverra consequat mus. In ullamcorper interdum nunc risus adipiscing nulla. Non tristique gravida ultricies amet. Nibh id massa scelerisque adipiscing sapien. Et, ornare feugiat dui adipiscing elementum elementum. Dolor mauris diam bibendum eget.  </p>
        
        <p><a href="#">an example of a link</a></p>
          
          <ul>
              <li>list item 1</li>
              <li>list item 2</li>
              <li>list item 3</li>
              <li>list item 4</li>
              <li>list item 5</li>
          </ul>
       
        <hr>  
        <h1>Buttons</h1>
        <hr>  
        <h2>large buttons</h2>
        <a href="#" class="btn btn-primary bg-gradient btn-lg">Button</a> <a href="#" class="btn btn-primary btn-icon btn-lg">Button Icon</a> <a href="#" class="btn btn-primary bg-gradient btn-lg disabled">Button</a> <a href="#" class="btn btn-primary btn-icon btn-lg disabled">Button Icon</a>
        <p>&nbsp;</p>
        <a href="#" class="btn btn-outline-primary btn-lg">Button</a> <a href="#" class="btn btn-outline-primary btn-icon btn-lg">Button Icon</a> <a href="#" class="btn btn-outline-primary btn-lg disabled">Button</a> <a href="#" class="btn btn-outline-primary btn-icon btn-lg disabled">Button Icon</a>
        <h2>Medium buttons</h2>
        <a href="#" class="btn btn-primary ">Button</a> <a href="#" class="btn btn-primary btn-icon ">Button Icon</a> <a href="#" class="btn btn-primary disabled">Button</a> <a href="#" class="btn btn-primary btn-icon disabled">Button Icon</a>
        <p>&nbsp;</p>
        <a href="#" class="btn btn-outline-primary ">Button</a> <a href="#" class="btn btn-outline-primary btn-icon ">Button Icon</a> <a href="#" class="btn btn-outline-primary disabled">Button</a> <a href="#" class="btn btn-outline-primary btn-icon disabled">Button Icon</a>
        <h2>Small buttons</h2>
        <a href="#" class="btn btn-primary btn-sm ">Button</a> <a href="#" class="btn btn-primary btn-icon btn-sm ">Button Icon</a> <a href="#" class="btn btn-primary btn-sm disabled">Button</a> <a href="#" class="btn btn-primary btn-icon btn-sm disabled">Button Icon</a>
        <p>&nbsp;</p>
        <a href="#" class="btn btn-outline-primary btn-sm ">Button</a> <a href="#" class="btn btn-outline-primary btn-icon btn-sm ">Button Icon</a> <a href="#" class="btn btn-outline-primary btn-sm disabled">Button</a> <a href="#" class="btn btn-outline-primary btn-icon btn-sm disabled">Button Icon</a>
        <h2>Tertiary buttons</h2>
        <a href="#" class="btn btn-link btn-sm ">Button</a> <a href="#" class="btn btn-link btn-icon btn-sm ">Button Icon</a>
        <p>&nbsp;</p>
      </div>
    </div>
  </div>
</main>
<!-- #main -->

<?php
get_sidebar();
get_footer();
