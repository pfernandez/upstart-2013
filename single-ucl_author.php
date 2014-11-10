<?php
/**
 * Template to display a single Author.
 */
?>


<?php get_header(); ?>

<div class="container">
	<div class="page-title clearfix">
		<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	</div>
	
	<div class="content">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

        <?php
            $post_id = get_the_ID();
            $image_id = get_post_meta( $post_id, '_uc_author_photo_id', true );
            $image = wp_get_attachment_image( $image_id, array(275, 400) );
            $bio = get_post_meta( $post_id, '_uc_author_bio', true );
            $website = get_post_meta( $post_id, '_uc_author_website', true );
            $content = apply_filters( 'the_content', $bio );
        ?>    

        <div class="blog_entry">
		
            <?php if ( $image ) { ?>
                <a class="blog-image" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                    <?php echo $image; ?>
                </a>
            <?php } ?>

			<?php echo $content; ?>
			
			<a href="<?php echo $website; ?>">Author Website</a>
			
		</div><!-- blog entry -->

        <?php author_pagination_links(); ?>

        <?php endwhile; endif; ?>

	</div><!-- content -->
	<?php get_sidebar(); ?>
</div><!-- container -->

<?php get_footer(); ?>
