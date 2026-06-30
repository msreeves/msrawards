<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package msrawards
 */

$context = 'listing';
if ( is_search() ) {
	$context = 'search';
} elseif ( is_category() || is_archive() || is_tax( 'award' ) ) {
	$context = 'archive';
}

msrawards_render_empty_state(
	array(
		'context' => $context,
		'search'  => is_search(),
	)
);
