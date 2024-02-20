<?php
/**
 * Theme template.
 *
 * @package ZlotyKlucz
 */

defined( 'ABSPATH' ) || exit;

global $wp_query;

$page_for_posts = get_option( 'page_for_posts' );
$archive_title  = get_the_title( $page_for_posts );

get_header();
?>

<main id="main" class="main main--archive" data-post-type="post">
	<section class="archive__content">
		<div class="container">
			<div class="row">
				<div class="col-md-10 offset-md-1 archive__items" data-page="1">
					<?php if ( have_posts() ) { ?>
						<?php while ( have_posts() ) { ?>
							<?php the_post(); ?>
							<?php get_template_part( 'partials/card-post' ); ?>
						<?php } ?>
						<?php if ( $wp_query->max_num_pages > 1 ) { ?>
							<div class="archive__load-more">
								<div class="wp-block-button is-style-primary header__cta">
									<button class="wp-block-button__link wp-element-button">
										<span>
											<?php esc_html_e( 'Załaduj więcej', 'zloty-klucz' ); ?>
										</span>
										<svg class="loader" width="22" height="21" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path fill-rule="evenodd" clip-rule="evenodd" d="M10.4413 19.7332C8.26866 19.6098 6.13156 18.7182 4.47187 17.0583C2.92642 15.5126 2.04719 13.5531 1.83415 11.5365L0.829108 11.5365C1.04544 13.8098 2.02397 16.0243 3.76472 17.7653C5.61968 19.6206 8.01244 20.6103 10.4413 20.7346L10.4413 19.7332ZM21.1214 11.2845C21.321 8.44512 20.3356 5.53802 18.165 3.36713C16.1077 1.30954 13.3889 0.316491 10.693 0.388043L10.693 1.38844C13.1328 1.31662 15.5958 2.21189 17.4578 4.07419C19.4332 6.04985 20.3201 8.70167 20.1187 11.2845H21.1214Z"/>
										</svg>
									</button>
								</div>
							</div>
						<?php } ?>
					<?php } else { ?>
						<div class="archive__message">
							<p><?php esc_html_e( 'Wygląda na to, że nie ma żadnych postów do wyświetlenia', 'zloty-klucz' ); ?></p>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</section>
</main>

<?php
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
