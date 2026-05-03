<?php
/**
 * ACF: Flexible Content > Layouts > Key Point list 
 * 
 * @package WordPress
 * @subpackage QORP
 */ 

$columns = is_array( $args['keypoint'] ?? null ) ? $args['keypoint'] : array();
?>

<section>
  <div class="container">
    <div class="row">
    <?php foreach( $columns as $column ):   
       $heading = $column['title'] ?? '';
       $icon = msrawards_acf_image_url( $column['icon'] ?? '' );
       $number = $column['number'] ?? '';
       $introduction = $column['introduction'] ?? ''; ?>
      <div class="col-xl-3 mx-auto">
        <div class="post panel">
          <div class="icon">
          <?php if ( $icon ) : ?>
          <img src="<?php echo esc_url( $icon ); ?>" alt="" />
          <?php endif; ?>
           </div>
        <div class="listing-text text-center">
           <?php if ( $number ) : ?>
        <h2 class="count"> <?php echo $number; ?></h1>
        <?php endif; ?>
        <h2><?php echo $heading; ?></h3>		
          <p><?php echo $introduction; ?></p>
           </div>
     </div>
    </div>
    <?php endforeach; ?>
     </div>
  </div>
</section>