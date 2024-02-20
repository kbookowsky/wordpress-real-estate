<?php
/**
 * Ajax handler
 *
 * @package ZlotyKlucz
 */

defined( 'ABSPATH' ) || exit;

/**
 * Ajax function for events and photos block
 *
 * @return void
 */
function example_ajax_handler() {
	if ( ! check_ajax_referer( 'example-nonce', 'nonce', false ) ) {
		wp_send_json_error( 'Invalid security token sent.' );
		wp_die();
	}

	$paged = isset( $_POST['paged'] ) ? (int) absint( $_POST['paged'] ) + 1 : 1; // sanitize int.
	$text  = isset( $_POST['text'] ) ? sanitize_text_field( wp_unslash( $_POST['text'] ) ) : null; // sanitize text.
	$array = isset( $_POST['array'] ) ? map_deep( wp_unslash( $_POST['array'] ), 'sanitize_text_field' ) : null; // sanitize array.

	ob_start();

	global $post;

	$query_args = array(
		'post_type' => 'example',
		'paged'     => $paged,
	);

	$posts = '';

	$the_query = new \WP_Query( $query_args );

	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			// Content.
		}
	}
	$posts = ob_get_clean();

	$return = array(
		'posts'   => $posts,
		'maxPage' => $the_query->max_num_pages,
		'page'    => $paged,
	);

	wp_send_json( $return );
	wp_die();
}
add_action( 'wp_ajax_example', 'example_ajax_handler' );
add_action( 'wp_ajax_nopriv_example', 'example_ajax_handler' );
