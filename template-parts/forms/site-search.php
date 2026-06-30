<?php
/**
 * Site search form partial.
 *
 * @package msrawards
 */

$msr_sb = sanitize_html_class( get_stylesheet() . '-site-search' );
?>
<div class="p-5 msr-site-search">
	<form role="search" method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Site search', 'msrawards' ); ?>">
		<div class="input-group flex-wrap flex-md-nowrap">
			<label class="screen-reader-text" for="<?php echo esc_attr( $msr_sb ); ?>"><?php esc_html_e( 'Search', 'msrawards' ); ?></label>
			<input class="form-control" type="search" name="s" id="<?php echo esc_attr( $msr_sb ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Search…', 'msrawards' ); ?>" autocomplete="off" aria-label="<?php esc_attr_e( 'Search MSR Awards', 'msrawards' ); ?>" />
			<input class="btn btn-primary" type="submit" value="<?php esc_attr_e( 'Search', 'msrawards' ); ?>" />
		</div>
	</form>
</div>
