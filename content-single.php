<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package naturelle
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'content-single-page' ); ?>>

		<header class="entry-header single-header">
			<div class="single-header-overlay"></div>
			<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'naturelle-post-thumbnail' );
			}
			?>
			<div class="inner-title-wrap">
				<div class="inner-title-wrap-inside">
					<div class="inner-title-wrap-inside-cell">
						<div class="container">
							<div>
								<?php the_title( '<h1 itemprop="headline" class="entry-title single-title">', '</h1>' ); ?>
								<div class="entry-meta single-entry-meta">
									<span class="author-link" itemprop="author" itemscope="" itemtype="http://schema.org/Person">
										<span itemprop="name" class="post-author author vcard">
											<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" itemprop="url" rel="author"><?php the_author(); ?></a>
										</span>
						            </span>
									<time class="post-time posted-on published" datetime="<?php the_time( 'c' ); ?>" itemprop="datePublished">
										<?php the_time( get_option( 'date_format' ) ); ?>
									</time>
								</div><!-- .entry-meta -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</header><!-- .entry-header -->

	<div class="container">
		<div class="inner-content-wrap">
			<div itemprop="text" class="entry-content">
				<?php the_content(); ?>
				<?php
					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'naturelle' ),
						'after'  => '</div>',
					) );
				?>
			</div><!-- .entry-content -->

			<footer class="entry-footer">
				<?php llorix_one_lite_entry_footer(); ?>
			</footer><!-- .entry-footer -->
		</div>
	</div>

</article><!-- #post-## -->

<?php
	$author_first_name = get_the_author_meta( 'first_name' );
	$author_last_name = get_the_author_meta( 'last_name' );
	$author_description = wp_kses_post( nl2br( get_the_author_meta( 'description' ) ) );
if ( ! empty( $author_first_name ) || ! empty( $author_last_name ) || ! empty( $author_description ) ) {
	echo '<div class="author-details-wrap"><div class="container">';
	echo '<div class="content-inner-wrap">';
	echo '<div class="author-details-img-wrap">';
	echo get_avatar( get_the_author_meta( 'user_email' ), '100' );
	echo '</div>';
	$author_name = '';
	if ( ! empty( $author_first_name ) ) {
		$author_name .= sanitize_text_field( $author_first_name ) . ' ';
	}
	if ( ! empty( $author_last_name ) ) {
		$author_name .= sanitize_text_field( $author_last_name );
	}
	echo '<div class="author-details-title">';
	if ( $author_name !== '' ) {
		echo '<a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" title="' . esc_attr( $author_name ) . '">' . $author_name . '</a>';
	}
	echo '</div>';
	if ( ! empty( $author_description ) ) {
		echo '<div class="author-details-content">' . $author_description . '</div>';
	}
	echo '</div>';
	echo '</div></div>';
}
?>
