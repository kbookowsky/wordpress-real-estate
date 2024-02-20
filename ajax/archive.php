<?php
/**
 * Ajax handler
 *
 * @package ZlotyKlucz
 */

defined( 'ABSPATH' ) || exit;

/**
 * Ajax function for archives
 *
 * @return void
 */
function archive_ajax_handler() {
	if ( ! check_ajax_referer( 'archive-nonce', 'nonce', false ) ) {
		wp_send_json_error( 'Invalid security token sent.' );
		wp_die();
	}

	$paged            = isset( $_POST['paged'] ) ? (int) absint( $_POST['paged'] ) + 1 : 1;
	$transaction_type = isset( $_POST['transactionType'] ) ? absint( $_POST['transactionType'] ) : null;
	$property_type    = isset( $_POST['propertyType'] ) ? absint( $_POST['propertyType'] ) : null;
	$property_city    = isset( $_POST['propertyCity'] ) ? absint( $_POST['propertyCity'] ) : null;
	$price_min        = isset( $_POST['priceMin'] ) ? (int) absint( $_POST['priceMin'] ) : 0;
	$price_max        = isset( $_POST['priceMax'] ) ? (int) absint( $_POST['priceMax'] ) : 0;

	global $post;

	$tax_count  = 0;
	$meta_count = 0;

	$query_args = array(
		'post_type'      => 'property',
		'posts_per_page' => get_option( 'posts_per_page' ),
		'paged'          => $paged,
	);

	if ( ! empty( $transaction_type ) ) {
		$query_args['tax_query'] = array( // phpcs:ignore
			array(
				'taxonomy' => 'transaction_type',
				'field'    => 'term_id',
				'terms'    => $transaction_type,
			),
		);

		++$tax_count;
	}

	if ( ! empty( $property_type ) ) {
		if ( 0 < $tax_count ) {
			$query_args['tax_query']['relation'] = 'AND';

			$query_args['tax_query'][] = array(
				'taxonomy' => 'property_type',
				'field'    => 'term_id',
				'terms'    => $property_type,
			);
		} else {
			$query_args['tax_query'] = array( // phpcs:ignore
				array(
					'taxonomy' => 'property_type',
					'field'    => 'term_id',
					'terms'    => $property_type,
				),
			);
		}

		++$tax_count;
	}

	if ( ! empty( $property_city ) ) {
		if ( 0 < $tax_count ) {
			$query_args['tax_query']['relation'] = 'AND';

			$query_args['tax_query'][] = array(
				'taxonomy' => 'property_city',
				'field'    => 'term_id',
				'terms'    => $property_city,
			);
		} else {
			$query_args['tax_query'] = array( // phpcs:ignore
				array(
					'taxonomy' => 'property_city',
					'field'    => 'term_id',
					'terms'    => $property_city,
				),
			);
		}
	}

	if ( ! empty( $price_min ) ) {
		$query_args['meta_query'] = array( // phpcs:ignore
			array(
				'key'     => 'property_price',
				'value'   => $price_min,
				'compare' => '>=',
				'type'    => 'numeric',
			),
		);

		++$meta_count;
	}

	if ( ! empty( $price_max ) ) {
		if ( 0 < $meta_count ) {
			$query_args['meta_query'][] = array(
				'key'     => 'property_price',
				'value'   => $price_max,
				'compare' => '<=',
				'type'    => 'numeric',
			);
		} else {
			$query_args['meta_query'] = array( // phpcs:ignore
				array(
					'key'     => 'property_price',
					'value'   => $price_max,
					'compare' => '<=',
					'type'    => 'numeric',
				),
			);
		}
	}

	ob_start();

	$posts = '';

	$the_query = new WP_Query( $query_args );

	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			get_template_part( 'partials/card-property' );
		}
	}
	$posts = ob_get_clean();

	$return = array(
		'posts'   => $posts,
		'maxPage' => $the_query->max_num_pages,
		'page'    => $paged,
		'args'    => $query_args,
	);

	wp_send_json( $return );
	wp_die();
}
add_action( 'wp_ajax_archive', 'archive_ajax_handler' );
add_action( 'wp_ajax_nopriv_archive', 'archive_ajax_handler' );
