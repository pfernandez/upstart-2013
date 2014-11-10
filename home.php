<?php 
/* 
Template Name: Upstart Crow Homepage
*/ 
?>

<?php get_header(); ?>
			
<div id="sections" class="home-books-news clearfix">
	
    <div class="section clearfix">
    
        <h2 id="our-clients-books" class="h3" >Our Clients' Books</h2>
        
        <div id="home-books-wrapper" class="fade-in-opacity"> 
            <div id="home-books">
                <ul class="slides">
                
                    <?php
                        $args = array( 'post_type' => 'ucl_book', 'posts_per_page' => 10 );
                        $query = new WP_Query( $args );
                    ?>

                    <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>  

                    <?php
                        $post_id = get_the_ID();
                        $image_id = get_post_meta( $post_id, '_uc_book_cover_image_id', true );
                        $image = wp_get_attachment_image( $image_id, 'medium' );
                    ?>                                                            

                    <?php if ( $image ) { ?>
                        <li>
                        <?php /*
                            <?php echo $image; ?>
                            
                             */ ?>
                            <a class="blog-image" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                <?php echo $image; ?>
                            </a>
                           
                        </li>
                    <?php } ?>

                    <?php endwhile; wp_reset_postdata(); endif; ?>
                
                </ul>
            </div>
        </div>
        
        <div id="home-news">

            <h2>News</h2>
    
            <?php
                $args = array( 'category_name' => 'news', 'posts_per_page' => 2 );
                $query = new WP_Query( $args );
            ?>

            <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>  

            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <div class="blog-content">
                <?php the_excerpt(); ?>
            </div>

            <?php endwhile; wp_reset_postdata(); endif; ?>
    
        </div>
        
    </div>
</div>

<div id="for-writers-wrapper" class="full-width">
    <div id="sections" class="clearfix">
        <div id="for-writers" class="section">

            <h2>For Writers</h2>
    
            <div id="for-writers-left">
                <h3>Want to Submit?</h3>
                <p>Read the requirements on<br />our Submissions page.</p>
                <a class="submissions-btn" href="<?php echo site_url(); ?>/submissions">Submissions</a>
            </div>
    
            <div id="for-writers-right">
                <h3>Writer's Toolbox</h3>
                <p>Our Toolbox is a destination<br />for writers wanting to improve<br />their craft and are working<br />towards publication.</p>
                <a class="toolbox-btn" href="<?php echo site_url(); ?>/writers-toolbox">Toolbox</a>
            </div>
        
        </div>
    </div>
</div>

<div id="home-news-blog-wrapper" class="full-width">
    <div id="sections" class="clearfix">
        <div class="section clearfix">
        
            <div id="home-blog">
        
                <h2>Our Blog</h2>
        
                <?php
                    $idObj = get_category_by_slug( 'news' ); 
                    $args = array(
                        'category__not_in' => $idObj->term_id,
                        'posts_per_page' => 2
                    );
                    $query = new WP_Query( $args );
                ?>

                <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>  
                
                    <div class="clearfix">
                    
                        <?php if ( has_post_thumbnail()) : ?>
                           <a class="blog-image" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
                           <?php the_post_thumbnail(); ?>
                           </a>
                        <?php endif; ?>
                        
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        
                        <div class="blog-content">
                            <?php the_excerpt(); ?>
                        </div>
                    
                    </div>
                
                <?php endwhile; wp_reset_postdata(); endif; ?>
        
            </div>
                    
            <div id="home-tweets">    
                <?php dynamic_sidebar( 'twitter_area' ); ?>
	        </div>
            
        </div>
    </div>
</div>
			
<?php get_footer(); ?>
