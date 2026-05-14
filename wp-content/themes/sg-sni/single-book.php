<?php
/**
 * Single template for book CPT.
 *
 * Two-column layout: cover image on the left (with sticky purchase links
 * beneath); title + subtitle + authors + body (Gutenberg) + endorsements
 * + accolades on the right.
 *
 * @package sg-sni
 */

get_header();

while ( have_posts() ) : the_post();
	$post_id        = get_the_ID();
	$cover_id       = get_post_thumbnail_id( $post_id );
	$subtitle       = get_field( 'subtitle' );
	$authors        = get_field( 'authors' );
	$pub_year       = get_field( 'publication_year' );
	$publisher      = get_field( 'publisher' );
	$purchase_links = get_field( 'purchase_links' );
	$endorsements   = get_field( 'endorsements' );
	$accolades      = get_field( 'accolades' );
	$related_books  = get_field( 'related_books' );

	$retailer_labels = array(
		'amazon'        => 'Buy on Amazon',
		'barnes-noble'  => 'Barnes & Noble',
		'bookshop'      => 'Bookshop.org',
		'apple-books'   => 'Apple Books',
		'google-books'  => 'Google Books',
		'audible'       => 'Audible',
		'publisher'     => 'Publisher',
		'other'         => 'Other',
	);
	?>
	<main class="sni-book-layout">
		<aside class="sni-book-side">
			<?php if ( $cover_id ) : ?>
				<?php echo wp_get_attachment_image( $cover_id, 'medium_large', false, array( 'class' => 'sni-book-cover', 'alt' => esc_attr( get_the_title() ) ) ); ?>
			<?php endif; ?>
			<?php if ( ! empty( $purchase_links ) ) : ?>
				<div class="sni-book-buylinks">
					<?php foreach ( $purchase_links as $link ) :
						$retailer = $link['retailer'] ?? 'other';
						$label    = $retailer_labels[ $retailer ] ?? $retailer;
						if ( empty( $link['url'] ) ) continue; ?>
						<a class="sni-book-buylink" href="<?php echo esc_url( $link['url'] ); ?>" rel="noopener" target="_blank"><?php echo esc_html( $label ); ?></a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<?php if ( $publisher || $pub_year ) : ?>
				<p style="margin-top:var(--wp--preset--spacing--20);font-size:var(--wp--preset--font-size--small);color:var(--wp--preset--color--dark-alt)">
					<?php echo esc_html( trim( ( $publisher ? $publisher : '' ) . ( $publisher && $pub_year ? ', ' : '' ) . ( $pub_year ? $pub_year : '' ) ) ); ?>
				</p>
			<?php endif; ?>
		</aside>

		<article class="sni-book-main entry-content">
			<header>
				<h1 style="font-family:var(--wp--preset--font-family--heading);color:var(--wp--preset--color--primary);margin:0"><?php the_title(); ?></h1>
				<?php if ( $subtitle ) : ?>
					<p style="font-size:var(--wp--preset--font-size--large);color:var(--wp--preset--color--dark-alt);margin:var(--wp--preset--spacing--10) 0 0 0"><?php echo esc_html( $subtitle ); ?></p>
				<?php endif; ?>
				<?php if ( ! empty( $authors ) ) : ?>
					<p style="margin-top:var(--wp--preset--spacing--20);font-size:var(--wp--preset--font-size--small);text-transform:uppercase;letter-spacing:.14em;color:var(--wp--preset--color--cta)">
						By
						<?php
						$author_links = array();
						foreach ( $authors as $author ) {
							$author_links[] = sprintf( '<a href="%s">%s</a>', esc_url( get_permalink( $author ) ), esc_html( get_the_title( $author ) ) );
						}
						echo implode( ', ', $author_links );
						?>
					</p>
				<?php endif; ?>
			</header>

			<?php if ( ! empty( $accolades ) ) : ?>
				<ul style="list-style:none;padding:0;margin:var(--wp--preset--spacing--30) 0;display:flex;flex-wrap:wrap;gap:var(--wp--preset--spacing--10)">
					<?php foreach ( $accolades as $row ) : ?>
						<li style="background:var(--wp--preset--color--light-alt);padding:0.25em 0.75em;border-radius:var(--wp--custom--radius--default);font-size:var(--wp--preset--font-size--small);font-weight:600;color:var(--wp--preset--color--secondary)"><?php echo esc_html( $row['item'] ); ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<div class="sni-book-description" style="margin:var(--wp--preset--spacing--40) 0">
				<?php the_content(); ?>
			</div>

			<?php if ( ! empty( $endorsements ) ) : ?>
				<aside class="sni-book-endorsements" style="margin-top:var(--wp--preset--spacing--60)">
					<h2 style="font-size:var(--wp--preset--font-size--large);text-transform:uppercase;letter-spacing:.14em;color:var(--wp--preset--color--cta);margin-bottom:var(--wp--preset--spacing--30)">Praise For This Book</h2>
					<?php foreach ( $endorsements as $e ) : ?>
						<blockquote style="border-left:3px solid var(--wp--preset--color--cta);padding:0 var(--wp--preset--spacing--30);margin:var(--wp--preset--spacing--30) 0">
							<p style="font-style:italic">&ldquo;<?php echo esc_html( $e['quote'] ); ?>&rdquo;</p>
							<cite style="font-style:normal;font-weight:600">
								<?php echo esc_html( $e['name'] ); ?>
								<?php if ( ! empty( $e['title'] ) ) : ?>, <span style="font-weight:400;color:var(--wp--preset--color--dark-alt)"><?php echo esc_html( $e['title'] ); ?></span><?php endif; ?>
							</cite>
						</blockquote>
					<?php endforeach; ?>
				</aside>
			<?php endif; ?>

			<?php if ( ! empty( $related_books ) ) : ?>
				<aside class="sni-book-related" style="margin-top:var(--wp--preset--spacing--60);padding-top:var(--wp--preset--spacing--40);border-top:1px solid var(--wp--preset--color--light-alt)">
					<h3 style="font-size:var(--wp--preset--font-size--medium);text-transform:uppercase;letter-spacing:.14em;color:var(--wp--preset--color--cta)">Also Available</h3>
					<ul style="list-style:none;padding:0;margin:0;display:flex;flex-wrap:wrap;gap:var(--wp--preset--spacing--20)">
						<?php foreach ( $related_books as $b ) : ?>
							<li><a href="<?php echo esc_url( get_permalink( $b ) ); ?>"><?php echo esc_html( get_the_title( $b ) ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</aside>
			<?php endif; ?>
		</article>
	</main>
<?php endwhile;

get_footer();
