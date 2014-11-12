<?php
/**
 * Custom functions that load before the parent theme's functions.php file.
 */

         /*/ DEBUGGING BLOCK //////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////
       //                                                                             //
           $var = is_home();
           echo "<pre style='font:14px Courier; padding:10px; border-radius:10px;";
           echo "color:#0E0; -webkit-box-shadow: 0 0 12px #000; margin:20px 0;";
           echo "background:rgba(0,0,0,.8);'>"; var_dump($var); echo "</pre>";
  //                                                                             //
 /////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////*/


/**
 * Show a special message to non-whitelisted users instead of the regular site.
 * To activate maintenance mode, uncomment the add_action() line below.
 */
//add_action('wp_head', 'simple_maintenance_mode');
function simple_maintenance_mode() {
 
    $user_name = wp_get_current_user()->user_login;
    $ip = $_SERVER['REMOTE_ADDR'];
    
    $user_is_dev = (
        current_user_can( 'update_themes' )
        // || $user_name == 'test1'
        // || $ip == '00.000.000.000'  
    );
    
    if( ! $user_is_dev ) {
?>
	</head>	
	<body>
		<div style="margin: 100px auto; width: 450px; text-align: center;">
		    <h1 style="font-size: 100px; margin-bottom: 50px;">Sit tight.</h1>
		    <h2>We're upgrading and will be back on line soon.</h2>
		</div>
	</body>
<?php
        exit;
    }
}


/**
 * Register and enqueue the requred CSS and Javascript.
 */
function custom_styles_scripts() {

    $theme_uri = get_stylesheet_directory_uri();

    // CSS for the parent theme.
    wp_register_style( 'parent-css', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'parent-css' );
    
    // Our style.css file, which inherits the parent theme's CSS.
    wp_register_style(
        'child-css',
        $theme_uri . '/css/custom.css',
        array( 'parent-css', 'media-queries-css', 'tb-css', 'flex-css' )
    );
    wp_enqueue_style( 'child-css' );
    
    // Scripts that will appear in the header.
    // wp_register_script( 'typekit', 'http://use.typekit.net/fah7euc.js' );
    // wp_enqueue_script( 'typekit' );
    
    // Scripts that will appear in the footer.
    wp_register_script(
        'child-custom-js',
        $theme_uri . '/js/custom.js',
        array( 'jquery' ),
        false,
        true
    );
	wp_enqueue_script( 'child-custom-js' );
	
	// Make some PHP data available to our custom Javascript file.
	$data = array( 'url' => __( $theme_uri ) );
	wp_localize_script('child-custom-js', 'SiteData', $data);
}
add_action( 'wp_enqueue_scripts', 'custom_styles_scripts' );


// Add theme support for HTML5 search forms.
add_theme_support( 'html5', array( 'search-form' ) );


function my_search_form( $form ) {
    $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
    <div><label class="screen-reader-text" for="s">' . __( 'Search for:' ) . '</label>
    <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="Search" />
    <input type="submit" id="searchsubmit" value="'. esc_attr__( 'Search' ) .'" />
    </div>
    </form>';

    return $form;
}
add_filter( 'get_search_form', 'my_search_form' );


// Customize excerpt length.
function custom_excerpt_length( $length ) {
    if( is_page_template( 'home.php' ) ) {
	    if( in_category( 'news' ) ) {
	        return 18;
	    }
	    else return 36;
	}
	return 185;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );


// Add the [Read More] link to excerpts on the Blog page.
function custom_excerpt_more( $more ) {
    return '... <div class="read-more"><a href="'. get_permalink( get_the_ID() ) . '">Read More>></a></div>';
}
add_filter( 'excerpt_more', 'custom_excerpt_more' );


// Returns a link that uses javascript to safely access an email address.
function get_safe_email( $email_address, $link_text ) {
    $arr = explode( '@', $email_address, 2 );
    return '<a onclick="p1=\'' . $arr[0] . '\'; p2=\''
        . $arr[1] . '\'; this.href=\'mailto:\' + p1 + \'@\' + p2" href="#"'
        . 'rel="nofollow">' . $link_text . '</a>';
}


// Register Custom Taxonomy
function book_genre_taxonomy()  {

	$labels = array(
		'name'                       => _x( 'Book Genres', 'Taxonomy General Name', 'okay' ),
		'singular_name'              => _x( 'Book Genre', 'Taxonomy Singular Name', 'okay' ),
		'menu_name'                  => __( 'Book Genres', 'okay' ),
		'all_items'                  => __( 'All Genres', 'okay' ),
		'parent_item'                => __( 'Parent Genre', 'okay' ),
		'parent_item_colon'          => __( 'Parent Genre:', 'okay' ),
		'new_item_name'              => __( 'New Genre Name', 'okay' ),
		'add_new_item'               => __( 'Add New Genre', 'okay' ),
		'edit_item'                  => __( 'Edit Genre', 'okay' ),
		'update_item'                => __( 'Update Genre', 'okay' ),
		'separate_items_with_commas' => __( 'Separate genres with commas', 'okay' ),
		'search_items'               => __( 'Search genres', 'okay' ),
		'add_or_remove_items'        => __( 'Add or remove genres', 'okay' ),
		'choose_from_most_used'      => __( 'Choose from the most used genres', 'okay' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'book_category', 'custom_post_type', $args );

}
add_action( 'init', 'book_genre_taxonomy', 0 );


// Register Custom Taxonomy
function book_series_taxonomy()  {

	$labels = array(
		'name'                       => _x( 'Book Series', 'Taxonomy General Name', 'okay' ),
		'singular_name'              => _x( 'Book Series', 'Taxonomy Singular Name', 'okay' ),
		'menu_name'                  => __( 'Book Series', 'okay' ),
		'all_items'                  => __( 'All Book Series', 'okay' ),
		'parent_item'                => __( 'Parent Book Series', 'okay' ),
		'parent_item_colon'          => __( 'Parent Book Series:', 'okay' ),
		'new_item_name'              => __( 'New Book Series Name', 'okay' ),
		'add_new_item'               => __( 'Add New Book Series', 'okay' ),
		'edit_item'                  => __( 'Edit Book Series', 'okay' ),
		'update_item'                => __( 'Update Book Series', 'okay' ),
		'separate_items_with_commas' => __( 'The series the book is a part of, if any.', 'okay' ),
		'search_items'               => __( 'Search series', 'okay' ),
		'add_or_remove_items'        => __( 'Add or remove series', 'okay' ),
		'choose_from_most_used'      => __( 'Choose from the most used series', 'okay' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'book_series', 'custom_post_type', $args );

}
add_action( 'init', 'book_series_taxonomy', 0 );


// Add Book post type.
add_action('init', 'cptui_register_my_cpt_book');
function cptui_register_my_cpt_book() {
    register_post_type('ucl_book', array(
        'label' => 'Books',
        'description' => 'Books written by the agency\'s Authors.',
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'capability_type' => 'post',
        'map_meta_cap' => true,
        'hierarchical' => false,
        'has_archive' => true,
        'rewrite' => array('slug' => 'book', 'with_front' => true),
        'query_var' => true,
        'supports' => array('title','revisions'),
        'taxonomies' => array( 'book_category', 'book_series' ),
        'labels' => array (
            'name' => 'Books',
            'singular_name' => 'Book',
            'menu_name' => 'Books',
            'add_new' => 'Add Book',
            'add_new_item' => 'Add New Book',
            'edit' => 'Edit',
            'edit_item' => 'Edit Book',
            'new_item' => 'New Book',
            'view' => 'View Book',
            'view_item' => 'View Book',
            'search_items' => 'Search Books',
            'not_found' => 'No Books Found',
            'not_found_in_trash' => 'No Books Found in Trash',
            'parent' => 'Parent Book',
        )
    ) );
}


// Add Author post type.
add_action('init', 'cptui_register_my_cpt_author');
function cptui_register_my_cpt_author() {
    register_post_type('ucl_author', array(
        'label' => 'Authors',
        'description' => 'An author managed by this agency.',
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'capability_type' => 'post',
        'map_meta_cap' => true,
        'hierarchical' => false,
        'has_archive' => true,
        'rewrite' => array('slug' => 'author', 'with_front' => true),
        'query_var' => true,
        'supports' => array('title','revisions'),
        'labels' => array (
            'name' => 'Authors',
            'singular_name' => 'Author',
            'menu_name' => 'Authors',
            'add_new' => 'Add Author',
            'add_new_item' => 'Add New Author',
            'edit' => 'Edit',
            'edit_item' => 'Edit Author',
            'new_item' => 'New Author',
            'view' => 'View Author',
            'view_item' => 'View Author',
            'search_items' => 'Search Authors',
            'not_found' => 'No Authors Found',
            'not_found_in_trash' => 'No Authors Found in Trash',
            'parent' => 'Parent Author',
        )
    ) );
}


// Add Agent post type.
add_action('init', 'cptui_register_my_cpt_agent');
function cptui_register_my_cpt_agent() {
    register_post_type('ucl_agent', array(
        'label' => 'Agents',
        'description' => 'Upstart Crow literary agents.',
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'capability_type' => 'post',
        'map_meta_cap' => true,
        'hierarchical' => false,
        'has_archive' => true,
        'rewrite' => array('slug' => 'agent', 'with_front' => true),
        'query_var' => true,
        'supports' => array('title','revisions','page-attributes'),
        'labels' => array (
            'name' => 'Agents',
            'singular_name' => 'Agent',
            'menu_name' => 'Agents',
            'add_new' => 'Add Agent',
            'add_new_item' => 'Add New Agent',
            'edit' => 'Edit',
            'edit_item' => 'Edit Agent',
            'new_item' => 'New Agent',
            'view' => 'View Agent',
            'view_item' => 'View Agent',
            'search_items' => 'Search Agents',
            'not_found' => 'No Agents Found',
            'not_found_in_trash' => 'No Agents Found in Trash',
            'parent' => 'Parent Agent',
        )
    ) );
}

// Replace "Enter title here" for custom post types.
function uc_custom_title_text( $translation, $text, $domain ) {

	global $post;
    if ( ! isset( $post->post_type ) )
        return $translation;
    
    $temp = get_translations_for_domain( $domain );
	$translations = &$temp;
	$translation_array = array();
 
	switch ($post->post_type) {
	
		case 'ucl_agent': // custom post type name
			$translation_array = array(
				'Enter title here' => 'Enter agent name here'
			);
			break;
			
		case 'ucl_author':
			$translation_array = array(
				'Enter title here' => 'Enter author name here'
			);
			break;
	}
 
	if ( array_key_exists( $text, $translation_array ) )
		return $translations->translate( $translation_array[$text] );
	
	return $translation;
}
add_filter('gettext', 'uc_custom_title_text', 10, 4);


// Add custom columns to the Author and Agent panels.
function add_new_post_type_columns( $columns ) {
    $columns['title'] = _x('Name', 'column name');
    return $columns;
}
add_filter('manage_edit-ucl_agent_columns', 'add_new_post_type_columns');
add_filter('manage_edit-ucl_author_columns', 'add_new_post_type_columns');


// Add custom columns to the Book panel.
function uc_book_add_columns( $columns, $post_id ) {
    $columns['in_carousel'] = __( 'Homepage Carousel' );
    return $columns;
}
function uc_book_get_column_value( $column, $post_id ) {
    switch ( $column ) {
		case 'in_carousel' :
			echo get_post_meta( $post_id , '_uc_in_carousel' , true ); 
			break;
    }
    
}
add_filter( 'manage_edit-ucl_book_columns', 'uc_book_add_columns' );
add_action( 'manage_ucl_book_posts_custom_column' , 'uc_book_get_column_value', 10, 2 );


// Customizations for the Metronet Reorder Podt Types plugin.
function uc_reorder_custom_post_types( $post_types ) {
    $post_types = array( 'ucl_agent' );
    return $post_types;
}
function uc_reorder_page_css() {
	echo '<style>
		.ucl_agent_page_reorder-ucl_agent .wrap h2 {
			display: none;
		}
		.ucl_agent_page_reorder-ucl_agent .wrap::before {
			content: "Order to display agents on About page:";
			display: block;
			font-size: 18px;
			font-weight: 400;
			padding: 9px 15px 4px 0;
			line-height: 29px;
		}
	</style>';
}
add_filter( 'metronet_reorder_post_types', 'uc_reorder_custom_post_types' );
add_action('admin_head', 'uc_reorder_page_css');


// Custom fields for the Author content type.
function uc_author_metaboxes( $meta_boxes ) {
	$prefix = '_uc_'; // Prefix for all fields
	$meta_boxes[] = array(
		'id' => 'author_info_metabox',
		'title' => 'Author Info',
		'pages' => array( 'ucl_author' ), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
                'name' => 'Photo',
                'desc' => 'Upload a photo of the author at least 120 pixels wide.',
                'id' => $prefix . 'author_photo',
                'type' => 'file',
                'save_id' => true, // save ID using true
                'allow' => array( 'attachment' ) // allow url reference with array( 'url', 'attachment' )
            ),
			array(
				'name' => 'Bio',
				'desc' => 'A description of the author\'s work and/or background.',
				'id' => $prefix . 'author_bio',
	            'type' => 'wysiwyg',
	            'options' => array(
	                'media_buttons' => false, // hide insert/upload button(s)
	                'teeny' => true, // output the minimal editor config used in Press This
	            ),
			),
			array(
				'name' => 'Website',
				'desc' => 'Example: http://williamgibson.com (leave blank if none).',
				'id' => $prefix . 'author_website',
				'type' => 'text'
			),
		),
	);

	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'uc_author_metaboxes' );


/**
 * Gets a number of terms and displays them as options
 * @param  string       $taxonomy Taxonomy terms to retrieve. Default is category.
 * @param  string|array $args     Optional. Change the defaults retrieving terms.
 * @return array                  An array of options that matches the CMB options array
 */
function cmb_get_term_options( $taxonomy = 'category', $args = array() ) {

    $args['taxonomy'] = $taxonomy;
    // $defaults = array( 'taxonomy' => 'category' );
    $args = wp_parse_args( $args, array( 'taxonomy' => 'category' ) );

    $taxonomy = $args['taxonomy'];

    $terms = (array) get_terms( $taxonomy, $args );

    // Initate an empty array
    $term_options = array();
    if ( ! empty( $terms ) ) {
        foreach ( $terms as $term ) {
            $term_options[ $term->slug ] = $term->name;
        }
    }

    return $term_options;
}


// Custom fields for the Book content type.
function uc_book_metaboxes( $meta_boxes ) {

	$prefix = '_uc_'; // Prefix for all fields
	$meta_boxes[] = array(
		'id' => 'book_info_metabox',
		'title' => 'Book Info',
		'pages' => array( 'ucl_book' ), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Author',
				'desc' => 'The name of the author.',
				'id' => $prefix . 'book_author',
				'type' => 'text'
			),
			array(
                'name' => 'Cover Image',
                'desc' => 'Upload an image of the book cover at least 275 pixels wide.',
                'id' => $prefix . 'book_cover_image',
                'type' => 'file',
                'save_id' => true, // save ID using true
                'allow' => array( 'attachment' ) // allow url reference with array( 'url', 'attachment' )
            ),
			array(
				'name' => 'Summary',
				'desc' => 'A summary of the book\'s contents.',
				'id' => $prefix . 'book_summary',
	            'type' => 'wysiwyg',
	            'options' => array(
	                'media_buttons' => false, // hide insert/upload button(s)
	              //  'teeny' => true, // output the minimal editor config used in Press This
	            ),
			),
			array(
	            'name' => 'Series',
	            'desc' => 'The series the book is a part of, if any.',
	            'id' => $prefix . 'book_series',
	            'taxonomy' => 'book_series',
	            'type' => 'taxonomy_select',
                    'show_option_none' => '- None -'
            ),
            array(
	            'name' => 'Genre',
	            'id' => $prefix . 'book_genre',
	            'taxonomy' => 'book_category',
	            'type' => 'taxonomy_multicheck',	
            ),
            array(
				'name'    => 'Homepage Carousel',
				'desc'    => 'Show the cover on the home page slider (max 10 shown, ordered by date).',
				'id' => $prefix . 'in_carousel',
				'type' => 'checkbox'
			),
        )
	);

	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'uc_book_metaboxes' );


// Custom fields for the Agent content type.
function uc_agent_metaboxes( $meta_boxes ) {
	$prefix = '_uc_'; // Prefix for all fields
	$meta_boxes[] = array(
		'id' => 'agent_info_metabox',
		'title' => 'Agent Info',
		'pages' => array( 'ucl_agent' ), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
		    array(
				'name' => 'Short Name',
				'desc' => 'The name the agent normally goes by, usually a first name or nickname.',
				'id' => $prefix . 'agent_short_name',
				'type' => 'text'
			),
			array(
                'name' => 'Photo',
                'desc' => 'Upload a photo of the agent at least 120 pixels wide.',
                'id' => $prefix . 'agent_photo',
                'type' => 'file',
                'save_id' => true, // save ID using true
                'allow' => array( 'attachment' ) // allow url reference with array( 'url', 'attachment' )
            ),
			array(
				'name' => 'Bio',
				'desc' => 'A description of the agent\'s background.',
				'id' => $prefix . 'agent_bio',
	            'type' => 'wysiwyg',
	            'options' => array(
	                'media_buttons' => false, // hide insert/upload button(s)
	                //'teeny' => true, // output the minimal editor config used in Press This
	            ),
			),
			array(
				'name' => 'Email',
				'desc' => 'The agent\'s email (displayed publicly).',
				'id' => $prefix . 'agent_email',
				'type' => 'text'
			),
			array(
				'name' => 'Twitter Handle',
				'desc' => 'Example: @SecretAgent007.',
				'id' => $prefix . 'agent_twitter_handle',
				'type' => 'text'
			),
			array(
	            'name' => 'Accepting Submissions?',
	            'desc' => 'Check this box if the agent is currently accepting submissions.',
	            'id' => $prefix . 'agent_accepting_submissions',
	            'type' => 'checkbox'
            ),
			array(
				'name' => 'Submission Email',
				'desc' => 'The agent\'s email for submissions (only diplayed if currently '
				    . 'accepting submissions).',
				'id' => $prefix . 'agent_submissions_email',
				'type' => 'text'
			),
			array(
	            'name' => 'Tastes',
	            'desc' => 'A description of the agent\'s literary tastes (only diplayed if '
				    . 'currently accepting submissions).',
	            'id' => $prefix . 'agent_tastes',
	            'type' => 'wysiwyg',
	            'options' => array(
	                'media_buttons' => false, // hide insert/upload button(s)
	                //'teeny' => true, // output the minimal editor config used in Press This
	            ),
            ),
		),
	);

	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'uc_agent_metaboxes' );


// Initialize the metabox class
if( ! function_exists( 'be_initialize_cmb_meta_boxes' ) ) {
    add_action( 'init', 'be_initialize_cmb_meta_boxes', 9999 );
    function be_initialize_cmb_meta_boxes() {
        if ( !class_exists( 'cmb_Meta_Box' ) ) {
            require_once( 'lib/metabox/init.php' );
        }
    }
}


// Remove the default Book taxonomy metaboxes because we've just added custom ones.
function remove_book_metaboxes() {
	remove_meta_box( 'tagsdiv-book_series', 'ucl_book', 'side' );
	remove_meta_box( 'book_categorydiv', 'ucl_book', 'side' );
}
add_action( 'admin_menu' , 'remove_book_metaboxes' );


// Remove widget areas from the parent theme that we won't be using.
function remove_parent_widget_areas() {

	// Unregister some of the TwentyTen sidebars
	unregister_sidebar( 'sidebar-1' ); // Header Toggle Icons
	unregister_sidebar( 'sidebar-2' ); // Services Text Columns
	unregister_sidebar( 'sidebar-3' ); // Testimonials
}
add_action( 'widgets_init', 'remove_parent_widget_areas', 11 );


// [agents_accepting_submissions] shortcode to display Agent fields when accepting book submissions.
function agents_accepting_submissions_shortcode() {

    $result = '';
    $post_args = array( 'post_type' => 'ucl_agent' );
    $posts_array = get_posts( $post_args );
    
    foreach ($posts_array as $post) {
    
        $post_id = $post->ID;
        $accepting_submissions = get_post_meta(
            $post_id,
            '_uc_agent_accepting_submissions',
            true
        );
        
        if ( $accepting_submissions ) {
        
            $short_name = get_post_meta( $post_id, '_uc_agent_short_name', true );
            $accepting_submissions = get_post_meta( $post_id, '_uc_agent_accepting_submissions', true );
            $submissions_email = get_post_meta( $post_id, '_uc_agent_submissions_email', true );
            $tastes = get_post_meta( $post_id, '_uc_agent_tastes', true );
            $tastes = apply_filters( 'the_content', $tastes );
            
            $result .= "<hr /><h4><strong><a href='{$post->guid}'>{$post->post_title}</a></strong></h4>";
            
            if ( $tastes ) {
			    $result .= "<div class='tastes'><h5>A bit about {$short_name}'s tastes</h5>";
			    $result .= "{$tastes}</div>";
			}
			
			if ( $submissions_email ) {
			    $link_text = 'Submit to ' . $short_name . ' >>';
			    $result .= '<h5>' . get_safe_email( $submissions_email, $link_text ) . '</h5>';
			}
        }
    }
    wp_reset_postdata();
    
    if( ! $result )
        $result = '<hr /><p><strong>No agents are currently accepting submissions.</strong></p>';
    
    return '' . $result . '<hr />';
}
add_shortcode( 'agents_accepting_submissions', 'agents_accepting_submissions_shortcode' );


// Order the list of authors by last name.
function posts_orderby_lastname( $orderby_statement ) {
    $orderby_statement = "RIGHT(post_title, LOCATE(' ', REVERSE(post_title)) - 1) ASC";
    return $orderby_statement;
}

// Order the list of books by title, ignoring "A", "An", and "The".
function posts_orderby_book_title( $orderby_statement ) {
    $orderby_statement = "TRIM(LEADING 'a ' FROM TRIM(LEADING 'an ' FROM "
    	. "TRIM(LEADING 'the ' FROM LOWER(ucl_posts.post_title)))) ASC";
    return $orderby_statement;
}

// Displays the previous and next links at the bottom of the 
// single Author pages.
function author_pagination_links() {
	$args = array(
		'post_type' =>	'ucl_author',
		'orderby'		=>	'title',
		'order'			=>	'ASC',
		'numberposts' => -1,
		'suppress_filters' => false,
	);
	add_filter( 'posts_orderby' , 'posts_orderby_lastname' );
	$posts = get_posts($args);
	remove_filter( 'posts_orderby' , 'posts_orderby_lastname' );

	$id = get_the_ID();
	$i = 0;
	foreach($posts as $p) {
		if($id == $p->ID) break;
		$i++;
	}
	
	$n = count($posts);
	if($i - 1 >= 0) {
		$prev = '<div class="alignleft">'
			. '<a href="' . get_permalink($posts[$i-1]->ID) . '">'
			. $posts[$i-1]->post_title . '</a></div>';
	} else {
		$prev = '<div class="alignleft">'
			. '<a href="' . get_permalink($posts[$n-1]->ID) . '">'
			. $posts[$n-1]->post_title . '</a></div>';
	}
	if($i + 1 < $n) {
		$next = '<div class="alignright">'
			. '<a href="' . get_permalink($posts[$i+1]->ID) . '">'
			. $posts[$i+1]->post_title . '</a></div>';
	} else {
		$next = '<div class="alignright">'
			. '<a href="' . get_permalink($posts[0]->ID) . '">'
			. $posts[0]->post_title . '</a></div>';
	}
	
	echo '<div class="blog-navigation">' . $prev . $next . '</div>';
}

// Displays the previous and next links at the bottom of the single Book pages.
function book_pagination_links() {
	$args = array(
		'post_type' =>	'ucl_book',
		'orderby'		=>	'title',
		'order'			=>	'ASC',
		'numberposts' => -1,
		'suppress_filters' => false,
	);
	add_filter( 'posts_orderby' , 'posts_orderby_book_title' );
	$posts = get_posts($args);
	remove_filter( 'posts_orderby' , 'posts_orderby_book_title' );

	$id = get_the_ID();
	$i = 0;
	foreach($posts as $p) {
		if($id == $p->ID) break;
		$i++;
	}
	
	$n = count($posts);
	if($i - 1 >= 0) {
		$prev = '<div class="alignleft">'
			. '<a href="' . get_permalink($posts[$i-1]->ID) . '">'
			. $posts[$i-1]->post_title . '</a></div>';
	} else {
		$prev = '<div class="alignleft">'
			. '<a href="' . get_permalink($posts[$n-1]->ID) . '">'
			. $posts[$n-1]->post_title . '</a></div>';
	}
	if($i + 1 < $n) {
		$next = '<div class="alignright">'
			. '<a href="' . get_permalink($posts[$i+1]->ID) . '">'
			. $posts[$i+1]->post_title . '</a></div>';
	} else {
		$next = '<div class="alignright">'
			. '<a href="' . get_permalink($posts[0]->ID) . '">'
			. $posts[0]->post_title . '</a></div>';
	}
	
	echo '<div class="blog-navigation">' . $prev . $next . '</div>';
}

// Register a "sidebar" to put a Twitter widget into for the homepage.
function homepage_twitter_area()  {

	$args = array(
		'id'            => 'twitter_area',
		'name'          => __( 'Homepage Twitter Area', 'okay' ),
		'description'   => __( 'The Twitter widget goes here and will be shown on the homepage.',
		                'okay' ),
		'class'         => 'twitter-area',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
		'before_widget' => '',
		'after_widget'  => '',
	);
	register_sidebar( $args );
}
add_action( 'widgets_init', 'homepage_twitter_area' );


/**
 * Adds Latest_Books_Widget widget.
 */
class Latest_Books_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'latest_books', // Base ID
			__('Latest Books', 'okay'), // Name
			array( 'description' => __( 'Displays the lastest book covers.', 'okay' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
			
?>

	<div id="portfolio-sidebar" class="portfolio-sidebar flexslider">
	    <ul class="slides">

	        <?php
                $post_args = array( 'post_type' => 'ucl_book', 'posts_per_page' => 5 );
                $posts_array = get_posts( $post_args );
                foreach ($posts_array as $post) {
                    $cover_image_id = get_post_meta( $post->ID, '_uc_book_cover_image_id', true );
                    $cover_image = wp_get_attachment_image( $cover_image_id, array(200, 300) );
                    if ( $cover_image ) {
            ?>
            
            <li class="flex-active-slide">
	            <a href="<?php echo $post->guid; ?>" title="<?php echo $post->post_title; ?>" class="blog-image">
	                <?php echo $cover_image; ?>
	            </a>
	        </li>

            <?php
                    }
                }
            ?>

         </ul>
	     <ol class="flex-control-nav flex-control-paging">
	        <li><a class="flex-active">1</a></li><li><a>2</a></li>
	        <li><a>3</a></li><li><a>4</a></li><li><a>5</a></li>
	     </ol>
	     <ul class="flex-direction-nav">
	        <li><a class="flex-prev" href="#">Previous</a></li>
	        <li><a class="flex-next" href="#">Next</a></li>
	     </ul>
	</div>
			
<?php
		
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Latest Books', 'okay' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

} // class Latest_Books_Widget


/**
 * Adds Blog_Category_Filter_Widget widget.
 */
class Blog_Category_Filter_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'blog_category_filter', // Base ID
			__('Blog Page Category Filter', 'okay'), // Name
			array( 'description' => __( 'A dropdown menu for filtering by category in the Blog page.', 'okay' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
	
	    $title = apply_filters( 'widget_title', $instance['title'] );
	    $cat_id = get_query_var('cat');
	    $cat_args = array(
	        'show_option_none' => ( $title ? $title : 'Category' ),
            'show_option_all'  => 'All Categories',
            'selected'         => ( $cat_id ? $cat_id : -1 )
	    );
		echo $args['before_widget'];
		wp_dropdown_categories( $cat_args );
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Category', 'okay' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

} // class Latest_Books_Widget


// Register custom widgets.
function uc_register_custom_widgets() {
    register_widget( 'Latest_Books_Widget' );
    register_widget( 'Blog_Category_Filter_Widget' );
}
add_action( 'widgets_init', 'uc_register_custom_widgets' );
