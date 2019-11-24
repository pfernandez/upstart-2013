<?php
/**
 * Template to display a single Author.
 */
?>


<?php get_header(); ?>

<div class="container post-single">

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<?php
		$post_id = get_the_ID();
		$image_id = get_post_meta( $post_id, '_uc_author_photo_id', true );
		$image = wp_get_attachment_image( $image_id, array(275, 400) );
		$bio = get_post_meta( $post_id, '_uc_author_bio', true );
		$website = get_post_meta( $post_id, '_uc_author_website', true );
		$content = apply_filters( 'the_content', $bio );
	?>

	<div class="page-title clearfix">
		<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	</div>
	
	<div class="content">
	
		<div class="blog_entry clearfix">
		
			<?php if ( $image ) { ?>
				<div class="blog-image"><?php echo $image; ?></div>
			<?php } ?>

			<?php echo $content; ?>
			
			<?php if ( $website ) { ?>
				<a href="<?php echo $website; ?>">Author Website</a>
			<?php } ?>
			
		</div><!-- blog entry -->
	
		<?php // Retrieve and display all the books by this author.
		
			$books = get_posts( array(
				'posts_per_page'   => -1,
				'orderby'          => 'post_date',
				'order'            => 'ASC',
				'meta_key'         => '_uc_book_author_id',
				'post_type'        => 'ucl_book'
			));
			
			$author_books = array();
			foreach ( $books as $book ) {
				$author_book = get_post_meta($book->ID, '_uc_book_author_id', true);
				if( in_array( $post_id, $author_book ) ) {
					$author_books[] = $book;
				}
			}
			
			if( count( $author_books ) >= 1 ) {
		?>
		
		<div class="book-series clearfix">
			<h3>Books by this author</h3>
		
			<?php
				foreach ( $author_books as $post ) {
			
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
			?>

		</div> <!-- /.book-series -->			
		<?php } ?>
		
		<?php author_pagination_links(); ?>
		
	</div><!-- content -->
	
	<?php endwhile; endif; ?>

	<?php get_sidebar(); ?>
	
</div><!-- container -->

<?php get_footer(); ?>
