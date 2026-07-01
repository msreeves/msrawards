<?php
/**
 * Awards SEO — meta description (supersedes legacy tenweb_meta_description).
 *
 * @package msrawards
 */

/**
 * Whether copy looks like Latin / lorem placeholder (not programme meta).
 *
 * @param string $text Plain text.
 * @return bool
 */
function msrawards_seo_is_placeholder_copy( $text ) {
	$text = strtolower( trim( wp_strip_all_tags( $text ) ) );
	if ( '' === $text ) {
		return true;
	}

	$patterns = array(
		'lorem ipsum',
		'class aptent taciti',
		'dolor sit amet',
		'ut et neque lacus',
		'in et arcu eu dui',
		'nulla consequat et mas',
	);

	foreach ( $patterns as $pattern ) {
		if ( str_contains( $text, $pattern ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Curated meta descriptions for programme archive pages (slug-keyed).
 *
 * @return array<string, string>
 */
function msrawards_seo_curated_page_descriptions() {
	return array(
		'nominees'     => msrawards_get_seo_nominees_description(),
		'partners'    => __( 'Meet sponsors and partners supporting MSR Awards categories, from main ceremony partners to category supporters.', 'msrawards' ),
		'topics'      => __( 'Explore MSR Awards programme news by topic—filter stories on shortlisting, judging, and sponsor announcements.', 'msrawards' ),
		'judges'      => __( 'Meet the independent judging panel reviewing nominees across MSR Awards categories and how judging works.', 'msrawards' ),
		'for-entrants' => __( 'Walk through nomination steps, season timelines, and judging transparency for MSR Awards entrants.', 'msrawards' ),
		'gallery'     => __( 'Ceremony and programme photography from the MSR Awards demonstration season.', 'msrawards' ),
		'about-us'    => __( 'MSR Awards is a demonstration recognition programme within the MSR WordPress ecosystem.', 'msrawards' ),
	);
}

/**
 * Normalise and trim a meta description string.
 *
 * @param string $description Raw description.
 * @return string
 */
function msrawards_seo_normalize_description( $description ) {
	$description = wp_strip_all_tags( (string) $description );
	$description = strip_shortcodes( $description );
	$description = preg_replace( '/\s+/', ' ', $description );
	$description = trim( (string) $description );

	if ( '' === $description || msrawards_seo_is_placeholder_copy( $description ) ) {
		return '';
	}

	return mb_substr( $description, 0, 300, 'UTF-8' );
}

/**
 * Meta description for a singular page or CPT.
 *
 * @param WP_Post $post Post object.
 * @return string
 */
function msrawards_seo_description_for_post( WP_Post $post ) {
	$excerpt = msrawards_seo_normalize_description( $post->post_excerpt );
	if ( '' !== $excerpt ) {
		return $excerpt;
	}

	$curated = msrawards_seo_curated_page_descriptions();
	$slug    = sanitize_title( (string) $post->post_name );
	if ( isset( $curated[ $slug ] ) ) {
		return msrawards_seo_normalize_description( $curated[ $slug ] );
	}

	return msrawards_seo_normalize_description( $post->post_content );
}

/**
 * @return void
 */
function msrawards_render_meta_description() {
	if ( is_admin() ) {
		return;
	}

	if ( is_singular() ) {
		global $post;
		if ( ! $post instanceof WP_Post ) {
			return;
		}

		$description = msrawards_seo_description_for_post( $post );
		if ( '' !== $description ) {
			echo '<meta name="description" content="' . esc_attr( $description ) . '" />' . "\n";
		}
		return;
	}

	if ( is_home() || is_front_page() ) {
		$description = msrawards_seo_normalize_description( (string) get_bloginfo( 'description' ) );
		if ( '' === $description ) {
			$description = msrawards_seo_normalize_description( msrawards_get_seo_home_description() );
		}
		if ( '' !== $description ) {
			echo '<meta name="description" content="' . esc_attr( $description ) . '" />' . "\n";
		}
		return;
	}

	if ( is_category() ) {
		$description = msrawards_seo_normalize_description( (string) category_description() );
		if ( '' !== $description ) {
			echo '<meta name="description" content="' . esc_attr( $description ) . '" />' . "\n";
		}
	}
}
add_action( 'wp_head', 'msrawards_render_meta_description', 1 );

/**
 * Ensure every front-end view has a non-empty document title.
 *
 * @param string[] $parts Title parts.
 * @return string[]
 */
function msrawards_document_title_parts( $parts ) {
	$title = isset( $parts['title'] ) ? trim( (string) $parts['title'] ) : '';
	if ( '' !== $title ) {
		return $parts;
	}

	if ( is_front_page() || is_home() ) {
		$parts['title'] = get_bloginfo( 'name', 'display' );
	} elseif ( is_singular() ) {
		$parts['title'] = get_the_title();
	} elseif ( is_category() || is_tax() ) {
		$parts['title'] = single_term_title( '', false );
	} elseif ( is_search() ) {
		$parts['title'] = sprintf(
			/* translators: %s: search query */
			__( 'Search: %s', 'msrawards' ),
			get_search_query()
		);
	} elseif ( is_404() ) {
		$parts['title'] = __( 'Page not found', 'msrawards' );
	} else {
		$parts['title'] = get_bloginfo( 'name', 'display' );
	}

	if ( ! is_front_page() && ! is_home() ) {
		$parts['site'] = get_bloginfo( 'name', 'display' );
	}

	return $parts;
}
add_filter( 'document_title_parts', 'msrawards_document_title_parts', 20 );
