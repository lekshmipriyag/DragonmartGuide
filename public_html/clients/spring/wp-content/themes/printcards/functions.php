<?php
function printshop_theme_enqueue_styles() {
	
	wp_enqueue_style( 'printshop-child-style', get_stylesheet_directory_uri() . '/style.css' );
	if( is_front_page () ){
		wp_enqueue_style( 'printshop-style-doughnut', get_stylesheet_directory_uri() .'/css/doughnutit.css', 'all' );
		wp_enqueue_script( 'printshop-chart', get_stylesheet_directory_uri() . '/js/Chart.js', array(), '', false );
		wp_enqueue_script( 'printshop-doughnutit', get_stylesheet_directory_uri() . '/js/doughnutit.js', array(), '', false );
		wp_enqueue_script( 'printshop-customize', get_stylesheet_directory_uri() . '/js/customize.js', array(), '', true );
	}
}
add_action( 'wp_enqueue_scripts', 'printshop_theme_enqueue_styles', 99 );

if ( in_array( 'redux-framework/redux-framework.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) 
{

}else{
	function printshop_cards_default_scripts() {
		wp_enqueue_style( 'printshop-default-cards', get_stylesheet_directory_uri() .'/css/style_default.css', 'all' );
	}
	add_action( 'wp_enqueue_scripts', 'printshop_cards_default_scripts' );
}