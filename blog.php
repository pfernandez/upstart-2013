<?php
/**
 * Template Name: Blog
 */

get_header();

$cat_slug = '';
$cat_string = '';
$cat_id = '';

if( isset( $_GET['cat'] ) )
    $cat_slug = $_GET['cat'];

if( $cat_slug ) {
    $cat = get_category_by_slug( $cat_slug );
    $cat_id = $cat->term_id;
    $cat_string = ': ' . $cat->name;
}
?>

<div id="blog-page" class="container">

	<div class="page-title clearfix">
		<?php get_search_form(); ?>
		<h2><a href="<?php echo site_url(); ?>/blog"><?php the_title(); ?></a><?php echo $cat_string; ?></h2>
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

		<?php endwhile; endif; ?>

        <?php
            // Override the $wp_query with our custom query to allow for pagination.
            $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
            $args = array(
                'posts_per_page' => 10,
                'paged' => $paged,
                'cat' => $cat_id,
            );
            global $wp_query;
            $temp = $wp_query; // store original query for later use
            $wp_query = null;
            $wp_query = new WP_Query( $args );
        ?>
                
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>               

        <div id="post-<?php echo the_ID(); ?>" <?php post_class('blog-post clearfix'); ?>>
            
            <div class="blog-text">
                    
                <div class="title-meta">
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                </div>
             
                <div class="blog-entry">
                    <div class="blog-content">
                    
                        <?php if ( get_post_meta( $post->ID, 'okvideo', true ) ) { ?>
                            <div class="okvideo">
                                <?php echo get_post_meta( $post->ID, 'okvideo', true ) ?>
                            </div>
                        <?php } else { ?>
        
                            <?php if ( has_post_thumbnail() ) { ?>
                                <a class="blog-image" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail( 'blog-image' ); ?></a>
                            <?php } ?>
        
                        <?php } ?>
		        
                        <?php the_excerpt(); ?>
                        
                    </div>
                </div><!-- blog entry -->
                
            </div><!-- blog text -->
            
            <div class="blog-meta">
		
			        <ul class="meta-links">
		            	<li><?php echo get_the_date('m/d/Y'); ?></li>
		            	<li><?php the_author_posts_link(); ?></li>
		            	<li><a href="<?php the_permalink(); ?>#comments"><?php comments_number(__('No Comments','okay'),__('1 Comment','okay'),__( '% Comments','okay') );?></a></li> 
		            </ul>
			
			        <?php if( is_single() ) { ?>
				        <ul class="meta-links">
					        <li class="share-title"><?php _e('Category:','okay'); ?></li>
					        <li>
						        <?php the_category('<br/>') ?>
					        </li>
					        <?php 										
						        $post_tags = wp_get_post_tags( $post->ID );
						        if( !empty( $post_tags ) ) {
					        ?>
						        <li></li>
						        <li class="share-title meta-tag-title"><?php _e('Tag:','okay'); ?></li>
						        <li>
							        <?php the_tags('', '<br />', ''); ?> 
						        </li>
					        <?php } ?>
				        </ul>
			        <?php } ?>
			
			        <?php if( is_search() || is_archive() || is_attachment() ) {} else { ?>
				        <ul class="meta-links">
					        <li class="share-title"><?php _e('Share:','okay'); ?></li>
					        <li class="twitter">
						        <a onclick="window.open('http://twitter.com/home?status=<?php the_title(); ?> - <?php the_permalink(); ?>','twitter','width=450,height=300,left='+(screen.availWidth/2-375)+',top='+(screen.availHeight/2-150)+'');return false;" href="http://twitter.com/home?status=<?php the_title(); ?> - <?php the_permalink(); ?>" title="<?php the_title(); ?>" target="blank"><?php _e('Twitter','okay'); ?></a>
					        </li>
					
					        <li class="facebook">
						        <a onclick="window.open('http://www.facebook.com/share.php?u=<?php the_permalink(); ?>','facebook','width=450,height=300,left='+(screen.availWidth/2-375)+',top='+(screen.availHeight/2-150)+'');return false;" href="http://www.facebook.com/share.php?u=<?php the_permalink(); ?>" title="<?php the_title(); ?>"  target="blank"><?php _e('Facebook','okay'); ?></a>
					        </li>
					
					        <li class="googleplus">
						        <a class="share-google" href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="window.open('https://plus.google.com/share?url=<?php the_permalink(); ?>','gplusshare','width=450,height=300,left='+(screen.availWidth/2-375)+',top='+(screen.availHeight/2-150)+'');return false;"><?php _e('Google+','okay'); ?></a>
					        </li>
				        </ul>
			        <?php } ?>
		        </div><!-- blog meta -->
            
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
