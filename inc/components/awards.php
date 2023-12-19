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
        <section>
          <div class="container">
            <div class="row">
            <div class="panel">
          <h1 class="animate__animated animate__backInLeft"><?php echo $heading;?></h1>
         <h3 class="animate__animated animate__backInLeft"><?php echo $introduction;?></h3>
</div>
    <?php foreach( $awards as $award ): ?>
              <div class="col-lg-4 mx-auto mb-3">
              <div class="panel">
            <h2><?php echo esc_html( $award->name ); ?></h2>
            <p><?php echo esc_html( $award->description ); ?></p>
        </div>
     </div>
    <?php endforeach; ?>
    </div>
 </div>
</section>

    
