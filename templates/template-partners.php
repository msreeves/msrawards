<?php
/**
 * Template Name: Partners template
 *
 * @package msrawards
 */

get_header();
?>
<main id="site-content" class="site-main">
<section class="partner msrawards-partners-page awards-archive-listing">
	<div class="container">
		<header class="awards-archive-intro">
			<?php the_title( '<h1>', '</h1>' ); ?>
			<p class="lead"><?php echo esc_html( msrawards_get_partners_page_lead() ); ?></p>
			<?php if ( get_the_content() ) : ?>
				<div class="awards-archive-intro__content">
					<?php the_content(); ?>
				</div>
			<?php endif; ?>
		</header>
		<?php msrawards_render_partner_tier_grid(); ?>
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
