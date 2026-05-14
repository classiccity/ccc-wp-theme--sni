<?php
/**
 * ACF field group for the book CPT.
 *
 * Title is the WP post_title. Description is freeform in the Gutenberg
 * body. Everything else is structured ACF below.
 *
 * @package sg-sni
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/include_fields', function () {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) return;

	acf_add_local_field_group( array(
		'key'      => 'group_sni_book',
		'title'    => 'Book Details',
		'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'book' ) ) ),
		'position' => 'normal',
		'fields'   => array(
			array(
				'key'   => 'field_sni_book_subtitle',
				'label' => 'Subtitle',
				'name'  => 'subtitle',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_sni_book_authors',
				'label' => 'Authors',
				'name'  => 'authors',
				'type'  => 'relationship',
				'post_type' => array( 'team_member' ),
				'instructions' => 'Pick the team members who co-authored this book.',
				'required' => 1,
			),
			array(
				'key'   => 'field_sni_book_publication_year',
				'label' => 'Publication Year',
				'name'  => 'publication_year',
				'type'  => 'number',
			),
			array(
				'key'   => 'field_sni_book_publisher',
				'label' => 'Publisher',
				'name'  => 'publisher',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_sni_book_isbn',
				'label' => 'ISBN',
				'name'  => 'isbn',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_sni_book_purchase_links',
				'label' => 'Purchase Links',
				'name'  => 'purchase_links',
				'type'  => 'repeater',
				'layout' => 'table',
				'button_label' => 'Add Retailer',
				'sub_fields' => array(
					array(
						'key'     => 'field_sni_book_retailer',
						'label'   => 'Retailer',
						'name'    => 'retailer',
						'type'    => 'select',
						'choices' => array(
							'amazon'        => 'Amazon',
							'barnes-noble'  => 'Barnes & Noble',
							'bookshop'      => 'Bookshop.org',
							'apple-books'   => 'Apple Books',
							'google-books'  => 'Google Books',
							'audible'       => 'Audible',
							'publisher'     => 'Publisher Direct',
							'other'         => 'Other',
						),
						'required' => 1,
					),
					array( 'key' => 'field_sni_book_retailer_url', 'label' => 'URL', 'name' => 'url', 'type' => 'url', 'required' => 1 ),
				),
			),
			array(
				'key'   => 'field_sni_book_endorsements',
				'label' => 'Endorsements',
				'name'  => 'endorsements',
				'type'  => 'repeater',
				'layout' => 'block',
				'button_label' => 'Add Endorsement',
				'sub_fields' => array(
					array( 'key' => 'field_sni_book_endorsement_quote',  'label' => 'Quote',        'name' => 'quote',        'type' => 'textarea', 'rows' => 4, 'required' => 1 ),
					array( 'key' => 'field_sni_book_endorsement_name',   'label' => 'Name',         'name' => 'name',         'type' => 'text', 'required' => 1 ),
					array( 'key' => 'field_sni_book_endorsement_title',  'label' => 'Title',        'name' => 'title',        'type' => 'text' ),
				),
			),
			array(
				'key'   => 'field_sni_book_accolades',
				'label' => 'Accolades',
				'name'  => 'accolades',
				'type'  => 'repeater',
				'layout' => 'table',
				'button_label' => 'Add Accolade',
				'instructions' => 'e.g. "NYT bestseller", "#1 Amazon new release".',
				'sub_fields' => array(
					array( 'key' => 'field_sni_book_accolade_item', 'label' => 'Accolade', 'name' => 'item', 'type' => 'text', 'required' => 1 ),
				),
			),
			array(
				'key'   => 'field_sni_book_related',
				'label' => 'Related Books',
				'name'  => 'related_books',
				'type'  => 'relationship',
				'post_type' => array( 'book' ),
				'instructions' => '"Also Available" sidebar — pick other SNI titles to surface.',
			),
		),
	) );
} );
