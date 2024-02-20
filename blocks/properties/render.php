<?php
/**
 * Block Template.
 *
 * @package ZlotyKlucz
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or its parent block.
 */

defined( 'ABSPATH' ) || exit;

// Get block name.
$block_name = str_replace( 'acf/', '', $block['name'] );

// Render preview in UI.
if ( ! empty( $block['data']['preview_image_help'] ) ) {
	$preview_url = get_template_directory_uri() . '/blocks/' . $block_name . '/preview.jpg';
	echo '<img src="' . esc_url( $preview_url ) . '" width="100%" height="auto" />';
	return;
}

// Get block fields.
$content = get_fields();

// Render preview in editor.
if ( isset( $block['example']['attributes']['data']['preview_image_help'] ) && $is_preview && bs_is_array_empty( $content ) ) {
	$preview_url = get_template_directory_uri() . '/blocks/' . $block_name . '/preview.jpg';
	echo '<img src="' . esc_url( $preview_url ) . '" width="100%" height="auto" />';
	return;
}

// Support custom "anchor" values.
$anchor = ! empty( $block['anchor'] ) ? $block['anchor'] : $block['id'];

// Create class attribute allowing for custom "className" and "align" values.
$classes = array( $block_name, 'block--custom', 'block--' . $block_name );
if ( ! empty( $block['className'] ) ) {
	$classes[] = $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$classes[] = $block['align'];
}
if ( ! empty( $block['backgroundColor'] ) ) {
	$classes[] = 'has-' . $block['backgroundColor'] . '-background-color';
}

$attrs = $is_preview ? '' : get_block_wrapper_attributes();

$query_args = array(
	'post_type'      => 'property',
	'posts_per_page' => 4,
	'no_found_rows'  => true,
);

if ( 'selected' === $content['content_type'] && ! empty( $content['selected_properties'] ) ) {
	$query_args['post__in']       = $content['selected_properties'];
	$query_args['posts_per_page'] = 99;
}

$the_query = new WP_Query( $query_args );
?>

<section id="<?php echo esc_attr( $anchor ); ?>" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" <?php echo wp_kses_post( $attrs ); ?>>
	<div class="container">
		<div class="row">
			<div class="col-12 properties__heading">
				<h2 class="properties__title onscroll">
					<?php echo wp_kses_post( $content['heading'] ); ?>
				</h2>
				<?php bs_get_button( $content['button'], 'primary', 'onscroll' ); ?>
			</div>
			<div class="col-12 properties__content">
				<?php if ( $the_query->have_posts() ) { ?>
					<?php while ( $the_query->have_posts() ) { ?>
						<?php $the_query->the_post(); ?>
						<?php get_template_part( 'partials/card-property' ); ?>
					<?php } ?>
				<?php } ?>
			</div>
		</div>
	</div>
</section>