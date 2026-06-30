<?php
/**
 * ACF: Flexible Content > Layouts > Awards
 *
 * @package WordPress
 */

$heading      = $args['title'] ?? '';
$introduction = $args['introduction'] ?? '';
$awards       = $args['name'] ?? array();
if ( ! is_array( $awards ) ) {
	$awards = $awards ? array( $awards ) : array();
}
?>
        <section class="awards">
          <div class="container">
            <div class="row">
            <div class="panel">
          <h2 class="msr-reveal text-center"><?php echo esc_html( $heading ); ?></h2>
         <div class="msr-reveal text-center msr-rich-text awards-section-intro"><?php msrawards_render_rich_text( $introduction ); ?></div>
</div>
    <?php
	$rendered = 0;
	foreach ( $awards as $award ) :
		$term_slug = msrawards_award_term_slug( $award );
		if ( '' === $term_slug ) {
			continue;
		}
		$term_name = ( $award instanceof WP_Term ) ? $award->name : '';
		$term_desc = ( $award instanceof WP_Term ) ? $award->description : '';
		if ( '' === $term_name ) {
			$resolved = get_term_by( 'slug', $term_slug, 'award' );
			if ( $resolved && ! is_wp_error( $resolved ) ) {
				$term_name = $resolved->name;
				$term_desc = $resolved->description;
			}
		}
		++$rendered;
		?>
              <div class="col-xl-4 col-lg-4 mx-auto mb-3">
              <div class="panel">
            <h2><?php echo esc_html( $term_name ); ?></h2>
            <p><?php echo esc_html( $term_desc ); ?></p>
                <?php
		$query_args = array(
			'post_type'      => 'partner',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
			'tax_query'      => array(
				array(
					'taxonomy' => 'award',
					'field'    => 'slug',
					'terms'    => $term_slug,
				),
			),
		);
		$all_partners = new WP_Query( $query_args );
		?>

      <?php if ( $all_partners->have_posts() ) : ?>
         <p class="mb-0"> Sponsor: </p>
             <div class="d-flex flex-row flex-wrap">
          <?php
			while ( $all_partners->have_posts() ) :
				$all_partners->the_post();
				?>
      <?php
				get_template_part(
					'template-parts/cards/partner-card',
					null,
					array(
						'show_sponsor_terms' => false,
						'compact'            => true,
					)
				);
				?>
          <?php endwhile; ?>
          <?php wp_reset_postdata(); ?>
      </div>
      <?php endif; ?>
        </div>
     </div>
    <?php endforeach; ?>
    <?php if ( 0 === $rendered ) : ?>
    <?php
	msrawards_render_empty_state(
		array(
			'context' => 'listing',
			'title'   => __( 'No award categories configured', 'msrawards' ),
			'message' => __( 'Award categories will appear here when taxonomy terms are configured.', 'msrawards' ),
			'inline'  => true,
		)
	);
	?>
    <?php endif; ?>
    </div>
 </div>
</section>
