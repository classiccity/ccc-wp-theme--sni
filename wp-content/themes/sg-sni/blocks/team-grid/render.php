<?php
/**
 * Team Grid block render template.
 *
 * Two query modes:
 *   1. `specific_members` populated → render those exact posts in given order.
 *   2. Otherwise → query team_member CPT filtered by `role_filter` term (if set).
 *
 * Each card is wrapped in an <a> to the team_member single. Speaker layout
 * surfaces speaker_topics and speaker_style on the card.
 *
 * @package sg-sni
 */

$eyebrow         = get_field( 'eyebrow' );
$heading         = get_field( 'heading' );
$role_filter     = get_field( 'role_filter' );
$layout          = get_field( 'layout' ) ?: 'standard';
$posts_per_page  = (int) ( get_field( 'posts_per_page' ) ?: 30 );
$specific        = get_field( 'specific_members' );

if ( ! empty( $specific ) && is_array( $specific ) ) {
	$query = new WP_Query( array(
		'post_type'      => 'team_member',
		'post__in'       => wp_list_pluck( $specific, 'ID' ),
		'orderby'        => 'post__in',
		'posts_per_page' => -1,
	) );
} else {
	$args = array(
		'post_type'      => 'team_member',
		'posts_per_page' => $posts_per_page,
		'orderby'        => 'menu_order title',
		'order'          => 'ASC',
	);
	if ( $role_filter ) {
		$args['tax_query'] = array( array(
			'taxonomy' => 'sni_team_role',
			'field'    => 'slug',
			'terms'    => $role_filter,
		) );
	}
	$query = new WP_Query( $args );
}

if ( ! $query->have_posts() ) {
	if ( is_admin() ) {
		echo '<p style="opacity:.6;font-style:italic">No team members found for the current filter. Add some under Team Members in the admin.</p>';
	}
	return;
}

$wrapper_attrs = get_block_wrapper_attributes( array( 'class' => 'sni-team-grid-block' ) );
?>
<div <?php echo $wrapper_attrs; ?>>
	<?php if ( $eyebrow ) : ?>
		<p class="is-style-eyebrow has-text-align-center"><?php echo esc_html( $eyebrow ); ?></p>
	<?php endif; ?>
	<?php if ( $heading ) : ?>
		<h2 class="sni-team-grid-heading has-text-align-center is-style-line-above"><?php echo esc_html( $heading ); ?></h2>
	<?php endif; ?>
	<div class="sni-team-grid">
		<?php while ( $query->have_posts() ) : $query->the_post();
			$member_id   = get_the_ID();
			$headshot_id = get_post_thumbnail_id( $member_id );
			$job_title   = get_field( 'job_title', $member_id );
			?>
			<article class="sni-team-card">
				<a class="sni-team-card-link" href="<?php echo esc_url( get_permalink() ); ?>">
					<?php if ( $headshot_id ) : ?>
						<?php echo wp_get_attachment_image( $headshot_id, array( 600, 600 ), false, array(
							'class' => 'sni-team-card-image',
							'alt'   => esc_attr( get_the_title() ),
						) ); ?>
					<?php else : ?>
						<div class="sni-team-card-image" aria-hidden="true"></div>
					<?php endif; ?>
					<div class="sni-team-card-body">
						<h3 class="sni-team-card-name"><?php echo esc_html( get_the_title() ); ?></h3>
						<?php if ( $job_title ) : ?>
							<p class="sni-team-card-title"><?php echo esc_html( $job_title ); ?></p>
						<?php endif; ?>
						<?php if ( $layout === 'speaker' ) :
							$topics = get_field( 'speaker_topics', $member_id );
							$style  = get_field( 'speaker_style', $member_id );
							if ( ! empty( $topics ) || $style ) : ?>
								<div class="sni-team-card-topics">
									<?php if ( $style ) : ?>
										<strong><?php echo esc_html( $style ); ?></strong>
									<?php endif; ?>
									<?php if ( ! empty( $topics ) ) : ?>
										<ul>
											<?php foreach ( array_slice( $topics, 0, 3 ) as $topic ) : ?>
												<li><?php echo esc_html( $topic['item'] ); ?></li>
											<?php endforeach; ?>
										</ul>
									<?php endif; ?>
								</div>
							<?php endif;
						endif; ?>
					</div>
				</a>
			</article>
		<?php endwhile; wp_reset_postdata(); ?>
	</div>
</div>
