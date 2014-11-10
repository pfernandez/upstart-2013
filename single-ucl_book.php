<?php
/**
 * Template to display a single Book.
 */
?>


<?php get_header(); ?>

<div class="container">

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

    <?php
        $post_id = get_the_ID();
        $cover_image_id = get_post_meta( $post_id, '_uc_book_cover_image_id', true );
        $cover_image = wp_get_attachment_image( $cover_image_id, array(275, 400) );
        $author = get_post_meta( $post_id, '_uc_book_author', true );
        $series = get_post_meta( $post_id, '_uc_book_series', true );
        if ( $series ) {
		    $series = $series[0];
		    $series = get_term_by( 'term_taxonomy_id', $series, 'book_series' )->slug;
        }
        $summary = get_post_meta( $post_id, '_uc_book_summary', true );
        $content = apply_filters( 'the_content', $summary );
    ?>   

	<div class="page-title clearfix">
		<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<h3><?php echo $author; ?></h3>
	</div>
	
	<div class="content">

        <div class="blog_entry clearfix">
		
            <?php if ( $cover_image ) { ?>
                <a class="blog-image" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                    <?php echo $cover_image; ?>
                </a>
            <?php } ?>

			<?php echo $content; ?>
			
		</div><!-- blog entry -->
		
		<?php if ( $series ) { ?>
	        
	    <div class="book-series clearfix">
	    
            <?php
                $args = array(
                    'post_type' => 'ucl_book',
                    'book_series' => $series
	            );
                $more_posts = get_posts( $args );
                
                if( count( $more_posts ) > 1 ) {
            ?>
            
	        <h3>Other Books in This Series</h3>
                
                <?php
                    foreach ( $more_posts as $post ) {
                    
                        setup_postdata( $post );
                        $related_post_id = get_the_ID();
                        $image_id = get_post_meta(
                            $related_post_id, '_uc_book_cover_image_id', true
                        );
                        $image = wp_get_attachment_image( $image_id, array(200, 300) );
                        
                        if ( $image && $related_post_id != $post_id ) {
                ?>
                
                <a class="blog-image" href="<?php the_permalink(); ?>"
                    title="<?php the_title(); ?>">
                    <?php echo $image; ?>
                </a>
                
            <?php
                        }
                    }
                    wp_reset_postdata();
                }
            ?>
            
        </div>
            
        <?php } ?>
		
        <?php book_pagination_links(); ?>

        <?php endwhile; endif; ?>

	</div><!-- content -->
	<?php get_sidebar(); ?>
</div><!-- container -->

<?php get_footer(); ?>
