<?php 
/*
Plugin Name: Netbase Printshop Widgets for SiteOrigin
Plugin URI: https://cmsmart.net
Description: Netbase Widgets for SiteOrigin Page Builder.
Author: Netbaseteam
Version: 2.2.1
Text Domain:Custom widget activator
Domain Path: /languages
Author URI: https://cmsmart.net
*/
if ( ! defined( 'ABSPATH' ) )
{
	exit;   
}	
function wpnetbase_so_widgets_bundle($folders){
	$folders[] = plugin_dir_path(__FILE__).'extra-widgets/';
	return $folders;
}
add_filter('siteorigin_widgets_widget_folders', 'wpnetbase_so_widgets_bundle');

function wpnetbase_tab_thumb() {
	add_image_size( 'wpnetbase-tab-thumb', 360, 285, array('center', 'center') );	
}
add_action( 'after_setup_theme', 'wpnetbase_tab_thumb' );

function wpnetbase_create_shortcode_postloop($atts) {
	ob_start();
	extract( shortcode_atts( array (
		'category' => ''
	), $atts ) );
	$loop_args = array(
		'post_type' => 'post',
		'posts_per_page' => 6,
		'category_name' => $category,
		'ignore_sticky_posts' => 1
	);
	$loop_query = new WP_Query( $loop_args );
	if ( $loop_query->have_posts() ): ?>
		<?php while ( $loop_query->have_posts() ) : $loop_query->the_post(); ?>
			<div class="col-md-4 col-sm-6 col-xs-12 block-recent">
				<div class="w-block-recent">
					<div class="image-recent">
						<?php
						if( has_post_thumbnail( ) ) {
							the_post_thumbnail( 'wpnetbase-tab-thumb' );
						}
						?>
					</div>
					<div class="info-recent">
						<h3 class="title"><?php the_title(); ?></h3>
						<?php
						if ( has_excerpt() ){
							echo '<div class="text-recent"><p>';
							echo wp_trim_words( get_the_excerpt(), 30, '...' ); 
							echo '</p></div>';
						}
						?>						
						<a href="<?php the_permalink(); ?>" class="read-more"><?php esc_html_e('read more', 'wpnetbase'); ?></a>
					</div>
				</div>
			</div>
		<?php endwhile;
		wp_reset_postdata();
	endif;
	$myvariable = ob_get_clean();
	return $myvariable;
}
add_shortcode( 'netbase-post-loop', 'wpnetbase_create_shortcode_postloop' );

/**
* Check if WooCommerce is active
**/
if ( ! function_exists( 'is_plugin_active' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}
function wpnetbase_install_woocommerce_admin_notice() {
	?>
	<div class="error">
		<p><?php _e( 'Netbase widget is enabled but not effective. It requires WooCommerce in order to work.', 'wpnetbase' ); ?></p>
	</div>
	<?php
}
function wpnetbase_wg_install() {

	if ( ! function_exists( 'WC' ) ) {
		add_action( 'admin_notices', 'wpnetbase_install_woocommerce_admin_notice' );
	}
	
}
add_action( 'plugins_loaded', 'wpnetbase_wg_install', 11 ); 
 
/**
	 * WC_List_Grid class
	 **/
	if ( ! class_exists( 'WC_List_Grid' ) ) {

		class WC_List_Grid {

			public function __construct() {
				// Hooks
  				add_action( 'wp' , array( $this, 'setup_gridlist' ) , 20);

  				// Init settings
				$this->settings = array(
					array(
						'name' 	=> __( 'Default catalog view', 'woocommerce-grid-list-toggle' ),
						'type' 	=> 'title',
						'id' 	=> 'wc_glt_options'
					),
					array(
						'name' 		=> __( 'Default catalog view', 'woocommerce-grid-list-toggle' ),
						'desc_tip' 	=> __( 'Display products in grid or list view by default', 'woocommerce-grid-list-toggle' ),
						'id' 		=> 'wc_glt_default',
						'type' 		=> 'select',
						'options' 	=> array(
							'grid'  => __( 'Grid', 'woocommerce-grid-list-toggle' ),
							'list' 	=> __( 'List', 'woocommerce-grid-list-toggle' )
						)
					),
					array( 'type' => 'sectionend', 'id' => 'wc_glt_options' ),
				);

				// Default options
				add_option( 'wc_glt_default', 'grid' );

				// Admin
				add_action( 'woocommerce_settings_image_options_after', array( $this, 'admin_settings' ), 20 );
				add_action( 'woocommerce_update_options_catalog', array( $this, 'save_admin_settings' ) );
				add_action( 'woocommerce_update_options_products', array( $this, 'save_admin_settings' ) );
			}

			/*-----------------------------------------------------------------------------------*/
			/* Class Functions */
			/*-----------------------------------------------------------------------------------*/

			function admin_settings() {
				woocommerce_admin_fields( $this->settings );
			}

			function save_admin_settings() {
				woocommerce_update_options( $this->settings );
			}

			// Setup
			function setup_gridlist() {
				if ( is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy() ) {
					add_action( 'wp_enqueue_scripts', array( $this, 'setup_scripts_styles' ), 20);
					add_action( 'wp_enqueue_scripts', array( $this, 'setup_scripts_script' ), 20);
					add_action( 'woocommerce_before_shop_loop', array( $this, 'gridlist_toggle_button' ), 1);
					add_action( 'woocommerce_after_shop_loop_item', array( $this, 'gridlist_buttonwrap_open' ), 9);
					add_action( 'woocommerce_after_shop_loop_item', array( $this, 'gridlist_buttonwrap_close' ), 11);
					add_action( 'woocommerce_after_shop_loop_item', array( $this, 'gridlist_hr' ), 30);
					add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_single_excerpt', 5);
					add_action( 'woocommerce_after_subcategory', array( $this, 'gridlist_cat_desc' ) );
				}
			}

			// Scripts & styles
			function setup_scripts_styles() {							
				wp_enqueue_style( 'dashicons' );
			}

			function setup_scripts_script() {
				wp_enqueue_script( 'cookie', plugins_url( '/assests/js/jquery.cookie.min.js', __FILE__ ), array( 'jquery' ) );
				wp_enqueue_script( 'grid-list-scripts', plugins_url( '/assests/js/jquery.gridlistview.min.js', __FILE__ ), array( 'jquery' ) );
				add_action( 'wp_footer', array( $this, 'gridlist_set_default_view' ) );
			}

			// Toggle button
			function gridlist_toggle_button() {
				?>
					<nav class="gridlist-toggle">
						<a href="#" id="grid" title="<?php _e('Grid view', 'woocommerce-grid-list-toggle'); ?>"><span class="dashicons dashicons-grid-view"></span> <em><?php _e( 'Grid view', 'woocommerce-grid-list-toggle' ); ?></em></a><a href="#" id="list" title="<?php _e('List view', 'woocommerce-grid-list-toggle'); ?>"><span class="dashicons dashicons-exerpt-view"></span> <em><?php _e( 'List view', 'woocommerce-grid-list-toggle' ); ?></em></a>
					</nav>
				<?php
			}

			// Button wrap
			function gridlist_buttonwrap_open() {
				?>
					<div class="gridlist-buttonwrap">
				<?php
			}
			function gridlist_buttonwrap_close() {
				?>
					</div>
				<?php
			}

			// hr
			function gridlist_hr() {
				?>
					<hr />
				<?php
			}

			function gridlist_set_default_view() {
				$default = get_option( 'wc_glt_default' );
				?>
					<script>
						if (jQuery.cookie( 'gridcookie' ) == null) {
					    	jQuery( 'ul.products' ).addClass( '<?php echo $default; ?>' );
					    	jQuery( '.gridlist-toggle #<?php echo $default; ?>' ).addClass( 'active' );
					    }
					</script>
				<?php
			}

			function gridlist_cat_desc( $category ) {
				global $woocommerce;
				echo '<div itemprop="description">';
					echo $category->description;
				echo '</div>';

			}
		}

		$WC_List_Grid = new WC_List_Grid();
	}
	/**/
	add_action('wp_head','wpnetbase_frontend_assests');
 
	function wpnetbase_frontend_assests(){
	
	wp_enqueue_style( 'owl-css', plugin_dir_url(__FILE__).'/assests/css/owl.carousel.min.css' );
	wp_enqueue_script( 'owl-js', plugin_dir_url( __FILE__ ).'/assests/js/owl.carousel.min.js', array( 'jquery' ));		
	wp_enqueue_style( 'nbt-so-css', plugin_dir_url(__FILE__).'/assests/css/nbt-print-so.css' );
	}	

	//	Sale product
	function wpnetbase_woocommerce_sale_products( $atts ){
		global $woocommerce_loop;

		extract( shortcode_atts( array(
			'columns'       => '4',
			'orderby'       => 'title',
			'order'         => 'asc'
		), $atts ) );

		$args = array(
			'post_type' => 'product',
			'post_status' => 'publish',
			'ignore_sticky_posts'   => 1,
			'orderby' => $orderby,
			'order' => $order,
			'posts_per_page' => $per_page,
			'meta_query' => array(
				array(
					'key' => '_visibility',
					'value' => array('catalog', 'visible'),
					'compare' => 'IN'
				),
				array(
					'key' => '_sale_price',
					'value' => 0,
					'compare' => '>',
					'type' => 'NUMERIC'
				)
			)
		);
		ob_start();

		$products = new WP_Query( $args );
		$woocommerce_loop['columns'] = $columns;
		if ( $products->have_posts() ) : ?>
			<ul class="products">
				<?php while ( $products->have_posts() ) : $products->the_post();  
				wc_get_template_part( 'content', 'product' );  
				endwhile; // end of the loop. ?>
			</ul>
		<?php endif;
		wp_reset_query();

		return ob_get_clean();
	}

	add_shortcode('sale_products', 'wpnetbase_woocommerce_sale_products');

	function wpnetbase_create_shortcode_randompost() {

		$random_query = new WP_Query(array(
			'posts_per_page' => 10,
			'orderby' => 'rand'
		));

		ob_start();
		if ( $random_query->have_posts() ) :
			"<ol>";
			while ( $random_query->have_posts() ) :
				$random_query->the_post();?>

				<li><a href="<?php the_permalink(); ?>"><h5><?php the_title(); ?></h5></a></li>

			<?php endwhile;
			"</ol>";
		endif;
		$list_post = ob_get_contents();

		ob_end_clean();

		return $list_post;
	}
	add_shortcode('random_post', 'wpnetbase_create_shortcode_randompost');
	
	include_once(plugin_dir_path(__FILE__).'widgets/top_seller_widget/top_seller_widget.php');	
	include_once(plugin_dir_path(__FILE__).'widgets/featured_widget/featured_widget.php');	
	include_once(plugin_dir_path(__FILE__).'widgets/new_arrival_widget/new_arrival_widget.php');	
	include_once(plugin_dir_path(__FILE__).'widgets/sale_off_widget/sale_off_widget.php');	
	include_once(plugin_dir_path(__FILE__).'widgets/category_widget/category_widget.php');	
	include_once(plugin_dir_path(__FILE__).'widgets/service_boxes_widget/service_boxes_widget.php');
	include_once(plugin_dir_path(__FILE__).'widgets/post_carousel/post-carousel-widget.php');
	include_once(plugin_dir_path(__FILE__).'widgets/social_media/social_media_widget.php');	
	include_once(plugin_dir_path(__FILE__).'widgets/product_search_form.php');		
	include_once(plugin_dir_path(__FILE__).'wp-tab-widget.php');
	
	function wpnetbase_mytheme_add_widget_tabs($tabs) {
		$tabs[] = array(
			'title' => __('Netbase Widgets', 'netbaseteam'),
			'filter' => array(
				'groups' => array('netbaseteam')
			)
		);

		return $tabs;
	}
	add_filter('siteorigin_panels_widget_dialog_tabs', 'wpnetbase_mytheme_add_widget_tabs', 20);	

?>