<?php
/**
 * Template Name: Books
 */

get_header();

$cat_id = get_query_var( 'cat' );
$cat_string = '';
if( $cat_id ) {
	$term = get_term( $cat_id, 'book_category' );
	$cat_string = ': ' . $term->name;
}

$page_id = get_queried_object_id();
$page_link = get_page_link( $page_id );
?>

<div class="container">

	<div class="post-type-header clearfix">
		<h2><?php the_title(); echo $cat_string; ?></h2>

		<ul class="category-list">
			<li><a href="<?php echo $page_link; ?>">All Genres</a></li>
			<?php
				$genres = get_terms( 'book_category' );
				foreach( $genres as $genre ) {
					echo '<li><a href="' . $page_link . '?cat=' . $genre->term_id . '">'
						. $genre->name . '</a></li>';
				}
			?>
		</ul>
	</div>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<div class="blog_entry">
		<?php if ( get_post_meta( $post->ID, 'okvideo', true ) ) { ?>
			<div class="okvideo">
				<?php echo get_post_meta( $post->ID, 'okvideo', true ); ?>
			</div>
		<?php } ?>

		<?php the_content(); ?>
	</div><!-- blog entry -->

	<?php endwhile; endif; ?>

	<?php
		// Override the $wp_query with our custom query to allow for pagination.
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		$tax_query = array();
		if( $cat_id ) {
			$tax_query[] = array(
				'taxonomy' => 'book_category',
				'field' => 'id',
				'terms' => $cat_id,
			);
		}
		$args = array(
			'post_type' => 'ucl_book',
			'posts_per_page' => 12,
			'paged' => $paged,
			'tax_query' => $tax_query,
			'orderby' => 'title',
			'order' => 'ASC',
		);
		global $wp_query;
		$temp = $wp_query; // store original query for later use
		$wp_query = null;
		add_filter( 'posts_orderby' , 'posts_orderby_book_title' );
		$wp_query = new WP_Query( $args );
		remove_filter( 'posts_orderby' , 'posts_orderby_book_title' );
	?>

	<div id="books-grid" class="clearfix">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<?php
			$post_id = get_the_ID();
			$image_id = get_post_meta( $post_id, '_uc_book_cover_image_id', true );
			$image = wp_get_attachment_image( $image_id, 'medium' );
			$author_ids = get_post_meta( $post_id, '_uc_book_author_id', true );
		?>

		<div id="post-<?php echo $post_id ?>" <?php echo post_class( 'book-tile' ); ?>>
			<div class="book-tile-inner">
				<a class="blog-image fade-in-display" href="<?php the_permalink(); ?>"
					title="<?php the_title(); ?>">
					<?php echo $image; ?>
				</a>
				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<?php foreach( $author_ids as $author_id ) : ?>
				<h4><?php echo get_the_title($author_id); ?></h4>
				<?php endforeach; ?>
			</div>
		</div>

		<?php endwhile; endif; ?>

	</div>

	<!-- Post navigation -->
	<?php if( okay_page_has_nav() ) : ?>
		<div class="blog-navigation">
			<div class="alignleft"><?php previous_posts_link(__('Previous', 'okay')) ?></div>
			<div class="alignright"><?php next_posts_link(__('Next', 'okay')) ?></div>
		</div>
	<?php endif; ?>

	<?php $wp_query = $temp; // reset back to original query ?>

</div><!-- container -->

<?php get_footer(); ?>
