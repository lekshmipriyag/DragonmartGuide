<?php
class nbtws_register_style_scripts {

	/**
	 * nbtws_register_style_scripts constructor.
     */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this,'nbtws_register_my_scripts' ) );
	}
	
	public function nbtws_register_my_scripts() {
		global $post,$product;
		$displaytypenumber               = 0;
		$woocommerce_nbtws_swatch_tooltip = get_option('woocommerce_nbtws_swatch_tooltip');
		$woo_version                     =  nbtws_get_woo_version_number();
		
		if ( is_product() || ( ! empty( $post->post_content ) && strstr( $post->post_content, '[product_page]' ) ) ) {
			if ((is_product())){
				$product           = wc_get_product($post->ID);
			}
			$displaytypenumber = nbtws_return_displaytype_number($product,$post);
		}
		
		wp_register_style( 'nbtws-frontend', NBTWS_PLUGIN_URL . 'css/front-end.css' );
		wp_register_style( 'minitip', NBTWS_PLUGIN_URL . 'css/minitip.css' );
		
		$goahead=1;
		
		if(isset($_SERVER['HTTP_USER_AGENT'])){
			$agent = $_SERVER['HTTP_USER_AGENT'];
		}
		
		if (preg_match('/(?i)msie [5-8]/', $agent)) {
			$goahead=0;
		}
		
		if ( ( $displaytypenumber >0 ) && ( $goahead == 1 ) ) {
			wp_register_script( 'product-frontend', NBTWS_PLUGIN_URL . 'js/product-frontend.js' ,array( 'jquery'), false, true);
			
			$nbtws_localize = array(
				'tooltip' => $woocommerce_nbtws_swatch_tooltip
			);
			
			wp_localize_script( 'product-frontend', 'nbtws', $nbtws_localize );
			
			wp_register_script( 'minitip', NBTWS_PLUGIN_URL . 'js/minitip.js' ,array( 'jquery'), false, true);
		}
		
		if ( is_product() || is_shop() || ( ! empty( $post->post_content ) && strstr( $post->post_content, '[product_page]' ) ) ) {
			if ( ( $displaytypenumber > 0 ) && ( $goahead == 1 ) ) {
				wp_enqueue_script('product-frontend');
				wp_deregister_script('wc-add-to-cart-variation'); 
				wp_dequeue_script ('wc-add-to-cart-variation'); 
				
				if ($woo_version < 2.5) {
					wp_register_script( 'wc-add-to-cart-variation', NBTWS_PLUGIN_URL . 'js/add-to-cart-variation1.js' ,array( 'jquery'), false, true);
				} else {
					wp_register_script( 'wc-add-to-cart-variation', NBTWS_PLUGIN_URL . 'js/add-to-cart-variation2.js' ,array( 'jquery', 'wp-util' ), false, true);
				}
				
				wp_enqueue_script('wc-add-to-cart-variation');
				wp_enqueue_style('nbtws-frontend');
				
				if (isset($woocommerce_nbtws_swatch_tooltip) && ($woocommerce_nbtws_swatch_tooltip == "yes")) {
					wp_enqueue_script('minitip');
					wp_enqueue_style('minitip');
				}
			}
		}
	}
}

new nbtws_register_style_scripts();
