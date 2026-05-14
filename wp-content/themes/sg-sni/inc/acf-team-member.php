<?php
/**
 * ACF field group for the team_member CPT.
 *
 * Body content is the WP post content (Gutenberg). All other structured
 * fields live here and render in the sidebar of the single template.
 *
 * Speaker-only fields (speaker_topics, speaker_style) are conditional on
 * the `sni_team_role` taxonomy including the `speaker` term — they hide
 * for pure team-member bios.
 *
 * @package sg-sni
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/include_fields', function () {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) return;

	acf_add_local_field_group( array(
		'key'      => 'group_sni_team_member',
		'title'    => 'Team Member Details',
		'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'team_member' ) ) ),
		'position' => 'side',
		'style'    => 'default',
		'fields'   => array(
			array(
				'key'   => 'field_sni_team_job_title',
				'label' => 'Job Title',
				'name'  => 'job_title',
				'type'  => 'text',
				'required' => 1,
				'instructions' => 'e.g. "Managing Partner", "Founder, Advisor"',
			),
			array(
				'key'   => 'field_sni_team_location',
				'label' => 'Location',
				'name'  => 'location',
				'type'  => 'text',
				'instructions' => 'City, State (e.g. "Baltimore, MD")',
			),
			array(
				'key'   => 'field_sni_team_linkedin',
				'label' => 'LinkedIn URL',
				'name'  => 'linkedin_url',
				'type'  => 'url',
			),
			array(
				'key'   => 'field_sni_team_personal_website',
				'label' => 'Personal Website',
				'name'  => 'personal_website',
				'type'  => 'url',
			),
			array(
				'key'   => 'field_sni_team_expertise',
				'label' => 'Areas of Expertise',
				'name'  => 'expertise_areas',
				'type'  => 'repeater',
				'instructions' => '3–6 short bullets, e.g. "Procurement Negotiation"',
				'layout' => 'table',
				'button_label' => 'Add Expertise',
				'sub_fields' => array(
					array( 'key' => 'field_sni_team_expertise_item', 'label' => 'Item', 'name' => 'item', 'type' => 'text', 'required' => 1 ),
				),
			),
			array(
				'key'   => 'field_sni_team_education',
				'label' => 'Education',
				'name'  => 'education',
				'type'  => 'repeater',
				'layout' => 'block',
				'button_label' => 'Add Education',
				'sub_fields' => array(
					array( 'key' => 'field_sni_team_edu_degree',      'label' => 'Degree',      'name' => 'degree',      'type' => 'text' ),
					array( 'key' => 'field_sni_team_edu_institution', 'label' => 'Institution', 'name' => 'institution', 'type' => 'text' ),
					array( 'key' => 'field_sni_team_edu_year',        'label' => 'Year',        'name' => 'year',        'type' => 'number' ),
				),
			),
			array(
				'key'   => 'field_sni_team_notable_clients',
				'label' => 'Notable Clients',
				'name'  => 'notable_clients',
				'type'  => 'repeater',
				'layout' => 'block',
				'button_label' => 'Add Client',
				'sub_fields' => array(
					array( 'key' => 'field_sni_team_client_name',     'label' => 'Client Name', 'name' => 'name',     'type' => 'text', 'required' => 1 ),
					array( 'key' => 'field_sni_team_client_category', 'label' => 'Category',    'name' => 'category', 'type' => 'text', 'instructions' => 'Optional grouping (e.g. "Sports", "Corporate")' ),
				),
			),
			array(
				'key'   => 'field_sni_team_career_highlights',
				'label' => 'Career Highlights',
				'name'  => 'career_highlights',
				'type'  => 'repeater',
				'layout' => 'table',
				'button_label' => 'Add Highlight',
				'sub_fields' => array(
					array( 'key' => 'field_sni_team_highlight_item', 'label' => 'Highlight', 'name' => 'item', 'type' => 'text', 'required' => 1 ),
				),
			),
			array(
				'key'   => 'field_sni_team_media_features',
				'label' => 'Media Features',
				'name'  => 'media_features',
				'type'  => 'repeater',
				'layout' => 'block',
				'button_label' => 'Add Media Feature',
				'sub_fields' => array(
					array( 'key' => 'field_sni_team_media_outlet', 'label' => 'Outlet', 'name' => 'outlet', 'type' => 'text', 'required' => 1 ),
					array( 'key' => 'field_sni_team_media_url',    'label' => 'URL',    'name' => 'url',    'type' => 'url' ),
				),
			),
			array(
				'key'   => 'field_sni_team_books_authored',
				'label' => 'Books Authored',
				'name'  => 'books_authored',
				'type'  => 'relationship',
				'post_type' => array( 'book' ),
				'instructions' => 'Pick the books this person co-authored. Surfaced on the bio sidebar.',
			),
			array(
				'key'   => 'field_sni_team_video',
				'label' => 'Featured Video',
				'name'  => 'featured_video',
				'type'  => 'oembed',
				'instructions' => 'YouTube/Vimeo URL for "Watch in Action" placement.',
			),
			array(
				'key'   => 'field_sni_team_languages',
				'label' => 'Languages',
				'name'  => 'languages',
				'type'  => 'repeater',
				'layout' => 'table',
				'button_label' => 'Add Language',
				'sub_fields' => array(
					array( 'key' => 'field_sni_team_lang_item', 'label' => 'Language', 'name' => 'item', 'type' => 'text', 'required' => 1 ),
				),
			),
			array(
				'key'   => 'field_sni_team_credentials',
				'label' => 'Credentials & Certifications',
				'name'  => 'credentials',
				'type'  => 'repeater',
				'layout' => 'table',
				'button_label' => 'Add Credential',
				'sub_fields' => array(
					array( 'key' => 'field_sni_team_credential_item', 'label' => 'Credential', 'name' => 'item', 'type' => 'text', 'required' => 1 ),
				),
			),

			// Speaker-only fields (visible when person has the `speaker` role term)
			array(
				'key'   => 'field_sni_team_speaker_topics',
				'label' => 'Speaker Topics',
				'name'  => 'speaker_topics',
				'type'  => 'repeater',
				'layout' => 'table',
				'button_label' => 'Add Topic',
				'instructions' => 'Only for people with the "Speaker" role.',
				'sub_fields' => array(
					array( 'key' => 'field_sni_team_speaker_topic_item', 'label' => 'Topic', 'name' => 'item', 'type' => 'text', 'required' => 1 ),
				),
			),
			array(
				'key'   => 'field_sni_team_speaker_style',
				'label' => 'Speaker Style',
				'name'  => 'speaker_style',
				'type'  => 'text',
				'instructions' => 'Short label (e.g. "Inspirational", "Tactical"). Only for Speaker role.',
			),
		),
	) );
} );
