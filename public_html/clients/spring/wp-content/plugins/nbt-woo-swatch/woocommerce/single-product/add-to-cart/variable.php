<?php
/**
 * Variable product add to cart
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product,$post;

$attribute_keys           =  array_keys( $attributes );
$_coloredvariables        =  get_post_meta( $post->ID, '_coloredvariables', true );
$woo_version              =  nbtws_get_woo_version_number();
$nbtws_global_activation   =  get_option("nbtws_woocommerce_global_activation");
$nbtws_global              =  get_option("nbtws_global");
do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo esc_attr( json_encode( $available_variations ) ) ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>
	<?php else : ?>
		<table class="variations" cellspacing="0">
			<tbody>
				<?php foreach ( $attributes as $attribute_name => $options ) : ?>
				
				<?php 
				    
				    if (isset( $_coloredvariables[$attribute_name]['display_type'])) {
                 
				          
					       $attribute_display_type  = $_coloredvariables[$attribute_name]['display_type'];
		                
						} elseif ((isset($nbtws_global_activation)) && ($nbtws_global_activation == "yes"))  {
						   $attribute_display_type  = $nbtws_global[$attribute_name]['display_type'];
						} 
				   
                        
                            if ($woo_version <2.1) {
	                          		$labeltext=$woocommerce->attribute_label( $attribute_name );  
	                        } else {
	                                $labeltext=wc_attribute_label( $attribute_name );
	                        }
						
							
				    $taxonomies = array($attribute_name);
	                              $args = array(
                         'hide_empty' => 0
                       );
                    $newvalues = get_terms( $taxonomies, $args);
				?>
					<tr>
						<td class="label">
						  <span class="swatchtitlelabel"><?php if (isset($labeltext) && ($labeltext != '')) { echo 'select ' . $labeltext; } ?></span>
						</td>
						<td class="value">
							
							<?php if (isset($attribute_display_type) && ($attribute_display_type  == "colororimage")) : ?>
							<?php 
							    $fields   = new nbtws_swatch_form_fields();
       							
								$selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean(    $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) : $product->            get_variation_default_attribute( $attribute_name );
								
							    $fields->nbtws_load_colored_select($attribute_name,$options,$_coloredvariables,$newvalues,$selected);
								
								nbtws_dropdown_variation_attribute_options1( array( 'options' => $options, 'attribute' =>        $attribute_name, 'product' => $product, 'selected' => $selected ) );
								
								echo end( $attribute_keys ) === $attribute_name ? '<a class="reset_variations" href="#">' . __( 'Clear', 'nbtws' ) . '</a>' : ''; 
						    ?>
							<?php elseif (isset($attribute_display_type) && ($attribute_display_type  == "global")) : ?>
							<?php   
								$fields   = new nbtws_swatch_form_fields();
       							
								$selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean(    $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) : $product->            get_variation_default_attribute( $attribute_name );
								
							    $fields->nbtws_load_colored_select2($attribute_name,$options,$newvalues,$selected);
								
								nbtws_dropdown_variation_attribute_options1( array( 'options' => $options, 'attribute' =>        $attribute_name, 'product' => $product, 'selected' => $selected ) );
								
								echo end( $attribute_keys ) === $attribute_name ? '<a class="reset_variations" href="#">' . __( 'Clear', 'nbtws' ) . '</a>' : ''; 
							?>	
							<?php else : ?>
							
							<?php
								$selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean(    $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) : $product->          get_variation_default_attribute( $attribute_name );
								
								nbtws_dropdown_variation_attribute_options2( array( 'options' => $options, 'attribute' =>        $attribute_name, 'product' => $product, 'selected' => $selected ) );
								
								echo end( $attribute_keys ) === $attribute_name ? '<a class="reset_variations" href="#">' . __( 'Clear', 'nbtws' ) . '</a>' : '';
							?>
							<?php endif; ?>
						</td>
					</tr>
		        <?php endforeach;?>
			</tbody>
		</table>

		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<div class="single_variation_wrap" style="display:none;">
			<?php
				/**
				 * woocommerce_before_single_variation Hook
				 */
				do_action( 'woocommerce_before_single_variation' );

				/**
				 * woocommerce_single_variation hook. Used to output the cart button and placeholder for variation data.
				 * @since 2.4.0
				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
				 */
				do_action( 'woocommerce_single_variation' );

				/**
				 * woocommerce_after_single_variation Hook
				 */
				do_action( 'woocommerce_after_single_variation' );
			?>
		</div>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
