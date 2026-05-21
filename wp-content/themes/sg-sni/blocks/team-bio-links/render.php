<?php
/**
 * Team Member Bio Links block — sidebar list of LinkedIn + media_features.
 * Renders nothing if none of the link fields are populated, so the column
 * collapses cleanly when an editor hasn't filled anything in.
 *
 * @package sg-sni
 */

$linkedin = get_field( 'linkedin_url' );
$website  = get_field( 'personal_website' );
$media    = get_field( 'media_features' );

if ( ! $linkedin && ! $website && empty( $media ) ) {
	return;
}

$wrapper_attrs = get_block_wrapper_attributes( array( 'class' => 'sni-bio-links' ) );
?>
<div <?php echo $wrapper_attrs; ?>>
	<?php if ( $linkedin ) : ?>
		<a class="sni-bio-links-linkedin" href="<?php echo esc_url( $linkedin ); ?>" rel="noopener" target="_blank" aria-label="<?php echo esc_attr( sprintf( __( 'Follow %s on LinkedIn', 'sg-sni' ), get_the_title() ) ); ?>">
			<svg aria-hidden="true" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg" width="28" height="28"><path fill="currentColor" d="M416 32H31.9C14.3 32 0 46.5 0 64.3v383.4C0 465.5 14.3 480 31.9 480H416c17.6 0 32-14.5 32-32.3V64.3c0-17.8-14.4-32.3-32-32.3zM135.4 416H69V202.2h66.5V416zm-33.2-243c-21.3 0-38.5-17.3-38.5-38.5S80.9 96 102.2 96c21.2 0 38.5 17.3 38.5 38.5 0 21.3-17.2 38.5-38.5 38.5zm282.1 243h-66.4V312c0-24.8-.5-56.7-34.5-56.7-34.6 0-39.9 27-39.9 54.9V416h-66.4V202.2h63.7v29.2h.9c8.9-16.8 30.6-34.5 62.9-34.5 67.2 0 79.7 44.3 79.7 101.9V416z"/></svg>
			<span><?php echo esc_html( sprintf( __( 'Follow %s on LinkedIn', 'sg-sni' ), get_the_title() ) ); ?></span>
		</a>
	<?php endif; ?>

	<?php if ( $website ) : ?>
		<a class="sni-bio-links-website" href="<?php echo esc_url( $website ); ?>" rel="noopener" target="_blank">
			<?php esc_html_e( 'Personal Website', 'sg-sni' ); ?>
		</a>
	<?php endif; ?>

	<?php if ( ! empty( $media ) ) : ?>
		<hr class="sni-bio-links-divider" />
		<h2 class="sni-bio-links-heading"><?php esc_html_e( 'Learn More', 'sg-sni' ); ?></h2>
		<p class="sni-bio-links-subheading"><?php esc_html_e( 'Recent published articles:', 'sg-sni' ); ?></p>
		<ul class="sni-bio-links-list">
			<?php foreach ( $media as $row ) :
				$outlet = $row['outlet'] ?? '';
				$url    = $row['url'] ?? '';
				if ( ! $outlet ) {
					continue;
				} ?>
				<li>
					<?php if ( $url ) : ?>
						<a href="<?php echo esc_url( $url ); ?>" rel="noopener" target="_blank">
							<svg aria-hidden="true" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" width="16" height="16"><path fill="currentColor" d="M256 8c137 0 248 111 248 248S393 504 256 504 8 393 8 256 119 8 256 8zm113.9 231L234.4 103.5c-9.4-9.4-24.6-9.4-33.9 0l-17 17c-9.4 9.4-9.4 24.6 0 33.9L285.1 256 183.5 357.6c-9.4 9.4-9.4 24.6 0 33.9l17 17c9.4 9.4 24.6 9.4 33.9 0L369.9 273c9.4-9.4 9.4-24.6 0-34z"/></svg>
							<span><?php echo esc_html( $outlet ); ?></span>
						</a>
					<?php else : ?>
						<?php echo esc_html( $outlet ); ?>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</div>
