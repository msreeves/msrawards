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
    $terms = get_the_terms( $post->ID, 'award' ); 
    foreach($terms as $term) {
      echo '<span>' . $term->name . '</span>';
    }
?>
         </div>
             </div>