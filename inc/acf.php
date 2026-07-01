<?php
/**
 * ACF options page and local fields — MSR Awards site copy (hero stays on Award Information).
 *
 * @package msrawards
 */

/**
 * @return void
 */
function msrawards_register_acf_options_page() {
	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return;
	}

	acf_add_options_page(
		array(
			'page_title' => __( 'MSR Awards settings', 'msrawards' ),
			'menu_title' => __( 'MSR Awards', 'msrawards' ),
			'menu_slug'  => 'msr-awards-settings',
			'capability' => 'edit_posts',
			'redirect'   => false,
			'icon_url'   => 'dashicons-awards',
			'position'   => 58,
		)
	);
}
add_action( 'acf/init', 'msrawards_register_acf_options_page' );

/**
 * @return void
 */
function msrawards_register_acf_options_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'    => 'group_msr_awards_programme_urls',
			'title'  => 'Programme URLs',
			'fields' => array(
				array(
					'key'   => 'field_msr_awd_opt_hub_url',
					'label' => 'MSR Events hub URL',
					'name'  => 'msr_programme_hub_url',
					'type'  => 'url',
				),
				array(
					'key'   => 'field_msr_awd_opt_publishing_url',
					'label' => 'Atlas Briefing URL',
					'name'  => 'msr_programme_publishing_url',
					'type'  => 'url',
				),
				array(
					'key'   => 'field_msr_awd_opt_ceremony_url',
					'label' => 'Ceremony event URL',
					'name'  => 'msr_programme_ceremony_url',
					'type'  => 'url',
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'msr-awards-settings',
					),
				),
			),
		)
	);

	acf_add_local_field_group(
		array(
			'key'    => 'group_msr_awards_site_copy',
			'title'  => 'Site copy',
			'fields' => array(
				array(
					'key'   => 'field_msr_awd_ecosystem_title',
					'label' => 'Ecosystem band title',
					'name'  => 'ecosystem_band_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_msr_awd_ecosystem_lead',
					'label' => 'Ecosystem band lead',
					'name'  => 'ecosystem_band_lead',
					'type'  => 'textarea',
					'rows'  => 2,
				),
				array(
					'key'   => 'field_msr_awd_nominees_lead',
					'label' => 'Nominees page lead',
					'name'  => 'nominees_page_lead',
					'type'  => 'textarea',
					'rows'  => 2,
				),
				array(
					'key'   => 'field_msr_awd_partners_lead',
					'label' => 'Partners page lead',
					'name'  => 'partners_page_lead',
					'type'  => 'textarea',
					'rows'  => 2,
				),
				array(
					'key'   => 'field_msr_awd_entrants_lead',
					'label' => 'For entrants page lead',
					'name'  => 'entrants_page_lead',
					'type'  => 'textarea',
					'rows'  => 2,
				),
				array(
					'key'   => 'field_msr_awd_entrant_journey_lead',
					'label' => 'Entrant journey band lead',
					'name'  => 'entrant_journey_lead',
					'type'  => 'textarea',
					'rows'  => 2,
				),
				array(
					'key'           => 'field_msr_awd_footer_demo_toggle',
					'label'         => 'Show footer demo disclaimer',
					'name'          => 'show_footer_demo_note',
					'type'          => 'true_false',
					'ui'            => 1,
					'default_value' => 1,
				),
				array(
					'key'   => 'field_msr_awd_footer_demo_text',
					'label' => 'Footer demo disclaimer text',
					'name'  => 'footer_demo_note',
					'type'  => 'text',
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'msr-awards-settings',
					),
				),
			),
		)
	);

	acf_add_local_field_group(
		array(
			'key'    => 'group_msr_awards_seo_copy',
			'title'  => 'SEO descriptions',
			'fields' => array(
				array(
					'key'   => 'field_msr_awd_seo_home',
					'label' => 'Home meta description',
					'name'  => 'seo_home_description',
					'type'  => 'textarea',
					'rows'  => 2,
				),
				array(
					'key'   => 'field_msr_awd_seo_nominees',
					'label' => 'Nominees archive meta description',
					'name'  => 'seo_nominees_description',
					'type'  => 'textarea',
					'rows'  => 2,
				),
				array(
					'key'   => 'field_msr_awd_seo_search',
					'label' => 'Search meta description',
					'name'  => 'seo_search_description',
					'type'  => 'textarea',
					'rows'  => 2,
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'msr-awards-settings',
					),
				),
			),
		)
	);
}
add_action( 'acf/init', 'msrawards_register_acf_options_fields' );
