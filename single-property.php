<?php
/**
 * The template for displaying singular post-types: posts, pages and user-defined custom post types.
 *
 * @package ZlotyKlucz
 */

defined( 'ABSPATH' ) || exit;

get_header();

$property_id      = get_the_ID();
$property_content = get_fields( $property_id );
$property_gallery = $property_content['property_gallery'];
$property_agent   = $property_content['property_agent'];
$agent_content    = get_fields( $property_agent );
$agent_phone      = $agent_content['agent_phone'];
$agent_email      = $agent_content['agent_email'];

while ( have_posts() ) {
	the_post();
	?>

	<main id="main" class="main main--property">
		<div class="container">
			<div class="row property__wrapper">
				<div class="col-12 property__heading">
					<h1 class="property__title onscroll">
						<?php the_title(); ?>
					</h1>
				</div>
				<div class="col-sm-7 col-md-6 property__gallery">
					<?php if ( ! empty( $property_gallery ) && is_array( $property_gallery ) ) { ?>
						<div class="swiper property__slider onscroll">
							<div class="swiper-wrapper">
								<?php foreach ( $property_gallery as $image ) { ?>
									<div class="swiper-slide">
										<?php echo wp_get_attachment_image( $image, '2048x2048' ); ?>
									</div>
								<?php } ?>
							</div>
							<div class="swiper-button-prev"></div>
							<div class="swiper-button-next"></div>
						</div>
						<div class="swiper property__slider__thumbs onscroll">
							<div class="swiper-wrapper">
								<?php foreach ( $property_gallery as $image ) { ?>
									<div class="swiper-slide">
										<?php echo wp_get_attachment_image( $image, 'thumbnail' ); ?>
									</div>
								<?php } ?>
							</div>
						</div>
					<?php } ?>
				</div>
				<div class="col-sm-5 col-md-4 property__contact">
					<div class="property__agent">
						<div class="property__agent__info onscroll">
							<div class="property__agent__image">
								<?php echo get_the_post_thumbnail( $property_agent, 'thumbnail' ); ?>
							</div>
							<div class="property__agent__name">
								<span class="name has-h-4-font-size">
									<?php echo esc_html( get_the_title( $property_agent ) ); ?>
								</span>
								<span class="position">
									<?php echo esc_html( $agent_content['agent_position'] ); ?>
								</span>
							</div>
						</div>
						<div class="property__agent__contact">
							<a class="property__agent__phone onscroll" href="tel:<?php echo esc_html( str_replace( array( ' ', '-' ), '', $agent_phone ) ); ?>">
								<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
									<path d="M19.65 23.6834L14.2 29.1334C13.6 28.6 13.0167 28.05 12.45 27.4834C10.7334 25.75 9.18337 23.9334 7.80004 22.0334C6.43337 20.1334 5.33337 18.2334 4.53337 16.35C3.73337 14.45 3.33337 12.6334 3.33337 10.9C3.33337 9.76671 3.53337 8.68337 3.93337 7.68337C4.33337 6.66671 4.96671 5.73337 5.85004 4.90004C6.91671 3.85004 8.08337 3.33337 9.31671 3.33337C9.78337 3.33337 10.25 3.43337 10.6667 3.63337C11.1 3.83337 11.4834 4.13337 11.7834 4.56671L15.65 10.0167C15.95 10.4334 16.1667 10.8167 16.3167 11.1834C16.4667 11.5334 16.55 11.8834 16.55 12.2C16.55 12.6 16.4334 13 16.2 13.3834C15.9834 13.7667 15.6667 14.1667 15.2667 14.5667L14 15.8834C13.8167 16.0667 13.7334 16.2834 13.7334 16.55C13.7334 16.6834 13.75 16.8 13.7834 16.9334C13.8334 17.0667 13.8834 17.1667 13.9167 17.2667C14.2167 17.8167 14.7334 18.5334 15.4667 19.4C16.2167 20.2667 17.0167 21.15 17.8834 22.0334C18.4834 22.6167 19.0667 23.1834 19.65 23.6834Z" fill="#EDC74C"/>
									<path d="M36.616 30.55C36.616 31.0167 36.5327 31.5 36.366 31.9667C36.316 32.1 36.266 32.2334 36.1994 32.3667C35.916 32.9667 35.5494 33.5334 35.066 34.0667C34.2494 34.9667 33.3494 35.6167 32.3327 36.0334C32.316 36.0334 32.2994 36.05 32.2827 36.05C31.2994 36.45 30.2327 36.6667 29.0827 36.6667C27.3827 36.6667 25.566 36.2667 23.6494 35.45C21.7327 34.6334 19.816 33.5334 17.916 32.15C17.266 31.6667 16.6161 31.1834 15.9994 30.6667L21.4494 25.2167C21.916 25.5667 22.3327 25.8334 22.6827 26.0167C22.766 26.05 22.866 26.1 22.9827 26.15C23.116 26.2 23.2494 26.2167 23.3994 26.2167C23.6827 26.2167 23.8994 26.1167 24.0827 25.9334L25.3494 24.6834C25.766 24.2667 26.166 23.95 26.5494 23.75C26.9327 23.5167 27.316 23.4 27.7327 23.4C28.0494 23.4 28.3827 23.4667 28.7494 23.6167C29.116 23.7667 29.4994 23.9834 29.916 24.2667L35.4327 28.1834C35.866 28.4834 36.166 28.8334 36.3494 29.25C36.516 29.6667 36.616 30.0834 36.616 30.55Z" fill="#191919"/>
								</svg>
								<?php echo esc_html( $agent_phone ); ?>
							</a>
							<a class="property__agent__email onscroll" href="mailto:<?php echo esc_html( $agent_email ); ?>">
								<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
									<path d="M28.3334 34.1667H11.6667C6.66671 34.1667 3.33337 31.6667 3.33337 25.8334V14.1667C3.33337 8.33337 6.66671 5.83337 11.6667 5.83337H28.3334C33.3334 5.83337 36.6667 8.33337 36.6667 14.1667V25.8334C36.6667 31.6667 33.3334 34.1667 28.3334 34.1667Z" fill="#EDC74C"/>
									<path d="M20.0014 21.45C18.6014 21.45 17.1847 21.0167 16.1013 20.1333L10.8846 15.9666C10.3513 15.5333 10.2513 14.75 10.6846 14.2166C11.118 13.6833 11.9013 13.5833 12.4346 14.0166L17.6514 18.1833C18.918 19.2 21.0679 19.2 22.3345 18.1833L27.5514 14.0166C28.0847 13.5833 28.8847 13.6666 29.3014 14.2166C29.7347 14.75 29.6514 15.55 29.1014 15.9666L23.8847 20.1333C22.818 21.0167 21.4014 21.45 20.0014 21.45Z" fill="#191919"/>
								</svg>
								<?php echo esc_html( $agent_email ); ?>
							</a>
						</div>
						<div class="property__agent__form onscroll">
							<?php echo do_shortcode( $agent_content['agent_form_shortcode'] ); ?>
						</div>
					</div>
				</div>
				<div class="col-12 property__details">
					<div class="property__details__heading">
						<h2 class="property__details__title onscroll">
							<?php esc_html_e( 'Szczegóły oferty', 'zloty-klucz' ); ?>
						</h2>
					</div>
					<div class="property__details__content">
						<div class="property__detail onscroll">
							<span class="property__detail__heading">
								<?php esc_html_e( 'Numer oferty:', 'zloty-klucz' ); ?>
							</span>
							<span class="property__detail__value">
								<?php echo esc_html( $property_content['offer_number'] ); ?>
							</span>
						</div>
						<div class="property__detail onscroll">
							<span class="property__detail__heading">
								<?php esc_html_e( 'Typ transakcji:', 'zloty-klucz' ); ?>
							</span>
							<span class="property__detail__value">
								<?php echo esc_html( get_the_terms( $property_id, 'transaction_type' )[0]->name ?? '' ); ?>
							</span>
						</div>
						<div class="property__detail onscroll">
							<span class="property__detail__heading">
								<?php esc_html_e( 'Typ nieruchomości:', 'zloty-klucz' ); ?>
							</span>
							<span class="property__detail__value">
								<?php echo esc_html( get_the_terms( $property_id, 'property_type' )[0]->name ?? '' ); ?>
							</span>
						</div>
						<div class="property__detail onscroll">
							<span class="property__detail__heading">
								<?php esc_html_e( 'Cena:', 'zloty-klucz' ); ?>
							</span>
							<span class="property__detail__value">
								<?php echo esc_html( $property_content['property_price'] . 'zł' ); ?>
							</span>
						</div>
						<div class="property__detail onscroll">
							<span class="property__detail__heading">
								<?php esc_html_e( 'Cena za m²:', 'zloty-klucz' ); ?>
							</span>
							<span class="property__detail__value">
								<?php echo esc_html( $property_content['square_meter_price'] . 'zł' ); ?>
							</span>
						</div>
						<div class="property__detail onscroll">
							<span class="property__detail__heading">
								<?php esc_html_e( 'Powierzchnia:', 'zloty-klucz' ); ?>
							</span>
							<span class="property__detail__value">
								<?php echo esc_html( $property_content['property_area'] . 'm²' ); ?>
							</span>
						</div>
						<div class="property__detail onscroll">
							<span class="property__detail__heading">
								<?php esc_html_e( 'Pow. użytkowa:', 'zloty-klucz' ); ?>
							</span>
							<span class="property__detail__value">
								<?php echo esc_html( $property_content['property_usable_area'] . 'm²' ); ?>
							</span>
						</div>
						<div class="property__detail onscroll">
							<span class="property__detail__heading">
								<?php esc_html_e( 'Liczba pokoi:', 'zloty-klucz' ); ?>
							</span>
							<span class="property__detail__value">
								<?php echo esc_html( $property_content['property_rooms'] ); ?>
							</span>
						</div>
						<div class="property__detail onscroll">
							<span class="property__detail__heading">
								<?php esc_html_e( 'Liczba pięter:', 'zloty-klucz' ); ?>
							</span>
							<span class="property__detail__value">
								<?php echo esc_html( $property_content['property_floors'] ); ?>
							</span>
						</div>
						<div class="property__detail onscroll">
							<span class="property__detail__heading">
								<?php esc_html_e( 'Rok budowy:', 'zloty-klucz' ); ?>
							</span>
							<span class="property__detail__value">
								<?php echo esc_html( $property_content['property_year'] ); ?>
							</span>
						</div>
						<div class="property__detail onscroll">
							<span class="property__detail__heading">
								<?php esc_html_e( 'Liczba sypialni:', 'zloty-klucz' ); ?>
							</span>
							<span class="property__detail__value">
								<?php echo esc_html( $property_content['property_bedrooms'] ); ?>
							</span>
						</div>
						<div class="property__detail onscroll">
							<span class="property__detail__heading">
								<?php esc_html_e( 'Liczba łazienek:', 'zloty-klucz' ); ?>
							</span>
							<span class="property__detail__value">
								<?php echo esc_html( $property_content['property_bathrooms'] ); ?>
							</span>
						</div>
					</div>
				</div>
				<div class="col-12 property__description">
					<div class="property__description__heading">
						<h2 class="property__description__title onscroll">
							<?php esc_html_e( 'Opis', 'zloty-klucz' ); ?>
						</h2>
					</div>
					<div class="property__description__content onscroll">
						<?php
						if ( ! empty( get_the_content() ) ) {
							the_content();
						} else {
							?>
							<p>
								<?php esc_html_e( 'Wygląda na to, że opis nieruchomości jest pusty.', 'zloty-klucz' ); ?>
							</p>
							<?php
						}
						?>
					</div>
				</div>
				<div class="col-12 property__location">
					<div class="property__location__heading">
						<h2 class="property__location__title onscroll">
							<?php esc_html_e( 'Lokalizacja', 'zloty-klucz' ); ?>
						</h2>
					</div>
					<div class="property__location__content">
						<iframe class="onscroll" width="100%" height="300" frameborder="0" style="border:0" referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAwW30Hxm7OTMG6S37q5zfyS7KjEhpotRc&q=<?php echo esc_html( $property_content['property_location']['address'] ); ?>" allowfullscreen>
						</iframe>
					</div>
				</div>
			</div>
		</div>
		<?php
		$cta_heading   = get_field( 'cta_heading', 'options' );
		$cta_left      = get_field( 'cta_left_side', 'options' );
		$cta_separator = get_field( 'cta_separator', 'options' );
		$cta_right     = get_field( 'cta_right_side', 'options' );
		?>
		<section class="cta block--custom block--cta border-top" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);">
			<div class="container">
				<div class="row">
					<div class="col-12 cta__heading">
						<h2 class="cta__title onscroll">
							<?php echo wp_kses_post( $cta_heading ); ?>
						</h2>
					</div>
					<div class="col-12 cta__content">
						<div class="cta__left">
							<h3 class="cta__left__heading has-h-4-font-size onscroll">
								<?php echo wp_kses_post( $cta_left['heading'] ); ?>
							</h3>
							<div class="cta__left__content">
								<a class="cta__left__phone onscroll" href="tel:<?php echo esc_html( str_replace( array( ' ', '-' ), '', $cta_left['phone_number'] ) ); ?>">
									<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
										<path d="M19.65 23.6834L14.2 29.1334C13.6 28.6 13.0167 28.05 12.45 27.4834C10.7334 25.75 9.18337 23.9334 7.80004 22.0334C6.43337 20.1334 5.33337 18.2334 4.53337 16.35C3.73337 14.45 3.33337 12.6334 3.33337 10.9C3.33337 9.76671 3.53337 8.68337 3.93337 7.68337C4.33337 6.66671 4.96671 5.73337 5.85004 4.90004C6.91671 3.85004 8.08337 3.33337 9.31671 3.33337C9.78337 3.33337 10.25 3.43337 10.6667 3.63337C11.1 3.83337 11.4834 4.13337 11.7834 4.56671L15.65 10.0167C15.95 10.4334 16.1667 10.8167 16.3167 11.1834C16.4667 11.5334 16.55 11.8834 16.55 12.2C16.55 12.6 16.4334 13 16.2 13.3834C15.9834 13.7667 15.6667 14.1667 15.2667 14.5667L14 15.8834C13.8167 16.0667 13.7334 16.2834 13.7334 16.55C13.7334 16.6834 13.75 16.8 13.7834 16.9334C13.8334 17.0667 13.8834 17.1667 13.9167 17.2667C14.2167 17.8167 14.7334 18.5334 15.4667 19.4C16.2167 20.2667 17.0167 21.15 17.8834 22.0334C18.4834 22.6167 19.0667 23.1834 19.65 23.6834Z" fill="#EDC74C"/>
										<path d="M36.616 30.55C36.616 31.0167 36.5327 31.5 36.366 31.9667C36.316 32.1 36.266 32.2334 36.1994 32.3667C35.916 32.9667 35.5494 33.5334 35.066 34.0667C34.2494 34.9667 33.3494 35.6167 32.3327 36.0334C32.316 36.0334 32.2994 36.05 32.2827 36.05C31.2994 36.45 30.2327 36.6667 29.0827 36.6667C27.3827 36.6667 25.566 36.2667 23.6494 35.45C21.7327 34.6334 19.816 33.5334 17.916 32.15C17.266 31.6667 16.6161 31.1834 15.9994 30.6667L21.4494 25.2167C21.916 25.5667 22.3327 25.8334 22.6827 26.0167C22.766 26.05 22.866 26.1 22.9827 26.15C23.116 26.2 23.2494 26.2167 23.3994 26.2167C23.6827 26.2167 23.8994 26.1167 24.0827 25.9334L25.3494 24.6834C25.766 24.2667 26.166 23.95 26.5494 23.75C26.9327 23.5167 27.316 23.4 27.7327 23.4C28.0494 23.4 28.3827 23.4667 28.7494 23.6167C29.116 23.7667 29.4994 23.9834 29.916 24.2667L35.4327 28.1834C35.866 28.4834 36.166 28.8334 36.3494 29.25C36.516 29.6667 36.616 30.0834 36.616 30.55Z" fill="#191919"/>
									</svg>
									<?php echo esc_html( $cta_left['phone_number'] ); ?>
								</a>
								<a class="cta__left__email onscroll" href="mailto:<?php echo esc_html( $cta_left['email_address'] ); ?>">
									<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
										<path d="M28.3334 34.1667H11.6667C6.66671 34.1667 3.33337 31.6667 3.33337 25.8334V14.1667C3.33337 8.33337 6.66671 5.83337 11.6667 5.83337H28.3334C33.3334 5.83337 36.6667 8.33337 36.6667 14.1667V25.8334C36.6667 31.6667 33.3334 34.1667 28.3334 34.1667Z" fill="#EDC74C"/>
										<path d="M20.0014 21.45C18.6014 21.45 17.1847 21.0167 16.1013 20.1333L10.8846 15.9666C10.3513 15.5333 10.2513 14.75 10.6846 14.2166C11.118 13.6833 11.9013 13.5833 12.4346 14.0166L17.6514 18.1833C18.918 19.2 21.0679 19.2 22.3345 18.1833L27.5514 14.0166C28.0847 13.5833 28.8847 13.6666 29.3014 14.2166C29.7347 14.75 29.6514 15.55 29.1014 15.9666L23.8847 20.1333C22.818 21.0167 21.4014 21.45 20.0014 21.45Z" fill="#191919"/>
									</svg>
									<?php echo esc_html( $cta_left['email_address'] ); ?>
								</a>
							</div>
						</div>
						<div class="separator has-h-3-font-size onscroll">
							<?php echo wp_kses_post( $cta_separator ); ?>
						</div>
						<div class="cta__right">
							<h3 class="cta__right__heading has-h-4-font-size onscroll">
								<?php echo wp_kses_post( $cta_right['heading'] ); ?>
							</h3>
							<div class="cta__right__content onscroll">
								<?php echo do_shortcode( $cta_right['form_shortcode'] ); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
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
