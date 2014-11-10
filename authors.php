<?php
/**
 * Template Name: Authors
 */
?>


<?php get_header(); global $more; ?>

<div class="container">
	<div class="page-title clearfix">
		<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	</div>
	
	<div class="content">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<div class="blog_entry">
			<?php if ( get_post_meta( $post->ID, 'okvideo', true ) ) { ?>
				<div class="okvideo">
					<?php echo get_post_meta( $post->ID, 'okvideo', true ); ?>
				</div>
			<?php } else { ?>
			
				<?php if ( has_post_thumbnail() ) { ?>
					<a class="blog-image" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail( 'blog-image' ); ?></a>
				<?php } ?>
			
			<?php } ?>
			
			<?php the_content(); ?>
		</div><!-- blog entry -->

		<?php endwhile; ?>
		<?php endif; ?>

        <?php
            // Override the $wp_query with our custom query to allow for pagination.
            $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
            $args = array(
                'post_type' => 'ucl_author',
                'posts_per_page' => 10,
                'paged' => $paged,
                'orderby' => 'title',
            );
            global $wp_query;
            $temp = $wp_query; // store original query for later use
            $wp_query = null;
            add_filter( 'posts_orderby' , 'posts_orderby_lastname' );
            $wp_query = new WP_Query( $args );
            remove_filter( 'posts_orderby' , 'posts_orderby_lastname' );
        ?>
                
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        
        <?php
            $post_id = get_the_ID();
            $image_id = get_post_meta( $post_id, '_uc_author_photo_id', true );
            $image = wp_get_attachment_image( $image_id, array(105, 145) );
            $bio = get_post_meta( $post_id, '_uc_author_bio', true );
            $website = get_post_meta( $post_id, '_uc_author_website', true );
        ?>                                                            

        <div id="post-<?php echo $post_id ?>" <?php post_class('blog-post clearfix'); ?>>
            
            <div class="blog-text">
                    
                <div class="title-meta">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                </div>
             
                <div class="blog-entry">
                    <div class="blog-content">

                        <?php
                            $more = '... <a href="' . get_permalink( $post_id ) . '">[More]</a>';
                            $content = apply_filters( 'the_content', $bio );
                            $content = str_replace( ']]>', ']]&gt;', $content );
                            echo wp_trim_words( $content, 55, $more );
                        ?>
                        
                        <!-- <a href="<?php echo $website; ?>">Author Website</a> -->
                    </div>
                    
                </div><!-- blog entry -->
            </div><!-- blog text -->
                 
            <div class="blog-meta">
                <?php if ( $image ) { ?>
                    <a class="blog-image" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                        <?php echo $image; ?>
                    </a>
                <?php } ?>
            </div>
            
        </div><!-- blog post -->

        <?php endwhile; endif; ?>

        <!-- Post navigation -->
        <?php if( okay_page_has_nav() ) : ?>
            <div class="blog-navigation paginate-links">
                <?php
                    echo paginate_links( array(
	                    'base' => str_replace( 99999, '%#%',
	                        esc_url( get_pagenum_link( 99999 ) ) ),
	                    'format' => '?paged=%#%',
	                    'current' => max( 1, get_query_var('paged') ),
	                    'total' => $wp_query->max_num_pages,
	                    'prev_text'    => __('Previous'),
	                    'next_text'    => __('Next'),
                    ) );
                ?>
            </div>
        <?php endif; ?>

		<?php $wp_query = $temp; // reset back to original query ?>

	</div><!-- content -->
	<?php get_sidebar(); ?>
</div><!-- container -->

<?php get_footer(); ?>
