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
		<h1 class="h1-hidden"><?php esc_html_e('PRINT CARDS', 'wpnetbase');?></h1>
		<div id="topbar" class="site-topbar">
			<div class="container">
				<div class="topbar-inner clearfix">
					<?php if (isset($printshop_option['homepage_layout']) && $printshop_option['homepage_layout'] =="home-boxed" ) { ?>
						<?php if ( $printshop_option['extract_1_value'] ) { ?>
							<div class="header-left-widgets">
								<span class="phone-text"><?php echo wp_kses_post( $printshop_option['extract_1_value'] ); ?></span>
								
							</div>
						<?php } ?>
						<?php if ( $printshop_option['header_social'] ) { ?>
							<div class="header-right-widgets">	
								
									<ul id="topbar-boxed-acc">
                                    <?php 
                                        $page1 = get_page_by_path('my-account');
                                        if(is_user_logged_in()){
                                            $user=wp_get_current_user();        
                                            $name=$user->display_name; 

                                            echo '<li>';
                                            _e('Welcome','printshop'); 
                                            echo  ' '.$name.'</li>';

                                            if($page1){
                                                echo '<li><a href="'.get_permalink($page1->ID).'" class="item-link">';
                                                _e('My Account','printshop');
                                                echo '</a></li>';
                                            }
                                            echo '<li><a href="'.wp_logout_url( home_url() ).'">';
                                            _e('Logout','printshop');
                                            echo '</a></li>';
                                        } 

                                        else{ ?>                                           
                                            <?php if($page1){ ?>
                                                <li>
                                                    <a href="<?php echo get_permalink($page1->ID); ?>" title="<?php _e('Login','printshop'); ?>"><?php _e('Login','printshop'); ?></a>
                                                </li>
                                            <?php
                                            }else{
                                                ?>
                                                <li>
                                                     <a href="<?php echo wp_login_url( home_url() ); ?>" title="<?php _e('Login','printshop'); ?>"><?php _e('Login','printshop'); ?></a>
                                                </li>
                                                <?php
                                            }
                                    	}
                                    ?>	
                                    <?php if ( is_active_sidebar( 'header-cs' ) ) { 
	                                    echo '<li class="sidebar-header-cs">';
	                                    	dynamic_sidebar( 'header-cs' );
	                                    echo '</li>';
                                    } ?>
                                   	</ul>
							</div>
						<?php } ?>

					<?php } else{ ?>
						<?php if ( $printshop_option['header_social'] ) { 
							if ( has_nav_menu( 'printshop-topbar-menu' ) ) {	
							?>
						<div class="header-left-widgets">						
							<div class="extract-element">
								<div class="header-social">
									<?php wp_nav_menu( array( 'theme_location' => 'printshop-topbar-menu' ) ); ?>										
								</div>
							</div>
											
						</div>
						<?php } 
						} ?>	
						<?php if ( $printshop_option['extract_1_value'] ) { ?>					
						<div class="header-right-widgets">						
							<div class="extract-element">
								<span class="phone-text">
								<i class="fa fa-phone"></i><?php echo wp_kses_post( $printshop_option['extract_1_value'] ); ?></span>
							</div>
							<?php if ( is_active_sidebar( 'header-cs' ) ) { 
	                            echo '<div class="header-currency-switch">';
	                               	dynamic_sidebar( 'header-cs' );
	                            echo '</div>';
                            } ?>							
																					
						</div>		
						<?php } ?>
					<?php } ?>									
				</div>
			</div>
			
		</div> <!-- /#topbar -->

		<header id="masthead" class="site-header <?php if ( printshop_get_option('header_fixed') ) echo 'fixed-on' ?>" role="banner">
			<div class="header-wrap">
				<div class="container">
					
				</div>
			</div>
			<div class="menu-logo">
				<div class="container">
					<div class="site-branding col-xs-6 col-sm-2 col-md-3 padding-left-0">
						<?php if ( printshop_get_option('site_logo', false, 'url') !== '' ) { ?>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
								<img src="<?php echo printshop_logo_render(); ?>" alt="<?php get_bloginfo( 'name' ) ?>" />
							</a>
						<?php } else { ?>
							<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
						<?php } ?>
					</div><!-- /.site-branding -->

					<div class="header-right-wrap-top col-sm-8 col-md-8">
						<div class="netbase-menu-title">
							<h3><?php esc_html_e('Navigation','printshop'); ?></h3>
							<span id="close-netbase-menu"><i class="fa fa-times-circle"></i></span>
						</div>
						<?php wp_nav_menu( array('theme_location' => 'primary', 'container' => '', 'items_wrap' => '%3$s' ) ); ?>
					</div>
					<div class="header-right-cart-search col-xs-5 col-sm-2 col-md-1 padding-right-0">
						<span id="netbase-responsive-toggle"><i class="fa fa-bars"></i></span>
						<div class="header-cart-search">
						<?php 
							if ( shortcode_exists( 'wpnetbase_ajaxcart' ) ) {
								do_shortcode("[wpnetbase_ajaxcart]");
							}						
							else{							
							?>
							<?php if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { ?>
							<?php $count = WC()->cart->cart_contents_count;?>
							<a class="cart-contents" href="<?php echo esc_url(WC()->cart->get_cart_url()); ?>" title="<?php esc_html_e( 'View your shopping cart', 'wpnetbase' ); ?>"><span><?php if ( $count > 0 ) echo intval($count) ; ?></span></a>
							<?php } ?>
							<div class="widget_shopping_cart_content"></div>
							<?php } ?>
						</div>
						<div class="header-search">
							<i class="fa fa-search" aria-hidden="true" style="display: none;"></i>
							<?php get_search_form(); ?>
						</div>
					</div>
				</div>
			</div>
		</header><!-- #masthead -->		

		<div id="content" class="site-content">