<?php
/**
 * Case Study CPT.
 *
 * Documents client engagements (Challenge / Approach / Results / Testimonial).
 * Filterable by `sni_industry` taxonomy.
 *
 * URL: /clients/{slug}/ — matches the staging site so redirects are clean.
 * No archive — /clients/ is a regular page with a Linked Logo Grid block.
 *
 * @package sg-sni
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'init', function () {
	register_post_type( 'case_study', array(
		'labels' => array(
			'name'                  => _x( 'Case Studies', 'post type general name', 'sg-sni' ),
			'singular_name'         => _x( 'Case Study', 'post type singular name', 'sg-sni' ),
			'menu_name'             => _x( 'Case Studies', 'admin menu', 'sg-sni' ),
			'add_new_item'          => __( 'Add New Case Study', 'sg-sni' ),
			'new_item'              => __( 'New Case Study', 'sg-sni' ),
			'edit_item'             => __( 'Edit Case Study', 'sg-sni' ),
			'view_item'             => __( 'View Case Study', 'sg-sni' ),
			'all_items'             => __( 'All Case Studies', 'sg-sni' ),
			'featured_image'        => __( 'Hero Image', 'sg-sni' ),
		),
		'description'        => __( 'Client engagements — challenge, approach, results.', 'sg-sni' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_rest'       => true,
		'menu_position'      => 26,
		'menu_icon'          => 'dashicons-portfolio',
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
		'rewrite'            => array(
			'slug'       => 'clients',
			'with_front' => false,
		),
	) );
} );

/**
 * Industry taxonomy — seeded with the categories observed across the existing
 * Shapiro client roster. Admins can add more freely.
 */
add_action( 'init', function () {
	register_taxonomy( 'sni_industry', array( 'case_study' ), array(
		'labels' => array(
			'name'          => _x( 'Industries', 'taxonomy general name', 'sg-sni' ),
			'singular_name' => _x( 'Industry', 'taxonomy singular name', 'sg-sni' ),
			'all_items'     => __( 'All Industries', 'sg-sni' ),
			'edit_item'     => __( 'Edit Industry', 'sg-sni' ),
			'add_new_item'  => __( 'Add New Industry', 'sg-sni' ),
			'menu_name'     => __( 'Industries', 'sg-sni' ),
		),
		'hierarchical'      => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'public'            => false,
		'publicly_queryable'=> false,
		'rewrite'           => false,
	) );

	foreach ( array(
		array( 'name' => 'Sports',                'slug' => 'sports' ),
		array( 'name' => 'Financial Services',    'slug' => 'financial-services' ),
		array( 'name' => 'Pharmaceutical',        'slug' => 'pharmaceutical' ),
		array( 'name' => 'Professional Services', 'slug' => 'professional-services' ),
		array( 'name' => 'Telecommunications',    'slug' => 'telecommunications' ),
		array( 'name' => 'Technology',            'slug' => 'technology' ),
		array( 'name' => 'Healthcare',            'slug' => 'healthcare' ),
		array( 'name' => 'Retail',                'slug' => 'retail' ),
		array( 'name' => 'Media',                 'slug' => 'media' ),
	) as $term ) {
		if ( ! term_exists( $term['slug'], 'sni_industry' ) ) {
			wp_insert_term( $term['name'], 'sni_industry', array( 'slug' => $term['slug'] ) );
		}
	}
} );
