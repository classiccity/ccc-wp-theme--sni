<?php
/**
 * ACF field group for the case_study CPT.
 *
 * Body content is freeform Gutenberg (for any additional narrative). The
 * structured client meta + numeric results + testimonials live in ACF and
 * render through the single template + linked-logo-grid block.
 *
 * @package sg-sni
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/include_fields', function () {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) return;

	acf_add_local_field_group( array(
		'key'      => 'group_sni_case_study',
		'title'    => 'Case Study Details',
		'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'case_study' ) ) ),
		'position' => 'normal',
		'fields'   => array(
			array(
				'key'   => 'field_sni_case_client_name',
				'label' => 'Client Name',
				'name'  => 'client_name',
				'type'  => 'text',
				'required' => 1,
				'instructions' => 'Leave blank if anonymized — then check the box below.',
			),
			array(
				'key'   => 'field_sni_case_is_anonymous',
				'label' => 'Anonymous Client',
				'name'  => 'is_anonymous',
				'type'  => 'true_false',
				'instructions' => 'Hide client name + logo on public single. Use anonymous_descriptor instead.',
			),
			array(
				'key'   => 'field_sni_case_anonymous_descriptor',
				'label' => 'Anonymous Descriptor',
				'name'  => 'anonymous_descriptor',
				'type'  => 'text',
				'instructions' => 'e.g. "Top-5 Pharmaceutical Manufacturer". Shown when client is anonymized.',
				'conditional_logic' => array(
					array( array( 'field' => 'field_sni_case_is_anonymous', 'operator' => '==', 'value' => '1' ) ),
				),
			),
			array(
				'key'   => 'field_sni_case_client_logo',
				'label' => 'Client Logo',
				'name'  => 'client_logo',
				'type'  => 'image',
				'return_format' => 'array',
				'preview_size' => 'medium',
				'instructions' => 'Transparent PNG/SVG preferred.',
			),
			array(
				'key'   => 'field_sni_case_executive_summary',
				'label' => 'Executive Summary',
				'name'  => 'executive_summary',
				'type'  => 'textarea',
				'rows'  => 3,
				'instructions' => '30-50 words. Shown on archive card.',
				'required' => 1,
			),
			array(
				'key'   => 'field_sni_case_challenge',
				'label' => 'Challenge',
				'name'  => 'challenge',
				'type'  => 'wysiwyg',
				'tabs'  => 'visual',
				'toolbar' => 'basic',
				'media_upload' => 0,
				'required' => 1,
			),
			array(
				'key'   => 'field_sni_case_approach',
				'label' => 'Approach',
				'name'  => 'approach',
				'type'  => 'wysiwyg',
				'tabs'  => 'visual',
				'toolbar' => 'basic',
				'media_upload' => 0,
				'required' => 1,
			),
			array(
				'key'   => 'field_sni_case_results_narrative',
				'label' => 'Results',
				'name'  => 'results_narrative',
				'type'  => 'wysiwyg',
				'tabs'  => 'visual',
				'toolbar' => 'basic',
				'media_upload' => 0,
				'required' => 1,
			),
			array(
				'key'   => 'field_sni_case_result_stats',
				'label' => 'Result Stats',
				'name'  => 'result_stats',
				'type'  => 'repeater',
				'layout' => 'block',
				'button_label' => 'Add Stat',
				'instructions' => 'Optional. Quantitative outcomes (e.g. "$2.18M / Revenue / in 90 days").',
				'sub_fields' => array(
					array( 'key' => 'field_sni_case_stat_value',  'label' => 'Value',  'name' => 'value',  'type' => 'text', 'required' => 1, 'instructions' => 'e.g. "$2.18M", "300%", "12x"' ),
					array( 'key' => 'field_sni_case_stat_metric', 'label' => 'Metric', 'name' => 'metric', 'type' => 'text', 'required' => 1, 'instructions' => 'e.g. "Revenue", "ROI", "Savings"' ),
					array( 'key' => 'field_sni_case_stat_unit',   'label' => 'Unit/Note', 'name' => 'unit', 'type' => 'text', 'instructions' => 'Optional. e.g. "in 90 days"' ),
				),
			),
			array(
				'key'   => 'field_sni_case_testimonials',
				'label' => 'Testimonials',
				'name'  => 'testimonials',
				'type'  => 'repeater',
				'layout' => 'block',
				'button_label' => 'Add Testimonial',
				'sub_fields' => array(
					array( 'key' => 'field_sni_case_quote',          'label' => 'Quote',          'name' => 'quote',          'type' => 'textarea', 'rows' => 4, 'required' => 1 ),
					array( 'key' => 'field_sni_case_attribution',    'label' => 'Attribution',    'name' => 'attribution',    'type' => 'text', 'required' => 1 ),
					array( 'key' => 'field_sni_case_quote_title',    'label' => 'Title/Company',  'name' => 'title_company',  'type' => 'text' ),
				),
			),
			array(
				'key'   => 'field_sni_case_program_duration',
				'label' => 'Program Duration',
				'name'  => 'program_duration',
				'type'  => 'text',
				'instructions' => 'e.g. "10+ years", "Global rollout 2019–present".',
			),
			array(
				'key'   => 'field_sni_case_related_team',
				'label' => 'Related Team Members',
				'name'  => 'related_team_members',
				'type'  => 'relationship',
				'post_type' => array( 'team_member' ),
				'instructions' => 'Facilitators who led the engagement.',
			),
			array(
				'key'   => 'field_sni_case_gallery',
				'label' => 'Gallery Images',
				'name'  => 'gallery_images',
				'type'  => 'gallery',
				'return_format' => 'array',
			),
		),
	) );
} );
