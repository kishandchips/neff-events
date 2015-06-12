<?php

define('THEME_NAME', 'neff-events');

$template_directory = get_template_directory();

$template_directory_uri = get_template_directory_uri();

require( $template_directory . '/inc/default/functions.php' );

require( $template_directory . '/inc/default/hooks.php' );

require( $template_directory . '/inc/default/shortcodes.php' );

// Custom Actions

add_action( 'after_setup_theme', 'custom_setup_theme' );

add_action( 'init', 'custom_init');

add_action( 'wp', 'custom_wp');

add_action( 'widgets_init', 'custom_widgets_init' );

add_action( 'wp_enqueue_scripts', 'custom_scripts', 30);

add_action( 'wp_print_styles', 'custom_styles', 30);

add_action( 'admin_init', 'custom_admin_init' );

add_action( 'pre_get_posts', 'advanced_search_query' );

// Custom Filters

add_filter( 'template_include', 'custom_template_include' );

add_filter('next_post_link', 'post_link_attributes');

add_filter('previous_post_link', 'post_link_attributes');





//Custom shortcodes


function custom_setup_theme() {
	
	add_theme_support( 'automatic-feed-links' );
	
	add_theme_support( 'post-thumbnails' );
	
	add_theme_support( 'html5' );

	add_theme_support('editor_style');

	add_post_type_support('page', 'excerpt');


	register_nav_menus( array(
		'primary' => __( 'Primary', THEME_NAME ),
		'secondary' => __( 'Secondary', THEME_NAME ),
	) );

	add_editor_style('css/editor-style.css');

}

function custom_init(){
	global $template_directory;

	require( $template_directory . '/inc/classes/bfi-thumb.php' );

	require( $template_directory . '/inc/classes/custom-post-type.php' );	

	$events_uri = get_page_uri(get_field('events_page', 'options'));

	// //Events custom post type
	if ($events_uri) {

		$events = new Custom_Post_Type( 'Events', 
			array(
				'rewrite' => array('with_front' => false, 'slug' => $events_uri),
				'capability_type' => 'post',
				'publicly_queryable' => true,
				'has_archive' => true, 
				'hierarchical' => false,
				'menu_position' => null,
				'menu_icon' => 'dashicons-welcome-widgets-menus',
				'supports' => array('title', 'editor', 'thumbnail'),
				'plural' => "Events",				
			)
		);

		$events->register_post_type();

		$events->register_taxonomy("School",
			array(
				'name' => 'event_schools',
				'hierarchical' => true,
				'rewrite' => array( 'with_front' => false, 'slug' => 'event_school' ),
			),
			array(
				'plural' => "Schools"
			)
		);

		$events->register_taxonomy("Categories",
			array(
				'name' => 'event_category',
				'hierarchical' => true,
				'rewrite' => array( 'with_front' => false, 'slug' => 'event_category' ),
			),
			array(
				'plural' => "Categories"
			)
		);	

		$events->register_taxonomy("Regions",
			array(
				'name' => 'event_regions',
				'hierarchical' => true,
				'rewrite' => array( 'with_front' => false, 'slug' => 'event_regions' ),
			),
			array(
				'plural' => "Regions"
			)
		);				

		

	}
}

//if( function_exists('acf_add_options_page') ) acf_add_options_page();

function custom_wp(){
	
}

function custom_admin_init(){
	if ( ! current_user_can( 'edit_posts' ) ){
		wp_redirect( site_url() );
		exit;		
	}
}
function custom_template_include( $template ) {

	$school_page = get_field('schools_page', 'options');
	$school_page_id = $school_page->ID;
	
	if ( is_page($school_page_id)) {
		$template = locate_template( 'archive-schools.php' );
	}
	return $template;
}

function custom_widgets_init() {
	global $template_directory;

	//require( $template_directory . '/inc/widgets/post.php' );
	
	register_sidebar( array(
		'name' => __( 'Default', THEME_NAME ),
		'id' => 'default',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',	
	) );
}

function custom_scripts() {
	global $template_directory_uri, $post;

	wp_enqueue_script('jquery');

	wp_enqueue_script('modernizr', $template_directory_uri.'/js/libs/modernizr.min.js', null, '', true);
	wp_enqueue_script('datepicker', $template_directory_uri.'/js/plugins/jquery.datetimepicker.js', null, '', true);
	wp_enqueue_script('main', $template_directory_uri.'/js/main.js', array('jquery', 'modernizr'), '', true);
}


function custom_styles() {
	global $wp_styles, $template_directory_uri;
	
	wp_enqueue_style( 'style', $template_directory_uri . '/css/style.css' );	
	wp_dequeue_style('gforms_formsmain_css');
}

function advanced_search_query( $query ) {

    if ( isset( $_REQUEST['search'] ) && $_REQUEST['search'] == 'advanced' && !is_admin() && $query->is_search && $query->is_main_query() ) {

        $query->set( 'post_type', 'events' );

        $_region = $_GET['event_regions'] != '' ? $_GET['event_regions'] : '';
        $_fromdate = $_GET['fromdate'] != '' ? $_GET['fromdate'] : '';
        $_todate = $_GET['todate'] != '' ? $_GET['todate'] : '';

	    if( $_region != '' ) {
		    $taxquery = array(
		        array(
		            'taxonomy' => 'event_regions',
		            'field' => 'slug',
		            'terms' => $_region,
		            'operator'=> 'IN'
		        )
		    );
		    $query->set( 'tax_query', $taxquery );
	    }

	    if ( $_fromdate != '' && $_todate !='') {
	    	$fromdate = date( 'Ymd', strtotime($_fromdate) );
	    	$todate = date( 'Ymd', strtotime($_todate) );
		    $metaquery = array(
		        array(
		            'key' => 'event_start_date',
		            'value' => array($fromdate, $todate),
		            'compare' => 'BETWEEN',
		            'type' => 'DATE'
		        )	        
		    );
		    $query->set( 'meta_query', $metaquery );    	
	    }

	    return; // always return
    }
}

// highlight active custom post page in nav
add_filter( 'nav_menu_css_class', 'namespace_menu_classes', 10, 2 );
function namespace_menu_classes( $classes , $item ){
	if ( get_post_type() == 'events' ) {
		// remove unwanted classes if found
		$classes = str_replace( 'current_page_parent', '', $classes );
		// find the url you want and add the class you want

		if ( $item->url == home_url().'/events/' ) {
			$classes = str_replace( 'menu-item', ' current-menu-item', $classes );
		}
	}
	return $classes;
}