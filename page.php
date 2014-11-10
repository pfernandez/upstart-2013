<?php get_header(); global $more; ?>

<div class="container">
	<div class="page-title clearfix">
		<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		
		<?php if ( get_post_meta( $post->ID, 'subtitle', true ) ) { ?>
			<h3><?php echo get_post_meta( $post->ID, 'subtitle', true ); ?></h3>
		<?php } ?>
	</div>
	
	<div class="content">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<div class="blog_entry">
			<?php if ( get_post_meta( $post->ID, 'okvideo', true ) ) { ?>
				<div class="okvideo">
					<?php echo get_post_meta( $post->ID, 'okvideo', true ); ?>
				</div>
			<?php } ?>
			
			<?php the_content(); ?>
		</div><!-- blog entry -->

		<?php endwhile; ?>
		<?php endif; ?>

	</div><!-- content -->
	<?php get_sidebar(); ?>
</div><!-- container -->

<?php get_footer(); ?>
