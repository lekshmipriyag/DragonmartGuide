<?php
function printshop_childtheme_enqueue_styles() {
 wp_enqueue_style( 'printshop-child-style',
      get_stylesheet_directory_uri() . '/style.css',
      array()
 );
}
add_action( 'wp_enqueue_scripts', 'printshop_childtheme_enqueue_styles',99 );

