<?php
/**
 * The template for displaying search results pages
 *
 * @package msrawards
 */

get_header();
?>

<main id="primary" class="site-main">
	<section>
		<div class="container">
			<?php if ( have_posts() ) : ?>
			<header class="page-header panel">
				<h1 class="page-title">
					<?php
					printf(
						/* translators: %s: search query */
						esc_html__( 'Search results for “%s”', 'msrawards' ),
						esc_html( get_search_query() )
					);
					?>
				</h1>
				<p class="text-center" role="status">
					<?php
					global $wp_query;
					$found = (int) $wp_query->found_posts;
					printf(
						/* translators: %d: number of results */
						esc_html( _n( '%d result found.', '%d results found.', $found, 'msrawards' ) ),
						$found
					);
					?>
				</p>
			</header>
			<?php get_template_part( 'template-parts/forms/site-search' ); ?>
			<div class="row">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content', 'search' );
				endwhile;
				?>
			</div>
			<nav class="msr-search-pagination" aria-label="<?php esc_attr_e( 'Search results pages', 'msrawards' ); ?>">
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
