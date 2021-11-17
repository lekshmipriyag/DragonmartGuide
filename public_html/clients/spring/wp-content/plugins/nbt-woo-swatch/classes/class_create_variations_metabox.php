<?php
class nbtws_add_colored_variation_metabox {

	/*
	* Construct
	* since version 1.0.0
	*/
	public function __construct() {
		add_action('admin_enqueue_scripts', array(&$this, 'nbtws_register_scripts'));
		add_action('woocommerce_product_write_panel_tabs', array($this, 'nbtws_add_colored_variable_metabox'));
		add_action('woocommerce_product_write_panels', array($this, 'colored_variable_tab_options'));
		add_action('woocommerce_process_product_meta', array($this, 'process_product_meta_colored_variable_tab'), 10, 2);
	}

	/*
	* Add metabox tab
	* since version 1.0.0
	*/
	public function nbtws_register_scripts() {
		wp_register_script( 'nbtws-meta', ''.NBTWS_PLUGIN_URL.'js/nbtws-meta.js' );
		wp_register_script( 'jquery.accordion', ''.NBTWS_PLUGIN_URL.'js/jquery.accordion.js' );
		wp_register_style( 'nbtws-meta', ''.NBTWS_PLUGIN_URL.'css/nbtws-meta.css' );
		wp_register_style( 'jquery.accordion', ''.NBTWS_PLUGIN_URL.'css/jquery.accordion.css' );
		wp_register_style( 'example-styles', ''.NBTWS_PLUGIN_URL.'css/example-styles.css' );

		$translation_array = array(
			'uploadimage'    => __( 'Choose an image' ,'nbtws'),
			'useimage'       => __( 'Use Image' ,'nbtws'),
			'placeholder'    => nbtws_placeholder_img_src(),
		);
		wp_localize_script( 'nbtws-meta', 'nbtwsmeta', $translation_array );
	}

	/*
	* Add metabox tab
	* since version 1.0.0
	*/
	public function nbtws_add_colored_variable_metabox() {
	?>
		<a href="#nbtws_colored_variable_tab_data"><li class="colored_variable_tab show_if_variable" ><?php _e('Variation Select', 'nbtws'); ?></a></li>
	<?php }


	/*
	* Adds metabox tab content
	* since version 1.0.0
	*/
	public function colored_variable_tab_options() {
		global $post, $woocommerce;

		$woo_version              =  nbtws_get_woo_version_number();
		$_coloredvariables        =  get_post_meta( $post->ID, '_coloredvariables', true );
		$shop_swatches            =  get_post_meta( $post->ID, '_shop_swatches', true );
		$shop_swatches_attribute  =  get_post_meta( $post->ID, '_shop_swatches_attribute', true );
		$helpimg                  =  '' . NBTWS_PLUGIN_URL . 'images/help.png';

		wp_enqueue_script('nbtws-meta');
		wp_enqueue_script('jquery.accordion');
		wp_enqueue_style('nbtws-meta');
		wp_enqueue_style('jquery.accordion');
		wp_enqueue_style('jquery.accordion');
		wp_enqueue_style('example-styles');
		wp_enqueue_script('wp-color-picker');
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_media();

		/**
		* Includes Metabox form
		*/
		include('forms/nbtws_variation_select_tab_content.php');
	}

	/**
	* Adds save metabox tab options
	* @$post_id - product id
	*/
	public function process_product_meta_colored_variable_tab( $post_id ) {
		$shop_swatches = isset( $_POST['shop_swatches'] ) ? 'yes' : 'no';
		
		if (isset($_POST['coloredvariables']))
			update_post_meta( $post_id, '_coloredvariables', $_POST['coloredvariables'] );
	
		if (isset($shop_swatches))
			update_post_meta( $post_id, '_shop_swatches', $shop_swatches );
	
		if (isset($_POST['shop_swatches_attribute']))
			update_post_meta( $post_id, '_shop_swatches_attribute', $_POST['shop_swatches_attribute'] );
	}
}

new nbtws_add_colored_variation_metabox();