<?php
$post_type = 'nominee';

// Register the columns.
add_filter( "manage_{$post_type}_posts_columns", function ( $defaults ) {
	
	$defaults['title'] = 'Name';
	$defaults['job-title'] = 'Job Title';
	$defaults['company'] = 'Company';
    unset($defaults['date']);
	unset($defaults['comments']);

	return $defaults;
} );

// Handle the value for each of the new columns.
add_action( "manage_{$post_type}_posts_custom_column", function ( $column_name, $post_id ) {
	
	if ( $column_name == 'job-title' ) {
		echo get_field( 'job_title', $post_id );
	}

	if ( $column_name == 'company' ) {
		echo get_field( 'company', $post_id );
	}
	
}, 10, 2 );

$post_type = 'judge';

// Register the columns.
add_filter( "manage_{$post_type}_posts_columns", function ( $defaults ) {
	
	$defaults['title'] = 'Name';
	$defaults['job-title'] = 'Job Title';
	$defaults['company'] = 'Company';
	unset($defaults['taxonomy-award']);
    unset($defaults['date']);
	unset($defaults['comments']);

	return $defaults;
} );

// Handle the value for each of the new columns.
add_action( "manage_{$post_type}_posts_custom_column", function ( $column_name, $post_id ) {
	if ( $column_name == 'job-title' ) {
		echo get_field( 'job_title', $post_id );
	}
	
	if ( $column_name == 'company' ) {
		echo get_field( 'company', $post_id );
	}
	
}, 10, 2 );

function ig_sort_nominee_name( $query ){
    global $pagenow;
    
    if( is_admin() && 'edit.php' == $pagenow && !isset( $_GET['orderby'] ) ):
        if( $_GET['post_type'] == 'nominee' && !isset( $_GET['post_status'] ) ):

            $query->set( 'meta_key', 'name' );
            $query->set( 'orderby', 'meta_value' );
            $query->set( 'order', 'ASC' );
        endif;
            
    endif;
}
add_action( 'pre_get_posts', 'ig_sort_nominee_name' );

function ig_sort_judge_name( $query ){
    global $pagenow;
    
    if( is_admin() && 'edit.php' == $pagenow && !isset( $_GET['orderby'] ) ):
        if( $_GET['post_type'] == 'judge' && !isset( $_GET['post_status'] ) ):

            $query->set( 'meta_key', 'name' );
            $query->set( 'orderby', 'meta_value' );
            $query->set( 'order', 'ASC' );
        endif;
            
    endif;
}
add_action( 'pre_get_posts', 'ig_sort_judge_name' );