<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Netbase
 */
$printshop_option = printshop_get_redux_options();
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="<?php echo esc_url('http://gmpg.org/xfn/11'); ?>">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="page" class="hfeed site">
		<div id="topbar" class="site-topbar">
			<div class="container">
				<div class="topbar-inner clearfix">
					<div class="header-left-widgets">
					<?php if ( $printshop_option['header_social'] ) { ?>
								<div class="extract-element">
									<div class="header-social">
										<?php wp_nav_menu( array( 'theme_location' => 'printshop-topbar-menu' ) ); ?>
									</div>
								</div>
								<?php } ?>
						
					</div>
					<?php if ( $printshop_option['extract_1_value'] ) { ?>
					<div class="header-right-widgets">
							
							<div class="extract-element">
								<span class="phone-text">
								<i class="fa fa-phone"></i> <?php echo wp_kses_post( $printshop_option['extract_1_value'] ); ?></span>
							</div>
							
							
					</div>
					<?php } ?>	
					</div>
				
			</div>
		</div> <!-- /#topbar -->
		<header id="masthead" class="site-header <?php if ( printshop_get_option('header_fixed') ) echo 'fixed-on' ?>" role="banner">
			<div class="header-wrap">
				<div class="container">
					<div class="site-branding col-md-3 padding-left-0">
						<?php if ( printshop_get_option('site_logo', false, 'url') !== '' ) { ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
							<img src="<?php echo printshop_logo_render(); ?>" alt="<?php get_bloginfo( 'name' ) ?>" />
						</a>
						<?php } else { ?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
						<?php } ?>
					</div><!-- /.site-branding -->
					<div class="header-right-wrap-top col-md-8">
						<div class="netbase-menu-title">
							<h3><?php esc_html_e('Navigation','printshop'); ?></h3>
							<span id="close-netbase-menu"><i class="fa fa-times-circle"></i></span>
						</div>
						<?php wp_nav_menu( array('theme_location' => 'primary', 'container' => '', 'items_wrap' => '%3$s' ) ); ?>
					</div>
					<div class="header-right-cart-search col-md-1 padding-right-0">
						<span id="netbase-responsive-toggle"><i class="fa fa-bars"></i></span>
						<div class="header-cart-search">
							<?php if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { ?>
							<?php $count = WC()->cart->cart_contents_count;?>
							<a class="cart-contents" href="<?php echo esc_url(WC()->cart->get_cart_url()); ?>" title="<?php esc_html_e( 'View your shopping cart', 'printshop' ); ?>"><span><?php if ( $count > 0 ) echo intval($count) ; ?></span></a>
							<div class="widget_shopping_cart_content"></div>
							<?php } ?>
						</div>
						<?php get_search_form(); ?>
					</div>
				</div>
			</div>
			
		</header><!-- #masthead -->
		
		<div id="content" class="site-content">