<?php
/**
 * Loop for home page.
 *
 * @package ZlotyKlucz
 */

defined( 'ABSPATH' ) || exit;

global $post;

$post_date     = get_the_date( get_option( 'date_format' ) );
$post_date_iso = get_the_time( 'c' );

$defaults = array(
	'heading_tag' => 'h3',
);

$args = wp_parse_args( $args, $defaults );
?>

<a href="<?php the_permalink(); ?>" class="card-post onscroll">
	<div class="card-post__thumbnail">
		<?php the_post_thumbnail( 'medium' ); ?>
	</div>
	<div class="card-post__content">
		<div class="card-post__time">
			<time datetime="<?php echo esc_attr( $post_date_iso ); ?>">
				<?php echo esc_attr( $post_date ); ?>
			</time>
		</div>
		<<?php echo esc_html( $args['heading_tag'] ); ?> class="card-post__title">
			<?php echo ! empty( get_the_title() ) ? esc_html( get_the_title() ) : esc_html__( 'No title', 'zloty-klucz' ); ?>
		</<?php echo esc_html( $args['heading_tag'] ); ?>>
		<p class="card-post__excerpt">
			<?php echo wp_kses_post( wp_trim_words( get_the_excerpt(), 20 ) ); ?>
		</p>
	</div>
</a>
