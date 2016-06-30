<?php
/**
 * @package llorix-one-lite
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('content-single-page'); ?>>

		<header class="entry-header single-header">
			<div class="single-header-overlay"></div>
			<?php
				if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'nature-post-thumbnail' );
				}
			?>
			<div class="inner-title-wrap">
				<div class="container">
					<div>
					<?php the_title( '<h1 itemprop="headline" class="entry-title single-title">', '</h1>' ); ?>
					<div class="entry-meta single-entry-meta">
						<span class="author-link" itemprop="author" itemscope="" itemtype="http://schema.org/Person">
							<span itemprop="name" class="post-author author vcard">
								<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' )); ?>" itemprop="url" rel="author"><?php the_author(); ?></a>
							</span>
			            </span>
						<time class="post-time posted-on published" datetime="<?php the_time('c'); ?>" itemprop="datePublished">
							<?php the_time( get_option('date_format') ); ?>
						</time>
					</div><!-- .entry-meta -->
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
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'llorix-one-lite' ),
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