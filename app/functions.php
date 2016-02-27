<?php
/**
 * RealTo functions and definitions
 *
 * @package RealTo
 * @since 	RealTo 1.5
 * @author  Waqas Riaz
**/

global $nt_option;
/* Content Width */
if ( ! isset( $content_width ) ) $content_width = 1050; /* pixels */


define('NT_FUNCTIONS', get_template_directory()  . '/inc');
define('NT_INDEX_JS', get_template_directory_uri()  . '/js');
define('NT_INDEX_CSS', get_template_directory_uri()  . '/css');

/*======================================================
=  TinyMac
========================================================*/
if($wp_version < 3.9){
	include_once(NT_FUNCTIONS.'/tinymce/realto-shortcodes_old_versions.php'); // Tinymce for WP less then 3.9 versions
}else{
	include_once(NT_FUNCTIONS.'/tinymce/realto-shortcodes.php'); // Tinymce
}

/* Custom Fields */
include_once( 'admin/acf/acf.php' );
include_once( 'admin/acf/acf-fields.php' );

/* Theme Options */
require_once ( 'admin/index.php' );

add_editor_style('');
require_once(NT_FUNCTIONS.'/register-scripts.php'); // include scripts and styles for the front end.
require_once(NT_FUNCTIONS.'/pagination.php'); // Pagination
require_once(NT_FUNCTIONS.'/realto-nav.php'); // Navigation
include_once(NT_FUNCTIONS.'/shortcodes.php'); // Shortcodes
require_once(NT_FUNCTIONS.'/property-post-type.php'); // Post Type
require_once(NT_FUNCTIONS.'/styling-options.php'); // theme styling options
require_once(NT_FUNCTIONS.'/sidebar.php'); // theme sidebars

include_once(NT_FUNCTIONS.'/class-tgm-plugin-activation.php'); // Plugin Activation Class
include_once(NT_FUNCTIONS.'/register-plugins.php'); // Register Plugins

/* Google Fonts */
include_once(NT_FUNCTIONS.'/google-fonts.php' ); // Load Fonts from Google


/* Register theme custom widgets */
require_once(NT_FUNCTIONS.'/widgets/nt-about-site.php'); // footer about site
require_once(NT_FUNCTIONS.'/widgets/nt-address.php'); // footer address
require_once(NT_FUNCTIONS.'/widgets/nt-property-search.php'); // Property Search
require_once(NT_FUNCTIONS.'/widgets/nt-most-commented.php'); // Property Search


/* --------------------------------------------------------------------------
 * include composer shortcodes
 ---------------------------------------------------------------------------*/
require_once(NT_FUNCTIONS.'/vc_shortcodes/property-big-search.php');
require_once(NT_FUNCTIONS.'/vc_shortcodes/featured-properties.php');
require_once(NT_FUNCTIONS.'/vc_shortcodes/properties-carousel.php');
require_once(NT_FUNCTIONS.'/vc_shortcodes/featured-properties-grid.php');
require_once(NT_FUNCTIONS.'/vc_shortcodes/properties-grid.php');
require_once(NT_FUNCTIONS.'/vc_shortcodes/info_box.php');
require_once(NT_FUNCTIONS.'/vc_shortcodes/info-box-icon.php');
require_once(NT_FUNCTIONS.'/vc_shortcodes/call-to-action.php');
require_once(NT_FUNCTIONS.'/vc_shortcodes/agents.php');
require_once(NT_FUNCTIONS.'/vc_shortcodes/articles_list.php');



/* Include Meta Box Framework */
define( 'RWMB_URL', trailingslashit( get_template_directory_uri() . '/inc/metaboxes' ) );
define( 'RWMB_DIR', trailingslashit( get_template_directory() . '/inc/metaboxes' ) );

require_once RWMB_DIR . 'meta-box.php';
require_once(NT_FUNCTIONS.'/metaboxes.php');

/* --------------------------------------------------------------------------
 * include composer after default init
 ---------------------------------------------------------------------------*/
if (is_plugin_active('js_composer/js_composer.php')) {
	function include_composer() {
		include(NT_FUNCTIONS.'/vc_extend.php');
	}
	add_action('init', 'include_composer', 9999);
}

// Custom template tags for this theme.
require NT_FUNCTIONS. '/template-tags.php';

if ( ! function_exists( 'realto_setup' ) ) :
/**
 * RealTo setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 *
 * @since RealTo 1.0
 */
function realto_setup() {
	/*
	 * Make RealTo available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 *
	 */
	load_theme_textdomain( 'realto', get_template_directory() . '/languages' );

	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Enable support for Post Thumbnails, and declare two sizes.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 672, 372, true );
	add_image_size( 'realto-full-width', 1038, 576, true );
	add_image_size( 'blog-layout-one', 800, 360, true );
	add_image_size( 'blog-layout', 800, 800, true );
	
//	add_image_size( 'property-regular', 800, 454, true );
	add_image_size( 'property-regular', 750, 450, false );
	

	// This theme uses wp_nav_menu() in one locations.
	register_nav_menus( array(
		'primary'   => __( 'Top primary menu', 'realto' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		
	) );

	// This theme allows users to set a custom background.
	add_theme_support( 'custom-background', apply_filters( 'realto_custom_background_args', array(
		'default-color' => 'f5f5f5',
	) ) );

	
}
endif; // realto_setup
add_action( 'after_setup_theme', 'realto_setup' );



if ( ! function_exists( 'realto_list_authors' ) ) :
/**
 * Print a list of all site contributors who published at least one post.
 *
 * @since RealTo 1.0
 *
 * @return void
 */
function realto_list_authors() {
	$contributor_ids = get_users( array(
		'fields'  => 'ID',
		'orderby' => 'post_count',
		'order'   => 'DESC',
		'who'     => 'authors',
	) );

	foreach ( $contributor_ids as $contributor_id ) :
		$post_count = count_user_posts( $contributor_id );

		// Move on if user has not published a post (yet).
		if ( ! $post_count ) {
			continue;
		}
	?>

	<div class="contributor">
		<div class="contributor-info">
			<div class="contributor-avatar"><?php echo get_avatar( $contributor_id, 132 ); ?></div>
			<div class="contributor-summary">
				<h2 class="contributor-name"><?php echo get_the_author_meta( 'display_name', $contributor_id ); ?></h2>
				<p class="contributor-bio">
					<?php echo get_the_author_meta( 'description', $contributor_id ); ?>
				</p>
				<a class="contributor-posts-link" href="<?php echo esc_url( get_author_posts_url( $contributor_id ) ); ?>">
					<?php printf( _n( '%d Article', '%d Articles', $post_count, 'realto' ), $post_count ); ?>
				</a>
			</div><!-- .contributor-summary -->
		</div><!-- .contributor-info -->
	</div><!-- .contributor -->

	<?php
	endforeach;
}
endif;
 

/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since RealTo 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function realto_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'realto' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'realto_wp_title', 10, 2 );


// Get The First Image From a Post
function first_post_image() {
	global $post, $posts;
	$first_img = '';
	ob_start();
	ob_end_clean();
	if( preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches ) ){
		$first_img = $matches[1][0];
		return $first_img;
	}
}


// Excerpt Length
function nt_excerpt_length( $length ) {
	global $nt_option;
	return $nt_option['site_wide_excerpt_length'];
}
add_filter( 'excerpt_length', 'nt_excerpt_length' );


// Excerpt more
function nt_excerpt_more( $more ) {
	return '<p class="italic serif read-more"><a class="more-link" href="'.get_permalink().'">Continue reading <span class="meta-nav">&rarr;</span></a></p>';
}
add_filter( 'excerpt_more', 'nt_excerpt_more' );

/*-----------------------------------------------------------------------------------*/
/* Listing Price */
/*-----------------------------------------------------------------------------------*/

function listing_price() {
	global $post, $nt_option;
	$price_meta = get_post_meta(get_the_ID(), 'nt_listprice', true);
	
	if($price_meta!=""):
		if(get_post_meta(get_the_ID(), 'nt_status', true)=="for-rent"){
			
			$price_meta = number_format_i18n( $price_meta, 0 );
			$price_meta = $nt_option["site_currency"]."".$price_meta."/". __( get_post_meta(get_the_ID(), 'nt_period', true), 'realto' );
			
		}else{
			$price_meta = number_format_i18n( $price_meta, 0 );
			$price_meta = $nt_option["site_currency"]."".$price_meta;
		}
		
		if(get_post_meta(get_the_ID(), 'nt_status', true)!="inquire"):
			if($nt_option["listing_price_prefix"]!=""):
				$prefix = __( $nt_option["listing_price_prefix"], 'realto');
				echo $prefix." ".$price_meta;
			else:
				echo $price_meta;	
			endif;
		endif;
	endif;
	
}

function is_post_type($type){
    global $wp_query;
    if($type == get_post_type($wp_query->post->ID)) return true;
    return false;
}

function nt_property_pic(){ ?>
    <a class="overlay" href="<?php the_permalink();?>" title="<?php the_title();?>">
        <span class="more">
            <i class="fa fa-zoom-in"></i>
        </span>
        <?php
        if(get_post_meta(get_the_ID(), 'nt_status', true)!="inquire"):?>
		
        <?php endif; ?>
        <?php
        if ( has_post_thumbnail() ) {?>
            <?php the_post_thumbnail( 'property-regular' );?>
        <?php
        }else{?>
            <img alt="image" class="media-object" src="http://placehold.it/370x210">
        <?php
        }?>
    </a>
        
<?php    
}

function nt_property_pic_list(){ ?>
	<a class="overlay" href="<?php the_permalink();?>" title="<?php the_title();?>">
		<span class="more"></span>
        <?php
        if(get_post_meta(get_the_ID(), 'nt_status', true)!="inquire"):?>
        	<span class="prop-price-tag"><?php listing_price(); ?></span>
        <?php endif; ?>
		<?php if ( has_post_thumbnail() ) {?>
			<?php the_post_thumbnail( 'property-regular' );?>
		<?php } else { ?>
             <img alt="image" class="media-object" src="http://placehold.it/370x210">
        <?php }?>
	</a>
<?php
}

/* ------ AGENT FUNCTIONS ------ */

if ( ! function_exists( 'nt_add_agent_contact_info' ) ) :
/**
 * Adds user custom fields
 *
 * @since realto 1.0
 */
function nt_add_agent_contact_info( $contactmethods ) {
	$contactmethods['phone_number']	= __( 'Phone', 'realto' );
	$contactmethods['linkedin']		= __( 'LinkedIn', 'realto' );
	$contactmethods['twitter']		= __( 'Twitter', 'realto' );
	$contactmethods['facebook']		= __( 'Facebook', 'realto' );
	$contactmethods['googleplus']	= __( 'Google Plus', 'realto' );
	$contactmethods['instagram']	= __( 'instagram', 'realto' );
	$contactmethods['flickr']		= __( 'Flickr', 'realto' );
	$contactmethods['foursquare']	= __( 'Foursquare', 'realto' );
	$contactmethods['pinterest']	= __( 'Pinterest', 'realto' );
	$contactmethods['skype']		= __( 'Skype', 'realto' );
	$contactmethods['tumblr']		= __( 'Tumblr', 'realto' );
	$contactmethods['vimeo']		= __( 'Vimeo', 'realto' );
	$contactmethods['youtube']		= __( 'Youtube', 'realto' );
	
	return $contactmethods;
}
endif; // add_agent_contact_info
add_filter( 'user_contactmethods', 'nt_add_agent_contact_info', 10, 1 );


/**
 * Adds home icon in menu
 *
 * @since realto 1.0
 */

function nt_home_link($items, $args) {
	
	if (is_front_page())
		$class = 'class="m-manage active"';
	else
		$class = 'class="m-manage"';

		$homeMenuItem =
			'<li ' . $class . '>' .
				$args->before .
					'<a href="' . home_url( '/' ) . '" title="Home">' .
						$args->link_before . '<i class="fa fa-home"></i>' . $args->link_after .
					'</a>' .
				$args->after .
			'</li>';
		$items = $homeMenuItem . $items;
		return $items;
}
add_filter( 'wp_nav_menu_items', 'nt_home_link', 10, 2 );


function nt_post_author() {
  global $wp_query;
  $thePostID = $wp_query->post->post_author;
  return $thePostID;
}

function reato_property_features(){
	global $nt_option;
	
	if($nt_option["sh_beds"]==1 && get_post_meta(get_the_ID(), "nt_bedrooms", true)!=""):?>
    <li class="info-label clearfix">
        <span class="pull-left"><?php echo $nt_option["f_beds"]["of_feature_title"]; ?></span>
        <span class="qty pull-right"><?php echo get_post_meta(get_the_ID(), "nt_bedrooms", true)." ".$nt_option["f_beds"]["of_feature_area"];?></span>
    </li>
    <?php endif;?>
    <?php if($nt_option["sh_baths"]==1 && get_post_meta(get_the_ID(), "nt_bathrooms", true)!=""):?>
    <li class="info-label clearfix">
        <span class="pull-left"><?php echo $nt_option["f_baths"]["of_feature_title"]; ?></span>
        <span class="qty pull-right"><?php echo get_post_meta(get_the_ID(), "nt_bathrooms", true)." ".$nt_option["f_baths"]["of_feature_area"];?></span>
   </li>
   <?php endif;?>
   
   <?php if($nt_option["sh_plotsize"]==1 && get_post_meta(get_the_ID(), "nt_plot_size", true)!=""):?>
    <li class="info-label clearfix">
        <span class="pull-left"><?php echo $nt_option["f_plotsize"]["of_feature_title"]; ?></span>
        <span class="qty pull-right"><?php echo get_post_meta(get_the_ID(), "nt_plot_size", true)." ".$nt_option["f_plotsize"]["of_feature_area"];?></span>
   </li>
   <?php endif;?>
   
   <?php if($nt_option["sh_livingarea"]==1 && get_post_meta(get_the_ID(), "nt_living_area", true)!=""):?>
    <li class="info-label clearfix">
        <span class="pull-left"><?php echo $nt_option["f_livingarea"]["of_feature_title"]; ?></span>
        <span class="qty pull-right"><?php echo get_post_meta(get_the_ID(), "nt_living_area", true)." ".$nt_option["f_livingarea"]["of_feature_area"];?></span>
   </li>
   <?php endif;?>
   
   <?php if($nt_option["sh_terrace"]==1 && get_post_meta(get_the_ID(), "nt_terrace", true)!=""):?>
    <li class="info-label clearfix">
        <span class="pull-left"><?php echo $nt_option["f_terrace"]["of_feature_title"]; ?></span>
        <span class="qty pull-right"><?php echo get_post_meta(get_the_ID(), "nt_terrace", true)." ".$nt_option["f_terrace"]["of_feature_area"];?></span>
   </li>
   <?php endif;?>
   
   <?php if($nt_option["sh_propertytype"]==1):?>
    <li class="info-label clearfix">
        <span class="pull-left"><?php _e("Property Type:", "realto"); ?></span>
        <span class="qty pull-right"><?php propertyltype();?></span>
   </li>
   <?php endif;?>
   <?php if($nt_option["sh_parking"]==1 && get_post_meta(get_the_ID(), "nt_parking", true)!=""):?>
    <li class="info-label clearfix">
        <span class="pull-left"><?php echo $nt_option["f_parking"]; ?></span>
        <span class="qty pull-right"><?php echo get_post_meta(get_the_ID(), "nt_parking", true);?></span>
   </li>
   <?php endif;?>
   
   <?php if($nt_option["sh_heating"]==1 && get_post_meta(get_the_ID(), "nt_heating", true)!=""):?>
        <li class="info-label clearfix">
            <span class="pull-left"><?php echo $nt_option["f_heating"]; ?></span>
            <span class="qty pull-right"><?php echo get_post_meta(get_the_ID(), "nt_heating", true);?></span>
        </li>
    <?php endif; ?>
   <?php /*?><?php if($nt_option["sh_squrefeet"]==1):?>
    <li class="info-label clearfix">
        <span class="pull-left"><?php _e("Square Feet:", "realto"); ?></span>
        <span class="qty pull-right"><?php echo get_post_meta(get_the_ID(), "nt_squarefeet", true);?> <?php echo __('sqft','realto')?></span>
   </li>

   <?php endif;?><?php */?>
   <?php if($nt_option["sh_neighborhood"]==1 && get_post_meta(get_the_ID(), "nt_neighborhood", true)!=""):?>
    <li class="info-label clearfix">
        <span class="pull-left"><?php echo $nt_option["f_neighborhood"]; ?></span>
        <span class="qty pull-right"><?php echo get_post_meta(get_the_ID(), "nt_neighborhood", true);?></span>
   </li>
   <?php endif;?>
   <?php if($nt_option["sh_year"]==1 && get_post_meta(get_the_ID(), "nt_builtin", true)!=""):?>
    <li class="info-label clearfix">
        <span class="pull-left"><?php echo $nt_option["f_builtin"]; ?></span>
        <span class="qty pull-right"><?php echo get_post_meta(get_the_ID(), "nt_builtin", true);?></span>
   </li>
   <?php endif;
}

function realto_property_prop_tags(){
	
	if(get_post_meta(get_the_ID(), "nt_status", true)=='for-sale'): 
		   _e('For Sale', 'realto'); 
	elseif(get_post_meta(get_the_ID(), "nt_status", true)=='sold'):
		  _e('Sold', 'realto');
	elseif(get_post_meta(get_the_ID(), "nt_status", true)=='upcoming'):
		  _e('Upcoming', 'realto');
		  
	elseif(get_post_meta(get_the_ID(), "nt_status", true)=='inquire'):
		  _e('Inquire', 'realto'); 
	else:  
		_e('For Rent', 'realto');
	endif;
}

function realto_property_search_small(){
	global $nt_option;
?>
	<p class="property_seach_title"><?php //_e("Find your new home", "realto");?></p>
                                        
	<?php $purl = get_post_type_archive_link( "property" ); ?>
    
    <form action="<?php echo $purl; ?>" class="row-fluid" method="get">
    
    	<input type="hidden" name="post_type" value="property" />
    
    	<?php if($nt_option["sp_keyword"]=="1"):?>
    	<div class="form-group">
    		<input type="text" class="form-control" name="search_keyword" value="" placeholder="<?php if(isset($nt_option["s_propertykeyword"])){ _e( $nt_option["s_propertykeyword"], 'realto' );} ?>" />
    	</div>
    	<?php endif; ?> 
    
    	<?php if($nt_option["sp_location"]=="1"):?>  
    	<div class="form-group"> 
	        <select class="form-control select" name="locations">
	            <option value=""><?php if(isset($nt_option["s_location"])){ _e( $nt_option["s_location"], 'realto');} ?></option>
	            <?php $locations = get_terms('location');?>
	            <?php foreach($locations as $location): ?>
	            <option value="<?php echo $location->slug; ?>"><?php echo $location->name; ?></option>
	            <?php endforeach; ?>
	        </select>
        </div>
		<?php endif; ?>
   
		<div class="row">
	   
	   		<?php if($nt_option["sp_property_type"]=="1"):?>
	   		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		        <select class="form-control select" name="property_type">
		            <option value=""><?php if(isset($nt_option["s_propertytype"])){ _e($nt_option["s_propertytype"], 'realto' );} ?></option>
		            <?php $property_type = get_terms('property-type');?>
		            <?php foreach($property_type as $p_type): ?>
		            <option value="<?php echo $p_type->slug; ?>"><?php echo $p_type->name; ?></option>
		            <?php endforeach; ?>
		        </select>
	        </div>
	    	<?php endif; ?>

	    	<?php if($nt_option["sp_status"]=="1"):?>
	        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			    <select class="form-control select" name="status">
		            <option value=""><?php if(isset($nt_option["s_status"])){ _e( $nt_option["s_status"], 'realto' ); } ?></option>
		            <option value="for-rent"><?php _e("For Rent","realto"); ?></option>
		            <option value="for-sale"><?php _e("For Sale","realto"); ?></option>
		            <option value="sold"><?php _e("Sold","realto"); ?></option>
		            <option value="upcoming"><?php _e("Upcoming","realto"); ?></option>
		            <option value="inquire"><?php _e("Inquire","realto"); ?></option>
		        </select>
	        </div>
	    	<?php endif; ?>
	    
	    	<?php if($nt_option["sp_beds"]=="1"):?>
	    	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		    	<select class="form-control select" name="beds">
		            <option value=""><?php if(isset($nt_option["s_bed"])){ _e( $nt_option["s_bed"], 'realto');} ?></option>
		            <option value="1">1+ <?php if(isset($nt_option["s_bed"])){ echo $nt_option["s_bed"];} ?></option>
		            <option value="2">2+ <?php if(isset($nt_option["s_bed"])){ echo $nt_option["s_bed"];} ?></option>
		            <option value="3">3+ <?php if(isset($nt_option["s_bed"])){ echo $nt_option["s_bed"];} ?></option>
		            <option value="4">4+ <?php if(isset($nt_option["s_bed"])){ echo $nt_option["s_bed"];} ?></option>
		            <option value="5">5+ <?php if(isset($nt_option["s_bed"])){ echo $nt_option["s_bed"];} ?></option>
		            <option value="6">6+ <?php if(isset($nt_option["s_bed"])){ echo $nt_option["s_bed"];} ?></option>
		            <option value="7">7+ <?php if(isset($nt_option["s_bed"])){ echo $nt_option["s_bed"];} ?></option>
                    <option value="8">8+ <?php if(isset($nt_option["s_bed"])){ echo $nt_option["s_bed"];} ?></option>
                    <option value="9">9+ <?php if(isset($nt_option["s_bed"])){ echo $nt_option["s_bed"];} ?></option>
                    <option value="10">10+ <?php if(isset($nt_option["s_bed"])){ echo $nt_option["s_bed"];} ?></option>
		        </select>	
	    	</div>
	    	<?php endif; ?>
	   
	    	<?php if($nt_option["sp_baths"]=="1"):?>
	    	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		        <select class="form-control select" name="baths">
		            <option value=""><?php if(isset($nt_option["s_bath"])){ _e( $nt_option["s_bath"], 'realto' ); } ?></option>
		            <option value="1">1+ <?php if(isset($nt_option["s_bath"])){ echo $nt_option["s_bath"];} ?></option>
		            <option value="2">2+ <?php if(isset($nt_option["s_bath"])){ echo $nt_option["s_bath"];} ?></option>
		            <option value="3">3+ <?php if(isset($nt_option["s_bath"])){ echo $nt_option["s_bath"];} ?></option>
		            <option value="4">4+ <?php if(isset($nt_option["s_bath"])){ echo $nt_option["s_bath"];} ?></option>
		            <option value="5">5+ <?php if(isset($nt_option["s_bath"])){ echo $nt_option["s_bath"];} ?></option>
		            <option value="6">6+ <?php if(isset($nt_option["s_bath"])){ echo $nt_option["s_bath"];} ?></option>
		            <option value="7">7+ <?php if(isset($nt_option["s_bath"])){ echo $nt_option["s_bath"];} ?></option>
                    <option value="8">8+ <?php if(isset($nt_option["s_bath"])){ echo $nt_option["s_bath"];} ?></option>
                    <option value="9">9+ <?php if(isset($nt_option["s_bath"])){ echo $nt_option["s_bath"];} ?></option>
                    <option value="10">10+ <?php if(isset($nt_option["s_bath"])){ echo $nt_option["s_bath"];} ?></option>
		        </select>
		    </div>
	    	<?php endif; ?>

			<?php if($nt_option["sp_min_price"]=="1"):?>     
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		        <input class="form-control" type="text" name="min-price" value="" placeholder="<?php if(isset($nt_option["s_minprice"])){echo $nt_option["site_currency"]." ". __( $nt_option["s_minprice"], 'realto' );}?>" />
		    </div>
		    <?php endif; ?> 
		   
		    <?php if($nt_option["sp_max_price"]=="1"):?>    
		    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		        <input class="form-control" type="text" name="max-price" value="" placeholder="<?php if(isset($nt_option["s_maxprice"])){echo $nt_option["site_currency"]." ". __( $nt_option["s_maxprice"], 'realto' );}?>" />
		    </div>
		    <?php endif; ?> 		
		
		</div><!-- .row -->
	        
	    <div class="form-group clearfix"> 
	        <input class="btn btn-realto-form btn-form" value="<?php _e("Search", "realto");?>" type="submit" />
	    </div>
    </form>
<?php
}

function realto_property_search_big(){
global $nt_option;
?>	
	<?php $purl = get_post_type_archive_link( "property" ); ?>
    <form action="<?php echo $purl; ?>" method="get">
    	
    	<input type="hidden" name="post_type" value="property" />
		
		<?php if($nt_option["sp_keyword"]=="1"):?> 
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
            	<div class="form-group">
                	<input type="text" class="input-block-level form-control" name="search_keyword" value="" placeholder="<?php if(isset($nt_option["s_propertykeyword"])){ _e( $nt_option["s_propertykeyword"], 'realto' );} ?>" />
                </div>
            </div>
            
            <?php if($nt_option["sp_location"]=="1"):?>
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                <select class="form-control select" name="locations">
                    <option value=""><?php if(isset($nt_option["s_location"])){ _e( $nt_option["s_location"], 'realto' ); } ?></option>
                    <?php $locations = get_terms('location');?>
                    <?php foreach($locations as $location): ?>
                    <option value="<?php echo $location->slug; ?>"><?php echo $location->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>

            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 hidden-sm hidden-xs">
	            <div class="form-group">
	            	<input class="btn btn-form btn-realto-form" value="<?php _e( 'Search', 'realto' ); ?>" type="submit">
	            </div>
            </div>
        
        	<?php endif; ?>
        
       
        
        	<?php if($nt_option["sp_property_type"]=="1"):?> 
            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                <select class="form-control select" name="property_type">
                    <option value=""><?php if(isset($nt_option["s_propertytype"])){ _e( $nt_option["s_propertytype"], 'realto'); } ?></option>
                    <?php $property_type = get_terms('property-type');?>
                    <?php foreach($property_type as $p_type): ?>
                    <option value="<?php echo $p_type->slug; ?>"><?php echo $p_type->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>
          
            
         
            <?php if($nt_option["sp_status"]=="1"):?>
            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                <select class="form-control select" name="status">
                    <option value=""><?php if(isset($nt_option["s_status"])){ _e( $nt_option["s_status"], 'realto' ); } ?></option>
                    <option value="for-rent"><?php _e("For Rent","realto"); ?></option>
                    <option value="for-sale"><?php _e("For Sale","realto"); ?></option>
                    <option value="sold"><?php _e("Sold","realto"); ?></option>
		            <option value="upcoming"><?php _e("Upcoming","realto"); ?></option>
		            <option value="inquire"><?php _e("Inquire","realto"); ?></option>
                </select>
            </div>
            <?php endif; ?>
           
            <?php if($nt_option["sp_beds"]=="1"):?>  
            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                <select class="form-control select" name="beds">
                    <option value=""><?php if(isset($nt_option["s_bed"])){ _e( $nt_option["s_bed"], 'realto'); } ?></option>
                    <option value="1">1+ <?php if(isset($nt_option["s_bed"])){ echo $nt_option["s_bed"];} ?></option>
                    <option value="2">2+ <?php if(isset($nt_option["s_bed"])){ echo $nt_option["s_bed"];} ?></option>
                    <option value="3">3+ <?php if(isset($nt_option["s_bed"])){ echo $nt_option["s_bed"];} ?></option>
                    <option value="4">4+ <?php if(isset($nt_option["s_bed"])){ echo $nt_option["s_bed"];} ?></option>
                    <option value="5">5+ <?php if(isset($nt_option["s_bed"])){ echo $nt_option["s_bed"];} ?></option>
                    <option value="6">6+ <?php if(isset($nt_option["s_bed"])){ echo $nt_option["s_bed"];} ?></option>
                    <option value="7">7+ <?php if(isset($nt_option["s_bed"])){ echo $nt_option["s_bed"];} ?></option>
                    <option value="8">8+ <?php if(isset($nt_option["s_bed"])){ echo $nt_option["s_bed"];} ?></option>
                    <option value="9">9+ <?php if(isset($nt_option["s_bed"])){ echo $nt_option["s_bed"];} ?></option>
                    <option value="10">10+ <?php if(isset($nt_option["s_bed"])){ echo $nt_option["s_bed"];} ?></option>
                </select>
            </div>
            <?php endif; ?> 
           
            <?php if($nt_option["sp_baths"]=="1"):?>
            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                <select class="form-control select" name="baths">
                    <option value=""><?php if(isset($nt_option["s_bath"])){ _e( $nt_option["s_bath"], 'realto' );} ?></option>
                    <option value="1">1+ <?php if(isset($nt_option["s_bath"])){ echo $nt_option["s_bath"];} ?></option>
                    <option value="2">2+ <?php if(isset($nt_option["s_bath"])){ echo $nt_option["s_bath"];} ?></option>
                    <option value="3">3+ <?php if(isset($nt_option["s_bath"])){ echo $nt_option["s_bath"];} ?></option>
                    <option value="4">4+ <?php if(isset($nt_option["s_bath"])){ echo $nt_option["s_bath"];} ?></option>
                    <option value="5">5+ <?php if(isset($nt_option["s_bath"])){ echo $nt_option["s_bath"];} ?></option>
                    <option value="6">6+ <?php if(isset($nt_option["s_bath"])){ echo $nt_option["s_bath"];} ?></option>
                    <option value="7">7+ <?php if(isset($nt_option["s_bath"])){ echo $nt_option["s_bath"];} ?></option>
                    <option value="8">8+ <?php if(isset($nt_option["s_bath"])){ echo $nt_option["s_bath"];} ?></option>
                    <option value="9">9+ <?php if(isset($nt_option["s_bath"])){ echo $nt_option["s_bath"];} ?></option>
                    <option value="10">10+ <?php if(isset($nt_option["s_bath"])){ echo $nt_option["s_bath"];} ?></option>
                </select>
            </div>
            <?php endif; ?> 
           
            <?php if($nt_option["sp_min_price"]=="1"):?>
            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
            	<div class="form-group">
                	<input class="form-control" type="text" name="min-price" value="" placeholder="<?php if(isset($nt_option["s_minprice"])){echo $nt_option["site_currency"]." ". __( $nt_option["s_minprice"], 'realto' );}?>">
                </div>
            </div>
            <?php endif; ?>
           
            <?php if($nt_option["sp_min_price"]=="1"):?> 
            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
            	<div class="form-group">
                	<input class="form-control" type="text" name="max-price" value="" placeholder="<?php if(isset($nt_option["s_maxprice"])){echo $nt_option["site_currency"]." ". __( $nt_option["s_maxprice"], 'realto');}?>">
            	</div>
            </div>
            <?php endif; ?>
            
            <div class="hidden-lg hidden-md">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                	<div class="form-group">
                    	<input class="btn btn-form btn-realto-form" value="<?php _e("Search", "realto");?>" type="submit">
                    </div>
                </div>
            </div>
            
        </div>
        <?php if($nt_option["sp_keyword"]=="0"):?> 
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 hidden-sm hidden-sm">
                <input class="btn input-block-level btn-realto-form" value="<?php _e("Search", "realto");?>" type="submit">
            </div>
        </div>
        <?php endif; ?>    				
    </form>
<?php
}

/**
 * Theme localization
 */
load_theme_textdomain( 'realto', get_template_directory() . '/languages' );
$locale = get_locale();
$locale_file = get_template_directory() . "/languages/$locale.php";
if ( is_readable($locale_file) ) require_once($locale_file);

/************************ Realto Build Style *************************************************/

function realtoBuildStyle( $bg_image = '', $padding_top = '', $padding_bottom = '', $bg_color = '', $bg_image_repeat = '', $font_color = '', $padding = '', $margin_bottom = '' ) {
	$has_image = false;
	$style = '';
	if ( (int) $bg_image > 0 && ( $image_url = wp_get_attachment_url( $bg_image, 'large' ) ) !== false ) {
		$has_image = true;
		$style .= "background-image: url(" . $image_url . ");";
	}
	if ( ! empty( $bg_color ) ) {
		$style .= vc_get_css_color( 'background-color', $bg_color );
	}
	if ( ! empty( $bg_image_repeat ) && $has_image ) {
		if ( $bg_image_repeat === 'cover' ) {
			$style .= "background-repeat:no-repeat;background-size: cover;";
		} elseif ( $bg_image_repeat === 'contain' ) {
			$style .= "background-repeat:no-repeat;background-size: contain;";
		} elseif ( $bg_image_repeat === 'no-repeat' ) {
			$style .= 'background-repeat: no-repeat;';
		}
	}
	if ( ! empty( $font_color ) ) {
		$style .= vc_get_css_color( 'color', $font_color ); // 'color: '.$font_color.';';
	}
	if ( $padding != '' ) {
		$style .= 'padding: ' . ( preg_match( '/(px|em|\%|pt|cm)$/', $padding ) ? $padding : $padding . 'px' ) . ';';
	}
	if ( $padding_top != '' ) {
		$style .= 'padding-top: ' . ( preg_match( '/(px|em|\%|pt|cm)$/', $padding_top ) ? $padding_top : $padding_top . 'px' ) . ';';
	}
	if ( $padding_bottom != '' ) {
		$style .= 'padding-bottom: ' . ( preg_match( '/(px|em|\%|pt|cm)$/', $padding_bottom ) ? $padding_bottom : $padding_bottom . 'px' ) . ';';
	}
	if ( $margin_bottom != '' ) {
		$style .= 'margin-bottom: ' . ( preg_match( '/(px|em|\%|pt|cm)$/', $margin_bottom ) ? $margin_bottom : $margin_bottom . 'px' ) . ';';
	}

	return empty( $style ) ? $style : ' style="' . esc_attr( $style ) . '"';
}

/* --------------------------------------------------------------------------
 * Hex to RGB values
 ---------------------------------------------------------------------------*/
function realto_hex2rgb($hex) {
   
   //$hex = str_replace("#", "", $hex);

	$hex = preg_replace("/#/", "", $hex );

   $color = array();

   if(strlen($hex) == 3) {
      $color['r'] = hexdec(substr($hex, 0, 1) );
      $color['g'] = hexdec(substr($hex, 1, 1) );
      $color['b'] = hexdec(substr($hex, 2, 1) );
   } else {
      $color['r'] = hexdec(substr($hex, 0, 2) );
      $color['g'] = hexdec(substr($hex, 2, 2) );
      $color['b'] = hexdec(substr($hex, 4, 4) );
   }
  
  return $color;
}

/* --------------------------------------------------------------------------
 * Setting Random ID
 ---------------------------------------------------------------------------*/
if(!function_exists('realto_random_id')) { 
	function realto_random_id($id_length) {
	$random_id_length = $id_length; 
	$rnd_id = uniqid(rand(),1); 
	$rnd_id = strip_tags(stripslashes($rnd_id)); 
	$rnd_id = str_replace(".","",$rnd_id); 
	$rnd_id = strrev(str_replace("/","",$rnd_id)); 
	$rnd_id = str_replace(range(0,9),"",$rnd_id); 
	$rnd_id = substr($rnd_id,0,$random_id_length); 
	$rnd_id = strtolower($rnd_id);  

	return $rnd_id;
	}
}


function realto_post_author_archive( $query ) {
    if ( $query->is_author() && $query->is_main_query() ) :
        $query->set( 'posts_per_page', 2 );
        $query->set( 'post_type', array('property') );
    endif;
}
add_action( 'pre_get_posts', 'realto_post_author_archive' );


/*function reato_text(){
	_e( 'Search Keyword...', 'realto');
	_e( 'Property Type', 'realto');
	_e( 'Location', 'realto');
	_e( 'Select Status', 'realto');
	_e( 'Beds', 'realto');
	_e( 'Baths', 'realto');
	_e( 'Min Price', 'realto');
	_e( 'Max Price', 'realto');
	_e( 'day', 'realto');
	_e( 'week', 'realto');
	_e( 'month', 'realto');
	_e( 'year', 'realto');
	_e( 'View profile page', 'realto');
	_e( 'Meet our agents', 'realto');
	
}*/
remove_filter( 'the_content', 'wpautop' ); //
remove_filter( 'the_excerpt', 'wpautop' ); //
remove_filter('comment_text', 'wpautop'); // main  22.02.2016