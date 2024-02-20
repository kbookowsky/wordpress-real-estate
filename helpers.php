<?php
/**
 * Starter Theme helper functions
 *
 * @package ZlotyKlucz
 */

if ( ! function_exists( 'bs_is_array_empty' ) ) {
	/**
	 * Check if array is empty.
	 *
	 * @param array $arr Array to check.
	 */
	function bs_is_array_empty( $arr ) {

		if ( empty( $arr ) ) {
			return true;
		}

		if ( is_array( $arr ) ) {

			foreach ( $arr as $arr_item ) {

				if ( empty( $arr_item ) ) {
					continue;
				} else {
					return false;
				}
			}
		}

		return true;
	}
}

if ( ! function_exists( 'bs_enqueue_block_script' ) ) {
	/**
	 * Register/Localize script for Block.
	 *
	 * @param array $args block details.
	 * @return void
	 */
	function bs_enqueue_block_script( $args ) {
		wp_register_script(
			'block-' . $args['name'],
			get_template_directory_uri() . '/build/js/blocks/' . $args['name'] . '.min.js',
			$args['reg_arr'],
			wp_get_theme()->Version,
			array(
				'strategy'  => 'defer',
				'in_footer' => true,
			)
		);
		wp_add_inline_script(
			'block-' . $args['name'],
			'var block' . ucfirst( str_replace( '-', '', $args['name'] ) ) . ' = ' .
			wp_json_encode(
				$args['loc_arr']
			),
			'before'
		);
	}
}

if ( ! function_exists( 'bs_prepare_block_script' ) ) {
	/**
	 * Prepare custom enqueue script from block.
	 *
	 * @param array $args block details.
	 * @return void
	 */
	function bs_prepare_block_script( $args ) {
		if ( is_user_logged_in() ) {
			add_action(
				'admin_enqueue_scripts',
				function () use ( $args ) {
					bs_enqueue_block_script( $args );
				}
			);
			bs_enqueue_block_script( $args );
		} else {
			bs_enqueue_block_script( $args );
		}
	}
}

/**
 * Return button field.
 *
 * @param string[] $button button array.
 * @param string   $type button type.
 * @param string   $custom_class additional class.
 * @return string
 */
function bs_get_button( $button = '', $type = '', $custom_class = '' ) {
	if ( empty( $button['title'] || $button['url'] ) ) {
		return;
	}

	$classes = array();
	if ( ! empty( $type ) ) {
		$classes[] = 'is-style-' . $type;
	}
	if ( ! empty( $custom_class ) ) {
		$classes[] = $custom_class;
	}

	ob_start();
	?>
	<div class="wp-block-button <?php echo esc_attr( implode( ' ', $classes ) ); ?>">
		<a href="<?php echo esc_url( $button['url'] ); ?>" class="wp-block-button__link wp-element-button" <?php echo $button['target'] ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
			<span>
				<?php echo wp_kses_post( $button['title'] ); ?>
			</span>
		</a>
	</div>
	<?php
	$button_html = ob_get_clean();
	echo wp_kses_post( $button_html );
}