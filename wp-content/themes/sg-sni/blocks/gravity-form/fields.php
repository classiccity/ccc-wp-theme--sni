<?php
/**
 * ACF field group for the Gravity Form block.
 *
 * Just a form ID picker. The actual form is authored in the GF admin.
 *
 * @package sg-sni
 */

if ( ! defined( 'ABSPATH' ) ) exit;

acf_add_local_field_group( array(
	'key'      => 'group_sni_block_gravity_form',
	'title'    => 'Gravity Form',
	'location' => array( array( array( 'param' => 'block', 'operator' => '==', 'value' => 'sg-sni/gravity-form' ) ) ),
	'position' => 'normal',
	'fields'   => array(
		array(
			'key'   => 'field_sni_gf_form_id',
			'label' => 'Gravity Form ID',
			'name'  => 'form_id',
			'type'  => 'number',
			'min'   => 1,
			'required' => 1,
			'instructions' => 'The numeric ID from Forms → All Forms in WP admin.',
		),
		array(
			'key'   => 'field_sni_gf_title',
			'label' => 'Show Form Title?',
			'name'  => 'show_title',
			'type'  => 'true_false',
			'ui'    => 1,
			'default_value' => 0,
		),
		array(
			'key'   => 'field_sni_gf_description',
			'label' => 'Show Form Description?',
			'name'  => 'show_description',
			'type'  => 'true_false',
			'ui'    => 1,
			'default_value' => 0,
		),
		array(
			'key'   => 'field_sni_gf_ajax',
			'label' => 'AJAX Submit?',
			'name'  => 'ajax',
			'type'  => 'true_false',
			'ui'    => 1,
			'default_value' => 1,
			'instructions' => 'Submit without page reload (recommended).',
		),
	),
) );
