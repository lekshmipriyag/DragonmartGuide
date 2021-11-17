<?php
/**
 * Ajax Drop Cart Class
 *
 * Main class
 *
 * @author 		Netbase
 * @version 	1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( !class_exists( 'NB_ADCart' ) ) :

class NB_ADCart {

	var $settings;
	var $icon_styles;

	public function __construct() {

		$this->settings = get_option( "nbadcart_plugin_settings" );
		$this->icon_styles = array(
			1=>'style1',
			2=>'style2',
			3=>'style3',
			4=>'style4',
			5=>'style5',
			6=>'style6',
			7=>'style7',
			8=>'style8',
			9=>'style9',
			10=>'style10',
		);

		/** Check WooCommerce Instalation **/
		add_action( 'wp_head', array($this , 'woostore_check_environment') );
		add_action( 'wp_head', array($this , 'netbase_print_dynamic_css') );
		//add_action( 'widgets_init', array( $this, 'register_widgets' ) );
		add_action( 'wp_enqueue_scripts', array($this,'netbase_drop_cart_stylesheets') );
		add_action( 'wp_enqueue_scripts', array($this,'netbase_drop_cart_scripts'),100 );

		add_action('wp_ajax_woocommerce_remove_from_cart',array(&$this,'woocommerce_ajax_remove_from_cart'),1000);
		add_action('wp_ajax_nopriv_woocommerce_remove_from_cart', array(&$this,'woocommerce_ajax_remove_from_cart'),1000);

		add_action( 'wp_ajax_add_to_cart_single', array(&$this, 'woocommerce_add_to_cart_single') );
		add_action( 'wp_ajax_nopriv_add_to_cart_single', array(&$this, 'woocommerce_add_to_cart_single') );

		add_action( 'wp_ajax_woocommerce_add_to_cart_variable_rc', array(&$this, 'woocommerce_add_to_cart_variable_rc_callback') );
		add_action( 'wp_ajax_nopriv_woocommerce_add_to_cart_variable_rc', array(&$this,'woocommerce_add_to_cart_variable_rc_callback') );

		add_filter('woocommerce_add_to_cart_fragments', array(&$this,'woocommerce_header_add_to_cart_fragment'));

		add_shortcode('nbadcart_widget', array($this,'nbadcart_widget_shortcode'));

		if(is_admin()) {

			add_action( 'init', array($this,'pw_add_image_sizes') );
			add_filter('image_size_names_choose', array($this,'pw_show_image_sizes'));
	 		// create custom plugin settings menu
			add_action('admin_menu', array($this,'nbajaxdropcart_create_menu'));
			add_action( 'admin_enqueue_scripts', array($this,'netbase_drop_cart_admin_stylesheets') );
			add_action( 'admin_enqueue_scripts', array($this,'nw_drop_cart_admin_scripts') );

		}

	}
	
	public function netbase_print_dynamic_css() {
		$widget_params = get_option('nbadcart_plugin_settings');
		if( $this->settings['adcart-style'] == 'cus' ) :
		?>
		<style type="text/css">
			.nw-cart-drop-content { -webkit-border-radius: <?php echo $widget_params['adcart-border-radius'];?>px;-moz-border-radius: <?php echo $widget_params['adcart-border-radius'];?>px;border-radius: <?php echo $widget_params['adcart-border-radius'];?>px;border:1px solid #<?php echo $widget_params['adcart-background-border-color'];?>;}
			.nw-drop-cart .nw-cart-drop-content-in a.button{color:#<?php echo $widget_params['adcart-button-text-color'];?>;background:#<?php echo $widget_params['adcart-button-bg-color'];?> }
			.nw-drop-cart a.button:hover{background:#<?php echo $widget_params['adcart-button-bghv-color'];?> }
			.nw-cart-drop-toggle { -webkit-border-radius: <?php echo $widget_params['adcart-border-radius'];?>px;-moz-border-radius: <?php echo $widget_params['adcart-border-radius'];?>px;border-radius: <?php echo $widget_params['adcart-border-radius'];?>px;border:1px solid #<?php echo $widget_params['adcart-background-border-color'];?>;background-color: #<?php echo $widget_params['adcart-background-color'];?>;color:#<?php echo $widget_params['adcart-text-color'];?> }
			.nw-cart-contents, .nw-cart-drop-content { color:#<?php echo $widget_params['adcart-text-color'];?>; }
			.nw-cart-drop-content a { color:#<?php echo $widget_params['adcart-link-color'];?>; }
			.nw-cart-drop-content a:hover{ color:#<?php echo $widget_params['adcart-link-hover-color'];?>; }
			.icns-adcartfont { color:#<?php echo $widget_params['adcart-icon-color'];?>; }
		</style>
		<?php else : ?>
			<style type="text/css">
				.icns-adcartfont { color:#<?php echo $widget_params['adcart-icon-color'];?>; }
			</style>
		<?php endif;
	}
	public function woocommerce_add_to_cart_variable_rc_callback() {

		ob_start();

		$product_id = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) );
		$quantity = empty( $_POST['quantity'] ) ? 1 : apply_filters( 'woocommerce_stock_amount', $_POST['quantity'] );
		$variation_id = $_POST['variation_id'];
		$variation  = $_POST['variation'];
		$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );

		if ( $passed_validation && WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation  ) ) {
			do_action( 'woocommerce_ajax_added_to_cart', $product_id );
			if ( get_option( 'woocommerce_cart_redirect_after_add' ) == 'yes' ) {
				wc_add_to_cart_message( $product_id );
			}


			WC_AJAX::get_refreshed_fragments();
		} else {
			$this->json_headers();


			$data = array(
				'error' => true,
				'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id )
				);
			echo json_encode( $data );
		}
		die();
	}
	/* public function woocommerce_add_to_cart_single() {
		global $woocommerce;
		$product_id  = intval( $_POST['product_id'] );

		$item_key = "";
		foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $cart_item ) {
			if( $cart_item['product_id'] == $product_id ) {
				$item_key = $cart_item_key;
			}
		}

		$woocommerce->cart->set_quantity( $item_key, 1 );

		$ver = explode(".", WC_VERSION);

		if($ver[0] >= 2 && $ver[1] >= 0 && $ver[2] >= 0) :
			$wc_ajax = new WC_AJAX();
			$wc_ajax->get_refreshed_fragments();
		else :
			woocommerce_get_refreshed_fragments();
		endif;

		wp_die();
	}*/

	public function woocommerce_add_to_cart_single() {
		ob_start();

		$product_id        = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) );
		$quantity          = empty( $_POST['quantity'] ) ? 1 : wc_stock_amount( $_POST['quantity'] );
		$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );
		$product_status    = get_post_status( $product_id );

		if ( $passed_validation && WC()->cart->add_to_cart( $product_id, $quantity ) && 'publish' === $product_status ) {

			do_action( 'woocommerce_ajax_added_to_cart', $product_id );

			if ( get_option( 'woocommerce_cart_redirect_after_add' ) == 'yes' ) {
				wc_add_to_cart_message( $product_id );
			}

			// Return fragments
			$wc_ajax = new WC_AJAX();
			$wc_ajax->get_refreshed_fragments();

		} else {

			// If there was an error adding to the cart, redirect to the product page to show any errors
			$data = array(
				'error'       => true,
				'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id )
			);

			wp_send_json( $data );

		}

		die();
	}

	function pw_show_image_sizes($sizes) {
		    $sizes['nwadcart-thumb'] = __( 'Cart icon', 'netbasecart' );
		    return $sizes;
	}
	function pw_add_image_sizes() {
		    add_image_size( 'nwadcart-thumb', 20, 20, true );
	}
	function nbadcart_widget_shortcode( $atts ) {
		$type = "NB_Widget_Ajax_Drop_Cart";
		// Configure defaults and extract the attributes into variables
		extract( shortcode_atts(
			array(
				'title'  => ''
			),
			$atts
		));

		$args = array(

		);

		ob_start();
		the_widget( $type, $atts, $args );
		$output = ob_get_clean();

		return $output;
	}
	//img
	

	//admin tab
	function nbadcart_admin_tabs( $current = 'homepage' ) {
	    $tabs = array( 'adcart-skin' => 'Skin', 'nbcart-setting' => 'Advanced Setting', 'nbadcart-icons' => 'Icons', 'nbadcart-other' => 'Effect' );
	    //echo '<div id="icon-nwadcart" class="icon32"><br></div>';
	    echo '<h2 class="nav-tab-wrapper">';
	    foreach( $tabs as $tab => $name ){
	        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
	        echo "<a class='nav-tab$class' href='?page=netbasecart-settings&tab=$tab'>$name</a>";
	    }
	    echo '</h2>';
	}
	
	function nbajaxdropcart_create_menu() {

		//create new top-level menu
		$settings_page = add_menu_page('Netbase Addcart Setting', 'Netbase Ajax Cart', 'manage_options', 'netbasecart-settings', array($this,'nbadcart_settings_page'),"");

		add_action( "load-{$settings_page}", array($this,'nbadcart_load_settings_page') );
	}

	function nbadcart_load_settings_page() {
		if ( isset($_POST["nbadcart-settings-submit"]) && $_POST["nbadcart-settings-submit"] == 'Y' ) {
			check_admin_referer( "nbadcart-settings-page" );
			$this->nwadcart_save_plugin_settings();
			$url_parameters = isset($_GET['tab'])? 'updated=true&tab='.$_GET['tab'] : 'updated=true';
			wp_redirect(admin_url('admin.php?page=netbasecart-settings&'.$url_parameters));
			exit;
		}
	}

	function nwadcart_save_plugin_settings() {
		global $pagenow;
		$settings = get_option( "nbadcart_plugin_settings" );

		if ( $pagenow == 'admin.php' && $_GET['page'] == 'netbasecart-settings' ){
			if ( isset ( $_GET['tab'] ) )
		        $tab = $_GET['tab'];
		    else
		        $tab = 'adcart-skin';

		    switch ( $tab ){
		    	
		        case 'adcart-skin' :
					$settings['adcart-skin']	  = $_POST['adcart-skin'];
		        	$settings['adcart-style']	  = $_POST['jform'];
					
					$settings['adcart-text-color']	  = $_POST['adcart-text-color'];
					$settings['adcart-link-color']	  = $_POST['adcart-link-color'];
					$settings['adcart-link-hover-color']	  = $_POST['adcart-link-hover-color'];
					$settings['adcart-button-text-color']	  = $_POST['adcart-button-text-color'];
					$settings['adcart-button-bg-color']	  = $_POST['adcart-button-bg-color'];
					$settings['adcart-button-bghv-color']	  = $_POST['adcart-button-bghv-color'];
					$settings['adcart-background-color']	  = $_POST['adcart-background-color'];
					$settings['adcart-background-border-color']	  = $_POST['adcart-background-border-color'];
					$settings['adcart-border-radius']	  = $_POST['adcart-border-radius'];
				break;
				case 'nbcart-setting' :
					$settings['adcart-windown']	  = $_POST['adcart-windown'];
					$settings['adcart-drop-trigger']	  = $_POST['drop-trigger'];
					$settings['adcart-numsub']      =$_POST['adcart-numsub'];
					$settings['adcart-subtotal']	  = $_POST['adcart-subtotal'];
					$settings['adcart-item-name']	  = $_POST['adcart-item-name'];
					$settings['adcart-item-name-plural']	  = $_POST['adcart-item-name-plural'];
					
					$settings['adcart-icon-position']	  = $_POST['icon-position'];
				break;
				case 'nbadcart-icons' :
					$settings['adcart-icon-display']	  = $_POST['jform-icon-display'];
					$settings['adcart-icon-skin']	  = $_POST['jform-icon'];
					$settings['adcart-icon-style']	  = $_POST['icon-style'];
					if(isset($_POST['product_label_image_id']) && !empty($_POST['product_label_image_id'])) $settings['adcart-custom-icon']	  = $_POST['product_label_image_id'];
					$settings['adcart-icon-color']	  = $_POST['adcart-icon-color'];
				break;
				case 'nbadcart-other' :
					$settings['adcart-display-cart']	  = $_POST['display-cart'];
				break;
		    }
		}

		$updated = update_option( "nbadcart_plugin_settings", $settings );
	}

	function nbadcart_settings_page() {
		global $pagenow;
	    $settings = get_option( "nbadcart_plugin_settings" );

	    ?>
	    <div class="wrap adcart">
	    <?php
	    	if ( isset ( $_GET['tab'] ) ) $this->nbadcart_admin_tabs($_GET['tab']); else $this->nbadcart_admin_tabs('adcart-skin');

	    	if ( isset ( $_GET['tab'] ) ) $tab = $_GET['tab'];
			else $tab = 'adcart-skin';
		?>
	
			<form id="myform" method="post" action="<?php admin_url( 'admin.php?page=netbasecart-settings' ); ?>" enctype="multipart/form-data">
				<table class="form-table">

				<?php wp_nonce_field( "nbadcart-settings-page" );

					if ( $pagenow == 'admin.php' && $_GET['page'] == 'netbasecart-settings' ){

						 switch ( $tab ){

							 case'adcart-skin':

							 	 ?>
							 	 <tr>
							 	 	<th><?php echo esc_html__(  "Select style","netbasecart");?> </th>
							 	 	<td>
							 	 		<fieldset name="check-style" id="jform_params_use_skin" class="radio ">
											<input type="radio" id="jform_params_use_skin0" name="jform" <?php echo ($settings['adcart-style']=='skil') ? " checked='checked'": "";?>value="skil">  <?php echo esc_html__(  "Available style","netbasecart");?>
										
											<input type="radio" id="jform_params_use_skin1" name="jform"<?php echo ($settings['adcart-style']=='cus') ? " checked='checked'": "";?>value="cus"> <?php echo esc_html__(  "Custom color","netbasecart");?>
										</fieldset>
									
							 	 	</td>
							 	 </tr>
						         <tr id="desc" class="skin-skil">
						            <th> <?php echo esc_html__(  "Select skin","netbasecart");?></th>
						            <td>
						               <select name="adcart-skin" id="adcart-skin">
						               		<option <?php echo ($settings['adcart-skin']=='pink') ? " selected='selected'": "";?>value="pink"><?php echo esc_html__(  "Pink","netbasecart");?></option>  
						               		<option <?php echo ($settings['adcart-skin']=='dark') ? " selected='selected'": "";?>value="dark"><?php echo esc_html__(  "Dark","netbasecart");?></option>
						               		<option <?php echo ($settings['adcart-skin']=='blue') ? " selected='selected'": "";?>value="blue"><?php echo esc_html__(  "Blue","netbasecart");?></option>
						               		<option <?php echo ($settings['adcart-skin']=='red') ? " selected='selected'": "";?>value="red"><?php echo esc_html__(  "Red","netbasecart");?></option>
						               		<option <?php echo ($settings['adcart-skin']=='orange') ? " selected='selected'": "";?>value="orange"><?php echo esc_html__(  "Orange","netbasecart");?></option>

						               		
						               </select>
						            </td>
						         </tr>
								 
						         <tr class="skin-cus" id="desc">
						            <th><?php echo esc_html__(  "Text color","netbasecart");?> </th>
						            <td>
						               <div id="colorSelector-t" class="colorSelector"><div></div></div>
						               <input type="hidden" name="adcart-text-color" id="colorSelVal-t" value="<?php echo $settings['adcart-text-color'];?>"/>
						               <script type="text/javascript">
							               jQuery('#colorSelector-t').ColorPicker({
												color: '#<?php echo $settings['adcart-text-color'];?>',
												onShow: function (colpkr) {
													jQuery(colpkr).fadeIn(500);
													return false;
												},
												onHide: function (colpkr) {
													jQuery(colpkr).fadeOut(500);
													return false;
												},
												onChange: function (hsb, hex, rgb) {
													jQuery('#colorSelector-t div').css('backgroundColor', '#' + hex);
													jQuery('#colorSelVal-t').val(hex);
												}
											});
											jQuery('#colorSelector-t div').css('background-color','#<?php echo $settings['adcart-text-color'];?>');
											jQuery('#colorSelVal-t').val('<?php echo $settings['adcart-text-color'];?>');
						               </script>
						            </td>
						         </tr>
						         <tr class="skin-cus" id="desc">
						            <th> <?php echo esc_html__(  "Link color","netbasecart");?></th>
						            <td>
						               <div id="colorSelector-l" class="colorSelector"><div></div></div>
						               <input type="hidden" name="adcart-link-color" id="colorSelVal-l" value="<?php echo $settings['adcart-link-color'];?>"/>
						               <script type="text/javascript">
							               jQuery('#colorSelector-l').ColorPicker({
												color: '#<?php echo $settings['adcart-link-color'];?>',
												onShow: function (colpkr) {
													jQuery(colpkr).fadeIn(500);
													return false;
												},
												onHide: function (colpkr) {
													jQuery(colpkr).fadeOut(500);
													return false;
												},
												onChange: function (hsb, hex, rgb) {
													jQuery('#colorSelector-l div').css('backgroundColor', '#' + hex);
													jQuery('#colorSelVal-l').val(hex);
												}
											});
											jQuery('#colorSelector-l div').css('background-color','#<?php echo $settings['adcart-link-color'];?>');
											jQuery('#colorSelVal-l').val('<?php echo $settings['adcart-link-color'];?>');
						               </script>
						            </td>
						         </tr>
						         <tr class="skin-cus" id="desc">
						            <th> <?php echo esc_html__(  "Link hover color","netbasecart");?></th>
						            <td>
						               <div id="colorSelector-2" class="colorSelector"><div></div></div>
						               <input type="hidden" name="adcart-link-hover-color" id="colorSelVal-2" value="<?php echo $settings['adcart-link-hover-color'];?>"/>
						               <script type="text/javascript">
							               jQuery('#colorSelector-2').ColorPicker({
												color: '#<?php echo $settings['adcart-link-hover-color'];?>',
												onShow: function (colpkr) {
													jQuery(colpkr).fadeIn(500);
													return false;
												},
												onHide: function (colpkr) {
													jQuery(colpkr).fadeOut(500);
													return false;
												},
												onChange: function (hsb, hex, rgb) {
													jQuery('#colorSelector-2 div').css('backgroundColor', '#' + hex);
													jQuery('#colorSelVal-2').val(hex);
												}
											});
											jQuery('#colorSelector-2 div').css('background-color','#<?php echo $settings['adcart-link-hover-color'];?>');
											jQuery('#colorSelVal-2').val('<?php echo $settings['adcart-link-hover-color'];?>');
						               </script>
						            </td>
						         </tr>
						         <tr class="skin-cus" id="desc">
						            <th> <?php echo esc_html__(  "Button text color","netbasecart");?></th>
						            <td>
						               <div id="colorSelector-btc" class="colorSelector"><div></div></div>
						               <input type="hidden" name="adcart-button-text-color" id="colorSelVal-btc" value="<?php echo $settings['adcart-button-text-color'];?>"/>
						               <script type="text/javascript">
							               jQuery('#colorSelector-btc').ColorPicker({
												color: '#<?php echo $settings['adcart-button-text-color'];?>',
												onShow: function (colpkr) {
													jQuery(colpkr).fadeIn(500);
													return false;
												},
												onHide: function (colpkr) {
													jQuery(colpkr).fadeOut(500);
													return false;
												},
												onChange: function (hsb, hex, rgb) {
													jQuery('#colorSelector-btc div').css('backgroundColor', '#' + hex);
													jQuery('#colorSelVal-btc').val(hex);
												}
											});
											jQuery('#colorSelector-btc div').css('background-color','#<?php echo $settings['adcart-button-text-color'];?>');
											jQuery('#colorSelVal-btc').val('<?php echo $settings['adcart-button-text-color'];?>');
						               </script>
						            </td>
						         </tr>
						         <tr class="skin-cus" id="desc">
						            <th> <?php echo esc_html__(  "Button background color","netbasecart");?> </th>
						            <td>
						               <div id="colorSelector-btbg" class="colorSelector"><div></div></div>
						               <input type="hidden" name="adcart-button-bg-color" id="colorSelVal-btbg" value="<?php echo $settings['adcart-button-bg-color'];?>"/>
						               <script type="text/javascript">
							               jQuery('#colorSelector-btbg').ColorPicker({
												color: '#<?php echo $settings['adcart-button-bg-color'];?>',
												onShow: function (colpkr) {
													jQuery(colpkr).fadeIn(500);
													return false;
												},
												onHide: function (colpkr) {
													jQuery(colpkr).fadeOut(500);
													return false;
												},
												onChange: function (hsb, hex, rgb) {
													jQuery('#colorSelector-btbg div').css('backgroundColor', '#' + hex);
													jQuery('#colorSelVal-btbg').val(hex);
												}
											});
											jQuery('#colorSelector-btbg div').css('background-color','#<?php echo $settings['adcart-button-bg-color'];?>');
											jQuery('#colorSelVal-btbg').val('<?php echo $settings['adcart-button-bg-color'];?>');
						               </script>
						            </td>
						         </tr>
						         <tr class="skin-cus" id="desc">
						            <th> <?php echo esc_html__(  "Button background hover color","netbasecart");?></th>
						            <td>
						               <div id="colorSelector-btbg-hover" class="colorSelector"><div></div></div>
						               <input type="hidden" name="adcart-button-bghv-color" id="colorSelVal-btbg-hover" value="<?php echo $settings['adcart-button-bghv-color'];?>"/>
						               <script type="text/javascript">
							               jQuery('#colorSelector-btbg-hover').ColorPicker({
												color: '#<?php echo $settings['adcart-button-bghv-color'];?>',
												onShow: function (colpkr) {
													jQuery(colpkr).fadeIn(500);
													return false;
												},
												onHide: function (colpkr) {
													jQuery(colpkr).fadeOut(500);
													return false;
												},
												onChange: function (hsb, hex, rgb) {
													jQuery('#colorSelector-btbg-hover div').css('backgroundColor', '#' + hex);
													jQuery('#colorSelVal-btbg-hover').val(hex);
												}
											});
											jQuery('#colorSelector-btbg-hover div').css('background-color','#<?php echo $settings['adcart-button-bghv-color'];?>');
											jQuery('#colorSelVal-btbg-hover').val('<?php echo $settings['adcart-button-bghv-color'];?>');
						               </script>
						            </td>
						         </tr>
						         <tr class="skin-cus" id="desc">
						            <th> <?php echo esc_html__(  "Background color","netbasecart");?> </th>
						            <td>
						               <div id="colorSelector-dc" class="colorSelector"><div></div></div>
						               <input type="hidden" name="adcart-background-color" id="colorSelVal-dc" value="<?php echo $settings['adcart-background-color'];?>"/>
						               <script type="text/javascript">
							               jQuery('#colorSelector-dc').ColorPicker({
												color: '#<?php echo $settings['adcart-background-color'];?>',
												onShow: function (colpkr) {
													jQuery(colpkr).fadeIn(500);
													return false;
												},
												onHide: function (colpkr) {
													jQuery(colpkr).fadeOut(500);
													return false;
												},
												onChange: function (hsb, hex, rgb) {
													jQuery('#colorSelector-dc div').css('backgroundColor', '#' + hex);
													jQuery('#colorSelVal-dc').val(hex);
												}
											});
											jQuery('#colorSelector-dc div').css('background-color','#<?php echo $settings['adcart-background-color'];?>');
											jQuery('#colorSelVal-dc').val('<?php echo $settings['adcart-background-color'];?>');
						               </script>
						            </td>
						         </tr>
						         <tr class="skin-cus" id="desc">
						            <th> <?php echo esc_html__(  "Border color","netbasecart");?></th>
						            <td>
						               <div id="colorSelector-dbc" class="colorSelector"><div></div></div>
						               <input type="hidden" name="adcart-background-border-color" id="colorSelVal-dbc" value="<?php echo $settings['adcart-background-border-color'];?>"/>
						               <script type="text/javascript">
							               jQuery('#colorSelector-dbc').ColorPicker({
												color: '#<?php echo $settings['adcart-background-border-color'];?>',
												onShow: function (colpkr) {
													jQuery(colpkr).fadeIn(500);
													return false;
												},
												onHide: function (colpkr) {
													jQuery(colpkr).fadeOut(500);
													return false;
												},
												onChange: function (hsb, hex, rgb) {
													jQuery('#colorSelector-dbc div').css('backgroundColor', '#' + hex);
													jQuery('#colorSelVal-dbc').val(hex);
												}
											});
											jQuery('#colorSelector-dbc div').css('background-color','#<?php echo $settings['adcart-background-border-color'];?>');
											jQuery('#colorSelVal-dbc').val('<?php echo $settings['adcart-background-border-color'];?>');
						               </script>
						            </td>
						         </tr>
						         <tr class="skin-cus" id="desc">
						            <th> <?php echo esc_html__(  "Border radius","netbasecart");?></th>
						            <td>
						              <div id="radiusSlider"></div>
						              <input type="hidden" name="adcart-border-radius" value="<?php echo $settings['adcart-border-radius'];?>" id="radiusVal"/>
						              <span id="radiusSliderVal">0</span>px
						              <script type="text/javascript">

							              jQuery(function() {
										    jQuery( "#radiusSlider" ).slider({
											    step:1,
											    value: <?php echo ($settings['adcart-border-radius']) ? $settings['adcart-border-radius'] : '0' ;?>,
											    maxvalue:50,
											    slide: function( event, ui ) {

												   jQuery('#radiusSliderVal').text(ui.value);
												   jQuery('#radiusVal').val(ui.value);
											    }
										    });

										    jQuery('#radiusSliderVal').text(<?php echo $settings['adcart-border-radius'];?>);

										  });

						              </script>
						            </td>
						         </tr>
						         <?php

							 break;
							 case'nbcart-setting':

							 	 ?>
							 	 <tr>
						            <th><?php echo esc_html__(  "Select dropdown action ","netbasecart");?></th>
						            <td>
						               <select name="drop-trigger" id="drop-trigger">
						               		<option <?php echo (isset($settings['adcart-drop-trigger']) && $settings['adcart-drop-trigger']=='click') ? " selected='selected'": "";?>value="click"><?php echo esc_html__(  "Click","netbasecart");?></option>           								  
						               		<option <?php echo (isset($settings['adcart-drop-trigger']) && $settings['adcart-drop-trigger']=='hover') ? " selected='selected'": "";?>value="hover"><?php echo esc_html__(  "Hover","netbasecart");?></option>
						               </select>
						       
						            </td>
						         </tr>
							 	 
						         <tr>
						            <th> <?php echo esc_html__(  "Show cart style","netbasecart");?></th>
						            <td>
						               <input type="radio" name="adcart-numsub" <?php echo ($settings['adcart-numsub']=="sub") ? "checked='checked'": "sub" ;?> value="sub"/>&nbsp;<?php echo esc_html__(  "Show quantity & subtotal","netbasecart");?>
						               <input type="radio" name="adcart-numsub" <?php echo ($settings['adcart-numsub']=="num") ? "checked='checked'": "" ;?> value="num"/>&nbsp; <?php echo esc_html__(  "Only quantity","netbasecart");?>
						               
						            </td>
						         </tr>
						         <tr class="icon-pos">
						            <th> <?php echo esc_html__(  "Icon position","netbasecart");?></th>
						            <td>
						               <select name="icon-position" id="icon-position">
						               		<option <?php echo (isset($settings['adcart-icon-position']) &&  $settings['adcart-icon-position']=='left') ? " selected='selected'": "";?>value="left"><?php echo esc_html__(  "Left","netbasecart");?></option>           								            <option <?php echo (isset($settings['adcart-icon-position']) && $settings['adcart-icon-position']=='right') ? " selected='selected'": "";?>value="right"><?php echo esc_html__(  "Right","netbasecart");?></option>
						               </select>
						            </td>
						         </tr>
						         

						         <tr class="icon-pos">
						            <th> <?php echo esc_html__(  "Item name","netbasecart");?></th>
						            <td>

						              <input type="text" name="adcart-item-name" value="<?php echo $settings['adcart-item-name'];?>"/>

						            </td>
						         </tr>

						         <tr class="icon-pos">
						            <th> <?php echo esc_html__(  "Item name plural","netbasecart");?></th>
						            <td>

						              <input type="text" name="adcart-item-name-plural" value="<?php echo $settings['adcart-item-name-plural'];?>"/>

						            </td>
						         </tr>
						         
								<tr>
						            <th><?php echo esc_html__(  "Show subtotal","netbasecart");?> </th>
						            <td>
						               <input type="radio" <?php echo ($settings['adcart-subtotal']==1) ? "checked='checked'": "" ;?>name="adcart-subtotal" value="1"/>&nbsp;<?php echo esc_html__(  "Yes","netbasecart");?>
						               &nbsp;&nbsp;
						               <input type="radio" <?php echo ($settings['adcart-subtotal']==0) ? "checked='checked'": "" ;?>name="adcart-subtotal" value="0"/>&nbsp;<?php echo esc_html__(  "No","netbasecart");?>
						            </td>
						         </tr>
						         <?php

							 break;
							 case'nbadcart-icons':

							 	 ?>
							 	 <tr>
							 	 	<th> <?php echo esc_html__(  "Cart icon","netbasecart");?></th>
							 	 	<td>
									 	 <fieldset id="jform_display_icon" class="radio ">
											<input type="radio" id="display-icon" name="jform-icon-display" <?php echo ($settings['adcart-icon-display']=='show') ? " checked='checked'": "";?>value="show"> <?php echo esc_html__(  "Show","netbasecart");?>
										
											<input type="radio" id="display-icon" name="jform-icon-display" <?php echo ($settings['adcart-icon-display']=='hide') ? " checked='checked'": "";?>value="hide"> <?php echo esc_html__(  "Hide","netbasecart");?>
										</fieldset>
									</td>
								</tr>
							 	 <tr class="icon-display-show">
							 	 	<th> <?php echo esc_html__(  "Icon style","netbasecart");?></th>
							 	 	<td>
									 	 <fieldset id="jform_use_icon" class="radio ">
											<input type="radio" id="use-icon" name="jform-icon" <?php echo ($settings['adcart-icon-skin']=='1') ? " checked='checked'": "";?>value="1"> <?php echo esc_html__(  "Use icon","netbasecart");?>
										
											<input type="radio" id="use-icon" name="jform-icon" <?php echo ($settings['adcart-icon-skin']=='0') ? " checked='checked'": "";?>value="0"> <?php echo esc_html__(  "Use image","netbasecart");?>
										</fieldset>
									</td>
								</tr>
						         <tr class="icon-set icon-display-show" id="icon-1">
						            <th><?php echo esc_html__(  "Icon skin ","netbasecart");?></th>
						            <td>
						               <ul class="list-icons">
						               <?php foreach($this->icon_styles as $key=>$icon_style) :
							               if($settings['adcart-icon-style']==$key) $cls = 'activei';
							               else $cls='';
						               ?>
						               	<li class="<?php echo $cls;?>">
						               		<div class="icon-adcartfont icon-<?php echo $icon_style;?>"></div>
						               		<input type="radio" name="icon-style" value="<?php echo $key;?>" style="display:none;"<?php echo ($settings['adcart-icon-style']==$key+1) ? " checked='checked'": "" ;?> />
						               	</li>
						               	<?php endforeach;?>
						               </ul>
						            </td>
						         </tr>
						         <tr class="icon-set icon-display-show" id="icon-1">
						            <th> <?php echo esc_html__(  "Icon color","netbasecart");?></th>
						            <td>
						               <div id="colorSelector-i" class="colorSelector"><div></div></div>
						               <input type="hidden" name="adcart-icon-color" id="colorSelVal-i" value="<?php echo $settings['adcart-icon-color'];?>"/>
						               <script type="text/javascript">
							               jQuery('#colorSelector-i').ColorPicker({
												color: '#<?php echo $settings['adcart-icon-color'];?>',
												onShow: function (colpkr) {
													jQuery(colpkr).fadeIn(500);
													return false;
												},
												onHide: function (colpkr) {
													jQuery(colpkr).fadeOut(500);
													return false;
												},
												onChange: function (hsb, hex, rgb) {
													jQuery('#colorSelector-i div').css('backgroundColor', '#' + hex);
													jQuery('#colorSelVal-i').val(hex);
												}
											});
											jQuery('#colorSelector-i div').css('background-color','#<?php echo $settings['adcart-icon-color'];?>');
											jQuery('#colorSelVal-i').val('<?php echo $settings['adcart-icon-color'];?>');
						               </script>
						            </td>
						         </tr>
						         <tr valign="top" class="icon-set icon-display-show" id="icon-0">
									 <th scope="row"> <?php echo esc_html__(  "Custom icon image","netbasecart");?>
									 <i style="font-size:10px; display: table;"><?php echo esc_html__(  "(preferred size 20x20.)","netbasecart");?></i></th>
									 
									 <td>

									 	<div id="product_label_image_field" class="form-field">
										<label><?php _e( 'Image', 'netbasecart' ); ?></label>
											
											<div id="product_label_image" style="float:left;margin-right:10px;">
												<?php
												 if($settings['adcart-custom-icon'] && file_exists(ABSPATH.str_replace(get_site_url()."/","",$settings['adcart-custom-icon']))) :?>
												
										
												 	<img width="60" height="60" src="<?php echo $settings['adcart-custom-icon'];?>"/>
												 <br/>
												<?php else: ?>
													<img src="<?php echo woocommerce_placeholder_img_src(); ?>" width="60" height='60'/>
												 <?php endif;?>
												

											</div>
											<div style="line-height:60px;">

												<input type="hidden" id="product_label_image_id" name="product_label_image_id" />
												<button type="submit" class="upload_image_button button"><?php echo esc_html__(  "Upload/Add image","netbasecart");?></button>
												<button type="submit" class="remove_image_button button"><?php echo esc_html__(  "Remove image","netbasecart");?></button>
											</div>
											<script type="text/javascript">
											
												if ( ! jQuery('#product_label_image_id').val() )
													 jQuery('.remove_image_button').hide();
										
												var file_frame;
										
												jQuery(document).on( 'click', '.upload_image_button', function( event ){	
													event.preventDefault();
													
													if ( file_frame ) {
														file_frame.open();
														return;
													}	
													
													file_frame = wp.media.frames.downloadable_file = wp.media({
														title: '<?php _e( 'Choose an image', 'netbasecart' ); ?>',
														button: {
															text: '<?php _e( 'Use image', 'netbasecart' ); ?>',
														},
														multiple: false
													});	
													
													file_frame.on( 'select', function() {
														attachment = file_frame.state().get('selection').first().toJSON();	
														jQuery('#product_label_image_id').val( attachment.url );
														jQuery('#product_label_image img').attr('src', attachment.url );
														jQuery('.remove_image_button').show();
													});	
													
													file_frame.open();
												});
										
												jQuery(document).on( 'click', '.remove_image_button', function( event ){
													jQuery('#product_label_image img').attr('src', '<?php echo woocommerce_placeholder_img_src(); ?>');
													jQuery('#product_label_image_id').val('');
													jQuery('.remove_image_button').hide();
													return false;
												});
										
											</script>
											<div class="clear"></div>
										</div>	
										
									 </td>
								 </tr>

						         <?php

							 break;
							 case'nbadcart-other':
							 ?>
							 	<tr>
						            <th> <?php echo esc_html__(  "Settings comming soon !!","netbasecart");?></th>
						            <td>
						               
						            </td>
						         </tr>
						         
							 <?php
							 break;

						 }
					}

				?>
				</table>
					<p class="submit">
	                    <input type="submit" class="button-primary" value="<?php _e('Save Changes','netbasecart') ?>" />
	                    <input type="hidden" name="nbadcart-settings-submit" value="Y"/>
	                </p>

				</form>
			</div>

		<?php


	}

	public function woocommerce_ajax_remove_from_cart() {
		global $woocommerce;

		$woocommerce->cart->set_quantity( $_POST['remove_item'], 0 );

		$ver = explode(".", WC_VERSION);

		if($ver[0] >= 2 && $ver[1] >= 0 && $ver[2] >= 0) :
			$wc_ajax = new WC_AJAX();
			$wc_ajax->get_refreshed_fragments();
		else :
			woocommerce_get_refreshed_fragments();
		endif;

		die();
	}

	/**
	 * Checks WooCommerce Installation
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function woostore_check_environment() {
		if (!class_exists('woocommerce')) wp_die(__('WooCommerce must be installed', 'oxfordshire'));
	}

	/**
	 * Enqueue plugin style-files
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function netbase_drop_cart_stylesheets() {
		// Respects SSL, Style.css is relative to the current file
        wp_register_style( 'netbase-style', plugins_url('assets/css/style.css', dirname(__FILE__)) );

        wp_register_style( 'netbase-style-dark', plugins_url('assets/css/style-dark.css', dirname(__FILE__)), 'netbase-style' );
        wp_register_style( 'netbase-style-pink', plugins_url('assets/css/style-pink.css', dirname(__FILE__)), 'netbase-style' );
        wp_register_style( 'netbase-style-red', plugins_url('assets/css/style-red.css', dirname(__FILE__)), 'netbase-style' );
        wp_register_style( 'netbase-style-orange', plugins_url('assets/css/style-orange.css', dirname(__FILE__)), 'netbase-style' );
        wp_register_style( 'netbase-style-blue', plugins_url('assets/css/style-blue.css', dirname(__FILE__)), 'netbase-style' );
        
        wp_enqueue_style( 'netbase-style' );

	    if($this->settings['adcart-style'] == "cus"){
	    	wp_enqueue_style( 'netbase-style-custom' );
	    }else{
	    	switch($this->settings['adcart-skin']) {
		        case'pink':
		        	wp_enqueue_style( 'netbase-style-pink' );
		        break;
		        case'dark':
		        	wp_enqueue_style( 'netbase-style-dark' );
		        break;
		        case'blue':
		        	wp_enqueue_style( 'netbase-style-blue' );
		        break;
		        case'orange':
		        	wp_enqueue_style( 'netbase-style-orange' );
		        break;
		        case'red':
		        	wp_enqueue_style( 'netbase-style-red' );
		        break;
		    }
        
	    }
	}

	/**
	 * Enqueue plugin style-files for admin
	 *
	 * @since 1.0.0
	 * @access public
	 */
	function netbase_drop_cart_admin_stylesheets() {
		if(strstr($_SERVER['REQUEST_URI'], 'netbasecart-settings')) {
	        wp_register_style( 'netbase-style', plugins_url('admin/assets/css/style.css', dirname(__FILE__)) );
	        wp_register_style( 'netbase-style-colorpicker', plugins_url('admin/lib/colorpicker/css/colorpicker.css', dirname(__FILE__)) );
	        wp_register_style( 'netbase-style-colorpicker-layout', plugins_url('admin/lib/colorpicker/css/layout.css', dirname(__FILE__)), 'netbase-style-colorpicker');
	        wp_register_style( 'netbase-style-jquery-ui', "http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" );

	        //wp_enqueue_style('thickbox');
	        wp_enqueue_style( 'netbase-style-jquery-ui' );
	        wp_enqueue_style( 'netbase-style' );
	        wp_enqueue_style( 'netbase-style-colorpicker' );
	        wp_enqueue_style( 'netbase-style-colorpicker-layout');
        }
	}

	/**
	 * Enqueue plugin javascript-files for admin
	 *
	 * @since 1.0.0
	 * @access public
	 */
	function nw_drop_cart_admin_scripts() {
		global $woocommerce;
		
		if(strstr($_SERVER['REQUEST_URI'], 'netbasecart-settings')) {
			if( version_compare( $woocommerce->version, '3.0', ">=" ) ) {
				wp_register_script( 'netbase-scripts', plugins_url('admin/assets/js/wc-ui.js', dirname(__FILE__)), array('jquery','media-upload',) );
			}else{
				wp_register_script( 'netbase-scripts', plugins_url('admin/assets/js/ui.js', dirname(__FILE__)), array('jquery','media-upload',) );
			}
	        wp_register_script( 'netbase-scripts-colorpicker', plugins_url('admin/lib/colorpicker/js/colorpicker.js', dirname(__FILE__)) );

	        wp_register_script( 'jquery-ui', 'http://code.jquery.com/ui/1.10.3/jquery-ui.js', 'jquery', '', true );
	        wp_enqueue_script('media-upload');
			//wp_enqueue_script('thickbox');

			wp_enqueue_script( 'jquery-ui' );

	        wp_enqueue_script( 'netbase-scripts' );
	        wp_enqueue_script( 'netbase-scripts-colorpicker' );
        }
	}

	/**
	 * Enqueue plugin javascript-files
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function netbase_drop_cart_scripts() {
		global $woocommerce;

		wp_enqueue_script("jquery");
		wp_enqueue_script( "jquery-effects-core" );
		
		if( version_compare( $woocommerce->version, '3.0', ">=" ) ) {
			wp_register_script( 'netbase-scripts', plugins_url('assets/js/wc-ui.js', dirname(__FILE__)) );
			wp_enqueue_script( 'netbase-scripts', plugins_url('assets/js/wc-ui.js', dirname(__FILE__)), array('jquery','jquery-effects-core') );
		}else{
			wp_register_script( 'netbase-scripts', plugins_url('assets/js/ui.js', dirname(__FILE__)) );
			wp_enqueue_script( 'netbase-scripts', plugins_url('assets/js/ui.js', dirname(__FILE__)), array('jquery','jquery-effects-core') );
		}

	    //wp_register_script( 'netbase-scripts', plugins_url('assets/js/fly.js', dirname(__FILE__)) );
	}

	/**
	 * register_widgets function.
	 *
	 * @access public
	 * @return void
	 */
	// public function register_widgets() {
	// 	include(NB_AJAX_DROP_CART_PATH . "includes/class-nw-ajax-drop-cart-widget.php");

	// 	register_widget( 'NB_Widget_Ajax_Drop_Cart' );
	// }
	
	function woocommerce_header_add_to_cart_fragment( $fragments ) {
		global $woocommerce;

		$cart_contents_count = 0;
		$show_only_individual = false;
		$settings = get_option( "nbadcart_plugin_settings" );
		foreach($woocommerce->cart->cart_contents as $key => $product) {

			if($show_only_individual) {
				if($product['data']->is_type('simple') && !isset($product['bundled_by']) ) $cart_contents_count++;
				if($product['data']->is_type('bundle')) $cart_contents_count++;
				if($product['data']->is_type('variation')) $cart_contents_count++;
			}else {
				if($product['data']->is_type('simple') && !isset($product['bundled_by']) ) $cart_contents_count += $product['quantity'] ;
				if($product['data']->is_type('bundle')) $cart_contents_count += $product['quantity'];
				if($product['data']->is_type('variation')) $cart_contents_count += $product['quantity'];
			}

		}

		ob_start();

		include_once( NB_ADCart::get_template_path('summary') );

		$fragments['div.nw-cart-contents'] = ob_get_clean();

		ob_start();

		include_once( NB_ADCart::get_template_path('mini-cart') );

		$fragments['div.nw-cart-drop-content-in'] = ob_get_clean();

		return $fragments;

	}

	/**
	 * get template path for everriding
	 * @param  string $filename template file name
	 * @return string           template file full path
	 */
	public static function get_template_path($filename) {

		if ( $overridden_template = locate_template( 'woocommerce-netbase-adcart/cart/'.$filename.'.php' ) ) {
		   // locate_template() returns path to file
		   // if either the child theme or the parent theme have overridden the template
		   $template_file = $overridden_template;
		 } else {
		   // If neither the child nor parent theme have overridden the template,
		   // we load the template from the 'templates' sub-directory of the directory this file is in
		   $template_file = NB_AJAX_DROP_CART_PATH.'templates/'.$filename.'.php';
		 }

		return $template_file;
	}


}

endif;