<?php
/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage msrawards
 * @since msrawards 1.0
 */

?>

<section>
<article <?php post_class(); ?> id="post-nominee<?php the_ID(); ?>">
<div class="container">
	<div class="row g-0">
		<div class="col-xl-6 col-lg-6">
			<div class="panel">
	<div class="my-auto text-center">
           <?php

$cat_list = array();

foreach ( get_the_terms( $post->ID, 'award' ) as $cat ) {
    if ( ! in_array( $cat->term_id, $exclude ) ) {
        $cat_list[] = '<p><span>' . $cat->name . '</p></span>';
    }
}

echo implode( ' ', $cat_list );?>
	<?php the_title( '<h1>', '</h1>' ); ?>
		<?php if (get_field('job_title')) : ?>
			<h2> <i class="fa fa-briefcase" aria-hidden="true"></i> <?php print get_field('job_title') ?> </h2>
			  <?php endif; ?>
			  <?php if (get_field('company')) : ?>
			<h3> <i class="fa fa-map-marker" aria-hidden="true"></i> <?php print get_field('company') ?> </h3>
			<?php endif; ?>
			<?php if( have_rows('social') ): ?>

 <?php while( have_rows('social') ) : the_row(); ?>

        <a href="<?php print get_sub_field('link') ?>" target="_blank"><i class="fa-brands fa-square-<?php print get_sub_field('platform') ?>"></i></a>

     <?php endwhile; ?>

<?php endif; ?>
		</div>
		</div>
			</div>
			<div class="col-xl-6 col-lg-6">
			<div class="panel">
			<div class="listing-image">
			<?php the_post_thumbnail();
echo get_post(get_post_thumbnail_id())->post_excerpt; ?>
</div>
		</div>
			  </div>
		<div class="col-sm-12">
		<div class="panel">
<?php if (get_field('profile')) : ?>
	<div class="post-inner">
		<div class="entry-content">
			
				<?php print get_field('profile') ?> 
				
		</div><!-- .entry-content -->

	</div><!-- .post-inner -->
	<?php endif; ?>
</div>
		</div>
	</div>
		</div>
</article><!-- .post -->
	</section>
