<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package msrawards
 */

get_header();

$image = get_field('image' , 'option');
$date = get_field('date' , 'option');
$time = get_field('time' , 'option');
$venue = get_field('venue' , 'option');
$sponsors = get_field('main_sponsor' , 'option');
if ( ! is_array( $venue ) ) {
	$venue = array();
}
if ( ! is_array( $date ) ) {
	$date = array();
}
if ( ! is_array( $time ) ) {
	$time = array();
}
?>

<main id="site-content">
<?php if ( msrawards_is_programme_home() ) : ?>
  <?php
	$hero_bg = msrawards_hero_background_url( get_field( 'image', 'option' ) );
	$hero_on = (bool) get_field( 'hero', 'option' );
	?>
  <?php if ( $hero_on ) : ?>
  <section class="background-image msr-awards-hero<?php echo $hero_bg ? '' : ' msr-awards-hero--no-image'; ?>"<?php echo $hero_bg ? ' style="background-image: url(' . esc_url( $hero_bg ) . ');"' : ''; ?>>
	<div class="msr-awards-hero__scrim" aria-hidden="true"></div>
	<div class="msr-awards-hero__inner">
		<div class="msr-awards-hero__content msr-reveal">
			<p class="msr-awards-hero__eyebrow"><?php esc_html_e( 'Awards programme', 'msrawards' ); ?></p>
			<?php if ( function_exists( 'msrawards_get_programme_format_label' ) ) : ?>
			<p class="msr-awards-hero__format-badge"><?php echo esc_html( msrawards_get_programme_format_label() ); ?></p>
			<?php endif; ?>
			<h1><?php echo esc_html( (string) get_field( 'name', 'option' ) ); ?></h1>
			<?php
			$venue_name  = isset( $venue['name'] ) ? (string) $venue['name'] : '';
			$venue_addr  = isset( $venue['address'] ) ? (string) $venue['address'] : '';
			$date_start  = isset( $date['start'] ) ? (string) $date['start'] : '';
			$date_finish = isset( $date['finish'] ) ? (string) $date['finish'] : '';
			$time_start  = isset( $time['start'] ) ? (string) $time['start'] : '';
			$time_finish = isset( $time['finish'] ) ? (string) $time['finish'] : '';
			$has_facts   = $venue_addr || $date_start || $date_finish || $time_start || $time_finish;
			?>
			<?php if ( $venue_name ) : ?>
			<p class="msr-awards-hero__lead"><?php echo esc_html( $venue_name ); ?></p>
			<?php endif; ?>
			<?php if ( $has_facts ) : ?>
			<ul class="msr-awards-hero__facts">
				<?php if ( $date_start || $date_finish ) : ?>
				<li class="msr-awards-hero__fact">
					<?php if ( $date_start ) : ?><i class="fa-solid fa-calendar" aria-hidden="true"></i><?php endif; ?>
					<span><?php echo esc_html( trim( $date_start . ( $date_finish ? ' - ' . $date_finish : '' ) ) ); ?></span>
				</li>
				<?php endif; ?>
				<?php if ( $time_start || $time_finish ) : ?>
				<li class="msr-awards-hero__fact">
					<?php if ( $time_start ) : ?><i class="fa-solid fa-clock" aria-hidden="true"></i><?php endif; ?>
					<span><?php echo esc_html( trim( $time_start . ( $time_finish ? ' - ' . $time_finish : '' ) ) ); ?></span>
				</li>
				<?php endif; ?>
				<?php if ( $venue_addr ) : ?>
				<li class="msr-awards-hero__fact msr-awards-hero__fact--address">
					<i class="fa fa-map-marker" aria-hidden="true"></i>
					<span class="msr-awards-hero__fact-text"><?php msrawards_render_rich_text( $venue_addr ); ?></span>
				</li>
				<?php endif; ?>
			</ul>
			<?php endif; ?>
			<div class="awards-ctas ctas">
				<?php msrawards_render_cta_link( get_field( 'link1', 'option' ) ); ?>
				<?php msrawards_render_cta_link( get_field( 'link2', 'option' ), 'btn btn-outline-primary' ); ?>
				<p class="msr-awards-hero__cta-note"><?php esc_html_e( 'Preview — entries open at launch', 'msrawards' ); ?></p>
			</div>
		</div>
	</div>
  </section>
  <?php if ( $sponsors ) : ?>
	<?php
	get_template_part(
		'template-parts/components/main-sponsor-bar',
		null,
		array( 'sponsors' => $sponsors )
	);
	?>
  <?php endif; ?>
<?php else : ?>
  <?php endif; ?>
  <?php
	if ( function_exists( 'msrawards_render_programme_stats' ) ) {
		msrawards_render_programme_stats();
	}
	if ( function_exists( 'msrawards_render_featured_nominees' ) ) {
		msrawards_render_featured_nominees();
	}
	?>
    <?php
      $sections = get_field( 'add_sections' );
      $has_structured_sections = is_array( $sections ) && isset( $sections[0] ) && is_array( $sections[0] ) && ! empty( $sections[0]['acf_fc_layout'] );

      if ( $has_structured_sections ) :
        foreach ( $sections as $section ) :
            if ( ! is_array( $section ) || empty( $section['acf_fc_layout'] ) ) {
                continue;
            }
            $template = str_replace( '_', '-', $section['acf_fc_layout'] );
            get_template_part( 'template-parts/sections/' . $template, '', $section );
        endforeach;
      elseif ( is_array( $sections ) ) :
        foreach ( $sections as $index => $layout_name ) :
            if ( ! is_string( $layout_name ) || '' === $layout_name ) {
                continue;
            }
            $prefix  = 'add_sections_' . $index . '_';
            $section = array(
                'acf_fc_layout' => $layout_name,
                'title'         => get_field( $prefix . 'title' ),
                'introduction'  => get_field( $prefix . 'introduction' ),
            );

            if ( 'contentsection' === $layout_name ) {
                $rows    = (int) get_field( $prefix . 'content' );
                $content = array();
                for ( $r = 0; $r < $rows; $r++ ) {
                    $content[] = array(
                        'image'        => get_field( $prefix . 'content_' . $r . '_image' ),
                        'title'        => get_field( $prefix . 'content_' . $r . '_title' ),
                        'introduction' => get_field( $prefix . 'content_' . $r . '_introduction' ),
                        'layout'       => get_field( $prefix . 'content_' . $r . '_layout' ),
                        'video'        => get_field( $prefix . 'content_' . $r . '_video' ),
                    );
                }
                $section['content'] = $content;
            } elseif ( 'awards' === $layout_name || 'storieslist' === $layout_name || 'partnerlist' === $layout_name ) {
                $section['name'] = get_field( $prefix . 'name' );
                $section['type'] = get_field( $prefix . 'type' );
            } elseif ( 'advert' === $layout_name ) {
                $section['advert'] = get_field( $prefix . 'advert' );
            } elseif ( 'keypointlist' === $layout_name ) {
                $rows     = (int) get_field( $prefix . 'keypoint' );
                $keypoint = array();
                for ( $r = 0; $r < $rows; $r++ ) {
                    $keypoint[] = array(
                        'icon'           => get_field( $prefix . 'keypoint_' . $r . '_icon' ),
                        'icon_class'     => get_field( $prefix . 'keypoint_' . $r . '_icon_class' ),
                        'number'         => get_field( $prefix . 'keypoint_' . $r . '_number' ),
                        'title'          => get_field( $prefix . 'keypoint_' . $r . '_title' ),
                        'introduction'   => get_field( $prefix . 'keypoint_' . $r . '_introduction' ),
                    );
                }
                $section['keypoint'] = $keypoint;
            } elseif ( 'cta' === $layout_name ) {
                $section['image'] = get_field( $prefix . 'image' );
                $section['link1'] = get_field( $prefix . 'link1' );
                $section['link2'] = get_field( $prefix . 'link2' );
            }

            $template = str_replace( '_', '-', $layout_name );
            get_template_part( 'template-parts/sections/' . $template, '', $section );
        endforeach;
      endif;
?>
<?php
	if ( function_exists( 'msrawards_render_season_timeline' ) ) {
		msrawards_render_season_timeline();
	}
	if ( function_exists( 'msrawards_render_ecosystem_band' ) ) {
		msrawards_render_ecosystem_band();
	}
?>
<?php else : ?>
  <section>
  <div class="container">
    <div class="panel">
     <h1> <?php the_title(); ?> </h1>
    <?php the_content(); ?>
  </div>
  </div>
</section>
<?php endif; ?>
</main>
<?php
get_footer();