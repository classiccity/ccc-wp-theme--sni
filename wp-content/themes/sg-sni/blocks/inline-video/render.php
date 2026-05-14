<?php
/**
 * Inline Video block render template.
 *
 * Output preference order:
 *   1. video_url present → oEmbed (wp_oembed_get).
 *   2. video_file present → <video> with poster + controls.
 *   3. neither → empty (admin nag).
 *
 * Wrapper is a 16:9 aspect-ratio container so the embed scales fluidly.
 *
 * @package sg-sni
 */

$video_url  = get_field( 'video_url' );
$video_file = get_field( 'video_file' );
$poster     = get_field( 'poster' );
$caption    = get_field( 'caption' );
$autoplay   = (bool) get_field( 'autoplay' );

if ( ! $video_url && empty( $video_file['url'] ) ) {
	if ( is_admin() ) {
		echo '<p style="opacity:.6;font-style:italic">Provide a video URL or upload an MP4 to render this block.</p>';
	}
	return;
}

$wrapper_attrs = get_block_wrapper_attributes( array( 'class' => 'sni-inline-video-block' ) );
?>
<figure <?php echo $wrapper_attrs; ?>>
	<div class="sni-inline-video">
		<?php if ( $video_url ) : ?>
			<?php
			$embed = wp_oembed_get( $video_url, array( 'width' => 1280 ) );
			if ( $embed ) {
				echo $embed;
			} else {
				printf( '<a href="%s">%s</a>', esc_url( $video_url ), esc_html( $video_url ) );
			}
			?>
		<?php elseif ( ! empty( $video_file['url'] ) ) : ?>
			<video
				controls
				preload="metadata"
				<?php if ( $autoplay ) echo 'autoplay muted playsinline loop'; ?>
				<?php if ( ! empty( $poster['url'] ) ) printf( 'poster="%s"', esc_url( $poster['url'] ) ); ?>
			>
				<source src="<?php echo esc_url( $video_file['url'] ); ?>" type="<?php echo esc_attr( $video_file['mime_type'] ?? 'video/mp4' ); ?>" />
			</video>
		<?php endif; ?>
	</div>
	<?php if ( $caption ) : ?>
		<figcaption class="sni-inline-video-caption"><?php echo esc_html( $caption ); ?></figcaption>
	<?php endif; ?>
</figure>
