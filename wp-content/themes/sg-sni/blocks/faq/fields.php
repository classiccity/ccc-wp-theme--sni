<?php
/**
 * ACF field group for the FAQ block.
 *
 * Optional eyebrow + heading at the top, then a repeater of Q/A pairs.
 * Each row is independently editable (no nested blocks); admins can drag
 * rows to reorder.
 *
 * @package sg-sni
 */

if ( ! defined( 'ABSPATH' ) ) exit;

acf_add_local_field_group( array(
	'key'      => 'group_sni_block_faq',
	'title'    => 'FAQ',
	'location' => array( array( array( 'param' => 'block', 'operator' => '==', 'value' => 'sg-sni/faq' ) ) ),
	'position' => 'normal',
	'fields'   => array(
		array(
			'key'   => 'field_sni_faq_eyebrow',
			'label' => 'Eyebrow (optional)',
			'name'  => 'eyebrow',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_sni_faq_heading',
			'label' => 'Heading (optional)',
			'name'  => 'heading',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_sni_faq_items',
			'label' => 'Q&A Items',
			'name'  => 'items',
			'type'  => 'repeater',
			'required' => 1,
			'layout' => 'block',
			'button_label' => 'Add Q&A',
			'min'   => 1,
			'sub_fields' => array(
				array( 'key' => 'field_sni_faq_question', 'label' => 'Question', 'name' => 'question', 'type' => 'text', 'required' => 1 ),
				array( 'key' => 'field_sni_faq_answer',   'label' => 'Answer',   'name' => 'answer',   'type' => 'wysiwyg', 'tabs' => 'visual', 'toolbar' => 'basic', 'media_upload' => 0, 'required' => 1 ),
			),
		),
	),
) );
