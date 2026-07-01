<?php
/**
 * MSR ecosystem outbound links — Events hub, Atlas Briefing, ceremony event.
 *
 * @package msrawards
 */

/**
 * Default ecosystem destinations (local demo URLs).
 *
 * @return array<string, array{label: string, url: string, description: string, cta: string}>
 */
function msrawards_get_ecosystem_link_defaults() {
	return array(
		'hub'        => array(
			'label'       => __( 'MSR Events hub', 'msrawards' ),
			'url'         => 'http://msrevents.local:8888/',
			'description' => __( 'Discover programmes, browse the events archive, and follow ceremony routing across the MSR demonstration estate.', 'msrawards' ),
			'cta'         => __( 'Visit the events hub', 'msrawards' ),
		),
		'publishing' => array(
			'label'       => __( 'Atlas Briefing insights', 'msrawards' ),
			'url'         => 'http://127.0.0.1:8888/sites/wp/msrpublishing/insights/',
			'description' => __( 'Winner stories, industry commentary, and resource library content from the Atlas Briefing publisher demo.', 'msrawards' ),
			'cta'         => __( 'Read Atlas Briefing', 'msrawards' ),
		),
		'ceremony'   => array(
			'label'       => __( 'Awards ceremony event', 'msrawards' ),
			'url'         => 'http://msrevents.local:8888/event/msrawards/',
			'description' => __( 'Ceremony and programme detail on the MSR Events hub — how the awards season connects to live event pages.', 'msrawards' ),
			'cta'         => __( 'View ceremony page', 'msrawards' ),
		),
	);
}

/**
 * Option keys for admin-first URL overrides (seed via msr-awards-options-seed.php).
 *
 * @return array<string, string>
 */
function msrawards_get_ecosystem_option_keys() {
	return array(
		'hub'        => 'msr_awards_ecosystem_hub_url',
		'publishing' => 'msr_awards_ecosystem_publishing_url',
		'ceremony'   => 'msr_awards_ecosystem_ceremony_url',
	);
}

/**
 * Resolved ecosystem links with option overrides.
 *
 * @return array<int, array{key: string, label: string, url: string, description: string, cta: string}>
 */
function msrawards_get_ecosystem_links() {
	$defaults = msrawards_get_ecosystem_link_defaults();
	$links    = array();

	foreach ( $defaults as $slug => $item ) {
		$url = function_exists( 'msrawards_get_programme_url_option' )
			? msrawards_get_programme_url_option( $slug )
			: '';
		if ( '' === $url ) {
			$url = $item['url'];
		}
		if ( '' === $url ) {
			continue;
		}
		$links[] = array_merge(
			array( 'key' => $slug ),
			$item,
			array( 'url' => $url )
		);
	}

	return $links;
}

/**
 * Ecosystem band — outbound CTAs to hub + publishing + ceremony.
 *
 * @return void
 */
function msrawards_render_ecosystem_band() {
	$links = msrawards_get_ecosystem_links();
	if ( ! $links ) {
		return;
	}
	?>
	<section class="msr-ecosystem msr-reveal" aria-labelledby="msr-ecosystem-heading">
		<div class="container">
			<header class="msr-ecosystem__header text-center mb-4">
				<h2 id="msr-ecosystem-heading" class="h4 msr-ecosystem__title mb-2">
					<?php echo esc_html( msrawards_get_ecosystem_band_title() ); ?>
				</h2>
				<p class="msr-ecosystem__lead mb-0">
					<?php echo esc_html( msrawards_get_ecosystem_band_lead() ); ?>
				</p>
			</header>
			<div class="row g-3 justify-content-center">
				<?php foreach ( $links as $link ) : ?>
					<div class="col-md-4">
						<div class="msr-ecosystem__card h-100">
							<h3 class="h6 msr-ecosystem__card-title mb-2"><?php echo esc_html( $link['label'] ); ?></h3>
							<p class="small msr-ecosystem__card-copy mb-3"><?php echo esc_html( $link['description'] ); ?></p>
							<a class="btn btn-outline-primary btn-sm" href="<?php echo esc_url( $link['url'] ); ?>">
								<?php echo esc_html( $link['cta'] ); ?>
							</a>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php
}
