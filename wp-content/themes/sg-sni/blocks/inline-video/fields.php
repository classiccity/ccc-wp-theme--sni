<?php
/**
 * ACF field group for the Inline Video block.
 *
 * Source modes:
 *   - oEmbed URL (YouTube/Vimeo) — most common.
 *   - Uploaded MP4 (Media Library).
 *
 * Editor picks one; render.php prefers the URL if both are set.
 *
 * @package sg-sni
 */

if ( ! defined( 'ABSPATH' ) ) exit;

acf_add_local_field_group( array(
	'key'      => 'group_sni_block_inline_video',
	'title'    => 'Inline Video',
	'location' => array( array( array( 'param' => 'block', 'operator' => '==', 'value' => 'sg-sni/inline-video' ) ) ),
	'position' => 'normal',
	'fields'   => array(
		array(
			'key'   => 'field_sni_iv_url',
			'label' => 'Video URL (YouTube/Vimeo)',
			'name'  => 'video_url',
			'type'  => 'url',
			'instructions' => 'Paste a YouTube or Vimeo link. Leave blank to use an uploaded MP4 instead.',
		),
		array(
			'key'   => 'field_sni_iv_file',
			'label' => 'Uploaded Video (MP4)',
			'name'  => 'video_file',
			'type'  => 'file',
			'return_format' => 'array',
			'mime_types' => 'mp4,webm',
			'instructions' => 'Used if no URL is provided.',
		),
		array(
			'key'   => 'field_sni_iv_poster',
			'label' => 'Poster Image',
			'name'  => 'poster',
			'type'  => 'image',
			'return_format' => 'array',
			'preview_size' => 'medium',
			'instructions' => 'Shown before play. Recommended for uploaded MP4s; YouTube/Vimeo provide their own poster.',
		),
		array(
			'key'   => 'field_sni_iv_caption',
			'label' => 'Caption',
			'name'  => 'caption',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_sni_iv_autoplay',
			'label' => 'Autoplay (muted)',
			'name'  => 'autoplay',
			'type'  => 'true_false',
			'ui'    => 1,
			'default_value' => 0,
			'instructions' => 'Only applies to uploaded MP4s. Autoplaying video must be muted by browser policy.',
		),
	),
) );
