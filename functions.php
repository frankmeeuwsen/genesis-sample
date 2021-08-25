<?php
/**
 * Genesis Sample.
 *
 * This file adds functions to the Genesis Sample Theme, added by me.
 *
 * @package Genesis FM Sample
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

// Starts the engine.
require_once get_template_directory() . '/lib/init.php';

// Defines the child theme (do not remove).
define( 'CHILD_THEME_NAME', 'Genesis Sample' );
define( 'CHILD_THEME_URL', 'https://www.studiopress.com/' );
define( 'CHILD_THEME_VERSION', '2.8.7' );

// Sets up the Theme.
require_once get_stylesheet_directory() . '/lib/theme-defaults.php';

add_action( 'after_setup_theme', 'genesis_sample_localization_setup' );
/**
 * Sets localization (do not remove).
 *
 * @since 1.0.0
 */
function genesis_sample_localization_setup() {

	load_child_theme_textdomain( 'genesis-sample', get_stylesheet_directory() . '/languages' );

}

// Adds helper functions.
require_once get_stylesheet_directory() . '/lib/helper-functions.php';

// Adds image upload and color select to Customizer.
require_once get_stylesheet_directory() . '/lib/customize.php';

// Includes Customizer CSS.
require_once get_stylesheet_directory() . '/lib/output.php';

// Adds WooCommerce support.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php';

// Adds the required WooCommerce styles and Customizer CSS.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php';

// Adds the Genesis Connect WooCommerce notice.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php';

add_action( 'after_setup_theme', 'genesis_child_gutenberg_support' );
/**
 * Adds Gutenberg opt-in features and styling.
 *
 * @since 2.7.0
 */
function genesis_child_gutenberg_support() { // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- using same in all child themes to allow action to be unhooked.
	require_once get_stylesheet_directory() . '/lib/gutenberg/init.php';
}

add_action( 'wp_enqueue_scripts', 'genesis_sample_enqueue_scripts_styles' );
/**
 * Enqueues scripts and styles.
 *
 * @since 1.0.0
 */
function genesis_sample_enqueue_scripts_styles() {

	wp_enqueue_style(
		'genesis-sample-fonts',
		'//fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,600,700',
		array(),
		CHILD_THEME_VERSION
	);

	wp_enqueue_style( 'dashicons' );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script(
		'genesis-sample-responsive-menu',
		get_stylesheet_directory_uri() . "/js/responsive-menus{$suffix}.js",
		array( 'jquery' ),
		CHILD_THEME_VERSION,
		true
	);

	wp_localize_script(
		'genesis-sample-responsive-menu',
		'genesis_responsive_menu',
		genesis_sample_responsive_menu_settings()
	);

	wp_enqueue_script(
		'genesis-sample',
		get_stylesheet_directory_uri() . '/js/genesis-sample.js',
		array( 'jquery' ),
		CHILD_THEME_VERSION,
		true
	);

}

/**
 * Defines responsive menu settings.
 *
 * @since 2.3.0
 */
function genesis_sample_responsive_menu_settings() {

	$settings = array(
		'mainMenu'         => __( 'Menu', 'genesis-sample' ),
		'menuIconClass'    => 'dashicons-before dashicons-menu',
		'subMenu'          => __( 'Submenu', 'genesis-sample' ),
		'subMenuIconClass' => 'dashicons-before dashicons-arrow-down-alt2',
		'menuClasses'      => array(
			'combine' => array(
				'.nav-primary',
			),
			'others'  => array(),
		),
	);

	return $settings;

}

// Adds support for HTML5 markup structure.
add_theme_support( 'html5', genesis_get_config( 'html5' ) );

// Adds support for accessibility.
add_theme_support( 'genesis-accessibility', genesis_get_config( 'accessibility' ) );

// Adds viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Adds custom logo in Customizer > Site Identity.
add_theme_support( 'custom-logo', genesis_get_config( 'custom-logo' ) );

// Renames primary and secondary navigation menus.
add_theme_support( 'genesis-menus', genesis_get_config( 'menus' ) );

// Adds image sizes.
add_image_size( 'sidebar-featured', 75, 75, true );

// Adds support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Adds support for 3-column footer widgets.
add_theme_support( 'genesis-footer-widgets', 3);

// Removes header right widget area.
unregister_sidebar( 'header-right' );

// Removes secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Removes site layouts.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Removes output of primary navigation right extras.
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

add_action( 'genesis_theme_settings_metaboxes', 'genesis_sample_remove_metaboxes' );
/**
 * Removes output of unused admin settings metaboxes.
 *
 * @since 2.6.0
 *
 * @param string $_genesis_admin_settings The admin screen to remove meta boxes from.
 */
function genesis_sample_remove_metaboxes( $_genesis_admin_settings ) {

	remove_meta_box( 'genesis-theme-settings-header', $_genesis_admin_settings, 'main' );
	remove_meta_box( 'genesis-theme-settings-nav', $_genesis_admin_settings, 'main' );

}

add_filter( 'genesis_customizer_theme_settings_config', 'genesis_sample_remove_customizer_settings' );
/**
 * Removes output of header and front page breadcrumb settings in the Customizer.
 *
 * @since 2.6.0
 *
 * @param array $config Original Customizer items.
 * @return array Filtered Customizer items.
 */
function genesis_sample_remove_customizer_settings( $config ) {

	unset( $config['genesis']['sections']['genesis_header'] );
	unset( $config['genesis']['sections']['genesis_breadcrumbs']['controls']['breadcrumb_front_page'] );
	return $config;

}

// Displays custom logo.
add_action( 'genesis_site_title', 'the_custom_logo', 0 );

// Repositions primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

// Repositions the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 10 );

add_filter( 'wp_nav_menu_args', 'genesis_sample_secondary_menu_args' );
/**
 * Reduces secondary navigation menu to one level depth.
 *
 * @since 2.2.3
 *
 * @param array $args Original menu options.
 * @return array Menu options with depth set to 1.
 */
function genesis_sample_secondary_menu_args( $args ) {

	if ( 'secondary' !== $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;
	return $args;

}

add_filter( 'genesis_author_box_gravatar_size', 'genesis_sample_author_box_gravatar' );
/**
 * Modifies size of the Gravatar in the author box.
 *
 * @since 2.2.3
 *
 * @param int $size Original icon size.
 * @return int Modified icon size.
 */
function genesis_sample_author_box_gravatar( $size ) {

	return 90;

}

add_filter( 'genesis_comment_list_args', 'genesis_sample_comments_gravatar' );
/**
 * Modifies size of the Gravatar in the entry comments.
 *
 * @since 2.2.3
 *
 * @param array $args Gravatar settings.
 * @return array Gravatar settings with modified size.
 */
function genesis_sample_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;
	return $args;

}

// OWNCODE

add_filter( 'wp_nav_menu_items', 'custom_menu_extras', 10, 2 );
/**
 * Filter menu items, appending a a search icon at the end.
 *
 * @param string   $menu HTML string of list items.
 * @param stdClass $args Menu arguments.
 *
 * @return string Amended HTML string of list items.
 */
function custom_menu_extras( $menu, $args ) {

	if ( 'primary' !== $args->theme_location ) {
		return $menu;
	}

	$menu .= '<li class="menu-item">' . get_search_form( false ) . '</li>';

	return $menu;

}

add_filter( 'genesis_markup_search-form-submit_open', 'custom_search_form_submit' );
/**
 * Change Search Form submit button markup.
 *
 * @return string Modified HTML for search forms' submit button.
 */
function custom_search_form_submit() {

	$search_button_text = apply_filters( 'genesis_search_button_text', esc_attr__( 'Search', 'genesis' ) );

	$searchicon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="search-icon"><path d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path></svg>';

	return sprintf( '<button type="submit" class="search-form-submit" aria-label="Search">%s<span class="screen-reader-text">%s</span></button>', $searchicon, $search_button_text );

}

//Change search form text

function custom_search_button_text( $text ) {
	return ( 'Vind je favoriete artikel');
	}
	add_filter( 'genesis_search_text', 'custom_search_button_text' );

// Add logo to site title

add_action( 'genesis_header', 'custom_site_image', 5 );
/**
 * Output image before site title.
 *
 * Checks to see if a header image exists. If so, output that in an `img` tag. If not, get
 * the Gravatar associated with the site administrator's email (under Settings > General).
 *
 * @see get_header_image()	Retrieve header image for custom header.
 * @see get_avatar() 		Retrieve the avatar `<img>` tag for a user.
 *
 * @return string 		HTML for site logo/image.
 */
function custom_site_image() {
 $header_image = get_header_image() ? '<img alt="" src="' . get_header_image() . '" />' : '<img alt="" src="/wp-content/uploads/dtd-logo.png" />';
 printf( '<a href="/"><div class="site-image">%s</div></a>', $header_image );
}

// Remove permalink onder post kind articles zonder titel
remove_action( 'genesis_entry_content', 'genesis_do_post_permalink', 14 );

// Microformats toevoegen
add_action( 'wp_head', 'microformats_header' );
// add_action( 'genesis_comments', 'display_webmention_likes', 1 ); 

function microformats_header() {
	?>
<link rel="profile" href="http://microformats.org/profile/specs" />
<link rel="profile" href="http://microformats.org/profile/hatom" />
<?php
}

add_filter( 'genesis_attr_entry-title', 'entry_title' );
// add_filter( 'genesis_attr_entry-title-link', 'entry_title_link' );
add_filter( 'genesis_attr_entry-content', 'entry_content' );
add_filter( 'genesis_attr_comment-content', 'comment_content' );
add_filter( 'genesis_attr_comment-author', 'comment_entry_author' );
add_filter( 'genesis_attr_entry-author', 'entry_author' );
add_filter( 'genesis_attr_entry-time', 'time_stamps' );
add_filter( 'genesis_attr_comment-time', 'time_stamps' );
add_filter( 'author-box', 'author_description' );
add_filter( 'genesis_attr_author-archive-description', 'author_archive_description' );
add_filter( 'post_class', 'post_content', 10, 3 );
add_filter( 'genesis_post_categories_shortcode', 'category_shortcode_class' ); 
add_filter( 'genesis_post_title_output', 'singular_entry_title_link', 10, 3 );


function entry_title( $attributes ) {
		$attributes['class'] .= ' p-entry-title p-name';
		$attributes['id'] .= get_the_ID();
		return $attributes;
	}


function entry_content( $attributes ) {	
	$attributes['class'] .= ' e-entry-content e-content';
	return $attributes;
	}

function entry_author( $attributes ){
	$attributes['class'] .= ' p-author h-card'; 
	return $attributes;
	}	


function comment_content($attributes) {
	$attributes['class'] .= 'comment-content p-summary p-name'; 
	return $attributes;
	}
	
function comment_entry_author($attributes) {
	$attributes['class'] .= 'comment-author p-author vcard hcard h-card'; 
	return $attributes;
	}
function time_stamps( $attributes ) {
	$attributes['class'] .= ' dt-updated dt-published';
	return $attributes;
	}	
function author_description( $attributes ) {
	$attributes['class'] .= ' p-note';
	return $attributes;
	}
	
function author_archive_description( $attributes ) {
	$attributes['class'] .= ' vcard h-card';
	return $attributes;
	}

function post_content( $classes, $class, $post_id ) {
	$classes[] .= 'h-entry';
	return $classes;
}

function category_shortcode_class( $output ) {
	$output = str_replace( '<a ', '<a class="p-category"', $output );
	return $output;
	}
		
function singular_entry_title_link( $output, $wrap, $title ) {
	if ( ! is_singular() ) {
		return $output;
	}

	$title = genesis_markup(
		[
			'open'    => '<a %s>',
			'close'   => '</a>',
			'content' => $title,
			'context' => 'entry-title-link',
			'atts' => [ 'class' => 'entry-title-link u-url', ],
			'echo'    => false,
		]
	);

	$output = genesis_markup(
		[
			'open'    => "<{$wrap} %s>",
			'close'   => "</{$wrap}>",
			'content' => $title,
			'context' => 'entry-title',
			'params'  => [
				'wrap' => $wrap,
			],
			'echo'    => false,
		]
	);

	return $output;
}

add_shortcode( 'dtd_permalink', 'dtd_permalink' );
// The Permalink Shortcode
function dtd_permalink() {
ob_start();
    the_permalink();
return ob_get_clean();
}

add_action ( 'genesis_before_loop', 'themeprefix_remove_post_info' );
// Remove Post Info, Post Meta from CPT
function themeprefix_remove_post_info() {
	if ('custom_post_type_name' == get_post_type()) {//add in your CPT name
		remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
	}
}

function disable_floc($headers){
	$headers['Permissions-Policy'] = 'interest-cohort=()';
	return $headers;
}
add_filter('wp_headers','disable_floc');

add_shortcode( 'my_permalink', 'my_permalink' );
// The Permalink Shortcode
function my_permalink() {
ob_start();
    the_permalink();
return ob_get_clean();
}

add_filter( 'the_excerpt_rss', 'my_excerpt_rss' );
function my_excerpt_rss( $content ) {
	global $post;

	if ( has_category( 'rss-club', $post->ID ) ) {
		// Excerpts usually don't contain HTML. Leave out the link.
		// $content = 'Dit bericht is alleen voor abonnees. ' . $content;

		// However, you probably could get away with it, like so:
		$content = '<p>' . $content . '</p><p>Dit is een geheim bericht voor iedereen. RSS Only. Niet strikt geheim, maar niet direct publiek zichtbaar. Alle vormen van reacties en links zijn welkom. <a href="' . get_permalink( get_page_by_path( 'rss-club' ) ) . '">Lees alles over de RSS Club.</a></p>';
	}

	return $content;
}

add_filter( 'the_content_feed', 'my_content_feed' );
function my_content_feed( $content ) {
	global $post;

	if ( has_category( 'rss-club', $post->ID ) ) {
		$content = $content.'
		<aside class="notice">
      <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 24 24" width="16" height="16" style="height: 1.2em; width: 1.2em; vertical-align: text-bottom">
        <path fill="currentColor" d="M 4 4.44 v 2.83 c 7.03 0 12.73 5.7 12.73 12.73 h 2.83 c 0 -8.59 -6.97 -15.56 -15.56 -15.56 Z m 0 5.66 v 2.83 c 3.9 0 7.07 3.17 7.07 7.07 h 2.83 c 0 -5.47 -4.43 -9.9 -9.9 -9.9 Z M 6.18 15.64 A 2.18 2.18 0 0 1 6.18 20 A 2.18 2.18 0 0 1 6.18 15.64" />
      </svg><br />
      <tt>Dit is een geheim bericht voor iedereen. RSS Only. Niet strikt geheim, maar niet direct publiek zichtbaar. Alle vormen van reacties en links zijn welkom. <br />
      <a href="' . get_permalink( get_page_by_path( 'rss-club' ) ) . '">Lees alles over de RSS Club.</a>.<br />
      </tt><br />
    </aside>';
	}

	return $content;
}

add_filter( 'simple_social_default_profiles', 'custom_reorder_simple_icons' );

function custom_reorder_simple_icons( $icons ) {

	// Set your new order here
	$new_icon_order = array(
		'rss'         => '',
		'linkedin'    => '',
		'medium'      => '',
		'twitter'     => '',
		'github'      => '',
		'instagram'   => '',
		'email'       => '',
		'phone'       => '',
		'youtube'     => '',
		// 'behance'     => '',
		// 'bloglovin'   => '',
		// 'dribbble'    => '',
		// 'facebook'    => '',
		// 'flickr'      => '',
		// 'gplus'       => '',
		// 'periscope'   => '',
		// 'pinterest'   => '',
		// 'snapchat'    => '',
		// 'stumbleupon' => '',
		// 'tumblr'      => '',
		// 'vimeo'       => '',
		// 'xing'        => '',
	);


	foreach( $new_icon_order as $icon => $icon_info ) {
		$new_icon_order[ $icon ] = $icons[ $icon ];
	}

	return $new_icon_order;
}

add_filter( 'simple_social_icon_html', 'custom_social_icon_html' );
function custom_social_icon_html( $html ) {
	return str_replace( '<a', '<a rel="me"', $html );
}

add_shortcode( 'blogroll_links', function () {
	$out = wp_list_bookmarks('title_li=');
	return $out;
} );

// Add Shortcode
// add_shortcode( 'get_current_author_avatar', function () {
//      global $post;
//     $post_author = $post->post_author;
//     return get_avatar($post_author, '32');

// });


add_filter( 'genesis_post_info', 'cd_post_info_filter' );
function cd_post_info_filter( $post_info) {

	// get author details
	$entry_author = get_avatar( get_the_author_meta( 'email' ), 32, null, null, array('class' => array('u-photo'),'extra_attr'=>'style="display:none"'));
	$author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );
	// $post_kind = get_post_kind_string();
	// build updated post_info
	$post_info = '[post_date] door ';
	$post_info .= sprintf( '<span class="author-avatar"><a href="%s">%s</a></span>', $author_link, $entry_author );
	$post_info .= '[post_author_posts_link] [post_comments] ';
        if(  has_post_kind('note')){
			$post_info .= sprintf( '<span class="permalink"><a href="%s">§</a></span> ', get_permalink() );
		}
	$post_info .= '[post_edit]';
		if(current_user_can( 'edit_posts' ) && get_post_status($ID) !=='private'){
			$post_info .= '  
				<form action="'. esc_url( admin_url("admin-post.php") ).'" method="post">
				<input type="hidden" name="action" value="add_foobar">
				<input type="hidden" name="post" value="' . get_the_ID() .'">
				<input type="submit" value="private">'.
				wp_nonce_field( "add_foobar", "foobar_nonce" ). 
				'</form>';
		}

	return $post_info;

}


add_action( 'admin_post_add_foobar', 'public_to_private' );
// add_action( 'admin_post_nopriv_add_foobar', 'public_to_private' );

function public_to_private(){
if ( ! isset( $_POST['foobar_nonce'] ) 
    || ! wp_verify_nonce( $_POST['foobar_nonce'], 'add_foobar' ) 
) {
   print 'Sorry, your nonce did not verify.';
   exit;
} else {
	// var_dump($_POST);
	wp_update_post( array( 'ID' =>  $_POST['post'], 'post_status' => 'private' ) );
	if ( wp_get_referer() ) {
    wp_safe_redirect( wp_get_referer().'#'.$_POST['post']);
} else {
    wp_safe_redirect( get_home_url() );
}
	}
}

//* Display author box on single posts
// add_filter( 'get_the_author_genesis_author_box_single', '__return_true' );

add_action( 'genesis_entry_content', 'custom_single_post_nav', 12 );
function custom_single_post_nav() {

	if ( ! is_singular( 'post' ) )
		return;

	echo '<div class="pagination-previous alignleft">';
	previous_post_link('%link', '&#x000AB; %title', FALSE);
	echo '</div>';

	echo '<div class="pagination-next alignright">';
	next_post_link('%link', '%title &#x000BB;', FALSE);
	echo '</div>';

}
// Speciale css voor notitie
// add_filter('post_class', 'add_post_class');
function add_post_class($classes) {
    $additional = 'dtd-note';
    foreach ($classes as $class) {
        if( $class == 'kind-note'){
            array_push($classes , $additional);
            break;
        }
    }
    return $classes;
}



// add_action( 'pre_get_posts', 'custom_query_vars',20);
function custom_query_vars( $query ) {
	if ( !is_admin() && $query->is_main_query() && is_tag('open') ) {
		$query->set( 'post_type', array( 
			'post',
			'newsletterglue') );
	  	return $query;
	}
	// var_dump($query);
	// wp_reset_postdata();
}



// add_action('save_post','add_open_newsletter_taxonomy',10,3);
 function add_open_newsletter_taxonomy($post_id, $post, $update){
	if ( 'newsletterglue' == $post->post_type ){
	$term = get_term_by( 'term_id', 114);
    wp_set_post_terms( $post_id, array($term->term_id), 'post_tag', true );
	}   
 }
