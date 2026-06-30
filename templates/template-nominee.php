<?php
/**
 * Template Name: Nominees Template
 *
 * @package WordPress
 * @subpackage msrawards
 * @since msrsandbox 1.0
 */
get_header();
?>
<main id="site-content" class="site-main">
<section class="people awards-archive-listing">
	<div class="container">
		<header class="awards-archive-intro">
			<?php the_title( '<h1>', '</h1>' ); ?>
			<p class="lead"><?php echo esc_html( msrawards_get_nominees_page_lead() ); ?></p>
		</header>
		<?php
		get_template_part(
			'templates/partials/filter-tabs',
			'',
			array(
				'taxonomy'      => 'award',
				'post_type'     => 'nominee',
				'all_label'     => __( 'All', 'msrawards' ),
				'listing_all'       => 'template-parts/cards/nominee-card',
				'listing_all_args'  => array( 'show_award_terms' => true ),
				'listing_term'      => 'template-parts/cards/nominee-card',
				'listing_term_args' => array( 'show_award_terms' => false ),
				'query_args'    => array(
					'meta_key' => 'name',
					'orderby'  => 'meta_value',
					'order'    => 'ASC',
				),
				'empty_message' => __( 'No nominees found in this category.', 'msrawards' ),
			)
		);
		?>
		<?php if ( get_the_content() ) : ?>
			<div class="awards-archive-supplement panel">
				<?php the_content(); ?>
			</div>
		<?php endif; ?>
		<?php get_template_part( 'template-parts/forms/site-search' ); ?>
		<?php
		if ( function_exists( 'msrawards_render_ecosystem_band' ) ) {
			msrawards_render_ecosystem_band();
		}
		?>
	</div>
</section>
</main>
<?php
get_footer();
