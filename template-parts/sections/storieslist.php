<?php
/**
 * ACF: Flexible Content > Layouts > Listing Stories
 *
 * @package msrawards
 */

$heading      = isset( $args['title'] ) ? (string) $args['title'] : '';
$introduction = isset( $args['introduction'] ) ? (string) $args['introduction'] : '';
$type_raw     = $args['type'] ?? 0;
$term_ids     = msrawards_normalize_category_term_ids( $type_raw );

$paged = get_query_var( 'page' ) ? (int) get_query_var( 'page' ) : 1;
$qargs = array(
	'post_type'           => 'post',
	'posts_per_page'      => 3,
	'paged'               => $paged,
	'ignore_sticky_posts' => true,
);
if ( $term_ids ) {
	$qargs['tax_query'] = array(
		array(
			'taxonomy' => 'category',
			'field'    => 'term_id',
			'terms'    => $term_ids,
		),
	);
}
$latests = new WP_Query( $qargs );
$term_id_for_ajax = $term_ids ? (int) $term_ids[0] : 0;
?>

<section class="msrawards-stories-list"<?php if ( $latests->max_num_pages > 1 ) : ?>
	data-loadmore-limit="3"
	data-loadmore-page="1"
	data-loadmore-listing-type="latest"
	data-loadmore-term-id="<?php echo (int) $term_id_for_ajax; ?>"
	data-loadmore-max-pages="<?php echo (int) $latests->max_num_pages; ?>"
<?php endif; ?>>
	<div class="container">
		<div class="panel">
			<?php if ( $heading ) : ?>
			<h2 class="msr-reveal"><?php echo esc_html( $heading ); ?></h2>
			<?php endif; ?>
			<?php if ( $introduction ) : ?>
			<p class="lead msr-reveal"><?php echo wp_kses_post( $introduction ); ?></p>
			<?php endif; ?>
		</div>
		<div class="latest_posts_wrapper">
			<?php if ( $latests->have_posts() ) : ?>
			<div class="row">
				<?php
				while ( $latests->have_posts() ) :
					$latests->the_post();
					get_template_part(
						'template-parts/cards/post-card',
						null,
						array( 'category_depth' => 'all' )
					);
				endwhile;
				?>
			</div>
			<?php else : ?>
				<?php
				msrawards_render_empty_state(
					array(
						'context' => 'listing',
						'title'   => __( 'No programme news yet', 'msrawards' ),
						'message' => __( 'Check back after the next awards update.', 'msrawards' ),
						'inline'  => true,
					)
				);
				?>
			<?php endif; ?>
		</div>
		<?php if ( $latests->max_num_pages > 1 ) : ?>
		<div class="load_more text-center">
			<button type="button" class="btn btn-load-more" data-idle-text="<?php echo esc_attr__( 'Load more', 'msrawards' ); ?>" data-loading-text="<?php echo esc_attr__( 'Loading…', 'msrawards' ); ?>" data-error-text="<?php echo esc_attr__( 'Retry', 'msrawards' ); ?>" data-empty-text="<?php echo esc_attr__( 'No more stories', 'msrawards' ); ?>"><?php esc_html_e( 'Load more', 'msrawards' ); ?></button>
			<p class="msr-load-more-status screen-reader-text" aria-live="polite"></p>
		</div>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</section>
