<?php
/**
 * MSR Awards ACF options — admin-first site copy and programme URLs.
 *
 * @package msrawards
 */

/**
 * @param string $field ACF field name.
 * @param string $default Fallback when empty.
 * @return string
 */
function msrawards_get_option_string( $field, $default = '' ) {
	if ( ! function_exists( 'get_field' ) ) {
		return $default;
	}
	$value = get_field( $field, 'option' );
	if ( ! is_string( $value ) || '' === trim( $value ) ) {
		return $default;
	}
	return trim( $value );
}

/**
 * @param string $field ACF field name.
 * @param bool   $default Fallback.
 * @return bool
 */
function msrawards_get_option_bool( $field, $default = false ) {
	if ( ! function_exists( 'get_field' ) ) {
		return $default;
	}
	$value = get_field( $field, 'option' );
	if ( null === $value || '' === $value ) {
		return $default;
	}
	return (bool) $value;
}

/**
 * Ecosystem band heading.
 *
 * @return string
 */
function msrawards_get_ecosystem_band_title() {
	return msrawards_get_option_string(
		'ecosystem_band_title',
		__( 'MSR ecosystem', 'msrawards' )
	);
}

/**
 * Ecosystem band lead copy.
 *
 * @return string
 */
function msrawards_get_ecosystem_band_lead() {
	return msrawards_get_option_string(
		'ecosystem_band_lead',
		__( 'MSR Awards connects to the events hub, Atlas Briefing insights, and the ceremony programme page in the local demonstration estate.', 'msrawards' )
	);
}

/**
 * Nominees archive page lead.
 *
 * @return string
 */
function msrawards_get_nominees_page_lead() {
	return msrawards_get_option_string(
		'nominees_page_lead',
		__( 'Browse nominees by award category—shortlisted entrants and judging cohorts for the current programme.', 'msrawards' )
	);
}

/**
 * Partners page lead.
 *
 * @return string
 */
function msrawards_get_partners_page_lead() {
	return msrawards_get_option_string(
		'partners_page_lead',
		__( 'Sponsors and partners supporting MSR Awards categories and ceremony delivery.', 'msrawards' )
	);
}

/**
 * For entrants page lead.
 *
 * @return string
 */
function msrawards_get_entrants_page_lead() {
	return msrawards_get_option_string(
		'entrants_page_lead',
		__( 'Nomination guidance for entrants exploring MSR Awards categories, judging, and ceremony timelines.', 'msrawards' )
	);
}

/**
 * Entrant journey band lead (for-entrants / home).
 *
 * @return string
 */
function msrawards_get_entrant_journey_lead() {
	return msrawards_get_option_string(
		'entrant_journey_lead',
		__( 'Nomination guidance for portfolio review — replace with live entry mechanics before a production awards season.', 'msrawards' )
	);
}

/**
 * Footer demo disclaimer line.
 *
 * @return string
 */
function msrawards_get_footer_demo_note() {
	return msrawards_get_option_string(
		'footer_demo_note',
		__( 'Demonstration awards programme for portfolio review.', 'msrawards' )
	);
}

/**
 * Whether the footer demo disclaimer is shown.
 *
 * @return bool
 */
function msrawards_show_footer_demo_note() {
	return msrawards_get_option_bool( 'show_footer_demo_note', true );
}

/**
 * Home meta description fallback.
 *
 * @return string
 */
function msrawards_get_seo_home_description() {
	return msrawards_get_option_string(
		'seo_home_description',
		__( 'MSR Awards — recognise excellence across categories with nominees, judging transparency, and ceremony routing in the MSR demonstration estate.', 'msrawards' )
	);
}

/**
 * Nominees archive meta description fallback.
 *
 * @return string
 */
function msrawards_get_seo_nominees_description() {
	return msrawards_get_option_string(
		'seo_nominees_description',
		__( 'Browse MSR Awards nominees by category—shortlisted entrants and demonstration profiles for the current programme season.', 'msrawards' )
	);
}

/**
 * Search meta description fallback.
 *
 * @return string
 */
function msrawards_get_seo_search_description() {
	return msrawards_get_option_string(
		'seo_search_description',
		__( 'Search MSR Awards nominees, programme news, and category pages.', 'msrawards' )
	);
}

/**
 * Programme outbound URL from options (ACF) with legacy wp_option fallback.
 *
 * @param string $slug hub|publishing|ceremony.
 * @return string
 */
function msrawards_get_programme_url_option( $slug ) {
	$acf_fields = array(
		'hub'        => 'msr_programme_hub_url',
		'publishing' => 'msr_programme_publishing_url',
		'ceremony'   => 'msr_programme_ceremony_url',
	);
	$legacy_keys = function_exists( 'msrawards_get_ecosystem_option_keys' )
		? msrawards_get_ecosystem_option_keys()
		: array();

	if ( isset( $acf_fields[ $slug ] ) ) {
		$url = msrawards_get_option_string( $acf_fields[ $slug ], '' );
		if ( '' !== $url ) {
			return esc_url_raw( $url );
		}
	}

	if ( isset( $legacy_keys[ $slug ] ) ) {
		$stored = (string) get_option( $legacy_keys[ $slug ], '' );
		if ( '' !== trim( $stored ) ) {
			return esc_url_raw( $stored );
		}
	}

	return '';
}
