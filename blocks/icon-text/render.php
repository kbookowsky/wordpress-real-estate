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

$items = $content['items'];
?>

<section id="<?php echo esc_attr( $anchor ); ?>" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" <?php echo wp_kses_post( $attrs ); ?>>
	<div class="container">
		<div class="row">
			<div class="col-12 icon-text__heading">
				<?php if ( ! empty( $content['heading'] ) ) { ?>
					<h2 class="icon-text__title onscroll">
						<?php echo wp_kses_post( $content['heading'] ); ?>
					</h2>
				<?php } ?>
			</div>
			<div class="col-12 icon-text__content">
				<?php if ( ! empty( $items ) && is_array( $items ) ) { ?>
					<?php foreach ( $items as $item ) { ?>
						<div class="icon-text__item onscroll">
							<div class="icon-text__item__icon">
								<?php echo wp_get_attachment_image( $item['icon'] ); ?>
							</div>
							<div class="icon-text__item__content">
								<div class="icon-text__item__heading">
									<h3 class="icon-text__item__title">
										<?php echo esc_html( $item['heading'] ); ?>
									</h3>
								</div>
								<div class="icon-text__item__content">
									<?php echo wp_kses_post( $item['text'] ); ?>
								</div>
							</div>
						</div>
					<?php } ?>	
				<?php } ?>
			</div>
		</div>
	</div>
</section>