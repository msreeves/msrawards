<?php
/**
 * Theme setup — body class and programme shell hooks.
 *
 * @package msrawards
 */

/**
 * Programme body class for scoped SCSS (see _awards-layout.scss, _awards-filter-bar.scss).
 *
 * @param string[] $classes Body classes.
 * @return string[]
 */
function msrawards_body_classes( $classes ) {
	$classes[] = 'msr-awards';
	$classes[] = 'msr-assets-self-hosted';
	return $classes;
}
add_filter( 'body_class', 'msrawards_body_classes' );

/**
 * Core theme supports (document title, HTML5).
 */
function msrawards_theme_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
}
add_action( 'after_setup_theme', 'msrawards_theme_setup' );
