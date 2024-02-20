<?php
/**
 * The template for displaying singular post-types: posts, pages and user-defined custom post types.
 *
 * @package ZlotyKlucz
 */

defined( 'ABSPATH' ) || exit;

get_header();

$current_post_type = get_post_type_object( get_post_type() );
$post_type_label   = '';

if ( $current_post_type ) {
	$post_type_label = $current_post_type->labels->singular_name;
}

$post_date     = get_the_date( get_option( 'date_format' ) );
$post_date_iso = get_the_time( 'c' );

while ( have_posts() ) {
	the_post();
	?>

	<main id="main" class="main main--post">
		<div class="container">
			<div class="row post__main">
				<div class="col-md-10 offset-md-1">
					<article class="post__content">
						<?php the_content(); ?>
					</article>
				</div>
			</div>
		</div>
	</main>
	<?php
}

$cookies_heading = get_field( 'cookies_heading', 'options' );
$cookies_consent = get_field( 'cookies_consent', 'options' );
$cookies_on      = get_field( 'cookies_on', 'options' );

if ( ! isset( $_COOKIE['bs_cookie_consent'] ) && $cookies_on ) {
	?>
	<div class="cookies-notice">
		<div class="container">
			<div class="row">
				<div class="col-12 cookies-notice__content">
					<div class="cookies-notice__text">
						<?php if ( ! empty( $cookies_heading ) ) { ?>
							<div class="cookies-notice__heading has-h-4-font-size">
								<?php echo wp_kses_post( $cookies_heading ); ?>
							</div>
						<?php } ?>
						<?php if ( ! empty( $cookies_consent ) ) { ?>
							<div class="cookies-notice__consent">
								<?php echo wp_kses_post( $cookies_consent ); ?>
							</div>
						<?php } ?>
					</div>
					<div class="cookies-notice__buttons">
						<div class="wp-block-button is-style-primary">
							<a href="<?php echo esc_url( get_privacy_policy_url() ); ?>" class="wp-block-button__link wp-element-button">
								<?php esc_html_e( 'Polityka prywatności', 'zloty-klucz' ); ?>
							</a>
						</div>
						<div class="wp-block-button is-style-primary">
							<button id="bs-accept-cookies" type="button" class="wp-block-button__link wp-element-button">
								<?php esc_html_e( 'Akceptuję', 'zloty-klucz' ); ?>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}

get_footer();
