<?php
/* 

Welcome to Your Custom WordPress Theme
This is the core WebDrafter.com Theme file where most of the
main functions & features reside. If you have
any custom functions, it's best to put them
in the functions.php file.

Produced by: WebDrafter.com @webdrafter
URL: http://www.webdrafter.com/

Base on Bones Theme by: Eddie Machado
URL: http://themble.com/

*/

/*********************
LAUNCH BONES
Let's fire off all the functions
and tools. I put it up here so it's
right up top and clean.
*********************/

// we're firing all out initial functions at the start
add_action( 'after_setup_theme', 'webdraftertheme_ahoy', 16 );

function webdraftertheme_ahoy() {

	// launching operation cleanup
	add_action( 'init', 'webdraftertheme_head_cleanup' );
	// remove WP version from RSS
	add_filter( 'the_generator', 'webdraftertheme_rss_version' );
	// remove pesky injected css for recent comments widget
	add_filter( 'wp_head', 'webdraftertheme_remove_wp_widget_recent_comments_style', 1 );
	// clean up comment styles in the head
	add_action( 'wp_head', 'webdraftertheme_remove_recent_comments_style', 1 );
	// clean up gallery output in wp
	add_filter( 'gallery_style', 'webdraftertheme_gallery_style' );

	// enqueue base scripts and styles
	add_action( 'wp_enqueue_scripts', 'webdraftertheme_scripts_and_styles', 999 );
	// ie conditional wrapper

	// launching this stuff after theme setup
	webdraftertheme_theme_support();

	// adding sidebars to Wordpress (these are created in functions.php)
	add_action( 'widgets_init', 'webdraftertheme_register_sidebars' );
	// adding the webdraftertheme search form (created in functions.php)
	add_filter( 'get_search_form', 'webdraftertheme_wpsearch' );

	// cleaning up random code around images
	add_filter( 'the_content', 'webdraftertheme_filter_ptags_on_images' );
	// cleaning up excerpt
	add_filter( 'excerpt_more', 'webdraftertheme_excerpt_more' );

} /* end webdraftertheme ahoy */

/*********************
WP_HEAD GOODNESS
The default wordpress head is
a mess. Let's clean it up by
removing all the junk we don't
need.
*********************/

function webdraftertheme_head_cleanup() {
	// category feeds
	// remove_action( 'wp_head', 'feed_links_extra', 3 );
	// post and comment feeds
	// remove_action( 'wp_head', 'feed_links', 2 );
	// EditURI link
	remove_action( 'wp_head', 'rsd_link' );
	// windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
	// index link
	remove_action( 'wp_head', 'index_rel_link' );
	// previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	// start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	// links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	// WP version
	remove_action( 'wp_head', 'wp_generator' );
	// remove WP version from css
	add_filter( 'style_loader_src', 'webdraftertheme_remove_wp_ver_css_js', 9999 );
	// remove Wp version from scripts
	add_filter( 'script_loader_src', 'webdraftertheme_remove_wp_ver_css_js', 9999 );

} /* end webdraftertheme head cleanup */

// remove WP version from RSS
function webdraftertheme_rss_version() { return ''; }

// remove WP version from scripts
function webdraftertheme_remove_wp_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}

// remove injected CSS for recent comments widget
function webdraftertheme_remove_wp_widget_recent_comments_style() {
	if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
		remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
	}
}

// remove injected CSS from recent comments widget
function webdraftertheme_remove_recent_comments_style() {
	global $wp_widget_factory;
	if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
		remove_action( 'wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style') );
	}
}

// remove injected CSS from gallery
function webdraftertheme_gallery_style($css) {
	return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
}


/*********************
SCRIPTS & ENQUEUEING
*********************/

// loading modernizr and jquery, and reply script
function webdraftertheme_scripts_and_styles() {
	global $wp_styles; // call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way
	if (!is_admin()) {

		// modernizr (without media query polyfill)
		wp_register_script( 'webdraftertheme-modernizr', get_stylesheet_directory_uri() . '/library/js/libs/modernizr.custom.min.js', array(), '2.5.3', false );

		// register main stylesheet
		wp_register_style( 'webdraftertheme-stylesheet', get_stylesheet_directory_uri() . '/library/css/style.css', array(), '', 'all' );

		// ie-only style sheet
		wp_register_style( 'webdraftertheme-ie-only', get_stylesheet_directory_uri() . '/library/css/ie.css', array(), '' );

		// comment reply script for threaded comments
		if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
			wp_enqueue_script( 'comment-reply' );
		}

		//adding scripts file in the footer
		wp_register_script( 'webdraftertheme-js', get_stylesheet_directory_uri() . '/library/js/scripts.js', array( 'jquery' ), '', true );

		// enqueue styles and scripts
		wp_enqueue_script( 'webdraftertheme-modernizr' );
		wp_enqueue_style( 'webdraftertheme-stylesheet' );
		wp_enqueue_style( 'webdraftertheme-ie-only' );

		$wp_styles->add_data( 'webdraftertheme-ie-only', 'conditional', 'lt IE 9' ); // add conditional wrapper around ie stylesheet

		/*
		I recommend using a plugin to call jQuery
		using the google cdn. That way it stays cached
		and your site will load faster.
		*/
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'webdraftertheme-js' );

	}
}

/*********************
THEME SUPPORT
*********************/

// Adding WP 3+ Functions & Theme Support
function webdraftertheme_theme_support() {

	// wp thumbnails (sizes handled in functions.php)
	add_theme_support( 'post-thumbnails' );

	// default thumb size
	set_post_thumbnail_size(125, 125, true);

	// wp custom background (thx to @bransonwerner for update)
	add_theme_support( 'custom-background',
		array(
		'default-image' => '',  // background image default
		'default-color' => '', // background color default (dont add the #)
		'wp-head-callback' => '_custom_background_cb',
		'admin-head-callback' => '',
		'admin-preview-callback' => ''
		)
	);
	
	add_theme_support( 'header_textcolor' , 
		array(
		'default'     => '#000000',
		'transport'   => 'refresh',
		)
	);

	// rss thingy
	add_theme_support('automatic-feed-links');

	// adding post format support
	add_theme_support( 'post-formats',
		array(
			'aside',             // title less blurb
			'gallery',           // gallery of images
			'link',              // quick link to other site
			'image',             // an image
			'quote',             // a quick quote
			'status',            // a Facebook like status update
			'video',             // video
			'audio',             // audio
			'chat'               // chat transcript
		)
	);

	// wp menus
	add_theme_support( 'menus' );

	// registering wp3+ menus
	register_nav_menus(
		array(
			'main-nav' => __( 'The Main Menu', 'webdraftertheme' ),   // main nav in header
			'mobile-menu' => __( 'The Mobile Menu', 'webdraftertheme' ),   // main nav in header
			'footer-links' => __( 'Footer Links', 'webdraftertheme' ), // secondary nav in footer
			'social-media-links' => __( 'Social Media Links', 'webdraftertheme' ) // secondary nav in footer
		)
	);
} /* end webdraftertheme theme support */

/*********************
OPTIONS PAGE
*********************/

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Website General Settings',
		'menu_title'	=> 'Website Defaults',
		'icon_url' 		=> get_template_directory_uri().'/website-defaults.png',
		'menu_slug' 	=> 'website-general-settings',
		'capability'	=> 'edit_posts',
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Company Information',
		'menu_title'	=> 'Company Information', 
		'parent_slug'	=> 'website-general-settings',
	));                                            
		
}

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
	'key' => 'group_555a3c8b1d7c7',
	'title' => 'Company Information',
	'fields' => array (
		array (
			'key' => 'field_556626b0a5c75',
			'label' => 'Contact Information',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'top',
		),
		array (
			'key' => 'field_55662700a5c77',
			'label' => 'Address',
			'name' => 'address',
			'type' => 'wysiwyg',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'tabs' => 'all',
			'toolbar' => 'full',
			'media_upload' => 1,
		),
		array (
			'key' => 'field_555a3cb50b5ab',
			'label' => 'Phone Number',
			'name' => 'phone_number',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_555a41330b5ac',
			'label' => 'Fax Number',
			'name' => 'fax_number',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_555a413c0b5ad',
			'label' => 'Email Address',
			'name' => 'email_address',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_55662878b065f',
			'label' => 'Hours',
			'name' => 'hours',
			'type' => 'wysiwyg',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'tabs' => 'all',
			'toolbar' => 'full',
			'media_upload' => 1,
		),
		array (
			'key' => 'field_556626d4a5c76',
			'label' => 'Theme Setup',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'top',
		),
		array (
			'key' => 'field_555a415db4277',
			'label' => 'Logo',
			'name' => 'logo',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'full',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array (
			'key' => 'field_556628adb0660',
			'label' => 'Header Slogan',
			'name' => 'header_slogan',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_5566279fb065e',
			'label' => 'Footer Height',
			'name' => 'default_footer_height',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'acf-options-company-information',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
));

endif;

/*********************
MENUS & NAVIGATION
*********************/

// the main menu
function webdraftertheme_main_nav() {
	// display the wp3 menu if available
	wp_nav_menu(array(
		'container' => false,                           // remove nav container
		'container_class' => 'clearfix',           		// class of container (should you choose to use it)
		'menu' => __( 'The Main Menu', 'webdraftertheme' ),  // nav name
		'menu_class' => 'nav main-menu clearfix',         // adding custom nav class
		'theme_location' => 'main-nav',                 // where it's located in the theme
		'before' => '',                                 // before the menu
		'after' => '',                                  // after the menu
		'link_before' => '',                            // before each link
		'link_after' => '',                             // after each link
		'depth' => 0,                                   // limit the depth of the nav
		'fallback_cb' => 'webdraftertheme_main_nav_fallback'      // fallback function
	));
} /* end webdraftertheme main nav */

// the mobile menu
function webdraftertheme_mobile_nav() {
	// display the wp3 menu if available
	wp_nav_menu(array(
		'container' => false,                           // remove nav container
		'container_class' => 'mobile-menu clearfix',           // class of container (should you choose to use it)
		'menu' => __( 'The Mobile Menu', 'webdraftertheme' ),  // nav name
		'menu_class' => 'nav clearfix mobile-menu-toggle',         // adding custom nav class
		'theme_location' => 'mobile-menu',                 // where it's located in the theme
		'before' => '',                                 // before the menu
		'after' => '',                                  // after the menu
		'link_before' => '',                            // before each link
		'link_after' => '',                             // after each link
		'depth' => 0,                                   // limit the depth of the nav
		'fallback_cb' => 'webdraftertheme_mobile_nav_fallback'      // fallback function
	));
} /* end webdraftertheme main nav */

// the footer menu (should you choose to use one)
function webdraftertheme_footer_links() {
	// display the wp3 menu if available
	wp_nav_menu(array(
		'container' => '',                              // remove nav container
		'container_class' => 'footer-links clearfix',   // class of container (should you choose to use it)
		'menu' => __( 'Footer Links', 'webdraftertheme' ),   // nav name
		'menu_class' => 'nav footer-nav clearfix',      // adding custom nav class
		'theme_location' => 'footer-links',             // where it's located in the theme
		'before' => '',                                 // before the menu
		'after' => '',                                  // after the menu
		'link_before' => '',                            // before each link
		'link_after' => '',                             // after each link
		'depth' => 0,                                   // limit the depth of the nav
		'fallback_cb' => 'webdraftertheme_footer_nav_fallback'      // fallback function
	));
} /* end webdraftertheme footer link */

// the footer menu (should you choose to use one)
function webdraftertheme_social_media_links() {
	// display the wp3 menu if available
	wp_nav_menu(array(
	'container'       => false,
	'echo'            => false,
	'menu' => __( 'Social Media Links', 'webdraftertheme' ),   // nav name
	'theme_location' => 'social-media-links',             // where it's located in the theme
	'depth' => 0,
	'items_wrap'      => '%3$s' ,                                  // limit the depth of the nav
	));
} /* end webdraftertheme footer link */

// this is the fallback for header menu
function webdraftertheme_main_nav_fallback() {
	wp_page_menu( array(
		'show_home' => true,
		'container_class' => 'clearfix',           		// class of container (should you choose to use it)
		'menu_class' => 'nav main-menu clearfix',      // adding custom nav class
		'include'     => '',
		'exclude'     => '',
		'echo'        => true,
		'link_before' => '',                            // before each link
		'link_after' => ''                             // after each link
	) );
}

// this is the fallback for header menu
function webdraftertheme_mobile_nav_fallback() {
	wp_page_menu( array(
		'show_home' => true,
		'container_class' => 'mobile-menu clearfix',           // class of container (should you choose to use it)
		'menu_class' => 'nav clearfix mobile-menu-toggle',      // adding custom nav class
		'include'     => '',
		'exclude'     => '',
		'echo'        => true,
		'link_before' => '',                            // before each link
		'link_after' => ''                             // after each link
	) );
}

// this is the fallback for header menu
function webdraftertheme_footer_nav_fallback() {
	wp_page_menu( array(
		'show_home' => true,
		'container_class' => 'clearfix',   // class of container (should you choose to use it)
		'menu_class' => 'nav clearfix footer-links',      // adding custom nav class
		'include'     => '',
		'exclude'     => '',
		'echo'        => true,
		'link_before' => '',                            // before each link
		'link_after' => ''                             // after each link
	) );
}

/*********************
RELATED POSTS FUNCTION
*********************/

// Related Posts Function (call using webdraftertheme_related_posts(); )
function webdraftertheme_related_posts() {
	echo '<ul id="webdraftertheme-related-posts">';
	global $post;
	$tags = wp_get_post_tags( $post->ID );
	if($tags) {
		foreach( $tags as $tag ) { 
			$tag_arr .= $tag->slug . ',';
		}
		$args = array(
			'tag' => $tag_arr,
			'numberposts' => 5, /* you can change this to show more */
			'post__not_in' => array($post->ID)
		);
		$related_posts = get_posts( $args );
		if($related_posts) {
			foreach ( $related_posts as $post ) : setup_postdata( $post ); ?>
				<li class="related_post"><a class="entry-unrelated" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
			<?php endforeach; }
		else { ?>
			<?php echo '<li class="no_related_post">' . __( 'No Related Posts Yet!', 'webdraftertheme' ) . '</li>'; ?>
		<?php }
	}
	wp_reset_query();
	echo '</ul>';
} /* end webdraftertheme related posts function */

/*********************
PAGE NAVI
*********************/

// Numeric Page Navi (built into the theme by default)
function webdraftertheme_page_navi() {
	global $wp_query;
	$bignum = 999999999;
	if ( $wp_query->max_num_pages <= 1 )
		return;
	
	echo '<nav class="pagination">';
	
		echo paginate_links( array(
			'base' 			=> str_replace( $bignum, '%#%', esc_url( get_pagenum_link($bignum) ) ),
			'format' 		=> '',
			'current' 		=> max( 1, get_query_var('paged') ),
			'total' 		=> $wp_query->max_num_pages,
			'prev_text' 	=> '&larr;',
			'next_text' 	=> '&rarr;',
			'type'			=> 'list',
			'end_size'		=> 3,
			'mid_size'		=> 3
		) );
	
	echo '</nav>';
} /* end page navi */

/*********************
RANDOM CLEANUP ITEMS
*********************/

// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function webdraftertheme_filter_ptags_on_images($content){
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

// This removes the annoying […] to a Read More link
function webdraftertheme_excerpt_more($more) {
	global $post;
	// edit here if you like
	return '...  <a class="excerpt-read-more" href="'. get_permalink($post->ID) . '" title="'. __( 'Read', 'webdraftertheme' ) . get_the_title($post->ID).'">'. __( 'Read more &raquo;', 'webdraftertheme' ) .'</a>';
}

/*
 * This is a modified the_author_posts_link() which just returns the link.
 *
 * This is necessary to allow usage of the usual l10n process with printf().
 */
function webdraftertheme_get_the_author_posts_link() {
	global $authordata;
	if ( !is_object( $authordata ) )
		return false;
	$link = sprintf(
		'<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
		get_author_posts_url( $authordata->ID, $authordata->user_nicename ),
		esc_attr( sprintf( __( 'Posts by %s' ), get_the_author() ) ), // No further l10n needed, core will take care of this one
		get_the_author()
	);
	return $link;
}


/*********************
REQUIRE AND RECOMMENDED PLUGINS
*********************/

require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function my_theme_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(

        // This is an example of how to include a plugin from the WordPress Plugin Repository.
        array(
            'name'      => 'WP Super Cache',
            'slug'      => 'wp-super-cache',
            'required'  => true,
        ),
        array(
            'name'      => 'Social Media Widget',
            'slug'      => 'social-media-widget',
            'required'  => false,
        ),
        array(
            'name'      => 'All in One SEO Pack',
            'slug'      => 'all-in-one-seo-pack',
            'required'  => false,
        ),
        array(
            'name'      => 'MainWP Child',
            'slug'      => 'mainwp-child',
            'required'  => true,
        ),
        array(
            'name'      => 'Search and Replace',
            'slug'      => 'search-and-replace',
            'required'  => false,
        ),
        array(
            'name'      => 'Redirection',
            'slug'      => 'redirection',
            'required'  => false,
        ),
        array(
            'name'      => 'Bulk Page Creator',
            'slug'      => 'bulk-page-creator',
            'required'  => false,
        ),		
        array(
            'name'               => 'Advanced Custom Fields Pro', // The plugin name.
            'slug'               => 'advanced-custom-fields-pro', // The plugin slug (typically the folder name).
            'source'             => get_stylesheet_directory() . '/library/plugins/advanced-custom-fields-pro.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'external_url'       => 'http://www.advancedcustomfields.com/pro/', // If set, overrides default API URL and points to an external URL.
        ),
        array( 
            'name'               => 'LayerSlider WP', // The plugin name.
            'slug'               => 'LayerSlider', // The plugin slug (typically the folder name).
            'source'             => get_stylesheet_directory() . '/library/plugins/layersliderwp-5.4.0.installable.zip', // The plugin source.
            'required'           => false, // If false, the plugin is only 'recommended' instead of required.
            'external_url'       => 'http://codecanyon.net/item/layerslider-responsive-wordpress-slider-plugin-/1362246', // If set, overrides default API URL and points to an external URL.
        ),
        array(
            'name'               => 'GravityForms', // The plugin name.
            'slug'               => 'gravityforms', // The plugin slug (typically the folder name).
            'source'             => get_stylesheet_directory() . '/library/plugins/gravityforms.zip', // The plugin source.
            'required'           => false, // If false, the plugin is only 'recommended' instead of required.
            'external_url'       => 'http://www.gravityforms.com/', // If set, overrides default API URL and points to an external URL. 
        ),

    );

    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => true,                   // Automatically activate plugins after installation or not.
        'message'      => '
		<ul>
			<li>Gravity Forms: 34235a3e7fdd9e0f68d24a23e79a386b</li>
			<li>Public Key: 6LdWsdISAAAAAN9ZNZd36dcDoZHpZ7M-Nkc8cTdZ</li>
			<li>Private Key: 6LdWsdISAAAAACYBY-SWZysg6vBFy_Nc8Z0XxhnZ</li>
			<li>LayerSlider: 7a2a418c-ef9a-4ffb-94df-fbf4dcd56e0c</li>
			<li>Advanced Custom Fields Pro: b3JkZXJfaWQ9NDQwODd8dHlwZT1kZXZlbG9wZXJ8ZGF0ZT0yMDE0LTExLTExIDE3OjA2OjUy</li>
		</ul>
		',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => __( 'Install Required Plugins', 'tgmpa' ),
            'menu_title'                      => __( 'Install Plugins', 'tgmpa' ),
            'installing'                      => __( 'Installing Plugin: %s', 'tgmpa' ), // %s = plugin name.
            'oops'                            => __( 'Something went wrong with the plugin API.', 'tgmpa' ),
            'notice_can_install_required'     => _n_noop( 'WebDrafter.com requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'WebDrafter.com recommends the following plugins: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins' ),
            'return'                          => __( 'Return to Required Plugins Installer', 'tgmpa' ),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'tgmpa' ),
            'complete'                        => __( 'All plugins installed and activated successfully. %s', 'tgmpa' ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );

    tgmpa( $plugins, $config );

}

/*********************
LESS AUTO COMPILER
*********************/

function autoCompileLess() {

    // include lessc.inc
    require_once( get_template_directory().'/library/less/lessc.inc.php' );

    // input and output location
    $inputFile = get_template_directory().'/library/less/style.less';
    $outputFile = get_template_directory().'/library/css/style.css';

    // load the cache
    $cacheFile = $inputFile.".cache";

    if (file_exists($cacheFile)) {
        $cache = unserialize(file_get_contents($cacheFile));
    } else {
        $cache = $inputFile;
    }

    $less = new lessc;
    // create a new cache object, and compile
    $newCache = $less->cachedCompile($cache);

    // output a LESS file, and cache file only if it has been modified since last compile
    if (!is_array($cache) || $newCache["updated"] > $cache["updated"]) {
        file_put_contents($cacheFile, serialize($newCache));
        file_put_contents($outputFile, $newCache['compiled']);
    }
}
function autoCompileLess2() {

    // include lessc.inc
    require_once( get_template_directory().'/library/less/lessc.inc.php' );

    // input and output location
    $inputFile = get_template_directory().'/library/less/ie.less';
    $outputFile = get_template_directory().'/library/css/ie.css';

    // load the cache
    $cacheFile = $inputFile.".cache";

    if (file_exists($cacheFile)) {
        $cache = unserialize(file_get_contents($cacheFile));
    } else {
        $cache = $inputFile;
    }

    $less = new lessc;
    // create a new cache object, and compile
    $newCache = $less->cachedCompile($cache);

    // output a LESS file, and cache file only if it has been modified since last compile
    if (!is_array($cache) || $newCache["updated"] > $cache["updated"]) {
        file_put_contents($cacheFile, serialize($newCache));
        file_put_contents($outputFile, $newCache['compiled']);
    }
}
function autoCompileLess3() {

    // include lessc.inc
    require_once( get_template_directory().'/library/less/lessc.inc.php' );

    // input and output location
    $inputFile = get_template_directory().'/library/less/login.less';
    $outputFile = get_template_directory().'/library/css/login.css';

    // load the cache
    $cacheFile = $inputFile.".cache";

    if (file_exists($cacheFile)) {
        $cache = unserialize(file_get_contents($cacheFile));
    } else {
        $cache = $inputFile;
    }

    $less = new lessc;
    // create a new cache object, and compile
    $newCache = $less->cachedCompile($cache);

    // output a LESS file, and cache file only if it has been modified since last compile
    if (!is_array($cache) || $newCache["updated"] > $cache["updated"]) {
        file_put_contents($cacheFile, serialize($newCache));
        file_put_contents($outputFile, $newCache['compiled']);
    }
}

if(is_user_logged_in()) {
    add_action('init', 'autoCompileLess');
    add_action('init', 'autoCompileLess2');
    add_action('init', 'autoCompileLess3');
}
?>
