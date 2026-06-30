<?php
/**
 * Template Name: Gallery template
 *
 * @package msrawards
 */

get_header();
?>
<main id="site-content" class="site-main">
<section class="awards-gallery-page">
	<div class="container">
		<div class="panel">
			<?php the_title( '<h1>', '</h1>' ); ?>
			<?php the_content(); ?>
		</div>
		<?php
		$gallery = get_field( 'gallery' );
		if ( is_array( $gallery ) && $gallery ) :
			?>
			<div class="awards-gallery-grid" role="list">
				<?php foreach ( $gallery as $img ) : ?>
					<?php
					if ( ! is_array( $img ) || empty( $img['url'] ) ) {
						continue;
					}
					$full_url = msrawards_sanitize_background_url( $img['url'] );
					if ( ! $full_url ) {
						continue;
					}
					$thumb_url = ! empty( $img['sizes']['medium'] )
						? msrawards_sanitize_background_url( $img['sizes']['medium'] )
						: $full_url;
					$title     = isset( $img['title'] ) ? (string) $img['title'] : '';
					$alt       = isset( $img['alt'] ) ? trim( (string) $img['alt'] ) : '';
					if ( '' === $alt ) {
						$alt = '' !== $title ? $title : __( 'Gallery image', 'msrawards' );
					}
					$link_label = sprintf(
						/* translators: %s: image title */
						__( 'View image: %s', 'msrawards' ),
						'' !== $title ? $title : $alt
					);
					?>
					<figure class="awards-gallery-grid__item" role="listitem">
						<a
							class="awards-gallery-grid__link"
							href="<?php echo esc_url( $full_url ); ?>"
							data-fancybox="gallery"
							data-caption="<?php echo esc_attr( $title ); ?>"
							aria-label="<?php echo esc_attr( $link_label ); ?>"
						>
							<img
								class="awards-gallery-grid__thumb"
								src="<?php echo esc_url( $thumb_url ); ?>"
								alt="<?php echo esc_attr( $alt ); ?>"
								loading="lazy"
								decoding="async"
							>
						</a>
					</figure>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<?php
			msrawards_render_empty_state(
				array(
					'context' => 'gallery',
					'inline'  => true,
				)
			);
			?>
		<?php endif; ?>
	</div>
</section>
</main>
<?php
get_footer();
