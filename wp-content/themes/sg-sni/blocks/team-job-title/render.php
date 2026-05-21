<?php
/**
 * Team Member Job Title block — renders the job_title ACF field of the
 * current post as a styled paragraph. Returns nothing if the field is empty
 * so the surrounding layout doesn't show an empty placeholder.
 *
 * @package sg-sni
 */

$job_title = get_field( 'job_title' );
if ( ! $job_title ) {
	return;
}

$wrapper_attrs = get_block_wrapper_attributes( array( 'class' => 'sni-team-job-title' ) );
?>
<p <?php echo $wrapper_attrs; ?>><?php echo esc_html( $job_title ); ?></p>
