<?php
$author = get_field('author');
$author_type = get_field('author_type');

if($author){
  $authorName = get_the_title($author);
  $authorLink = get_permalink($author);
  $authorImageURL = get_the_post_thumbnail_url($author);
  $author_image = '';
  if($authorImageURL){
      $author_image = '<img src="'.get_the_post_thumbnail_url($author).'" width="50" height="50" alt="'.$authorName.'" />';
  }
}else{
  $authorName = get_the_author();
  $author_image = '';
}
if($author_type == 'Editor') {
  $authorName = 'Edited by: ' . $authorName;
}

?>

<div class="author-wrapper">
  <a href="<?php echo $authorLink; ?>" class="author-info">
      <?php echo $author_image; ?>
      <p>
          <?php echo $authorName; ?>
          <span>Last updated: <?php the_date(); ?></span>
      </p>
  </a>
  <div class="social-share">
      <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink(); ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri() . '/images/icons/fb-avpn.svg' ?>" alt="facebook icon" width="30" height="30" /></a>
      <a href="https://twitter.com/intent/tweet?url=<?php echo get_permalink(); ?>&text=<?php the_title(); ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri() . '/images/icons/twitter-avpn.svg' ?>" alt="twitter icon" width="30" height="30"></a>
  </div>
</div>