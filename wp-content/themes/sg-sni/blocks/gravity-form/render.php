<?php
/**
 * Gravity Form block render template.
 *
 * Delegates to GF's shortcode renderer. If Gravity Forms isn't active,
 * the block degrades to an admin-only notice.
 *
 * @package sg-sni
 */

$form_id          = (int) get_field( 'form_id' );
$show_title       = (bool) get_field( 'show_title' );
$show_description = (bool) get_field( 'show_description' );
$ajax             = (bool) get_field( 'ajax' );

if ( ! $form_id ) {
	if ( is_admin() ) {
		echo '<p style="opacity:.6;font-style:italic">Pick a Gravity Form ID to render this block.</p>';
	}
	return;
}

if ( ! class_exists( 'GFForms' ) || ! function_exists( 'gravity_form' ) ) {
	if ( is_admin() ) {
		echo '<p style="opacity:.6;font-style:italic">Gravity Forms is not active. Install/activate it to render this block.</p>';
	}
	return;
}

$wrapper_attrs = get_block_wrapper_attributes( array( 'class' => 'sni-gravity-form-block' ) );
?>
<div <?php echo $wrapper_attrs; ?>>
	<?php gravity_form( $form_id, $show_title, $show_description, false, null, $ajax ); ?>
</div>
