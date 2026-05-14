<?php
/**
 * Single template for case_study CPT.
 *
 * Spine: client-logo hero → executive summary → result stats strip →
 * challenge / approach / results (ACF WYSIWYG) → testimonials → freeform
 * body (Gutenberg). The freeform body is the editor's escape hatch for
 * any case-by-case additions.
 *
 * @package sg-sni
 */

get_header();

while ( have_posts() ) : the_post();
	$post_id      = get_the_ID();
	$is_anonymous = (bool) get_field( 'is_anonymous' );
	$client_name  = $is_anonymous
		? ( get_field( 'anonymous_descriptor' ) ?: 'Anonymous Client' )
		: ( get_field( 'client_name' ) ?: get_the_title() );
	$logo         = get_field( 'client_logo' );
	$summary      = get_field( 'executive_summary' );
	$challenge    = get_field( 'challenge' );
	$approach     = get_field( 'approach' );
	$results      = get_field( 'results_narrative' );
	$stats        = get_field( 'result_stats' );
	$testimonials = get_field( 'testimonials' );
	$duration     = get_field( 'program_duration' );
	$related_team = get_field( 'related_team_members' );
	?>
	<main>
		<section class="sni-case-hero">
			<?php if ( ! $is_anonymous && ! empty( $logo['url'] ) ) : ?>
				<img src="<?php echo esc_url( $logo['url'] ); ?>" alt="<?php echo esc_attr( $client_name ); ?> logo" />
			<?php endif; ?>
			<h1><?php echo esc_html( get_the_title() ); ?></h1>
			<?php if ( $summary ) : ?>
				<p class="sni-case-summary"><?php echo esc_html( $summary ); ?></p>
			<?php endif; ?>
		</section>

		<?php if ( ! empty( $stats ) ) : ?>
			<section class="sni-case-stats">
				<?php foreach ( $stats as $stat ) : ?>
					<div class="sni-case-stat">
						<span class="sni-case-stat-value"><?php echo esc_html( $stat['value'] ); ?></span>
						<span class="sni-case-stat-label">
							<?php echo esc_html( $stat['metric'] ); ?>
							<?php if ( ! empty( $stat['unit'] ) ) : ?> · <?php echo esc_html( $stat['unit'] ); ?><?php endif; ?>
						</span>
					</div>
				<?php endforeach; ?>
			</section>
		<?php endif; ?>

		<article class="sni-case-narrative entry-content" style="max-width:800px;margin:0 auto;padding:var(--wp--preset--spacing--80) var(--wp--preset--spacing--40)">
			<?php if ( $challenge ) : ?>
				<h2>Challenge</h2>
				<?php echo wp_kses_post( $challenge ); ?>
			<?php endif; ?>
			<?php if ( $approach ) : ?>
				<h2>Approach</h2>
				<?php echo wp_kses_post( $approach ); ?>
			<?php endif; ?>
			<?php if ( $results ) : ?>
				<h2>Results</h2>
				<?php echo wp_kses_post( $results ); ?>
			<?php endif; ?>

			<?php if ( ! empty( $testimonials ) ) : ?>
				<aside class="sni-case-testimonials" style="margin:var(--wp--preset--spacing--60) 0">
					<?php foreach ( $testimonials as $t ) : ?>
						<blockquote style="border-left:3px solid var(--wp--preset--color--cta);padding:0 var(--wp--preset--spacing--30);margin:var(--wp--preset--spacing--40) 0">
							<p style="font-style:italic;font-size:var(--wp--preset--font-size--large)">&ldquo;<?php echo esc_html( $t['quote'] ); ?>&rdquo;</p>
							<cite style="font-style:normal;font-weight:600">
								<?php echo esc_html( $t['attribution'] ); ?>
								<?php if ( ! empty( $t['title_company'] ) ) : ?>, <span style="font-weight:400;color:var(--wp--preset--color--dark-alt)"><?php echo esc_html( $t['title_company'] ); ?></span><?php endif; ?>
							</cite>
						</blockquote>
					<?php endforeach; ?>
				</aside>
			<?php endif; ?>

			<?php if ( get_the_content() ) : ?>
				<div class="sni-case-extra">
					<?php the_content(); ?>
				</div>
			<?php endif; ?>

			<?php if ( $duration ) : ?>
				<p style="margin-top:var(--wp--preset--spacing--40);font-size:var(--wp--preset--font-size--small);color:var(--wp--preset--color--dark-alt)"><strong>Program Duration:</strong> <?php echo esc_html( $duration ); ?></p>
			<?php endif; ?>

			<?php if ( ! empty( $related_team ) ) : ?>
				<aside class="sni-case-team" style="margin-top:var(--wp--preset--spacing--60);padding-top:var(--wp--preset--spacing--40);border-top:1px solid var(--wp--preset--color--light-alt)">
					<h3 style="font-size:var(--wp--preset--font-size--medium);text-transform:uppercase;letter-spacing:.14em;color:var(--wp--preset--color--cta)">Led By</h3>
					<ul style="list-style:none;padding:0;margin:0;display:flex;flex-wrap:wrap;gap:var(--wp--preset--spacing--20)">
						<?php foreach ( $related_team as $member ) : ?>
							<li><a href="<?php echo esc_url( get_permalink( $member ) ); ?>"><?php echo esc_html( get_the_title( $member ) ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</aside>
			<?php endif; ?>
		</article>
	</main>
<?php endwhile;

get_footer();
