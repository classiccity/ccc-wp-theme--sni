<?php
/**
 * Linked Logo Grid block render template.
 *
 * Pulls case studies, renders their client_logo as a clickable tile.
 * Anonymous case studies (is_anonymous = true) are skipped here — they
 * appear via narrative content but shouldn't show a logo.
 *
 * @package sg-sni
 */

$industry        = get_field( 'industry' );
$posts_per_page  = (int) ( get_field( 'posts_per_page' ) ?: 30 );
$specific        = get_field( 'specific_studies' );

if ( ! empty( $specific ) && is_array( $specific ) ) {
	$query = new WP_Query( array(
		'post_type'      => 'case_study',
		'post__in'       => wp_list_pluck( $specific, 'ID' ),
		'orderby'        => 'post__in',
		'posts_per_page' => -1,
	) );
} else {
	$args = array(
		'post_type'      => 'case_study',
		'posts_per_page' => $posts_per_page,
		'orderby'        => 'menu_order title',
		'order'          => 'ASC',
	);
	if ( $industry ) {
		$args['tax_query'] = array( array(
			'taxonomy' => 'sni_industry',
			'field'    => 'term_id',
			'terms'    => (int) $industry,
		) );
	}
	$query = new WP_Query( $args );
}

if ( ! $query->have_posts() ) {
	if ( is_admin() ) {
		echo '<p style="opacity:.6;font-style:italic">No case studies found. Add some under Case Studies in the admin.</p>';
	}
	return;
}

$wrapper_attrs = get_block_wrapper_attributes( array( 'class' => 'sni-linked-logo-grid-block' ) );
?>
<div <?php echo $wrapper_attrs; ?>>
	<div class="sni-logo-grid">
		<?php while ( $query->have_posts() ) : $query->the_post();
			$study_id     = get_the_ID();
			$is_anonymous = (bool) get_field( 'is_anonymous', $study_id );
			if ( $is_anonymous ) continue;
			$logo         = get_field( 'client_logo', $study_id );
			$client_name  = get_field( 'client_name', $study_id ) ?: get_the_title();
			if ( empty( $logo['url'] ) ) continue;
			?>
			<a class="sni-logo-grid-item" href="<?php echo esc_url( get_permalink() ); ?>" aria-label="<?php echo esc_attr( $client_name ); ?> case study">
				<img
					src="<?php echo esc_url( $logo['url'] ); ?>"
					alt="<?php echo esc_attr( $client_name ); ?> logo"
					loading="lazy"
				/>
			</a>
		<?php endwhile; wp_reset_postdata(); ?>
	</div>
</div>
