<?php
/**
 * Template Name: Writer's Toolbox
 */
?>

<?php get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<div id="for-writers-wrapper" class="full-width">
    <div id="sections" class="clearfix">
        <div id="for-writers">
        
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            
            <div id="for-writers-left">
                <h3>Getting Started</h3>
		        <?php the_field( 'getting_started' ); ?>
		    </div>
		
		    <div id="for-writers-right">
		        <h3>Latest Additions</h3>
                <?php
                    $posts_array = get_posts(array(
                        'category_name'  => 'writers-toolbox',
                        'posts_per_page' => 5
                    ));
                    foreach ($posts_array as $post) {
                        echo '<p><a href="' . get_permalink() . '">' 
                          . $post->post_title . '</a></p>';
                    }
                    wp_reset_postdata();
                ?>
            </div>

		    <a id="toolbox-link" href="<?php echo site_url(); ?>/blog/?cat=writers-toolbox">
                See All Toolbox Posts>>
            </a>
		
        </div>
    </div>
</div>

<div id="visit-our-bookshelf-wrapper" class="full-width">
    <div id="sections" class="clearfix">
        <div id="visit-our-bookshelf">
            <h3>Visit our Bookshelf for Writers</h3>
            <a href="<?php echo site_url(); ?>/bookshelf-writers-editors/">
                Hone your craft. See our Recommendations >>
            </a>
        </div>
    </div>
</div>

<div class="container">
    
    <div id="useful-links">
        <h3>Useful Links</h3>
        <div id="useful-links-left">
            <?php the_field( 'useful_links_left_column' ); ?>
        </div>
        <div id="useful-links-right">
            <?php the_field( 'useful_links_right_column' ); ?>
        </div>
    </div>
    
    <div id="want-to-submit">
        <h3>Want to Submit?</h3>
        <p>Read the requirements on our submissions page.</p>
        <a class="submissions-btn" href="<?php echo site_url(); ?>/submissions">Submissions</a>
    </div>
    
</div><!-- container -->

<?php endwhile; endif; ?>

<?php get_footer(); ?>
