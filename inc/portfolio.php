<?php
/**
 * Portfolio demonstration surfaces — stats, featured nominees, CTA preview copy.
 *
 * @package msrawards
 */

/**
 * Published count for a post type.
 *
 * @param string $post_type Post type slug.
 * @return int
 */
function msrawards_count_published( $post_type ) {
	$counts = wp_count_posts( $post_type );
	if ( ! $counts || ! isset( $counts->publish ) ) {
		return 0;
	}
	return (int) $counts->publish;
}

/**
 * Social proof stats for the awards programme home.
 *
 * @return array<int, array{value: string, label: string}>
 */
function msrawards_get_programme_stats() {
	$categories = get_terms(
		array(
			'taxonomy'   => 'award',
			'hide_empty' => false,
			'fields'     => 'count',
		)
	);
	$cat_count  = is_wp_error( $categories ) ? 0 : (int) $categories;
	$nominees   = msrawards_count_published( 'nominee' );
	$judges     = msrawards_count_published( 'judge' );

	return array(
		array(
			'value' => $cat_count > 0 ? (string) $cat_count : '8',
			'label' => __( 'Award categories', 'msrawards' ),
		),
		array(
			'value' => $nominees > 0 ? (string) $nominees : '24',
			'label' => __( 'Nominees', 'msrawards' ),
		),
		array(
			'value' => $judges > 0 ? (string) $judges : '12',
			'label' => __( 'Judges', 'msrawards' ),
		),
		array(
			'value' => '2026',
			'label' => __( 'Ceremony season', 'msrawards' ),
		),
	);
}

/**
 * Featured nominees for home.
 *
 * @param int $limit Max cards.
 * @return array<int, array{title: string, meta: string, url: string, summary: string}>
 */
function msrawards_get_featured_nominees( $limit = 3 ) {
	$query = new WP_Query(
		array(
			'post_type'              => 'nominee',
			'post_status'            => 'publish',
			'posts_per_page'         => $limit,
			'orderby'                => 'date',
			'order'                  => 'DESC',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => true,
		)
	);

	$items = array();
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$terms = get_the_terms( get_the_ID(), 'award' );
			$meta  = '';
			if ( is_array( $terms ) && ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				$meta = $terms[0]->name;
			}
			$raw = has_excerpt() ? get_the_excerpt() : wp_strip_all_tags( (string) get_the_content( null, false ) );
			if ( '' === trim( (string) $raw ) && function_exists( 'get_field' ) ) {
				$profile = trim( (string) get_field( 'profile', get_the_ID() ) );
				$job     = trim( (string) get_field( 'job_title', get_the_ID() ) );
				$company = trim( (string) get_field( 'company', get_the_ID() ) );
				$bits    = array_filter( array( $job, $company ) );
				$lead    = $bits ? implode( ' · ', $bits ) . '. ' : '';
				$raw     = trim( $lead . $profile );
			}
			$items[] = array(
				'title'   => get_the_title(),
				'meta'    => $meta,
				'url'     => get_permalink(),
				'summary' => $raw ? wp_trim_words( $raw, 28, '…' ) : '',
			);
		}
		wp_reset_postdata();
	}

	return $items;
}

/**
 * Season format label for hero (portfolio default).
 *
 * @return string
 */
function msrawards_get_programme_format_label() {
	$label = (string) apply_filters( 'msrawards_programme_format_label', __( 'Awards season · judging in progress', 'msrawards' ) );
	return trim( $label );
}

/**
 * Primary header CTA with portfolio preview note.
 *
 * @return void
 */
function msrawards_render_header_cta() {
	if ( ! function_exists( 'msr_get_primary_cta' ) ) {
		return;
	}

	$cta = msr_get_primary_cta();
	if ( empty( $cta['label'] ) || empty( $cta['url'] ) ) {
		return;
	}

	$nominees_url = msrawards_get_page_url( 'nominees', '/nominees/' );
	$entrants_url = msrawards_get_page_url( 'for-entrants', '/for-entrants/' );
	$main_url     = $nominees_url ? $nominees_url : (string) $cta['url'];
	$sub_url      = $entrants_url ? $entrants_url : $main_url;
	?>
	<div class="msr-primary-cta msr-primary-cta--awards">
		<div class="msr-primary-cta__actions">
			<a class="btn btn-primary msr-primary-cta__main" href="<?php echo esc_url( $main_url ); ?>"><?php echo esc_html( (string) $cta['label'] ); ?></a>
			<?php if ( ! empty( $cta['sub'] ) ) : ?>
			<a class="btn btn-outline-primary msr-primary-cta__sub" href="<?php echo esc_url( $sub_url ); ?>"><?php echo esc_html( (string) $cta['sub'] ); ?></a>
			<?php endif; ?>
		</div>
		<p class="msr-primary-cta__preview small mb-0"><?php esc_html_e( 'Preview — entries open at launch', 'msrawards' ); ?></p>
	</div>
	<?php
}

/**
 * Programme stats strip (social proof).
 *
 * @return void
 */
function msrawards_render_programme_stats() {
	$stats = msrawards_get_programme_stats();
	if ( ! $stats ) {
		return;
	}
	?>
	<section class="awards-programme-stats msr-reveal" aria-labelledby="awards-programme-stats-heading">
		<div class="container">
			<h2 id="awards-programme-stats-heading" class="visually-hidden"><?php esc_html_e( 'Awards programme at a glance', 'msrawards' ); ?></h2>
			<ul class="awards-programme-stats__list list-unstyled mb-0">
				<?php foreach ( $stats as $stat ) : ?>
				<li class="awards-programme-stats__item">
					<p class="awards-programme-stats__value mb-0"><?php echo esc_html( $stat['value'] ); ?></p>
					<p class="awards-programme-stats__label mb-0"><?php echo esc_html( $stat['label'] ); ?></p>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
	<?php
}

/**
 * Featured nominees band for programme home.
 *
 * @return void
 */
function msrawards_render_featured_nominees() {
	$nominees = msrawards_get_featured_nominees( 3 );
	if ( ! $nominees ) {
		return;
	}
	$archive_url = msrawards_get_page_url( 'nominees', '/nominees/' );
	?>
	<section class="awards-featured-nominees msr-reveal" aria-labelledby="awards-featured-nominees-heading">
		<div class="container">
			<header class="awards-featured-nominees__header text-center">
				<h2 id="awards-featured-nominees-heading" class="h4 awards-featured-nominees__title mb-2">
					<?php esc_html_e( 'Featured nominees', 'msrawards' ); ?>
				</h2>
				<p class="awards-featured-nominees__lead mb-0">
					<?php esc_html_e( 'A sample of shortlisted profiles from the seeded programme — swap for live shortlists before ceremony night.', 'msrawards' ); ?>
				</p>
				<?php if ( $archive_url ) : ?>
				<div class="awards-featured-nominees__cta awards-ctas">
					<a class="btn btn-outline-primary awards-featured-nominees__nominees-btn" href="<?php echo esc_url( $archive_url ); ?>"><?php esc_html_e( 'Browse all nominees', 'msrawards' ); ?></a>
				</div>
				<?php endif; ?>
			</header>
			<ul class="awards-featured-nominees__grid list-unstyled mb-0">
				<?php foreach ( $nominees as $nominee ) : ?>
				<li class="awards-featured-nominees__item panel">
					<article class="awards-featured-nominees__card">
						<a class="awards-featured-nominees__card-link" href="<?php echo esc_url( $nominee['url'] ); ?>">
							<h3 class="h6 awards-featured-nominees__nominee-title mb-0"><?php echo esc_html( $nominee['title'] ); ?></h3>
						</a>
						<?php if ( ! empty( $nominee['meta'] ) ) : ?>
						<ul class="awards-featured-nominees__chips list-unstyled mb-0" role="list">
							<li>
								<span class="awards-featured-nominees__chip"><?php echo esc_html( $nominee['meta'] ); ?></span>
							</li>
						</ul>
						<?php endif; ?>
						<?php if ( ! empty( $nominee['summary'] ) ) : ?>
						<p class="awards-featured-nominees__summary mb-0"><?php echo esc_html( $nominee['summary'] ); ?></p>
						<?php endif; ?>
					</article>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
	<?php
}

add_filter(
	'msr_primary_cta',
	static function ( $cta, $ctx ) {
		if ( 'awards' !== $ctx || ! is_array( $cta ) ) {
			return $cta;
		}
		$nominees_url = msrawards_get_page_url( 'nominees', '/nominees/' );
		if ( $nominees_url ) {
			$cta['url'] = $nominees_url;
		}
		$entrants_url = msrawards_get_page_url( 'for-entrants', '/for-entrants/' );
		if ( $entrants_url ) {
			$cta['sub_url'] = $entrants_url;
		}
		return $cta;
	},
	10,
	2
);
