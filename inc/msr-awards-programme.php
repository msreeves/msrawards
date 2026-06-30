<?php
/**
 * Awards programme surfaces — season lifecycle timeline and judging transparency.
 *
 * @package msrawards
 */

/**
 * Season phases for demo lifecycle messaging.
 *
 * @return array<string, array{label: string, description: string}>
 */
function msrawards_get_season_phases() {
	return array(
		'entries'   => array(
			'label'       => __( 'Entries open', 'msrawards' ),
			'description' => __( 'Nomination window open for eligible entrants across MSR Awards categories.', 'msrawards' ),
		),
		'judging'   => array(
			'label'       => __( 'Judging in progress', 'msrawards' ),
			'description' => __( 'Independent panel review underway with category-specific scoring criteria.', 'msrawards' ),
		),
		'shortlist' => array(
			'label'       => __( 'Shortlist published', 'msrawards' ),
			'description' => __( 'Category shortlists announced ahead of the ceremony programme.', 'msrawards' ),
		),
		'winners'   => array(
			'label'       => __( 'Winners announced', 'msrawards' ),
			'description' => __( 'Winners revealed at the ceremony and featured in Atlas Briefing coverage.', 'msrawards' ),
		),
	);
}

/**
 * Active season phase slug (option override with seed script).
 *
 * @return string
 */
function msrawards_get_season_phase() {
	$phases  = msrawards_get_season_phases();
	$default = 'judging';
	$stored  = sanitize_key( (string) get_option( 'msr_awards_season_phase', $default ) );

	return isset( $phases[ $stored ] ) ? $stored : $default;
}

/**
 * Season lifecycle timeline for home and trust surfaces.
 *
 * @return void
 */
function msrawards_render_season_timeline() {
	$phases = msrawards_get_season_phases();
	$active = msrawards_get_season_phase();
	if ( ! isset( $phases[ $active ] ) ) {
		return;
	}

	$active_label = $phases[ $active ]['label'];
	?>
	<section class="awards-season-timeline msr-reveal" aria-labelledby="awards-season-heading">
		<div class="container">
			<header class="awards-season-timeline__header text-center mb-4">
				<h2 id="awards-season-heading" class="h4 awards-season-timeline__title mb-2">
					<?php esc_html_e( 'Awards season timeline', 'msrawards' ); ?>
				</h2>
				<p class="awards-season-timeline__status mb-0">
					<?php
					printf(
						/* translators: %s: current season phase label */
						esc_html__( 'Current phase: %s', 'msrawards' ),
						esc_html( $active_label )
					);
					?>
				</p>
			</header>
			<ol class="awards-season-timeline__list list-unstyled mb-0">
				<?php foreach ( $phases as $slug => $phase ) : ?>
					<?php
					$is_active = ( $slug === $active );
					$item_cls  = 'awards-season-timeline__item';
					if ( $is_active ) {
						$item_cls .= ' is-active';
					}
					?>
					<li class="<?php echo esc_attr( $item_cls ); ?>">
						<div class="awards-season-timeline__marker" aria-hidden="true"></div>
						<div class="awards-season-timeline__body">
							<h3 class="h6 awards-season-timeline__label mb-1"><?php echo esc_html( $phase['label'] ); ?></h3>
							<p class="small awards-season-timeline__copy mb-0"><?php echo esc_html( $phase['description'] ); ?></p>
						</div>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
	</section>
	<?php
}

/**
 * Judging transparency narrative for judges and trust routes.
 *
 * @return void
 */
function msrawards_render_judging_transparency() {
	$steps = array(
		array(
			'title' => __( 'Independent review process', 'msrawards' ),
			'copy'  => __( 'Category judges review submissions against published criteria. Scores are captured in a structured workflow suitable for portfolio demonstration of fairness controls.', 'msrawards' ),
		),
		array(
			'title' => __( 'Conflict of interest checks', 'msrawards' ),
			'copy'  => __( 'Judges declare category relationships before scoring. Conflicted reviewers are excluded from affected nominee reviews in production operations.', 'msrawards' ),
		),
		array(
			'title' => __( 'Blind review and embargo', 'msrawards' ),
			'copy'  => __( 'Entrant identities can be anonymised during scoring. Shortlist and winner outcomes remain embargoed until the ceremony programme is published.', 'msrawards' ),
		),
	);
	?>
	<section class="awards-judging-transparency" aria-labelledby="awards-judging-transparency-heading">
		<header class="mb-3">
			<h2 id="awards-judging-transparency-heading" class="h4 awards-judging-transparency__title mb-2">
				<?php esc_html_e( 'How judging works', 'msrawards' ); ?>
			</h2>
			<p class="awards-judging-transparency__lead mb-0">
				<?php esc_html_e( 'Transparency controls for entrants, judges, and sponsors — demonstration copy for portfolio review of a modern awards programme.', 'msrawards' ); ?>
			</p>
		</header>
		<div class="row g-3">
			<?php foreach ( $steps as $step ) : ?>
				<div class="col-md-4">
					<div class="awards-judging-transparency__card h-100">
						<h3 class="h6 awards-judging-transparency__card-title mb-2"><?php echo esc_html( $step['title'] ); ?></h3>
						<p class="small awards-judging-transparency__card-copy mb-0"><?php echo esc_html( $step['copy'] ); ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</section>
	<?php
}
