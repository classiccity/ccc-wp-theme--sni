<?php
/**
 * ACF field group for the Linked Logo Grid block.
 *
 * Optional industry filter + max items. Logos pull from the case_study CPT's
 * client_logo ACF field; each tile links to the case study single page.
 *
 * @package sg-sni
 */

if ( ! defined( 'ABSPATH' ) ) exit;

acf_add_local_field_group( array(
	'key'      => 'group_sni_block_linked_logo_grid',
	'title'    => 'Linked Logo Grid',
	'location' => array( array( array( 'param' => 'block', 'operator' => '==', 'value' => 'sg-sni/linked-logo-grid' ) ) ),
	'position' => 'normal',
	'fields'   => array(
		array(
			'key'   => 'field_sni_llg_industry',
			'label' => 'Industry Filter (optional)',
			'name'  => 'industry',
			'type'  => 'taxonomy',
			'taxonomy' => 'sni_industry',
			'field_type' => 'select',
			'allow_null' => 1,
			'return_format' => 'id',
		),
		array(
			'key'   => 'field_sni_llg_posts_per_page',
			'label' => 'Max Logos',
			'name'  => 'posts_per_page',
			'type'  => 'number',
			'min'   => 1,
			'max'   => 100,
			'default_value' => 30,
		),
		array(
			'key'   => 'field_sni_llg_specific_studies',
			'label' => 'Specific Case Studies (optional)',
			'name'  => 'specific_studies',
			'type'  => 'relationship',
			'post_type' => array( 'case_study' ),
			'instructions' => 'Override industry filter — pick specific studies in display order.',
		),
	),
) );
