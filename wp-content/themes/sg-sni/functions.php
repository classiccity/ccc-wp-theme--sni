<?php
/**
 * Child theme bootstrap for sg-sni.
 * Shapiro Negotiations Institute. Inherits classic-city-core.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'sg-sni-google-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap',
		array(),
		null
	);
	wp_enqueue_style(
		'sg-sni-style',
		get_stylesheet_uri(),
		array( 'ccc-blocks' ),
		file_exists( get_stylesheet_directory() . '/style.css' )
			? (string) filemtime( get_stylesheet_directory() . '/style.css' )
			: '1.0.0'
	);
}, 20 );

add_action( 'after_setup_theme', function () {
	add_editor_style( 'style.css' );
} );

/**
 * Auto-register ACF blocks from sg-sni/blocks/{slug}/. Mirrors the parent's
 * block loader but scoped to this child directory.
 */
add_action( 'init', function () {
	$blocks_dir = get_stylesheet_directory() . '/blocks';
	if ( ! is_dir( $blocks_dir ) ) return;
	foreach ( glob( $blocks_dir . '/*', GLOB_ONLYDIR ) as $block_path ) {
		if ( file_exists( $block_path . '/block.json' ) ) {
			register_block_type_from_metadata( $block_path );
		}
	}
}, 5 );

add_action( 'acf/include_fields', function () {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) return;
	foreach ( glob( get_stylesheet_directory() . '/blocks/*/fields.php' ) as $fields_file ) {
		require_once $fields_file;
	}
}, 5 );

/**
 * Load every PHP file under inc/ — CPTs, taxonomies, CPT-level ACF, patterns,
 * etc. Each file is responsible for its own hooks; this loader just includes
 * everything alphabetically so order is predictable.
 */
foreach ( glob( get_stylesheet_directory() . '/inc/*.php' ) as $inc_file ) {
	require_once $inc_file;
}

/**
 * Diagonal section-divider block styles — the SNI brand signature.
 * "bottom" cuts a slanted bottom edge on a group; "top" mirrors it on the
 * following group so the two slants align tightly.
 */
add_action( 'init', function () {
	register_block_style( 'core/group', array(
		'name'  => 'diagonal-divider-bottom',
		'label' => __( 'Diagonal Divider Bottom', 'sg-sni' ),
	) );
	register_block_style( 'core/group', array(
		'name'  => 'diagonal-divider-top',
		'label' => __( 'Diagonal Divider Top', 'sg-sni' ),
	) );
} );

/**
 * Gravity Forms: render submit buttons with the same classes a WP core Button
 * block uses, so they pick up theme.json `elements.button` styling AND the
 * parent theme's palette pair-helpers automatically.
 */
add_filter( 'gform_submit_button', function ( $button, $form ) {
	$form_id = absint( $form['id'] ?? 0 );
	$text    = $form['button']['text'] ?? __( 'Submit', 'sg-sni' );
	$classes = 'gform_button wp-block-button__link wp-element-button has-cta-background-color has-background';
	return sprintf(
		'<button type="submit" id="gform_submit_button_%1$d" class="%2$s">%3$s</button>',
		$form_id,
		esc_attr( $classes ),
		esc_html( $text )
	);
}, 10, 2 );
