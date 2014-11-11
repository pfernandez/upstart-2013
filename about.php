<?php
/**
 * Template Name: About
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
			<?php the_content(); ?>
		</div><!-- blog entry -->

		<?php endwhile; ?>
		<?php endif; ?>

        <?php
            // Override the $wp_query with our custom query to allow for pagination.
            $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
            $args = array(
                'post_type' => 'ucl_agent',
                'paged'     => $paged,
                'orderby'   => 'menu_order',
                'order'     => 'ASC',
            );
            global $wp_query;
            $temp = $wp_query; // store original query for later use
            $wp_query = null;
            $wp_query = new WP_Query( $args );
        ?>
                
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        
        <?php
            $post_id = get_the_ID();
            $short_name = get_post_meta( $post_id, '_uc_agent_short_name', true );
            $image_id = get_post_meta( $post_id, '_uc_agent_photo_id', true );
            $image = wp_get_attachment_image( $image_id, array(120, 160) );
            $bio = get_post_meta( $post_id, '_uc_agent_bio', true );
            $email = get_post_meta( $post_id, '_uc_agent_email', true );
            $twitter_handle = get_post_meta( $post_id, '_uc_agent_twitter_handle', true );
            $accepting_submissions = get_post_meta( $post_id, '_uc_agent_accepting_submissions', true );
            $submissions_email = get_post_meta( $post_id, '_uc_agent_submissions_email', true );
            $tastes = get_post_meta( $post_id, '_uc_agent_tastes', true );
        ?>                                                            

        <div id="post-<?php echo $post_id ?>" <?php post_class('blog-post clearfix'); ?>>
            
            <div class="blog-text">
                    
                <div class="title-meta">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                </div>
             
                <div class="blog-entry">
                    <div class="blog-content">
                        <?php
                            $more = '... <a href="' . get_permalink( $post_id )
                                . '">[Read more about ' . $short_name . ']</a>';
                            $content = apply_filters( 'the_content', $bio );
                            $content = str_replace( ']]>', ']]&gt;', $content );
                            echo wp_trim_words( $content, 55, $more );
                        ?>
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
            <div class="blog-navigation">
                <div class="alignleft"><?php previous_posts_link(__('Previous', 'okay')) ?></div>
                <div class="alignright"><?php next_posts_link(__('Next', 'okay')) ?></div>
            </div>
        <?php endif; ?>

		<?php $wp_query = $temp; // reset back to original query ?>

	</div><!-- content -->
	<?php get_sidebar(); ?>
</div><!-- container -->

<?php get_footer(); ?>
