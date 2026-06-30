<?php
/**
 * The template for displaying archive pages
 *
 * @package msrawards
 */

get_header();
?>

<main id="primary" class="site-main">
	<section>
		<div class="container">
			<?php if ( have_posts() ) : ?>
			<div class="panel">
				<h1><?php single_cat_title(); ?></h1>
				<?php the_archive_description( '<p class="lead">', '</p>' ); ?>
				<?php get_template_part( 'template-parts/forms/site-search' ); ?>
			</div>
			<div class="row">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part(
						'template-parts/cards/post-card',
						null,
						array( 'category_depth' => 'all' )
					);
				endwhile;
				?>
			</div>
			<nav class="msr-archive-pagination" aria-label="<?php esc_attr_e( 'Archive pages', 'msrawards' ); ?>">
				<?php
				the_posts_pagination(
					array(
						'mid_size'  => 2,
						'prev_text' => __( 'Previous', 'msrawards' ),
						'next_text' => __( 'Next', 'msrawards' ),
					)
				);
				?>
			</nav>
			<?php else : ?>
			<?php get_template_part( 'template-parts/content', 'none' ); ?>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php
get_footer();
