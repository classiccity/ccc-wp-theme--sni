<?php
/**
 * ACF field group for the Team Grid block.
 *
 * One configurable knob: which Role term to filter on (Team Member, Speaker,
 * or both/empty for everyone). Posts-per-page caps the grid so editors can
 * use it for "featured 3" on the home page vs. "everyone" on /who-we-are/.
 *
 * @package sg-sni
 */

if ( ! defined( 'ABSPATH' ) ) exit;

acf_add_local_field_group( array(
	'key'      => 'group_sni_block_team_grid',
	'title'    => 'Team Grid',
	'location' => array( array( array( 'param' => 'block', 'operator' => '==', 'value' => 'sg-sni/team-grid' ) ) ),
	'position' => 'normal',
	'fields'   => array(
		array(
			'key'   => 'field_sni_tg_eyebrow',
			'label' => 'Eyebrow (optional)',
			'name'  => 'eyebrow',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_sni_tg_heading',
			'label' => 'Heading (optional)',
			'name'  => 'heading',
			'type'  => 'text',
		),
		array(
			'key'     => 'field_sni_tg_role_filter',
			'label'   => 'Role Filter',
			'name'    => 'role_filter',
			'type'    => 'select',
			'choices' => array(
				''            => '— All Roles —',
				'team-member' => 'Team Members only',
				'speaker'     => 'Speakers only',
			),
			'default_value' => '',
			'allow_null' => 0,
			'ui' => 1,
		),
		array(
			'key'     => 'field_sni_tg_layout',
			'label'   => 'Card Layout',
			'name'    => 'layout',
			'type'    => 'select',
			'choices' => array(
				'standard' => 'Standard (headshot + name + title)',
				'speaker'  => 'Speaker (adds speaker_topics + style on card)',
			),
			'default_value' => 'standard',
			'allow_null' => 0,
			'ui' => 1,
		),
		array(
			'key'     => 'field_sni_tg_posts_per_page',
			'label'   => 'Max Items',
			'name'    => 'posts_per_page',
			'type'    => 'number',
			'min'     => 1,
			'max'     => 100,
			'default_value' => 30,
			'instructions' => 'Use a small number for featured grids (e.g. 3 on the home page).',
		),
		array(
			'key'     => 'field_sni_tg_specific_members',
			'label'   => 'Specific Members (optional)',
			'name'    => 'specific_members',
			'type'    => 'relationship',
			'post_type' => array( 'team_member' ),
			'instructions' => 'Override Role Filter — if any people are picked, only those are shown, in this exact order. Leave empty to use the role filter + max items above.',
		),
	),
) );
