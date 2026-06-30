<?php
/**
 * Displays the featured image with card media frame on archives.
 *
 * @package msrawards
 */

if ( ! has_post_thumbnail() || post_password_required() ) {
	return;
}

if ( is_singular() ) {
	?>
	<figure class="featured-media">
		<div class="featured-media-inner">
			<?php
			the_post_thumbnail(
				'large',
				array(
					'class' => 'msr-single-media__img',
				)
			);
			$caption = get_the_post_thumbnail_caption();
			if ( $caption ) {
				echo '<figcaption class="wp-caption-text">' . esc_html( $caption ) . '</figcaption>';
			}
			?>
		</div>
	</figure>
	<?php
	return;
}

msrawards_render_card_media();
