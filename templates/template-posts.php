<?php
/**
 * Template Name: Posts Template
 *
 * @package WordPress
 * @subpackage msrawards
 * @since msrsandbox 1.0
 */
get_header();
?>
<main id="site-content" class="site-main">
<section class="awards-archive-listing">
	<div class="container">
		<header class="awards-archive-intro">
			<?php the_title( '<h1>', '</h1>' ); ?>
			<?php if ( get_the_content() ) : ?>
				<div class="awards-archive-intro__content">
					<?php the_content(); ?>
				</div>
			<?php endif; ?>
		</header>
		<?php
		get_template_part(
			'templates/partials/filter-tabs',
			'',
			array(
				'taxonomy'      => 'category',
				'post_type'     => 'post',
				'all_label'     => __( 'All', 'msrawards' ),
				'listing_all'       => 'template-parts/cards/post-card',
				'listing_all_args'  => array( 'category_depth' => 'all' ),
				'listing_term'      => 'template-parts/cards/post-card',
				'listing_term_args' => array( 'category_depth' => 'child-only' ),
				'parent'        => 0,
				'query_args'    => array(
					'orderby' => 'date',
					'order'   => 'ASC',
				),
				'empty_message' => __( 'No posts found in this category.', 'msrawards' ),
			)
		);
		?>
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
