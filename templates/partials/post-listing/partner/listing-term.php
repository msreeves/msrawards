         <div class="mx-auto mb-3">
              <div class="panel">
                <div class="partner-listing-image">
               <?php 
$link = get_field('link');
    $link_url = $link['url'];
    $link_title = $link['title'];
    $link_target = $link['target'] ? $link['target'] : '_self';
    ?>
    <a class="m-1" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>">  <?php get_template_part( 'templates/partials/featured-image' ); ?></a>
          </div>
               <p> Awards sponsoring:</p>
                   <?php

$cat_list = array();

foreach ( get_the_terms( $post->ID, 'award' ) as $cat ) {
    if ( ! in_array( $cat->term_id, $exclude ) ) {
        $cat_list[] = '<span class="m-1">' . $cat->name . '</span>';
    }
}

echo implode( ' ', $cat_list );?>
         </div>
             </div>