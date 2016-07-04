<?php
/**
 * The template part for displaying results in search pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package llorix-one-lite
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('border-bottom-hover search-article'); ?>>
	<header class="entry-header">

		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

			<div class="entry-meta list-post-entry-meta">
				<span class="post-author">
					<?php the_author_posts_link(); ?>
				</span>
				
					<?php
						/* translators: used between list items, there is a space after the comma */
						$categories_list = get_the_category_list( esc_html__( ', ', 'llorix-one-lite' ) );
                        if(!empty($categories_list)){
                        ?>
                            <span class="posted-in">
                        <?php
                            esc_html_e('Posted in ','llorix-one-lite');
                        
                            $pos = strpos($categories_list, ',');
                            if ( $pos ) {
                                echo substr($categories_list, 0, $pos);
                            } else {
                                echo $categories_list;
                            }
                            echo '</span>';
                        }
					?>
				
				<a href="<?php comments_link(); ?>" class="post-comments">
					<?php comments_number( esc_html__('No comments','llorix-one-lite'), esc_html__('One comment','llorix-one-lite'), esc_html__('% comments','llorix-one-lite') ); ?>
				</a>
			</div><!-- .entry-meta -->


	</header><!-- .entry-header -->
	<div class="entry-content">
		<?php
			$ismore = @strpos( $post->post_content, '<!--more-->');
			if($ismore) : the_content( sprintf( esc_html__('Read more %s ...','llorix-one-lite'), '<span class="screen-reader-text">'.esc_html__('about ', 'llorix-one-lite').get_the_title().'</span>' ) );
			else : the_excerpt();
			endif;
			
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'llorix-one-lite' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->

