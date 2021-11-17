<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Netbase
 */

$printshop_option = printshop_get_redux_options();
?>

	</div><!-- #content -->
	
	<div class="clear"></div>

	<footer id="colophon" class="site-footer <?php if($printshop_option['header_style']=='creativeleft' || $printshop_option['header_style']=='creativeright'){echo 'displaynone';}?>" role="contentinfo">
		
		<div class="container">
			<?php if ( $printshop_option['footer_widgets'] ) { ?>
			<div class="footer-widgets-area">
				<?php $footer_columns = intval($printshop_option['footer_columns']); ?>
				<?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) ) { ?>
					<div class="sidebar-footer footer-columns footer-<?php echo esc_attr($footer_columns); ?>-columns clearfix">
						<?php 
						for ( $count = 1; $count <= $footer_columns; $count++ ) {
							?>
							<div id="footer-<?php echo esc_attr($count); ?>" class="footer-<?php echo esc_attr($count); ?> footer-column widget-area" role="complementary">
								<?php dynamic_sidebar('footer-'.$count);?>
							</div>
							<?php
						}
						?>
					</div>
				<?php } ?>
			</div>
			<?php } ?>
		</div>
		<div class="site-info-wrapper">
			<div class="container">
				<?php if ( is_active_sidebar( 'footer-bottom' ) ) : ?>
				<div class="footer-widget-parallax footer-column col-md-5 hidden-xs hidden-sm">
						<?php dynamic_sidebar('footer-bottom');?>
					</div>
				<?php endif; ?>
				
				<div class="copy_text col-md-7 padding-right-0 padding-left-0 col-xs-12">
						<?php
						if ( printshop_get_option('footer_copyright') == '' ) {
							printf( esc_html__( 'Central - Copyright &copy; 2015 - %d %2$s. All Rights Reserved', 'printshop' ), date('Y'), '<a href="'. esc_url( esc_html__( 'http://www.netbaseteam.com/', 'printshop' ) ) .'" rel="designer">netbaseteam.com</a>' );
						} else {
							echo wp_kses_post( printshop_get_option('footer_copyright') );
						}
						?>
				</div>
				
			</div>
		</div>
	</footer><!-- #colophon -->
	
</div><!-- #page -->

<?php if ( $printshop_option['page_back_totop'] ) { ?>
<div id="btt"><i class="fa fa-chevron-up"></i>Top</div> 
<?php } ?>

<?php wp_footer(); ?>
</body>
</html>
