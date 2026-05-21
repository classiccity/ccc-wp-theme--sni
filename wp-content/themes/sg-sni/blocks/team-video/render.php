<?php
/**
 * Team Member Featured Video Section — self-contained "Watch in Action"
 * band. Outputs the full-width section (heading + 16:9 iframe) when the
 * featured_video ACF field is populated, or nothing at all when it isn't,
 * so the section collapses cleanly on bios without a video.
 *
 * The field accepts either a YouTube watch URL (converted to embed form),
 * a YouTube embed URL, or raw <iframe> markup (passed through as-is).
 *
 * @package sg-sni
 */

$video = get_field( 'featured_video' );
if ( ! $video ) {
	return;
}

$embed_html = '';
$trimmed    = trim( $video );

if ( stripos( $trimmed, '<iframe' ) === 0 ) {
	$embed_html = $trimmed;
} elseif ( preg_match( '#(?:youtube\.com/(?:watch\?v=|embed/)|youtu\.be/)([A-Za-z0-9_-]{6,})#', $trimmed, $m ) ) {
	$embed_html = sprintf(
		'<iframe src="https://www.youtube.com/embed/%s" title="%s" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen referrerpolicy="strict-origin-when-cross-origin"></iframe>',
		esc_attr( $m[1] ),
		esc_attr( get_the_title() )
	);
} else {
	$embed_html = wp_oembed_get( $trimmed );
}

if ( ! $embed_html ) {
	return;
}

$wrapper_attrs = get_block_wrapper_attributes( array( 'class' => 'sni-team-video-section alignfull' ) );
?>
<section <?php echo $wrapper_attrs; ?>>
	<div class="sni-team-video-inner">
		<h2 class="sni-team-video-heading is-style-line-above"><?php echo esc_html( sprintf( __( 'Watch %s in Action', 'sg-sni' ), get_the_title() ) ); ?></h2>
		<div class="sni-team-video-frame">
			<?php echo $embed_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
	</div>
</section>
