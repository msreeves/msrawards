<?php
/**
 * Template Name: Judges template
 *
 * @package WordPress
 * @subpackage msrawards
 * @since msrawards 1.0
 */

get_header();
?>
<main id="site-content" class="site-main">
<section class="people">
  <div class="container">
      <div class="panel">
        <?php the_title( '<h1>', '</h1>' ); ?>
          <?php the_content(); ?>
          <?php
          if ( function_exists( 'msrawards_render_judging_transparency' ) ) {
              msrawards_render_judging_transparency();
          }
          ?>
      </div> 
         <?php 	
      $args = array(
        'post_type' => 'judge',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC'
      );
      $all_partners = new WP_Query( $args );		
      ?>

      <?php if ( $all_partners->have_posts() ) : ?>
            <div class="row">
          <?php while ( $all_partners->have_posts() ) : $all_partners->the_post(); ?>	
      <?php get_template_part( 'template-parts/cards/judge-card' ); ?>
          <?php endwhile; ?>
          <?php wp_reset_postdata(); ?>
      </div>
      <?php endif; ?>
      </div>
</section>
</main>
<?php
get_footer();