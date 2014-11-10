<?php get_header(); ?>

			<div class="container">					
				<div class="page-title clearfix">
					<?php if( is_search() ) { ?>
						<h2><?php printf( __( 'Search Results for: %s', 'okay' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
					<?php } else if( is_tag() ) { ?>
						<h2><?php _e('Tag','okay'); ?>: <?php single_tag_title(); ?></h2>
					<?php } else if( is_day() ) { ?>
						<h2> <?php _e('Archive','okay'); ?>: <?php echo get_the_date(); ?></h2>
					<?php } else if( is_month() ) { ?>
						<h2><?php _e('Archive','okay'); ?>: <?php echo get_the_date('F Y'); ?></h2>
					<?php } else if( is_year() ) { ?>
						<h2><?php _e('Archive','okay'); ?>: <?php echo get_the_date('Y'); ?></h2>
					<?php } else if( is_404() ) { ?>
						<h2><?php _e('404 - Page Not Found','okay'); ?></h2>
					<?php } else if( is_category() ) { ?>
						<h2><?php _e('Category','okay'); ?>: <?php single_cat_title(); ?></h2>
					<?php } else if( is_author() ) { ?>
						<h2><?php the_author_posts(); ?> <?php _e('posts by','okay'); ?> <?php
						$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); echo $curauth->nickname; ?></h2>
					<?php } else { ?>
						<h2><?php single_post_title(); ?></h2>
					<?php } ?>
					
					<?php 
						$page_object = get_queried_object();
						$page_id = get_queried_object_id();
						if ( get_post_meta( $page_id, 'subtitle', true) ) {
							echo '<h3>' . get_post_meta($page_id, 'subtitle', true) . '</h3>';
						}
					?>
					
					<?php get_search_form(); ?>
				</div>
					
				<div class="content">
					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	
					<div id="post-<?php the_ID(); ?>" <?php post_class('blog-post clearfix'); ?>>
						<!-- uses the post format -->
						<?php
							if(!get_post_format()) {
							   get_template_part('format', 'standard');
							} else {
							   get_template_part('format', get_post_format());
							};
						?>
					</div><!-- blog post -->
		
					<?php endwhile; ?>
					
					<!-- Next post navigation for single pages -->
					<?php if(is_single()) { ?>
						<div class="blog-navigation">
							<div class="alignleft"><?php previous_post_link('%link', 'Previous Post', TRUE); ?></div>
							<div class="alignright"><?php next_post_link('%link', 'Next Post', TRUE); ?></div>
						</div>
					<?php } ?>
					
					<!-- Post navigation -->					
					<?php if( okay_page_has_nav() ) : ?>
						<div class="blog-navigation">
					    	<div class="alignleft"><?php next_posts_link(__('Older Posts', 'okay')) ?></div>
					    	<div class="alignright"><?php previous_posts_link(__('Newer Posts', 'okay')) ?></div>
						</div>
					<?php endif; ?>
					
					<!-- Comments -->					
					<?php if( is_single() ) { ?>
						<?php if ('open' == $post->comment_status) { ?>
							<div class="comments">
								<?php comments_template(); ?>
							</div>
						<?php } ?>
					<?php } ?>
					
					<?php endif; ?>
					
					<?php wp_reset_query(); ?>
					
				</div><!-- content -->

				<?php get_sidebar(); ?>
		</div><!-- container -->

<?php get_footer(); ?>
