<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package ABARIS
 */
global $abaris;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
if ( ! function_exists( '_wp_render_title_tag' ) ) :
    function abaris_render_title() {
?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php
    }
    add_action( 'wp_head', 'abaris_render_title' );
endif;
?>
<?php if( isset( $abaris['ipad-icon-retina'] ) && $abaris['ipad-icon-retina']['url'] != '' ) : ?>
	<!-- For third-generation iPad with high-resolution Retina display: -->
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo esc_url( $abaris['ipad-icon-retina']['url'] ); ?>">
<?php endif; ?>

<?php if( isset( $abaris['iphone-icon-retina'] ) && $abaris['iphone-icon-retina']['url'] != '' ) : ?>
	<!-- For iPhone with high-resolution Retina display: -->
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo esc_url( $abaris['iphone-icon-retina']['url'] ); ?>">
<?php endif; ?>

<?php if( isset( $abaris['ipad-icon'] ) && $abaris['ipad-icon']['url'] != '' ) : ?>
	<!-- For first- and second-generation iPad: -->
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo esc_url( $abaris['ipad-icon']['url'] ); ?>">
<?php endif; ?>

<?php if( isset( $abaris['iphone-icon'] ) && $abaris['iphone-icon']['url'] != '' ) : ?>
	<!-- For non-Retina iPhone, iPod Touch, and Android 2.1+ devices: -->
	<link rel="apple-touch-icon-precomposed" href="<?php echo esc_url( $abaris['iphone-icon']['url'] ); ?>">
<?php endif; ?>

<?php if( isset( $abaris['favicon'] ) && $abaris['favicon']['url'] != '' ) : ?>
	<link rel="icon" href="<?php echo esc_url( $abaris['favicon']['url'] ); ?>">
<?php endif; ?>

<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>
	<?php if( get_header_image() ) : ?>
		<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" style="position: absolute;" />
	<?php endif; ?>
	<header id="masthead" class="site-header header-wrap" role="banner">
		<div class="container">
			<div class="row">
				<div class="span3">
					<div class="logo site-branding">
						<?php if( isset( $abaris['site-title'] ) && isset( $abaris['custom-logo'] ) && $abaris['site-title'] ) : ?>
							<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo esc_url( $abaris['custom-logo']['url'] ); ?>" alt="logo" ></a></h1>
						<?php else : ?>
							<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<?php endif; ?>
						<?php if( isset( $abaris['site-description'] ) && $abaris['site-description'] != 0 ) : ?>
							<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
						<?php endif; ?>
					</div>
				</div>

				<div class="span9">
					<nav id="site-navigation" class="main-navigation" role="navigation">
						<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'abaris' ); ?></a>
						<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
					</nav><!-- #site-navigation -->
				</div>
			</div>
		</div>
	</header><!-- #masthead -->
<?php	if (! is_front_page() ) : ?>
	<div id="content" class="site-content container">
<?php endif; ?>