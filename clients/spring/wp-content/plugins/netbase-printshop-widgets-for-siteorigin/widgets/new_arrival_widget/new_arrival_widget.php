<?php
/* New arrival product widget */
class wpnetbase_new_arrival_wpb_widget extends WP_Widget 
{
	function __construct() 
	{
		parent::__construct(
		// Base ID of your widget
		'wpnetbase_new_arrival_wpb_widget', 

		// Widget name will appear in UI
		__('NBT Woocommerce New Arrival', 'wpb_widget_domain'), 

		// Widget description
		array( 'description' => __( 'New Arrival Products For Woocommerce', 'wpb_widget_domain' ), 'panels_groups' => array('netbaseteam')) 
		);
	}
function getTemplatePart($slug = null, $name = null, array $params = array()) {
    global $posts, $post, $wp_did_header, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

    do_action("get_template_part_{$slug}", $slug, $name);
    $templates = array();
    if (isset($name))
        $templates[] = "{$slug}-{$name}.php";

    $templates[] = "{$slug}.php";

    $_template_file = locate_template($templates, false, false);

    if (is_array($wp_query->query_vars)) {
        extract($wp_query->query_vars, EXTR_SKIP);
    }
    extract($params, EXTR_SKIP);

    require($_template_file);
}
	public function widget( $args, $instance )
	{

		if(isset($instance['title'])){
			$title =  $instance['title'];
		}
		if(isset($instance['product_limit']))
		{
			$product_limit =  $instance['product_limit'];
		}
		else
		{
			$product_limit =  12;
		}
		if(isset($instance['product_columns']))
		{
			$product_columns =  $instance['product_columns'];
			
		}else{$product_columns = 4;}
		
		 ?>
		<div class="recent-products woocommerce">
			<?php if(isset($title) && $title!=''){ ?>
			<h3 class="widget-title"><?php echo $title; ?></h2>
			<?php } ?>  
				<ul id="<?php echo 'nbt_new_arrival_product'.$instance['panels_info']['id']; ?>" class="products owl-carousel" style="display:block;">
				<?php
					if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) 
					{
							$args = array(
								'post_type'     => 'product',
								'posts_per_page' => $product_limit,
								'post_status'   => 'publish',
								'ignore_sticky_posts' => 1,
								'per_page' => '12',
								'columns'  => '1',
								'meta_key' => 'total_sales',
								'orderby' 	=> 'date',
								'order' 	=> 'desc' 
							);
							$loop = new WP_Query( $args );
							if ( $loop->have_posts() ) 
							{
								while ( $loop->have_posts() ) : $loop->the_post();
								include(locate_template('woocommerce/content-newproduct.php'));
								endwhile;
							}
							else{ echo '<p>No products found.</p>'; }
							wp_reset_postdata();
					}
					else{ echo '<p>Woocommerce plugin does not exist</p>'; }
				?>
				</ul>
			
		</div>
		<?php if($instance['nbt_carousel'] == 'yes' ){	?>			
			<script>			
				jQuery(document).ready(function(){
					
					jQuery('.panel-grid').each(function(){
						var item_count= <?php echo $product_columns; ?>;
						
							jQuery(this).find('#nbt_new_arrival_product'+<?php echo $instance['panels_info']['id']; ?>).owlCarousel({
								rtl:<?php echo is_rtl()?'true':'false'; ?>,
								items:item_count,
								autoPlay: 5000, 
								lazyLoad : true,
								
								<?php if($instance['nbt_pagination'] == 'yes' ) {?>
								navigation : false,
								pagination:true,
								<?php } else{?>
									navigation : true,
									pagination: false,
									navigationText: ['<span class="icon-left-open"></span>', '<span class="icon-right-open"></span>'],
								<?php } ?>
								
								responsiveClass:true,
								margin: 30,
								responsive:{

									0:{
										items:1,            
									},
									480:{
										items:2,            
									},
									600:{
										items:3,            
									},
									768:{
										items:4,           
									}
								},
								
							});
										
							
					}); 
					
				});
				
			</script>
			
			<?php
		}		
	}
			
	// Widget Backend 
	public function form( $instance )
	{
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = '';
		}
		if ( isset( $instance[ 'product_limit' ] ) ) 
		{
			$product_limit = $instance[ 'product_limit' ];
		}
		else 
		{
			$product_limit =12;
		}
		if ( isset( $instance[ 'product_columns' ] ) ) 
		{
				$product_columns = $instance[ 'product_columns' ];
		}else{$product_columns = 4;}
		if ( isset( $instance[ 'nbt_carousel' ] ) )
		{
			$nbt_carousel = $instance[ 'nbt_carousel'];
		}
		else 
		{
		$nbt_carousel ='yes';
		}
		if ( isset( $instance[ 'nbt_pagination' ] ) )
		{
			$nbt_pagination = $instance[ 'nbt_pagination'];
		}
		else 
		{
		$nbt_pagination ='no';
		}
		// Widget admin form
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'product_limit' ); ?>"><?php _e( 'Products per page:' ); ?></label> 
			
			<input class="widefat" id="<?php echo $this->get_field_id( 'product_limit' ); ?>" name="<?php echo $this->get_field_name( 'product_limit' ); ?>" type="text" value="<?php echo esc_attr( $product_limit ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'product_columns' ); ?>"><?php _e( 'Columns:' ); ?></label> 
			
			<input class="widefat" id="<?php echo $this->get_field_id( 'product_columns' ); ?>" name="<?php echo $this->get_field_name( 'product_columns' ); ?>" type="text" value="<?php echo esc_attr( $product_columns ); ?>" />
		</p>
		<p>

			<label for="<?php echo $this->get_field_id( 'nbt_carousel' ); ?>"><?php _e( 'Carousel Enable:' ); ?></label> 
			<input type="radio" name="<?php echo $this->get_field_name( 'nbt_carousel' ); ?>" id="<?php echo $this->get_field_id( 'nbt_carousel_yes' ); ?>" value="yes" <?php if($nbt_carousel=='yes'){ echo "checked";}?>>Yes
			<input type="radio" name="<?php echo $this->get_field_name( 'nbt_carousel' ); ?>" id="<?php echo $this->get_field_id( 'nbt_carousel_no' ); ?>" value="no" <?php if($nbt_carousel=='no'){ echo "checked";}?>>NO
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'nbt_pagination' ); ?>"><?php _e( 'Show Pagination:' ); ?></label> 
			
			<input type="radio" name="<?php echo $this->get_field_name( 'nbt_pagination' ); ?>" id="<?php echo $this->get_field_id( 'nbt_pagination_yes' ); ?>" value="yes" <?php if($nbt_pagination=='yes'){ echo "checked";}?>>Yes
			
			<input type="radio" name="<?php echo $this->get_field_name( 'nbt_pagination' ); ?>" id="<?php echo $this->get_field_id( 'nbt_pagination_no' ); ?>" value="no" <?php if($nbt_pagination=='no'){ echo "checked";}?>>NO
		</p>
		<?php 
	}
		
	// Updating widget replacing old instances with new
	public function nbt_new_arrival_pro_update( $new_instance, $old_instance ) 
	{
		$instance = array();
		
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		
		$instance['product_limit'] = ( ! empty( $new_instance['product_limit'] ) ) ? strip_tags( $new_instance['product_limit'] ) : '';
		$instance['product_columns'] = ( ! empty( $new_instance['product_columns'] ) ) ? strip_tags( $new_instance['product_columns'] ) : '';
		$instance['nbt_carousel'] = ( ! empty( $new_instance['nbt_carousel'] ) ) ? strip_tags( $new_instance['nbt_carousel'] ) : '';
		$instance['nbt_pagination'] = ( ! empty( $new_instance['nbt_pagination'] ) ) ? strip_tags( $new_instance['nbt_pagination'] ) : '';
		return $instance;
	}
}
function wpnetbase_new_arrival_load_widget() {
	register_widget( 'wpnetbase_new_arrival_wpb_widget' );
}
add_action( 'widgets_init', 'wpnetbase_new_arrival_load_widget' );

?>