<?php
$rating = 0;
$int = 0;
$frac = 0;
$leftover= 0;
$rand = 0;
$percent = 0;

$tooltip = ($override = get_field('tooltip_override')) ? $override : get_field('rating_tooltip', 'option');
$tooltip_link = get_field('method_link', 'option');

if($args['rating']) {
  $rating = $args['rating'];
  $int = floor($rating);
  $frac = $rating - $int;
  $leftover = 5 - ceil($rating);
  $rand = rand(0, 99999);
  $percent = $frac  * 100;
}
//echo $percent;
?>

<div class="rating-container">
  <svg style="width: 0; height: 0;" width="0" height="0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 23">
    <defs>
      <linearGradient id="half-<?php echo $rand; ?>" x1="0" x2="100%" y1="0" y2="0">
        <stop offset="<?php echo $percent; ?>%" stop-color="#006ADE"></stop>
        <stop offset="<?php echo $percent; ?>%" stop-color="#D2D2D2"></stop>
      </linearGradient>

      <symbol width="24" height="23" viewBox="0 0 24 23" id="star" xmlns="http://www.w3.org/2000/svg">
        <path d="M12.0188 0L15.6995 7.56579L24 8.77632L18.0282 14.6776L19.4178 23L12.0188 19.0658L4.58216 23L6.00939 14.6776L0 8.77632L8.30047 7.56579L12.0188 0Z" />
      </symbol>
    </defs>
  </svg>
  <div class="d-inline-flex align-items-center">
    <div class="stars position-relative d-inline-flex">
      <?php for ($i = 0; $i < $int; $i++) : ?>
        <svg class="star" xmlns="http://www.w3.org/2000/svg" width="24" height="23" viewBox="0 0 24 23">
          <use xlink:href="#star"></use>
        </svg>
      <?php endfor; ?>
      <?php if ($frac > 0) : ?>
        <svg class="star" xmlns="http://www.w3.org/2000/svg" width="24" height="23" viewBox="0 0 24 23">
          <use xlink:href="#star" fill="url(#half-<?php echo $rand; ?>)"></use>
        </svg>
      <?php endif; ?>
      <?php for ($i = 0; $i < $leftover; $i++) : ?>
        <svg class="star inactive" xmlns="http://www.w3.org/2000/svg" width="24" height="23" viewBox="0 0 24 23">
          <use xlink:href="#star"></use>
        </svg>
      <?php endfor; ?>
  
    </div>
    <h4 class="ml-2 font-weight-bold rating-number leading-none mb-0"><?php echo $rating; ?></h4>
    <?php if($args['show_tooltip']) : ?>
      <div class="dropdown position-relative tooltip-dropdown">
        <button id="dropdownMenuButton" class="ml-2 rating-tooltip p-0 dropdown-toggle" type="button" id="dropdown-<?php echo $rand; ?>" data-toggle="dropdown" aria-expanded="false">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 7 16 16" height="16" width="16"><path d="M8.40039 16.7852H6.90625C6.90234 16.5703 6.90039 16.4395 6.90039 16.3926C6.90039 15.9082 6.98047 15.5098 7.14062 15.1973C7.30078 14.8848 7.62109 14.5332 8.10156 14.1426C8.58203 13.752 8.86914 13.4961 8.96289 13.375C9.10742 13.1836 9.17969 12.9727 9.17969 12.7422C9.17969 12.4219 9.05078 12.1484 8.79297 11.9219C8.53906 11.6914 8.19531 11.5762 7.76172 11.5762C7.34375 11.5762 6.99414 11.6953 6.71289 11.9336C6.43164 12.1719 6.23828 12.5352 6.13281 13.0234L4.62109 12.8359C4.66406 12.1367 4.96094 11.543 5.51172 11.0547C6.06641 10.5664 6.79297 10.3223 7.69141 10.3223C8.63672 10.3223 9.38867 10.5703 9.94727 11.0664C10.5059 11.5586 10.7852 12.1328 10.7852 12.7891C10.7852 13.1523 10.6816 13.4961 10.4746 13.8203C10.2715 14.1445 9.83398 14.5859 9.16211 15.1445C8.81445 15.4336 8.59766 15.666 8.51172 15.8418C8.42969 16.0176 8.39258 16.332 8.40039 16.7852ZM6.90625 19V17.3535H8.55273V19H6.90625Z" fill="#006ADE"></path><circle cx="8" cy="15" r="7.25" stroke="#006ADE" stroke-width="1.5"></circle></svg>
        </button>
        <div class="tooltip-container dropdown-menu" aria-labelledby="dropdown-<?php echo $rand; ?>">
          <?php if($tooltip) : ?>
          <div>
            <div class="content">
              <?php echo $tooltip; ?>
            </div>
            <div class="link">
              <a href="<?php echo $tooltip_link['url'] ?>"><?php echo $tooltip_link['title'] ?> ></a>
            </div>
          </div>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>

  </div>
</div>
