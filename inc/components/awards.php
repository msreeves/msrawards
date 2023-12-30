<?php
/**
 * ACF: Flexible Content > Layouts > Awards
 * 
 * @package WordPress
 */ 

$heading = $args['title'];
$introduction = $args['introduction'];
$awards = $args['name'];
?>
        <section class="awards">
          <div class="container">
            <div class="row">
            <div class="panel">
          <h1 class="animate__animated animate__backInLeft"><?php echo $heading;?></h1>
         <h3 class="animate__animated animate__backInLeft"><?php echo $introduction;?></h3>
</div>
    <?php foreach( $awards as $award ): ?>
              <div class="col-xl-4 col-lg-4 mx-auto mb-3">
              <div class="panel">
            <h2><?php echo esc_html( $award->name ); ?></h2>
            <p><?php echo esc_html( $award->description ); ?></p>
                <?php 	
      $args = array(
        'post_type' => 'partner',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
        'tax_query' => array(
            array(
              'taxonomy' => 'award',
              'field' => 'slug',
              'terms' => $award
            )
          )
      );
      $all_partners = new WP_Query( $args );		
      ?>

      <?php if ( $all_partners->have_posts() ) : ?>  
         <p class="mb-0"> Sponsor: </p>         
             <div class="d-flex flex-row flex-wrap">
          <?php while ( $all_partners->have_posts() ) : $all_partners->the_post(); ?>	
      <?php get_template_part( 'templates/partials/post-listing/partner/listing-no-term' ); ?>
          <?php endwhile; ?>
          <?php wp_reset_query() ?>
      </div>
      <?php endif; ?>
        </div>
     </div>
    <?php endforeach; ?>
    </div>
 </div>
</section>

    
