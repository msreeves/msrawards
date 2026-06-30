<?php
/**
 * Template part for displaying results in search pages
 *
 * @package msrawards
 */

get_template_part(
	'template-parts/cards/post-card',
	null,
	array(
		'category_depth' => 'all',
		'variant'        => 'search',
	)
);
