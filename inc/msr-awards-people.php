<?php
/**
 * Nominee / judge profile rendering — escaped output for singles.
 *
 * @package msrawards
 */

/**
 * Sanitize social platform slug for Font Awesome brand icon class.
 *
 * @param mixed $platform Raw ACF value.
 * @return string Safe slug for fa-square-{slug} (empty if invalid).
 */
function msrawards_sanitize_social_platform_slug( $platform ) {
	$slug = sanitize_key( (string) $platform );
	if ( '' === $slug ) {
		return '';
	}
	if ( 'x' === $slug ) {
		$slug = 'twitter';
	}
	$allowed = array( 'facebook', 'twitter', 'linkedin', 'instagram', 'youtube', 'tiktok' );
	return in_array( $slug, $allowed, true ) ? $slug : '';
}

/**
 * Award taxonomy badges for a person post.
 *
 * @param int|null $post_id Post ID.
 * @return void
 */
function msrawards_render_award_term_badges( $post_id = null ) {
	$post_id = null === $post_id ? get_the_ID() : (int) $post_id;
	$terms   = get_the_terms( $post_id, 'award' );
	if ( ! $terms || is_wp_error( $terms ) ) {
		return;
	}
	foreach ( $terms as $term ) {
		if ( ! $term instanceof WP_Term ) {
			continue;
		}
		printf(
			'<span class="awards-person__term">%s</span>',
			esc_html( $term->name )
		);
	}
}

/**
 * Job title + company lines with icons.
 *
 * @param int|null $post_id Post ID.
 * @return void
 */
function msrawards_render_person_job_company( $post_id = null ) {
	$post_id   = null === $post_id ? get_the_ID() : (int) $post_id;
	$job_title = get_field( 'job_title', $post_id );
	$company   = get_field( 'company', $post_id );

	if ( $job_title ) {
		printf(
			'<h2 class="awards-person__job"><i class="fa fa-briefcase" aria-hidden="true"></i> %s</h2>',
			esc_html( (string) $job_title )
		);
	}
	if ( $company ) {
		printf(
			'<h3 class="awards-person__company"><i class="fa fa-building" aria-hidden="true"></i> %s</h3>',
			esc_html( (string) $company )
		);
	}
}

/**
 * Social link row from ACF repeater.
 *
 * @param int|null $post_id Post ID.
 * @return void
 */
function msrawards_render_person_social_links( $post_id = null ) {
	$post_id = null === $post_id ? get_the_ID() : (int) $post_id;
	if ( ! have_rows( 'social', $post_id ) ) {
		return;
	}
	echo '<div class="awards-person__social">';
	while ( have_rows( 'social', $post_id ) ) {
		the_row();
		$url      = (string) get_sub_field( 'link' );
		$platform = msrawards_sanitize_social_platform_slug( get_sub_field( 'platform' ) );
		if ( '' === $url || '' === $platform ) {
			continue;
		}
		printf(
			'<a class="awards-person__social-link" href="%s" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-square-%s" aria-hidden="true"></i><span class="screen-reader-text">%s</span></a>',
			esc_url( $url ),
			esc_attr( $platform ),
			esc_html( ucfirst( $platform ) )
		);
	}
	echo '</div>';
}

/**
 * WYSIWYG profile body inside entry-content.
 *
 * @param int|null $post_id Post ID.
 * @return void
 */
function msrawards_render_person_profile( $post_id = null ) {
	$post_id = null === $post_id ? get_the_ID() : (int) $post_id;
	$profile = get_field( 'profile', $post_id );
	if ( ! $profile ) {
		return;
	}
	echo '<div class="entry-content awards-person__profile">';
	echo wp_kses_post( $profile );
	echo '</div>';
}

/**
 * Primary CTA link styled as button (valid HTML — no nested button).
 *
 * @param array{url?: string, title?: string, target?: string} $link ACF link array.
 * @param string                                               $class Extra classes.
 * @return void
 */
function msrawards_render_cta_link( $link, $class = 'btn btn-primary' ) {
	if ( ! is_array( $link ) || empty( $link['url'] ) || empty( $link['title'] ) ) {
		return;
	}
	$target = ! empty( $link['target'] ) ? (string) $link['target'] : '_self';
	printf(
		'<a class="%s" href="%s" target="%s">%s</a>',
		esc_attr( $class ),
		esc_url( (string) $link['url'] ),
		esc_attr( $target ),
		esc_html( (string) $link['title'] )
	);
}
