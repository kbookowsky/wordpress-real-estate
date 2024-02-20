<?php
/**
 * Theme template.
 *
 * @package ZlotyKlucz
 */

defined( 'ABSPATH' ) || exit;

$footer_logo = get_field( 'footer_logo', 'options' );
$footer_data = get_field( 'footer_data', 'options' );
$footer_copy = get_field( 'footer_copyright', 'options' );
?>

<footer role="contentinfo">
	<div class="footer">
		<div class="container-wide">
			<div class="row">
				<div class="col-xmd-4 offset-md-1 footer__logo">
					<a href="<?php echo is_front_page() ? '#main' : esc_url( home_url() ); ?>" title="<?php echo esc_html( get_bloginfo( 'name' ) ); ?>">
						<?php echo wp_get_attachment_image( $footer_logo ); ?>
					</a>
				</div>
				<div class="col-sm-6 col-xmd-4 col-md-3 footer__data">
					<h2 class="has-h-4-font-size">
						<?php esc_html_e( 'Informacje', 'zloty-klucz' ); ?>
					</h2>
					<?php echo wp_kses_post( $footer_data ); ?>
				</div>
				<div class="col-sm-6 col-xmd-4 col-md-3 footer__navigation">
					<h2 class="has-h-4-font-size">
						<?php esc_html_e( 'Menu', 'zloty-klucz' ); ?>
					</h2>
					<?php if ( has_nav_menu( 'footer' ) ) { ?>
						<nav class="footer__menu" role="navigation">
							<?php
							wp_nav_menu(
								array(
									'menu'           => 'footer',
									'menu_class'     => 'menu menu--footer',
									'container'      => false,
									'fallback_cb'    => false,
									'theme_location' => 'footer',
								)
							);
							?>
						</nav>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<div class="footnote">
		<div class="container">
			<div class="row">
				<div class="col-16 footnote__content">
					<div class="footnote__text">
						&copy;<?php echo esc_attr( gmdate( 'Y' ) ); ?>
						<?php echo ! empty( $footer_copy ) ? wp_kses_post( $footer_copy ) : ''; ?>
					</div>
					<?php if ( has_nav_menu( 'footnote' ) ) { ?>
						<div class="footnote__navigation">
							<nav class="footnote__menu" role="navigation">
								<?php
								wp_nav_menu(
									array(
										'menu'           => 'footnote',
										'menu_class'     => 'menu menu--footnote',
										'container'      => false,
										'fallback_cb'    => false,
										'theme_location' => 'footnote',
									)
								);
								?>
							</nav>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
