<?php

// Netbase Widget Woo Products
add_shortcode('netbase_widget_woo_products', 'netbase_shortcode_widget_woo_products');
add_action('vc_after_init', 'netbase_load_widget_woo_products_shortcode');

function netbase_shortcode_widget_woo_products($atts, $content = null) {
    ob_start();
    if ($template = netbase_shortcode_woo_template('netbase_widget_woo_products'))
        include $template;
    return ob_get_clean();
}

function netbase_load_widget_woo_products_shortcode() {
    $animation_type = netbase_vc_animation_type();
    $animation_duration = netbase_vc_animation_duration();
    $animation_delay = netbase_vc_animation_delay();
    $custom_class = netbase_vc_custom_class();

    // woocommerce products widget
    vc_map(
        array(
            'name' => __( 'Products', 'netbase-shortcodes' ) . " " . __("Widget", 'netbase-shortcodes' ),
            'base' => 'netbase_widget_woo_products',
            'icon' => 'netbase_vc_woocommerce',
            'category' => __( 'WooCommerce Widgets', 'netbase-shortcodes' ),
            'class' => 'wpb_vc_wp_widget',
            'weight' => - 50,
            'description' => __( 'Display a list of your products on your site.', 'woocommerce' ),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'heading' => __( 'Title', 'woocommerce' ),
                    'param_name' => 'title',
                    'admin_label' => true
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __( 'Number of products to show', 'woocommerce' ),
                    'param_name' => 'number',
                    'value' => 5
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __( 'Show', 'woocommerce' ),
                    'param_name' => 'show',
                    'value' => array(
                        __( 'All Products', 'woocommerce' )      => '',
                        __( 'Featured Products', 'woocommerce' ) => 'featured',
                        __( 'On-sale Products', 'woocommerce' )  => 'onsale',
                    ),
                    'admin_label' => true
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __( 'Order by', 'woocommerce' ),
                    'param_name' => 'orderby',
                    'value' => array(
                        __( 'Date', 'woocommerce' )   => 'date',
                        __( 'Price', 'woocommerce' )  => 'price',
                        __( 'Random', 'woocommerce' ) => 'rand',
                        __( 'Sales', 'woocommerce' )  => 'sales',
                    ),
                    'admin_label' => true
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => _x( 'Order', 'Sorting order', 'woocommerce' ),
                    'param_name' => 'order',
                    'value' => array(
                        __( 'DESC', 'woocommerce' ) => 'desc',
                        __( 'ASC', 'woocommerce' )  => 'asc',
                    )
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => __( 'Hide free products', 'woocommerce' ),
                    'param_name' => 'hide_free',
                    'value' => array( __( 'Yes', 'js_composer' ) => 'yes' )
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => __( 'Show hidden products', 'woocommerce' ),
                    'param_name' => 'show_hidden',
                    'value' => array( __( 'Yes', 'js_composer' ) => 'yes' )
                ),
                $custom_class,
                $animation_type,
                $animation_duration,
                $animation_delay
            )
        )
    );

    if (!class_exists('WPBakeryShortCode_Netbase_Widget_Woo_Products')) {
        class WPBakeryShortCode_Netbase_Widget_Woo_Products extends WPBakeryShortCode {
        }
    }
}