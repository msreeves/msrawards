<?php
/**
 * Partner / sponsor archive card.
 *
 * @package msrawards
 *
 * @var array $args {
 *     @type bool $show_sponsor_terms Show award categories sponsored.
 *     @type bool $compact            Inline logo chip (home award strip).
 * }
 */

$show_sponsor_terms = ! isset( $args['show_sponsor_terms'] ) || $args['show_sponsor_terms'];
$compact            = ! empty( $args['compact'] );
$link               = msrawards_get_acf_link_parts( get_field( 'link' ) );
$tier_slug          = msrawards_get_partner_tier( get_the_ID() );
$tier_labels        = msrawards_get_sponsor_tiers();
$tier_label         = $tier_labels[ $tier_slug ] ?? '';
$terms              = $show_sponsor_terms ? get_the_terms( get_the_ID(), 'award' ) : array();
if ( is_wp_error( $terms ) ) {
	$terms = array();
}

$media_args = array();
if ( $link['url'] ) {
	$media_args = array(
		'link_url'    => $link['url'],
		'link_target' => $link['target'],
	);
}
?>
<div class="<?php echo esc_attr( $compact ? 'awards-partner-chip' : 'mx-auto mb-3 col-md-6 col-lg-4' ); ?>">
	<article <?php post_class( $compact ? 'partner-card partner-card--compact' : 'partner-card panel msr-reveal msr-reveal--up' ); ?>>
		<div class="partner-listing-image awards-logo-tile<?php echo $compact ? ' awards-logo-tile--compact' : ''; ?>">
			<?php
			if ( $link['url'] ) {
				msrawards_render_card_media( null, 'medium', $media_args );
			} else {
				msrawards_render_card_media( null, 'medium' );
			}
			?>
		</div>
		<?php if ( ! $compact && $tier_label ) : ?>
			<p class="partner-card__tier small text-center mb-2">
				<span class="partner-card__tier-badge"><?php echo esc_html( $tier_label ); ?></span>
			</p>
		<?php endif; ?>
		<?php if ( ! $compact && $show_sponsor_terms && $terms ) : ?>
			<p class="partner-card__sponsor-label"><?php esc_html_e( 'Awards sponsoring:', 'msrawards' ); ?></p>
			<div class="nominee-card__terms text-center" aria-label="<?php esc_attr_e( 'Sponsored award categories', 'msrawards' ); ?>">
				<?php foreach ( $terms as $term ) : ?>
					<?php if ( $term instanceof WP_Term ) : ?>
						<span><?php echo esc_html( $term->name ); ?></span>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</article>
</div>
