<?php
/**
 * Event Companion demo bridge — link-out URLs + home promo band (C1c).
 *
 * Hub event ACF is source of truth; Awards options mirror local demo URLs.
 *
 * @package msrawards
 */

/**
 * Local portfolio demo URL (C1b Awards stub).
 *
 * @return string
 */
function msrawards_get_companion_demo_url_default() {
	return 'http://127.0.0.1:8888/sites/portfolio/projects/event-companion/?event=msrawards';
}

/**
 * @return string Absolute companion demo URL or empty.
 */
function msrawards_get_companion_demo_url() {
	$stored = trim( (string) get_option( 'msr_awards_companion_demo_url', '' ) );
	if ( '' !== $stored ) {
		return esc_url_raw( $stored );
	}
	return msrawards_get_companion_demo_url_default();
}

/**
 * @return string Booking / enter URL (may be mailto).
 */
function msrawards_get_companion_booking_url() {
	$stored = trim( (string) get_option( 'msr_awards_booking_url', '' ) );
	if ( '' !== $stored ) {
		return $stored;
	}
	return 'mailto:hello@example.com?subject=MSR%20Awards%20(demo)';
}

/**
 * Home band — hide after winners (replay analogue); show entries/judging/shortlist.
 *
 * @return bool
 */
function msrawards_should_show_companion_home_band() {
	$phase = function_exists( 'msrawards_get_season_phase' ) ? msrawards_get_season_phase() : '';
	if ( 'winners' === $phase ) {
		return false;
	}
	return '' !== msrawards_get_companion_demo_url();
}

/**
 * Compact home promo band.
 */
function msrawards_render_companion_home_band() {
	if ( ! msrawards_should_show_companion_home_band() ) {
		return;
	}

	$url = msrawards_get_companion_demo_url();
	?>
	<section class="awards-companion-band msr-reveal" aria-labelledby="awards-companion-band-heading">
		<div class="container">
			<div class="awards-companion-band__inner">
				<div class="awards-companion-band__copy">
					<p class="awards-companion-band__eyebrow mb-1">
						<?php esc_html_e( 'Companion demo', 'msrawards' ); ?>
					</p>
					<h2 id="awards-companion-band-heading" class="h5 awards-companion-band__title mb-2">
						<?php esc_html_e( 'Programme companion — awards stub demo', 'msrawards' ); ?>
					</h2>
					<p class="awards-companion-band__lead mb-0">
						<?php esc_html_e( 'Website plus companion demo for the Awards programme. Categories and nominees stay on this site — portfolio demonstration, not an App Store product.', 'msrawards' ); ?>
					</p>
				</div>
				<div class="awards-companion-band__actions awards-ctas">
					<a class="btn btn-primary" href="<?php echo esc_url( $url ); ?>">
						<?php esc_html_e( 'Open companion demo', 'msrawards' ); ?>
					</a>
				</div>
			</div>
		</div>
	</section>
	<?php
}
