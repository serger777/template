<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="">
 *
 * @package RealTo
 * @since RealTo 1.5
 */
global $nt_option; // Fetch options stored in $nt_option;
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    
    <?php 
	// Get the favicon
	if ($nt_option['site_favicon'] != '' ) { 
		$site_favicon = $nt_option['site_favicon'];
	} else { 
		$site_favicon = get_template_directory_uri() . '/ico/favicon.png';
	}
	
	// Get retina favicon 144 x 144
	if ( $nt_option['site_retina_favicon'] != '' ) { 
		$retina_favicon144 = $nt_option['site_retina_favicon'];
	} else { 
		$retina_favicon144 = get_template_directory_uri() . '/ico/apple-touch-icon-144-precomposed.png';
	}
	?>
    <!-- Favicon and touch icons  -->
    <link href="<?php echo $retina_favicon144;?>" rel="apple-touch-icon-precomposed" sizes="144x144">
    <link href="<?php echo $site_favicon; ?>" rel="shortcut icon">
	<!-- my style-->

	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
    <script src="http://maps.google.com/maps/api/js?sensor=true" type="text/javascript"></script>
	<?php wp_head(); ?>
</head>

<body id="<?php echo $nt_option["website_color"]; ?>" <?php body_class(); ?>>
<!-- begin header -->
<header>
    <div class="navbar banner navbar-inverse"><!-- navbar-fixed-top -->
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#realto-nav-bar">
					<span class="sr-only">Toggle navigation</span>
					<i class="fa fa-bars"></i>
				</button>
			</div>
		</div><!-- .container-fluid -->


		<div class="collapse navbar-collapse" id="realto-nav-bar">
			<?php // Define Main Menu 
			if ( has_nav_menu( 'primary' ) ) :?>
		
			<?php
			wp_nav_menu( array (
				'theme_location' => 'primary',
				'container' => 'div',
				'container_class' => 'container',
				'menu_class' => 'nav navbar-nav',
				'depth' => 3,
				'fallback_cb' => false,
				'walker' => new realto_nav_menu()
			));
			?>

			<?php 
			else:
			echo '<div class="message warning"><i class="fa fa-exclamation-triangle"></i>' . __( 'Define your site primary menu', 'realto' ) . '</div>';
			endif;
			?>
		</div><!-- .navbar-collapse -->
    </div><!-- .navbar -->
    <div class="clearfix"></div>
    <div>
        <div class="container">
            <div class="row">
		<a href="/"><img src="/wp-content/uploads/2015/09/new-header3.jpg"></a>
            </div>
        </div>
    </div>
    <!-- #logo-container -->
</header>  
<!-- end header -->
<a id="showHere"></a>