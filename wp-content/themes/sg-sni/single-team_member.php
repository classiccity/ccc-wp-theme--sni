<?php
/**
 * Single template for team_member CPT.
 *
 * Layout: sticky-sidebar of ACF structured fields on the left; full
 * Gutenberg post content on the right. Editors author the body in any
 * blocks they want; the sidebar is template-owned and always renders.
 *
 * Speaker-only fields (speaker_topics, speaker_style) only render if
 * the member has the `speaker` role term assigned.
 *
 * @package sg-sni
 */

get_header();

while ( have_posts() ) : the_post();
	$post_id     = get_the_ID();
	$headshot_id = get_post_thumbnail_id( $post_id );
	$job_title   = get_field( 'job_title' );
	$location    = get_field( 'location' );
	$linkedin    = get_field( 'linkedin_url' );
	$website     = get_field( 'personal_website' );
	$expertise   = get_field( 'expertise_areas' );
	$education   = get_field( 'education' );
	$clients     = get_field( 'notable_clients' );
	$highlights  = get_field( 'career_highlights' );
	$media       = get_field( 'media_features' );
	$languages   = get_field( 'languages' );
	$credentials = get_field( 'credentials' );
	$books       = get_field( 'books_authored' );
	$video       = get_field( 'featured_video' );
	$roles       = wp_get_post_terms( $post_id, 'sni_team_role', array( 'fields' => 'slugs' ) );
	$is_speaker  = is_array( $roles ) && in_array( 'speaker', $roles, true );
	$topics      = $is_speaker ? get_field( 'speaker_topics' ) : null;
	$style       = $is_speaker ? get_field( 'speaker_style' ) : null;
	?>
	<main class="sni-bio-layout">
		<aside class="sni-bio-sidebar">
			<?php if ( $headshot_id ) : ?>
				<?php echo wp_get_attachment_image( $headshot_id, 'medium_large', false, array( 'class' => 'sni-bio-headshot', 'alt' => esc_attr( get_the_title() ) ) ); ?>
			<?php else : ?>
				<div class="sni-bio-headshot" aria-hidden="true"></div>
			<?php endif; ?>

			<header>
				<h1 class="sni-bio-name"><?php the_title(); ?></h1>
				<?php if ( $job_title ) : ?>
					<p class="sni-bio-title"><?php echo esc_html( $job_title ); ?></p>
				<?php endif; ?>
			</header>

			<?php if ( $location ) : ?>
				<div class="sni-bio-meta-block">
					<span class="sni-bio-meta-label">Location</span>
					<p class="sni-bio-meta-value"><?php echo esc_html( $location ); ?></p>
				</div>
			<?php endif; ?>

			<?php if ( $linkedin || $website ) : ?>
				<div class="sni-bio-meta-block">
					<span class="sni-bio-meta-label">Connect</span>
					<ul class="sni-bio-meta-list">
						<?php if ( $linkedin ) : ?><li><a href="<?php echo esc_url( $linkedin ); ?>" rel="noopener" target="_blank">LinkedIn</a></li><?php endif; ?>
						<?php if ( $website ) : ?><li><a href="<?php echo esc_url( $website ); ?>" rel="noopener" target="_blank">Website</a></li><?php endif; ?>
					</ul>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $expertise ) ) : ?>
				<div class="sni-bio-meta-block">
					<span class="sni-bio-meta-label">Areas of Expertise</span>
					<ul class="sni-bio-meta-list">
						<?php foreach ( $expertise as $row ) : ?><li><?php echo esc_html( $row['item'] ); ?></li><?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

			<?php if ( $is_speaker && $style ) : ?>
				<div class="sni-bio-meta-block">
					<span class="sni-bio-meta-label">Speaking Style</span>
					<p class="sni-bio-meta-value"><?php echo esc_html( $style ); ?></p>
				</div>
			<?php endif; ?>

			<?php if ( $is_speaker && ! empty( $topics ) ) : ?>
				<div class="sni-bio-meta-block">
					<span class="sni-bio-meta-label">Speaking Topics</span>
					<ul class="sni-bio-meta-list">
						<?php foreach ( $topics as $row ) : ?><li><?php echo esc_html( $row['item'] ); ?></li><?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $education ) ) : ?>
				<div class="sni-bio-meta-block">
					<span class="sni-bio-meta-label">Education</span>
					<ul class="sni-bio-meta-list">
						<?php foreach ( $education as $row ) : ?>
							<li>
								<?php echo esc_html( trim( ( $row['degree'] ?? '' ) . ( $row['institution'] ? ', ' . $row['institution'] : '' ) ) ); ?>
								<?php if ( ! empty( $row['year'] ) ) : ?><em>(<?php echo (int) $row['year']; ?>)</em><?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $clients ) ) : ?>
				<div class="sni-bio-meta-block">
					<span class="sni-bio-meta-label">Notable Clients</span>
					<ul class="sni-bio-meta-list">
						<?php foreach ( $clients as $row ) : ?>
							<li><?php echo esc_html( $row['name'] ); ?><?php if ( ! empty( $row['category'] ) ) : ?> <em>(<?php echo esc_html( $row['category'] ); ?>)</em><?php endif; ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $highlights ) ) : ?>
				<div class="sni-bio-meta-block">
					<span class="sni-bio-meta-label">Career Highlights</span>
					<ul class="sni-bio-meta-list">
						<?php foreach ( $highlights as $row ) : ?><li><?php echo esc_html( $row['item'] ); ?></li><?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $media ) ) : ?>
				<div class="sni-bio-meta-block">
					<span class="sni-bio-meta-label">In the Media</span>
					<ul class="sni-bio-meta-list">
						<?php foreach ( $media as $row ) : ?>
							<li>
								<?php if ( ! empty( $row['url'] ) ) : ?>
									<a href="<?php echo esc_url( $row['url'] ); ?>" rel="noopener" target="_blank"><?php echo esc_html( $row['outlet'] ); ?></a>
								<?php else : ?>
									<?php echo esc_html( $row['outlet'] ); ?>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $languages ) ) : ?>
				<div class="sni-bio-meta-block">
					<span class="sni-bio-meta-label">Languages</span>
					<ul class="sni-bio-meta-list">
						<?php foreach ( $languages as $row ) : ?><li><?php echo esc_html( $row['item'] ); ?></li><?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $credentials ) ) : ?>
				<div class="sni-bio-meta-block">
					<span class="sni-bio-meta-label">Credentials</span>
					<ul class="sni-bio-meta-list">
						<?php foreach ( $credentials as $row ) : ?><li><?php echo esc_html( $row['item'] ); ?></li><?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $books ) ) : ?>
				<div class="sni-bio-meta-block">
					<span class="sni-bio-meta-label">Books Authored</span>
					<ul class="sni-bio-meta-list">
						<?php foreach ( $books as $book_post ) : ?>
							<li><a href="<?php echo esc_url( get_permalink( $book_post ) ); ?>"><?php echo esc_html( get_the_title( $book_post ) ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>
		</aside>

		<article class="sni-bio-content entry-content">
			<?php if ( $video ) : ?>
				<div class="sni-bio-video"><?php echo $video; ?></div>
			<?php endif; ?>
			<?php the_content(); ?>
		</article>
	</main>
<?php endwhile;

get_footer();
