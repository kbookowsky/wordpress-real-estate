<?php
/**
 * Theme template.
 *
 * @package ZlotyKlucz
 */

defined( 'ABSPATH' ) || exit;

$header_logo_light = get_field( 'header_logo_light', 'options' );
$header_logo_dark  = get_field( 'header_logo_dark', 'options' );
$header_cta        = get_field( 'header_cta', 'options' );

$header_type = get_field( 'header_type', get_the_ID() );
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
	<?php
	$fonts = array( 'lato-v24-latin-ext-300', 'lato-v24-latin-ext-regular', 'lato-v24-latin-ext-700' );
	foreach ( $fonts as $font ) {
		echo '<link rel="preload" as="font" href="' . esc_url( get_template_directory_uri() ) . '/build/fonts/' . esc_html( $font ) . '.woff2" type="font/woff2" crossorigin="anonymous">';
	}
	?>
	<script>
		var root = document.documentElement;
		root.className = root.className.replace("no-js", "js");
		root.setAttribute("data-useragent", navigator.userAgent);
		root.setAttribute("data-platform", navigator.platform);
	</script>
	<style>
		.page-sprite {
			display: none !important;
		}
	</style>
</head>
<body>
<?php
$site_name        = get_bloginfo( 'name' );
$site_description = get_bloginfo( 'description' );
if ( ! empty( $site_description && $site_name ) ) {
	?>
	<title>
		<?php echo esc_html( $site_name . ' – ' . $site_description ); ?>
	</title>
	<?php
} elseif ( ! empty( $site_name ) ) {
	?>
	<title>
		<?php echo esc_html( $site_name ); ?>
	</title>
	<?php
}
echo file_get_contents( get_template_directory() . '/build/img/sprite.svg' ); // phpcs:ignore
?>
<header class="header<?php echo 'fixed' === $header_type ? ' header--fixed' : ''; ?>" role="banner">
	<div class="container-wide header__content">
		<a class="skip-link screen-reader-text" href='#main'><?php esc_html_e( 'Przejdź do treści', 'zloty-klucz' ); ?></a>
		<a class="header__logo" href="<?php echo is_front_page() ? '#main' : esc_url( home_url() ); ?>" title="<?php echo esc_html( get_bloginfo( 'name' ) ); ?>">
			<?php echo wp_get_attachment_image( $header_logo_light, 'thumbnail', false, array( 'class' => 'logo-light' ) ); ?>
			<?php echo wp_get_attachment_image( $header_logo_dark, 'thumbnail', false, array( 'class' => 'logo-dark' ) ); ?>
		</a>
		<?php if ( has_nav_menu( 'main' ) ) { ?>
			<nav class="header__menu" role="navigation" aria-label="<?php esc_html_e( 'Main Menu', 'zloty-klucz' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'menu'           => 'main',
						'menu_class'     => 'menu menu--header',
						'container'      => false,
						'fallback_cb'    => false,
						'theme_location' => 'main',
						'items_wrap'     => '<ul id="%1$s" class="%2$s" role="menubar">%3$s</ul>',
					)
				);

				if ( ! empty( $header_cta['title'] && $header_cta['url'] ) ) {
					?>
					<div class="wp-block-button is-style-primary header__cta">
						<a href="<?php echo esc_url( $header_cta['url'] ); ?>" class="wp-block-button__link wp-element-button">
							<?php echo esc_html( $header_cta['title'] ); ?>
						</a>
					</div>
					<?php
				}
				?>
			</nav>
			<button id="hamburgerMenu" class="header__hamburger">
				<span class="screen-reader-text open active"><?php esc_html_e( 'Open Menu', 'zloty-klucz' ); ?></span>
				<span class="screen-reader-text close"><?php esc_html_e( 'Close Menu', 'zloty-klucz' ); ?></span>
				<span class="header__hamburger-icon">
					<span></span>
				</span>
			</button>
		<?php } ?>
	</div>
</header>
