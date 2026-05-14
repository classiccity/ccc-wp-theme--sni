<?php
/**
 * FAQ block render template.
 *
 * Uses native <details>/<summary> for accordion behavior — no JS dependency.
 * Each row gets an open/close indicator (+/−) via ::after in style.css.
 *
 * @package sg-sni
 */

$eyebrow = get_field( 'eyebrow' );
$heading = get_field( 'heading' );
$items   = get_field( 'items' );

if ( empty( $items ) || ! is_array( $items ) ) {
	if ( is_admin() ) {
		echo '<p style="opacity:.6;font-style:italic">Add at least one Q&amp;A to render this FAQ block.</p>';
	}
	return;
}

$classes = array( 'sni-faq-block' );
$wrapper_attrs = get_block_wrapper_attributes( array( 'class' => implode( ' ', $classes ) ) );
?>
<div <?php echo $wrapper_attrs; ?>>
	<?php if ( $eyebrow ) : ?>
		<p class="is-style-eyebrow has-text-align-center"><?php echo esc_html( $eyebrow ); ?></p>
	<?php endif; ?>
	<?php if ( $heading ) : ?>
		<h2 class="sni-faq-heading has-text-align-center"><?php echo esc_html( $heading ); ?></h2>
	<?php endif; ?>
	<div class="sni-faq-list">
		<?php foreach ( $items as $item ) : ?>
			<details class="sni-faq-item">
				<summary class="sni-faq-summary"><?php echo esc_html( $item['question'] ); ?></summary>
				<div class="sni-faq-answer"><?php echo wp_kses_post( $item['answer'] ); ?></div>
			</details>
		<?php endforeach; ?>
	</div>
</div>
