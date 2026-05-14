<?php
/**
 * Book CPT.
 *
 * Books authored by SNI team members. Linked to team_member CPT via an
 * ACF relationship field (see inc/acf-book.php).
 *
 * URL: /resources/books/{slug}/ — nested under /resources/.
 * No archive — /resources/books/ is a regular page with a Books listing.
 *
 * @package sg-sni
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'init', function () {
	register_post_type( 'book', array(
		'labels' => array(
			'name'                  => _x( 'Books', 'post type general name', 'sg-sni' ),
			'singular_name'         => _x( 'Book', 'post type singular name', 'sg-sni' ),
			'menu_name'             => _x( 'Books', 'admin menu', 'sg-sni' ),
			'add_new_item'          => __( 'Add New Book', 'sg-sni' ),
			'new_item'              => __( 'New Book', 'sg-sni' ),
			'edit_item'             => __( 'Edit Book', 'sg-sni' ),
			'view_item'             => __( 'View Book', 'sg-sni' ),
			'all_items'             => __( 'All Books', 'sg-sni' ),
			'featured_image'        => __( 'Cover Image', 'sg-sni' ),
			'set_featured_image'    => __( 'Set cover image', 'sg-sni' ),
		),
		'description'        => __( 'Books authored by SNI team members.', 'sg-sni' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_rest'       => true,
		'menu_position'      => 27,
		'menu_icon'          => 'dashicons-book',
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
		'rewrite'            => array(
			'slug'       => 'resources/books',
			'with_front' => false,
		),
	) );
} );
