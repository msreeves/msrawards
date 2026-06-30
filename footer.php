<?php
/**
 * The template for displaying the footer
 *
 * @package msrawards
 */

?>
<?php
if ( function_exists( 'msrawards_show_leaderboard_ads' ) && msrawards_show_leaderboard_ads() ) {
	get_template_part( 'templates/partials/leaderboard/footer' );
}
?>
<?php
if ( function_exists( 'msrawards_render_site_footer' ) ) {
	msrawards_render_site_footer();
}
?>
<?php wp_footer(); ?>
</body>
</html>
