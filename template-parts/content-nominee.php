<?php
/**
 * Nominee single content.
 *
 * @package msrawards
 */

?>

<section>
<article <?php post_class( 'awards-person' ); ?> id="post-nominee<?php the_ID(); ?>">
<div class="container">
	<div class="row g-0">
		<div class="col-xl-6 col-lg-6">
			<div class="panel">
				<div class="my-auto text-center">
					<?php msrawards_render_award_term_badges(); ?>
					<?php the_title( '<h1>', '</h1>' ); ?>
					<?php msrawards_render_person_job_company(); ?>
					<?php msrawards_render_person_social_links(); ?>
				</div>
			</div>
		</div>
		<div class="col-xl-6 col-lg-6">
			<div class="panel">
				<?php msrawards_render_single_media(); ?>
			</div>
		</div>
		<div class="col-sm-12">
			<div class="panel">
				<?php if ( get_field( 'profile' ) ) : ?>
				<div class="post-inner">
					<?php msrawards_render_person_profile(); ?>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
</article>
</section>
