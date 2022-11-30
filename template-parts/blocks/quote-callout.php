<?php

/**
 * Add Featured Quote Block.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$quote = get_field('quote');
$author_first_name = get_field('author_first_name');
$author_last_name = get_field('author_last_name');
$title = get_field('author_title');
$return = '';
if ($quote){
	$return .= '
	<div class="quote-callout d-flex">
		<blockquote class="quote-text-wrapper">
			<p class="quote mb-1"><span class="open-quote">&ldquo;</span><span class="quote-body">'.$quote.'</span><span class="close-quote">&rdquo;</span></p>
			<p class="cite mb-0">'.$author_first_name.' '.$author_last_name;
			$return .= ($title) ? ', '.$title : '';
			$return .= '</p>
		</blockquote>	
	</div>';
}
echo $return;