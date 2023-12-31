<?php
/**
 * ACF: Flexible Content > Layouts > Listing Partners
 *
 * @package WordPress
 * @subpackage QORP
 */

$heading = $args['title'];
$introduction = $args['introduction'];
?>

        <section class="partner">
      	<div class="container">
            <div class="panel">
          <h1 class="animate__animated animate__backInLeft"><?php echo $heading;?></h1>
         <h3 class="animate__animated animate__backInLeft"><?php echo $introduction;?></h3>
            </div>
 <?php 	

      $args = array(
         'post_type' => 'partner',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC'
      );
      $all_posts = new WP_Query( $args );		
      ?>

      <?php if ( $all_posts->have_posts() ) : ?>
            <div class="d-flex flex-row flex-wrap">
          <?php while ( $all_posts->have_posts() ) : $all_posts->the_post(); ?>	
          <?php get_template_part( 'templates/partials/post-listing/partner/listing-term' ); ?>
          <?php endwhile; ?>
          <?php wp_reset_query() ?>
      </div>
      <?php endif; ?>
       </div>
  </section>
  