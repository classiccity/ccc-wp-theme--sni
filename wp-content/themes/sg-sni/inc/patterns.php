<?php
/**
 * Block pattern registrations.
 *
 * Two patterns ship with SNI:
 *   - sni/industry-page — the 8-block recipe used identically on all 7
 *     existing industry pages. Editors insert this and swap copy/logos.
 *   - sni/service-opener — Hero + Split intro used on all 5 service pages.
 *
 * Patterns sit in the `patterns/` directory of the theme and are
 * auto-registered by WordPress core if they follow the block-pattern
 * file header format. This file is here in case future patterns need
 * programmatic registration; for now it just declares the SNI category.
 *
 * @package sg-sni
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'init', function () {
	if ( function_exists( 'register_block_pattern_category' ) ) {
		register_block_pattern_category( 'sni', array(
			'label' => __( 'Shapiro Negotiations', 'sg-sni' ),
		) );
	}
} );
