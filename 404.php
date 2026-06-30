<?php
/**
 * 404 — awards programme chrome with helpful links.
 *
 * @package msrawards
 */

get_header();

$home     = home_url( '/' );
$topics   = home_url( '/topics/' );
$nominees = home_url( '/nominees/' );
$search   = home_url( '/?s=' );
?>
<main id="site-content" class="awards-error-page">
	<div class="container py-5 text-center">
		<p class="awards-error-page__code display-1 mb-2" aria-hidden="true">404</p>
		<h1 class="h2 mb-3"><?php esc_html_e( 'Page not found', 'msrawards' ); ?></h1>
		<p class="text-muted mb-4 awards-error-page__lead">
			<?php esc_html_e( 'That URL is not part of the MSR Awards programme site, or it may have moved.', 'msrawards' ); ?>
		</p>
		<nav class="d-flex flex-wrap gap-2 justify-content-center" aria-label="<?php esc_attr_e( 'Helpful links', 'msrawards' ); ?>">
			<a class="btn btn-primary" href="<?php echo esc_url( $home ); ?>"><?php esc_html_e( 'Home', 'msrawards' ); ?></a>
			<a class="btn btn-outline-primary" href="<?php echo esc_url( $topics ); ?>"><?php esc_html_e( 'Topics', 'msrawards' ); ?></a>
			<a class="btn btn-outline-primary" href="<?php echo esc_url( $nominees ); ?>"><?php esc_html_e( 'Nominees', 'msrawards' ); ?></a>
			<a class="btn btn-outline-primary" href="<?php echo esc_url( $search ); ?>"><?php esc_html_e( 'Search', 'msrawards' ); ?></a>
		</nav>
	</div>
</main>
<?php
get_footer();
