<?php
/**
 * Template to display a single Agent.
 */
?>


<?php get_header(); ?>

<div class="container">
	<div class="page-title clearfix">
		<h2><?php the_title(); ?></h2>
	</div>
	
	<div class="content">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

        <?php
            $post_id = get_the_ID();
            $short_name = trim( get_post_meta( $post_id, '_uc_agent_short_name', true ) );
            $image_id = get_post_meta( $post_id, '_uc_agent_photo_id', true );
            $image = wp_get_attachment_image( $image_id, array(275, 400) );
            $bio = get_post_meta( $post_id, '_uc_agent_bio', true );
            $email = trim( get_post_meta( $post_id, '_uc_agent_email', true ) );
            $twitter_handle = trim( get_post_meta( $post_id, '_uc_agent_twitter_handle', true ) );
            $accepting_submissions = get_post_meta( $post_id, '_uc_agent_accepting_submissions', true );
            $content = apply_filters( 'the_content', $bio );
        ?>    

        <div class="blog_entry">
		
            <?php if ( $image ) { ?>
                <a class="blog-image" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                    <?php echo $image; ?>
                </a>
            <?php } ?>
            
            <hr />

			<?php echo $content; ?>
			
			<ul>
                <?php if ( $email ) { ?>
                <li>
                    Send <?php echo $short_name; ?> a 
                    <?php echo get_safe_email( $email, 'message' ); ?>
                </li>
                <? } ?>
			
			
			    <?php if ( $twitter_handle ) { ?>
                <li>
                    Follow <?php echo $short_name; ?> on 
                    <a href="https://twitter.com/<?php echo $twitter_handle; ?>">Twitter</a>
                </li>
                <?php } ?>
            
                <li>
                    <?php echo $short_name; ?> is 
                    <?php echo ( $accepting_submissions ? '' : 'NOT ' ) ?> currently 
                    accepting <a href="<?php echo site_url(); ?>/submissions">submissions</a>
                </li>
            </ul>
			
		</div><!-- blog entry -->

        <!-- Post navigation -->
        <div class="blog-navigation">
            <div class="alignleft"><?php previous_post_link( '%link' ); ?></div>
            <div class="alignright"><?php next_post_link( '%link' ); ?></div>
        </div>

        <?php endwhile; endif; ?>

	</div><!-- content -->
	<?php get_sidebar(); ?>
</div><!-- container -->

<?php get_footer(); ?>
