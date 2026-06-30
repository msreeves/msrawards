<?php
/**
 * Template Name: Entrants template
 *
 * Entrant / nomination journey preview for portfolio demonstration.
 *
 * @package msrawards
 */

get_header();
?>
<main id="primary" class="site-main awards-entrant-page">
	<section>
		<div class="container">
			<div class="panel text-center mb-4">
				<?php the_title( '<h1>', '</h1>' ); ?>
				<p class="lead"><?php echo esc_html( msrawards_get_entrants_page_lead() ); ?></p>
				<?php the_content(); ?>
				<?php get_template_part( 'template-parts/forms/site-search' ); ?>
			</div>
			<?php
			if ( function_exists( 'msrawards_render_entrant_journey' ) ) {
				msrawards_render_entrant_journey();
			}
			if ( function_exists( 'msrawards_render_season_timeline' ) ) {
				msrawards_render_season_timeline();
			}
			if ( function_exists( 'msrawards_render_judging_transparency' ) ) {
				msrawards_render_judging_transparency();
			}
			?>
		</div>
	</section>
</main>
<?php
get_footer();
