<?php
/**
 * Theme functions and definitions
 *
 * @package ZlotyKlucz
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue required scripts and styles.
 */
function bs_enqueue_scripts() {
	$style_patch         = '/build/css/style.min.css';
	$style_post_patch    = '/build/css/pages/single.min.css';
	$style_archive_patch = '/build/css/pages/archive.min.css';
	$script_patch        = '/build/js/script.min.js';

	if ( is_single() ) {
		if ( 'property' === get_post_type() ) {
			wp_enqueue_style( 'style_property', get_template_directory_uri() . '/build/css/pages/single-property.min.css', array(), wp_get_theme()->Version );
			wp_enqueue_style( 'block-cta', get_template_directory_uri() . '/build/css/blocks/cta.min.css', array(), wp_get_theme()->Version );
			wp_enqueue_style( 'style_swiper', get_template_directory_uri() . '/build/css/vendor/swiper-bundle.min.css', array(), wp_get_theme()->Version );
			wp_enqueue_style( 'style_glightbox', get_template_directory_uri() . '/build/css/vendor/glightbox.min.css', array(), wp_get_theme()->Version );
			wp_enqueue_script(
				'script_swiper',
				get_template_directory_uri() . '/build/js/vendor/swiper-bundle.min.js',
				array( 'jquery' ),
				wp_get_theme()->Version,
				array(
					'strategy'  => 'defer',
					'in_footer' => true,
				)
			);
			wp_enqueue_script(
				'script_glightbox',
				get_template_directory_uri() . '/build/js/vendor/glightbox.min.js',
				array(),
				wp_get_theme()->Version,
				array(
					'strategy'  => 'defer',
					'in_footer' => true,
				)
			);
			wp_enqueue_script(
				'script_property',
				get_template_directory_uri() . '/build/js/single-property.min.js',
				array( 'script_swiper', 'script_glightbox' ),
				wp_get_theme()->Version,
				array(
					'strategy'  => 'defer',
					'in_footer' => true,
				)
			);
		} else {
			wp_enqueue_style( 'style_post', get_template_directory_uri() . $style_post_patch, array(), wp_get_theme()->Version );
		}
	}
	if ( is_home() || 'tpl-archive-property.php' === get_page_template_slug() ) {
		wp_enqueue_style( 'style_archive', get_template_directory_uri() . $style_archive_patch, array(), wp_get_theme()->Version );
		wp_enqueue_style( 'block-cta', get_template_directory_uri() . '/build/css/blocks/cta.min.css', array(), wp_get_theme()->Version );
		wp_enqueue_style( 'style_select2', get_template_directory_uri() . '/build/css/vendor/select2.min.css', array(), wp_get_theme()->Version );

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

		wp_enqueue_script(
			'script_archive',
			get_template_directory_uri() . '/build/js/archive.min.js',
			array( 'jquery' ),
			wp_get_theme()->Version,
			array(
				'strategy'  => 'defer',
				'in_footer' => true,
			)
		);
		wp_add_inline_script(
			'script_archive',
			'const archiveData = ' .
			wp_json_encode(
				array(
					'ajaxUrl' => admin_url( 'admin-ajax.php' ),
					'nonce'   => wp_create_nonce( 'archive-nonce' ),
				)
			),
			'before'
		);
	}

	wp_enqueue_style( 'style', get_template_directory_uri() . $style_patch, array(), wp_get_theme()->Version );

	wp_enqueue_script(
		'script',
		get_template_directory_uri() . $script_patch,
		array(),
		wp_get_theme()->Version,
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);
}
add_action( 'wp_enqueue_scripts', 'bs_enqueue_scripts', 20 );

/**
 * Disable editing on archive pages - disable block editor.
 *
 * @param bool   $can_edit Whether the post can be edited or not.
 * @param object $post The post being checked.
 */
function bs_disable_editor( $can_edit, $post ) {
	if ( 'page' === $post->post_type && ( 'tpl-archive-property.php' === get_page_template_slug( $post->ID ) || intval( get_option( 'page_for_posts' ) ) === $post->ID ) ) {
		return false;
	}
	return $can_edit;
}
add_filter( 'use_block_editor_for_post', 'bs_disable_editor', 10, 2 );

/**
 * Disable editing on archive pages - hide elements on screen.
 */
function bs_hide_on_screen() {
	global $post;

	if ( empty( $post ) ) {
		return;
	}

	if ( 'page' === $post->post_type && ( 'tpl-archive-property.php' === get_page_template_slug( $post->ID ) || intval( get_option( 'page_for_posts' ) ) === $post->ID ) ) {
		$style    = '';
		$elements = array(
			'permalink'       => '#edit-slug-box',
			'the_content'     => '#postdivrich',
			'excerpt'         => '#postexcerpt',
			'custom_fields'   => '#postcustom',
			'discussion'      => '#commentstatusdiv',
			'comments'        => '#commentsdiv',
			'slug'            => '#slugdiv',
			'author'          => '#authordiv',
			'format'          => '#formatdiv',
			'page_attributes' => '#pageparentdiv',
			'featured_image'  => '#postimagediv',
			'revisions'       => '#revisionsdiv',
			'categories'      => '#categorydiv',
			'tags'            => '#tagsdiv-post_tag',
			'send-trackbacks' => '#trackbacksdiv',
		);

		$hide_on_screen = array( 'the_content', 'excerpt', 'custom_fields', 'discussion', 'comments', 'slug', 'author', 'format', 'featured_image', 'revisions', 'categories', 'tags', 'send-trackbacks' );

		// Loop over field group settings and generate list of selectors to hide.
		if ( is_array( $hide_on_screen ) ) {
			$hide = array();
			foreach ( $hide_on_screen as $key ) {
				if ( isset( $elements[ $key ] ) ) {
					$id     = $elements[ $key ];
					$hide[] = $id;
					$hide[] = '#screen-meta label[for=' . substr( $id, 1 ) . '-hide]';
				}
			}
			$style = '<style>' . implode( ', ', $hide ) . ' {display: none;}</style>';
		}

		echo $style; // phpcs:ignore
	}
}
add_action( 'admin_print_styles', 'bs_hide_on_screen' );

/**
 * Update ACF setting - Google Map API.
 */
function my_acf_init() {
	$api_key = get_field( 'api_key_google_maps', 'options' );

	if ( ! empty( $api_key ) ) {
		acf_update_setting( 'google_api_key', $api_key );
	}
}
add_action( 'acf/init', 'my_acf_init' );

// ------------------------- DEFAULT FUNCTIONS.

// Load languages.
load_theme_textdomain( 'zloty-klucz', get_template_directory() . '/languages' );

// Declare theme support.
add_theme_support( 'editor-styles' );
add_theme_support( 'post-thumbnails' );
remove_theme_support( 'core-block-patterns' );

// Disable big image size threshold.
add_filter( 'big_image_size_threshold', '__return_false', 999 );

// Register navigation menus.
register_nav_menus(
	array(
		'main'     => __( 'Główne Menu', 'zloty-klucz' ),
		'footer'   => __( 'Footer Menu', 'zloty-klucz' ),
		'footnote' => __( 'Footnote Menu', 'zloty-klucz' ),
	)
);

/**
 * Add block categories.
 *
 * @param array $categories HTML content.
 */
function bs_custom_block_category( $categories ) {
	return array_merge(
		array(
			array(
				'slug'  => 'bs-custom',
				'title' => __( 'Customowe bloki', 'zloty-klucz' ),
				'icon'  => 'wordpress',
			),
		),
		$categories
	);
}
add_filter( 'block_categories_all', 'bs_custom_block_category', 10, 2 );

/**
 * Register block pattern category.
 */
function bs_block_pattern_category() {
	register_block_pattern_category(
		'bs-patterns',
		array(
			'label' => __( 'zloty-klucz', 'zloty-klucz' ),
		)
	);
}
add_action( 'init', 'bs_block_pattern_category' );

/**
 * Register ACF blocks.
 */
function bs_register_acf_blocks_json() {
	foreach ( glob( __DIR__ . '/blocks/*/block.json' ) as $filename ) {
		register_block_type( $filename );
	}
}
add_action( 'init', 'bs_register_acf_blocks_json', 5 );

// Disable ACF editing menu.
add_filter( 'acf/settings/show_admin', '__return_true' ); // TODO: Change to false.

/**
 * Set ACF color pallette.
 */
function bs_set_acf_color_palette() {
	?>
	<script type="text/javascript">
		(function($) {
			acf.addFilter('color_picker_args', function (args) {
				const settings = wp.data.select("core/editor").getEditorSettings();
				const colors = settings.colors.map(x => x.color);
				args.palettes = colors;
				return args;
			});
		})(jQuery);
	</script>
	<?php
}
add_action( 'acf/input/admin_footer', 'bs_set_acf_color_palette' );

/**
 * Gutenberg scripts and styles to admin
 *
 * @return void
 */
function bs_custom_gutenberg_admin_scripts() {
	wp_enqueue_script( 'editor-script', get_template_directory_uri() . '/build/js/editor.min.js', array( 'wp-blocks', 'wp-dom' ), wp_get_theme()->Version, true );
}
add_action( 'enqueue_block_editor_assets', 'bs_custom_gutenberg_admin_scripts' );

/**
 * Only load styles for used blocks.
 */
add_filter( 'should_load_separate_core_block_assets', '__return_true' );

/**
 * Remove WordPress generator meta.
 */
remove_action( 'wp_head', 'wp_generator' );
/**
 * Remove Windows Live Writer manifest link.
 */
remove_action( 'wp_head', 'wlwmanifest_link' );
/**
 * Remove the link to Really Simple Discovery service endpoint.
 */
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
remove_action( 'wp_head', 'rest_output_link_wp_head' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'template_redirect', 'rest_output_link_header', 11 );

/**
 * Disable emoji
 */
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
add_filter( 'emoji_svg_url', '__return_false' );
add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );

/**
 * Disable emojicons
 *
 * @param array $plugins Array of plugins.
 * @return array
 */
function disable_emojicons_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) :
		return array_diff( $plugins, array( 'wpemoji' ) );
	endif;

	return array();
}

// Disable embed.

// Remove the REST API endpoint.
remove_action( 'rest_api_init', 'wp_oembed_register_route' );

// Turn off oEmbed auto discovery.
add_filter( 'embed_oembed_discover', '__return_false' );

// Don't filter oEmbed results.
remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );

// Remove oEmbed discovery links.
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

// Remove oEmbed-specific JavaScript from the front-end and back-end.
remove_action( 'wp_head', 'wp_oembed_add_host_js' );

add_action( 'template_redirect', 'template_redirect' );

/**
 * Deregister wp-embed script
 */
function template_redirect() {
	wp_deregister_script( 'wp-embed' );
}

/**
 * Add editor styles.
 */
function bs_editor_styles() {
	add_editor_style( 'build/css/editor.min.css' );
}
add_action( 'admin_init', 'bs_editor_styles' );

/**
 * Remove core blocks from editor.
 */
function bs_remove_default_blocks() {
	$registered_blocks = WP_Block_Type_Registry::get_instance()->get_all_registered();

	$filtered_blocks = array();

	$exceptions = array( 'core/button', 'core/buttons', 'core/column', 'core/columns', 'core/gallery', 'core/group', 'core/heading', 'core/image', 'core/list', 'core/list-item', 'core/paragraph', 'core/separator', 'core/spacer', 'core/table', 'core/html' );

	foreach ( $registered_blocks as $block ) {
		if ( strpos( $block->name, 'core/' ) === false || in_array( $block->name, $exceptions, true ) ) {
			array_push( $filtered_blocks, $block->name );
		}
	}

	return $filtered_blocks;
}
add_filter( 'allowed_block_types_all', 'bs_remove_default_blocks' );

/**
 * Remove unnecesary admin menus.
 */
function bs_remove_admin_menus() {
	remove_menu_page( 'edit-comments.php' );
	remove_menu_page( 'edit.php' );
}
add_action( 'admin_menu', 'bs_remove_admin_menus' );

/**
 * Remove comment support.
 */
function bs_remove_comment_support() {
	// Redirect any user trying to access comments page.
	global $pagenow;

	if ( 'edit-comments.php' === $pagenow ) {
		wp_safe_redirect( admin_url() );
		exit;
	}

	// Remove comments metabox from dashboard.
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );

	// Disable support for comments and trackbacks.
	remove_post_type_support( 'post', 'comments' );
	remove_post_type_support( 'page', 'comments' );
}
add_action( 'admin_init', 'bs_remove_comment_support', 100 );

// Close comments on the front-end.
add_filter( 'comments_open', '__return_false', 20, 2 );
add_filter( 'pings_open', '__return_false', 20, 2 );

// Hide existing comments.
add_filter( 'comments_array', '__return_empty_array', 10, 2 );

// Remove comments page in menu.
add_action(
	'admin_menu',
	function () {
		remove_menu_page( 'edit-comments.php' );
	}
);

/**
 * Remove comment support from admin bar.
 */
function bs_admin_bar_render() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu( 'comments' );
}
add_action( 'wp_before_admin_bar_render', 'bs_admin_bar_render' );

/**
 * Remove menu item whitespace.
 *
 * @param string $html_content HTML content.
 */
function bs_remove_menu_item_whitespace( $html_content ) {
	return preg_replace( '/>\s+</', '><', $html_content );
}
add_filter( 'wp_nav_menu_items', 'bs_remove_menu_item_whitespace' );

/**
 * Add JSON to upload mimes.
 *
 * @param array $mime_types HTML content.
 */
function bs_allow_json( $mime_types ) {
	$mime_types['json'] = 'application/json';
	return $mime_types;
}
add_filter( 'upload_mimes', 'bs_allow_json', 1, 1 );

/**
 * Custom login URL.
 */
function bs_custom_login_url() {
	return esc_url( home_url() );
}
add_filter( 'login_headerurl', 'bs_custom_login_url' );

/**
 * Drag & Drop Upload - change autodelete time to 7 days.
 *
 * @return int
 */
function bs_dnd_cf7_autodelete_time() {
	return 604800;
}
add_filter( 'dnd_cf7_auto_delete_files', 'bs_dnd_cf7_autodelete_time' );

/**
 * Change default excerpt length
 *
 * @return int
 */
function bs_excerpt_length() {
	return 20;
}
add_filter( 'excerpt_length', 'bs_excerpt_length', 999 );

/**
 * Change default excerpt end
 *
 * @return string
 */
function bs_excerpt_more() {
	return '...';
}
add_filter( 'excerpt_more', 'bs_excerpt_more', 999 );

require_once get_parent_theme_file_path( 'helpers.php' );
require_once get_parent_theme_file_path( 'ajax/archive.php' );
