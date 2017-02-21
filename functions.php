<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'minimum', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'minimum' ) );

//* Add Image upload and Color select to WordPress Theme Customizer
require_once( get_stylesheet_directory() . '/lib/customize.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Minimum Pro Theme', 'minimum' ) );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/minimum/' );
define( 'CHILD_THEME_VERSION', '3.2.1' );

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Enqueue scripts
add_action( 'wp_enqueue_scripts', 'minimum_enqueue_scripts' );
function minimum_enqueue_scripts() {

	wp_enqueue_script( 'minimum-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );
					
		 		wp_enqueue_script( 'carousel', get_bloginfo( 'stylesheet_directory' ) . '/js/owl.carousel.js', array( 'jquery' ), '1.0.0' );
	wp_enqueue_script('init', get_bloginfo('stylesheet_directory') . '/js/init.js', array('jquery'));
	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'minimum-google-fonts', '//fonts.googleapis.com/css?family=Roboto:300,400|Roboto+Slab:300,400', array(), CHILD_THEME_VERSION );
	

}

//* Add new image sizes
add_image_size( 'portfolio', 540, 340, TRUE );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'width'           => 300,
	'height'          => 60,
	'header-selector' => '.site-title a',
	'header-text'     => false
) );

//* Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'site-tagline',
	'nav',
	'subnav',
	'home-featured',
	'site-inner',
	'footer-widgets',
	'footer'
) );

//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Unregister secondary sidebar 
unregister_sidebar( 'sidebar-alt' );

//* Remove site description
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

//* Rename primary and secondary navigation menus
add_theme_support ( 'genesis-menus' , array ( 'primary' => __( 'After Header Menu', 'minimum' ), 'secondary' => __( 'Footer Menu', 'minimum' ) ) );

//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_after_header', 'genesis_do_nav', 15 );

//* Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 7 );

//* Reduce the secondary navigation menu to one level depth
add_filter( 'wp_nav_menu_args', 'minimum_secondary_menu_args' );
function minimum_secondary_menu_args( $args ){

	if( 'secondary' != $args['theme_location'] )
	return $args;

	$args['depth'] = 1;
	return $args;

}

//* Add the site tagline section
// add_action( 'genesis_after_header', 'minimum_site_tagline' );
function minimum_site_tagline() {

	printf( '<div %s>', genesis_attr( 'site-tagline' ) );
	genesis_structural_wrap( 'site-tagline' );

		printf( '<div %s>', genesis_attr( 'site-tagline-left' ) );
		printf( '<p %s>%s</p>', genesis_attr( 'site-description' ), esc_html( get_bloginfo( 'description' ) ) );
		echo '</div>';
	
		printf( '<div %s>', genesis_attr( 'site-tagline-right' ) );
		genesis_widget_area( 'site-tagline-right' );
		echo '</div>';

	genesis_structural_wrap( 'site-tagline', 'close' );
	echo '</div>';

	

}

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'minimum_author_box_gravatar' );
function minimum_author_box_gravatar( $size ) {

	return 144;

}

//* Modify the size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'minimum_comments_gravatar' );
function minimum_comments_gravatar( $args ) {

	$args['avatar_size'] = 96;
	return $args;

}

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Relocate after entry widget
remove_action( 'genesis_after_entry', 'genesis_after_entry_widget_area' );
add_action( 'genesis_after_entry', 'genesis_after_entry_widget_area', 5 );

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'site-tagline-right',
	'name'        => __( 'Site Tagline Right', 'minimum' ),
	'description' => __( 'This is the site tagline right section.', 'minimum' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-featured-1',
	'name'        => __( 'Home Featured 1', 'minimum' ),
	'description' => __( 'This is the home featured 1 section.', 'minimum' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-featured-2',
	'name'        => __( 'Home Featured 2', 'minimum' ),
	'description' => __( 'This is the home featured 2 section.', 'minimum' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-featured-3',
	'name'        => __( 'Home Featured 3', 'minimum' ),
	'description' => __( 'This is the home featured 3 section.', 'minimum' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-featured-4',
	'name'        => __( 'Home Featured 4', 'minimum' ),
	'description' => __( 'This is the home featured 4 section.', 'minimum' ),
) );
genesis_register_sidebar( array(
	'id'          => 'footer-right',
	'name'        => __( 'Footer right Section', 'minimum' ),
	'description' => __( 'This is the Footer Right section.', 'minimum' ),
) );




add_action( 'genesis_entry_content', 'single_post_featured_image', 1 );
function single_post_featured_image() {
    if ( ! is_singular( 'post' ) )
        return;

    $img = genesis_get_image( array(
        'format' => 'html', 
        'size' => genesis_get_option( 'full' ), 
        'attr' => array( 'class' => 'post-image' ) ) );
    
    echo $img;
}
add_action( 'get_header', 'remove_titles_all_single_pages' );
			function remove_titles_all_single_pages() {
    			if ( is_singular('page') ) {
        			remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
    			}
			}
add_action('genesis_after_header', 'page_header_function');

function page_header_function(){
	if(!is_home() || !is_front_page()):
	$header_title = get_field('header_title');
	$header_background = get_field('header_background');
	$header_content = get_field('header_content');
	if( $header_title || $header_background || $header_content ):

		
	?>

	<header class="entry-header page custom-banner" <?php if($header_background): ?> style="  background-image:url(<?php echo $header_background; ?>); " <?php endif; ?>>
	    <div class="wrap">
	    	<div class="first one-sixth">&nbsp;</div>
	      	<div class="five-sixths header-content-block">
		        <h1 class="entry-title" itemprop="headline">
		          <?php
		   			if($header_title):   
		   				echo $header_title;
		   			else:    
		   				the_title();  
		   			endif; ?>
		        </h1>
	        <p>
	          <?php
	   			if($header_content):   
	    			echo $header_content;
	     		endif; ?>
	        </p>
	      </div>
	    </div>
	</header>
	<?php endif; //$header_title || $header_background || $header_content 
	 endif; //is_home() || !is_front_page()

}


add_action( 'genesis_before_footer', 'page_footer_widgets', 0 );
function page_footer_widgets(){
?>
	<div class="wrap"> 
		<?php 	 $the_query = new WP_Query( 'page_id=6173' ); ?>
		<?php while ($the_query -> have_posts()) : $the_query -> the_post();  ?>
			<?php the_content(); ?>
     	<?php endwhile; ?>
     </div>
     <?php
}



add_action( 'genesis_footer', 'footer_widgets_right', 10 );
function footer_widgets_right(){
?>
	<div class="footer-right"> 
		<?php genesis_widget_area( 'footer-right' ); ?>
     </div>
     <?php
}

