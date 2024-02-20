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

wp_enqueue_script(
	'script_select2',
	get_template_directory_uri() . '/build/js/vendor/select2.min.js',
	array( 'jquery' ),
	wp_get_theme()->Version,
	array(
		'strategy'  => 'defer',
		'in_footer' => true,
	)
);

// Register custom block script.
$enqueue_args = array(
	'name'     => esc_attr( $block_name ), // Block name.
	'obj_name' => 'block' . esc_attr( ucfirst( str_replace( '-', '', $block_name ) ) ), // Object name.
	'reg_arr'  => array( 'jquery' ), // Dependencies.
	'loc_arr'  => array(
		'propertiesUrl' => esc_url( $content['properties_page'] ),
	), // Data array.
);
bs_enqueue_block_script( $enqueue_args );
?>

<section id="<?php echo esc_attr( $anchor ); ?>" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" <?php echo wp_kses_post( $attrs ); ?>>
	<?php if ( ! empty( $content['background'] ) ) { ?>
		<div class="banner__background">
			<?php echo wp_get_attachment_image( $content['background'], 'full' ); ?>
		</div>
	<?php } ?>
	<div class="container">
		<div class="row">
			<div class="col-12 banner__content">
				<?php if ( ! empty( $content['title'] ) ) { ?>
					<h1 class="banner__title onscroll">
						<?php echo wp_kses_post( $content['title'] ); ?>
					</h1>
				<?php } ?>
				<?php if ( ! empty( $content['text'] ) ) { ?>
					<p class="banner__text onscroll">
						<?php echo wp_kses_post( $content['text'] ); ?>
					</p>
				<?php } ?>
				<?php if ( ! empty( $content['button'] ) ) { ?>
					<?php bs_get_button( $content['button'], 'white', 'onscroll' ); ?>
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="container banner__filters__wrapper">
		<div class="banner__filters onscroll">
			<div class="banner__filter">
				<label for="transaction_type">
					<?php esc_html_e( 'Typ transakcji', 'zloty-klucz' ); ?>
				</label>
				<?php $terms = get_terms( array( 'taxonomy' => 'transaction_type' ) ); ?>
				<select name="transaction_type" id="transaction_type">
					<?php if ( ! empty( $terms ) && is_array( $terms ) ) { ?>
						<?php foreach ( $terms as $item ) { ?>
							<option value="<?php echo esc_attr( $item->term_id ); ?>">
								<?php echo esc_html( $item->name ); ?>
							</option>
						<?php } ?>
					<?php } ?>
				</select>
			</div>
			<div class="banner__filter">
				<label for="property_type">
					<?php esc_html_e( 'Typ nieruchomości', 'zloty-klucz' ); ?>
				</label>
				<?php $terms = get_terms( array( 'taxonomy' => 'property_type' ) ); ?>
				<select name="property_type" id="property_type">
					<?php if ( ! empty( $terms ) && is_array( $terms ) ) { ?>
						<?php foreach ( $terms as $item ) { ?>
							<option value="<?php echo esc_attr( $item->term_id ); ?>">
								<?php echo esc_html( $item->name ); ?>
							</option>
						<?php } ?>
					<?php } ?>
				</select>
			</div>
			<div class="banner__filter">
				<label for="property_city">
					<?php esc_html_e( 'Miejscowość', 'zloty-klucz' ); ?>
				</label>
				<?php $terms = get_terms( array( 'taxonomy' => 'property_city' ) ); ?>
				<select name="property_city" id="property_city">
					<?php if ( ! empty( $terms ) && is_array( $terms ) ) { ?>
						<?php foreach ( $terms as $item ) { ?>
							<option value="<?php echo esc_attr( $item->term_id ); ?>">
								<?php echo esc_html( $item->name ); ?>
							</option>
						<?php } ?>
					<?php } ?>
				</select>
			</div>
			<div class="wp-block-button is-style-primary">
				<button type="button" class="wp-block-button__link wp-element-button">
					<span><?php esc_html_e( 'Szukaj', 'zloty-klucz' ); ?></span>
				</button>
			</div>
		</div>
	</div>
</section>