<?php
/**
 * Team Member CPT.
 *
 * One CPT covers both team members and external/keynote speakers — the
 * `sni_team_role` taxonomy (registered separately) distinguishes them.
 * A single person can hold both terms.
 *
 * Body: full Gutenberg (so editors can compose freely).
 * Sidebar meta: ACF fields (see inc/acf-team-member.php).
 *
 * URL: /who-we-are/{slug}/ — matches the staging site so redirects are clean.
 * No archive — /who-we-are/ is a regular page that includes a Team Grid block.
 *
 * @package sg-sni
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'init', function () {
	register_post_type( 'team_member', array(
		'labels' => array(
			'name'                  => _x( 'Team Members', 'post type general name', 'sg-sni' ),
			'singular_name'         => _x( 'Team Member', 'post type singular name', 'sg-sni' ),
			'menu_name'             => _x( 'Team Members', 'admin menu', 'sg-sni' ),
			'add_new'               => __( 'Add New', 'sg-sni' ),
			'add_new_item'          => __( 'Add New Team Member', 'sg-sni' ),
			'new_item'              => __( 'New Team Member', 'sg-sni' ),
			'edit_item'             => __( 'Edit Team Member', 'sg-sni' ),
			'view_item'             => __( 'View Team Member', 'sg-sni' ),
			'all_items'             => __( 'All Team Members', 'sg-sni' ),
			'search_items'          => __( 'Search Team Members', 'sg-sni' ),
			'not_found'             => __( 'No team members found.', 'sg-sni' ),
			'featured_image'        => __( 'Headshot', 'sg-sni' ),
			'set_featured_image'    => __( 'Set headshot', 'sg-sni' ),
			'remove_featured_image' => __( 'Remove headshot', 'sg-sni' ),
			'use_featured_image'    => __( 'Use as headshot', 'sg-sni' ),
		),
		'description'        => __( 'Bios for SNI team members and external speakers. Categorize via the Role taxonomy.', 'sg-sni' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_rest'       => true,
		'menu_position'      => 25,
		'menu_icon'          => 'dashicons-id',
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'page-attributes' ),
		'rewrite'            => array(
			'slug'       => 'who-we-are',
			'with_front' => false,
		),
	) );
} );

/**
 * Role taxonomy — two terms shipped on first activation: team-member, speaker.
 * Hierarchical so admins see checkboxes (and a person can hold both).
 */
add_action( 'init', function () {
	register_taxonomy( 'sni_team_role', array( 'team_member' ), array(
		'labels' => array(
			'name'              => _x( 'Roles', 'taxonomy general name', 'sg-sni' ),
			'singular_name'     => _x( 'Role', 'taxonomy singular name', 'sg-sni' ),
			'search_items'      => __( 'Search Roles', 'sg-sni' ),
			'all_items'         => __( 'All Roles', 'sg-sni' ),
			'edit_item'         => __( 'Edit Role', 'sg-sni' ),
			'update_item'       => __( 'Update Role', 'sg-sni' ),
			'add_new_item'      => __( 'Add New Role', 'sg-sni' ),
			'new_item_name'     => __( 'New Role Name', 'sg-sni' ),
			'menu_name'         => __( 'Roles', 'sg-sni' ),
		),
		'hierarchical'      => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'public'            => false,
		'publicly_queryable'=> false,
		'rewrite'           => false,
	) );

	// Seed the two canonical terms on init if they don't exist yet.
	foreach ( array(
		array( 'name' => 'Team Member', 'slug' => 'team-member' ),
		array( 'name' => 'Speaker',     'slug' => 'speaker' ),
	) as $term ) {
		if ( ! term_exists( $term['slug'], 'sni_team_role' ) ) {
			wp_insert_term( $term['name'], 'sni_team_role', array( 'slug' => $term['slug'] ) );
		}
	}
} );
