<?php
add_action('init', 'wpnetbase_owl_pc_thumb_register');
function wpnetbase_owl_pc_thumb_register() {
	add_image_size('wpnetbase-owl-pc-thumb', 285, 255, array('center', 'center'));
}

class wpnetbase_post_carousel_widget extends WP_Widget {

	static $variables = array();
	protected $skinlayout;
	function __construct() {
		parent::__construct(
			'nbt_pc_widget',
			__( 'Post carousel widget by Netbase Team', 'text_domain' ),
			array( 'description' => __( 'A carousel to display post', 'text_domain' ), 'panels_groups' => array('netbaseteam'))
		);
		$this->skinlayout = array( 'default', '3d','boxed');
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Post carousel', 'text_domain' );
		if  ( $instance ) {	
			$slider_alias = esc_attr($instance['slider_alias']);		
			$per_view = esc_attr($instance['per_view']);			
			$posts_per_page = esc_attr($instance['posts_per_page']);
			$category = esc_attr($instance['category']);
			$skinlayout = esc_attr($instance['skinlayout']);
		} else {
			$slider_alias = '';		
			$per_view = '4';	
			$posts_per_page = '8';
			$category = 'blog';
			$skinlayout = 'default';
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'slider_alias' ); ?>"><?php _e( 'Slider Alias:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'slider_alias' ); ?>" name="<?php echo $this->get_field_name( 'slider_alias' ); ?>" type="text" value="<?php echo esc_attr( $slider_alias ); ?>">
		<span>Slider Alias must be a->z characters or number and don't have white space</span>
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'per_view' ); ?>"><?php _e( 'Posts per view:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'per_view' ); ?>" name="<?php echo $this->get_field_name( 'per_view' ); ?>" type="number" value="<?php echo esc_attr( $per_view ); ?>">
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>"><?php _e( 'Posts per page:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" type="number" value="<?php echo esc_attr( $posts_per_page ); ?>">
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Category Slug:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>" type="text" value="<?php echo esc_attr( $category ); ?>">
		</p>
        <p>
            <label for="<?php echo $this->get_field_id('skinlayout'); ?>"><?php _e( 'Skin Layout', 'wpnetbase' ); ?>:</label>
            <select class='widefat' id="<?php echo $this->get_field_id('skinlayout'); ?>" name="<?php echo $this->get_field_name('skinlayout'); ?>" type="text">
                  <option value='default'<?php echo ($skinlayout=='default')?'selected':''; ?>>
                    <?php _e( 'default', 'wpnetbase' ); ?>
                  </option>
                  <option value='3d'<?php echo ($skinlayout=='3d')?'selected':''; ?>>
                    <?php _e( '3d', 'wpnetbase' ); ?>
                  </option> 
                  <option value='boxed'<?php echo ($skinlayout=='boxed')?'selected':''; ?>>
                    <?php _e( 'boxed', 'wpnetbase' ); ?>
                  </option> 
                  
                </select>

        </p>
		<?php 
	}

	public function widget( $args, $instance ) {
		$title = $instance['title'];		
		$slider_alias = $instance['slider_alias'];
		$per_view = $instance['per_view'];
		$posts_per_page = $instance['posts_per_page'];
		$category = $instance['category'];		
		$skinlayout = $instance['skinlayout'];
		
		$nbt_args = array(
			'post_type' => 'post',
			'posts_per_page' => $posts_per_page,			
			'category_name' => $category
		);
		
		$nbt_query = new WP_Query( $nbt_args );

		if ( $nbt_query->have_posts() ) {
			$i = 0;
			echo $args['before_widget'];
			echo '<div id="owl-pc-' . $instance['slider_alias'] . '" class="owl-carousel owl-post-carousel skinlayout-'.$skinlayout.'">';
			
			if($skinlayout=='3d'){
				while ($nbt_query->have_posts()): $nbt_query->the_post();
				?>
				<div class="grid-item grid-sm-6 grid-md-3 slick-slide slick-active">
					<div class="grid-thumbnail">
						<a href="<?php the_permalink(); ?>">
							<?php 
							if ( has_post_thumbnail() ) {
							    	the_post_thumbnail('wpnetbase-owl-pc-thumb');
							} 
							?>
						</a>
					</div>
					<h4 class="grid-title"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h4>
					
					<?php
					if ( has_excerpt() ){
					echo '<p>';
					echo wp_trim_words( get_the_excerpt(), 28, '...' ); 
					echo '</p>';
					}
					?>
					<div class="recent-news-meta">
						<span class="post-date">
						<i class="fa fa-file-text-o"></i> <time class="entry-date published updated" datetime="2016-01-13T04:14:37+00:00">
						<?php the_time('F j, Y') ?></time></span>
						<span class="comments-link"><i class="fa fa-comments-o"></i> <a href="#">No Comments</a></span>
					</div>
				</div>
				
				<?php 
				endwhile;				
				
			}elseif($skinlayout=='boxed'){
				while ($nbt_query->have_posts()): $nbt_query->the_post();
					?>
				<div class="grid-item ">
					<div class="grid-thumbnail">
						<div class="recent-time"><?php the_time(' j M') ?></div>
						<a href="<?php the_permalink(); ?>">
							<?php 
							if ( has_post_thumbnail() ) {
							   	the_post_thumbnail('wpnetbase-owl-pc-thumb');
							} 
							?>
						</a>
					</div>
					<div class="home-blog-meta">								
					<?php 
					if(get_the_author()){
					?>
						<span class="post-date"> 
							<i class="fa fa-user" aria-hidden="true"></i> Post by
							<?php 								
							echo '<span class="author">'.esc_html( get_the_author() ).'</span>'; 
						echo '</span>';	
					}
						if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
						echo '<span class="comments-link">'. wp_kses(__(' <i class="fa fa-comment"></i> ', 'wpnetbase'), array('i' => array('class' => array())));
									comments_popup_link( esc_html__( '0', 'wpnetbase' ), esc_html__( '1', 'wpnetbase' ), esc_html__( '%', 'wpnetbase' ) );
									echo '</span>';
						}
								
						$categories_list = get_the_category_list( esc_html__( ', ', 'wpnetbase' ) );
								
						if ( $categories_list ) {
							printf( '<span class="tag-blog-boxed"><i class="fa fa-tags"></i>' . esc_html__( '%1$s', 'wpnetbase' ) . '</span>', $categories_list );
						}
						?>								
						</div>
							<h4 class="grid-title"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h4>
							<?php
							if ( has_excerpt() ){
									echo '<p class="product-description">';
									echo wp_trim_words( get_the_excerpt(), 16, '...' ); 
									echo '</p>';
								}
							?>
														
						
						</div>
					
					<?php 
						endwhile;

			}
			else{
				while( $nbt_query->have_posts() ) :
					$nbt_query->the_post(); ?>
					<?php if ( $i %2 == 0 ): ?>
					<div class="owl-pc-content">
						<div class="owl-pc-thumbnail">
							<a href="<?php the_permalink(); ?>">
							<?php 
							if ( has_post_thumbnail() ) {
							    	the_post_thumbnail('wpnetbase-owl-pc-thumb');
							} 
							?>
							</a>
						</div>
						<div class="owl-pc-info">
							<?php the_title('<h2 class="owl-pc-title">', '</h2>')?>
							<?php
							if ( has_excerpt() ){
									echo '<p class="owl-pc-excerpt">';
									echo wp_trim_words( get_the_excerpt(), 20, '...' ); 
									echo '</p>';
								}
							?>							
							<p class="owl-pc-more">
								<a href="<?php the_permalink(); ?>">read more</a>
							</p>
						</div>
					</div>
					<?php else: ?>
					<div class="owl-pc-content">					
						<div class="owl-pc-info">
							<?php the_title('<h2 class="owl-pc-title">', '</h2>')?>
							<?php
							if ( has_excerpt() ){
									echo '<p class="owl-pc-excerpt">';
									echo wp_trim_words( get_the_excerpt(), 20, '...' ); 
									echo '</p>';
								}
							?>							
							<p class="owl-pc-more">
								<a href="<?php the_permalink(); ?>">read more</a>
							</p>
						</div>
						<div class="owl-pc-thumbnail">
							<a href="<?php the_permalink(); ?>">
							<?php 
							if ( has_post_thumbnail() ) {
							    	the_post_thumbnail('wpnetbase-owl-pc-thumb');
							} 
							?>
							</a>
						</div>
					</div>
					<?php endif;?>
				<?php
				$i++;
				endwhile;			
			}
			
			echo '</div>';
			echo $args['after_widget'];
			?>
			<script>			
				jQuery(document).ready(function(){
					jQuery('.panel-grid').each(function(){
						jQuery(this).find("#owl-pc-<?php echo $instance['slider_alias']; ?>").owlCarousel({
							pagination: true,
							rtl:<?php echo is_rtl()?'true':'false'; ?>,
							items:<?php echo $instance['per_view']; ?>, margin:30,
							autoPlay: 6000,														
							responsiveClass:true,														
							responsive:{
								0:{
									items:1,            
								},
								500:{
									items:2,            
								},
								992:{
									items:3,           
								},
								1024: {
									items:<?php echo $instance['per_view']; ?>,
								}
							},							
						});						
					}); 					
				});				
			</script>
			<?php
		}
		wp_reset_postdata();

	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['slider_alias'] = strip_tags($new_instance['slider_alias']);
		$instance['per_view'] = strip_tags($new_instance['per_view']);
		$instance['posts_per_page'] = strip_tags($new_instance['posts_per_page']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['skinlayout'] = strip_tags($new_instance['skinlayout']);
		return $instance;
	}   

}

function wpnetbase_pc_carousel_load_widget() {
	register_widget( 'wpnetbase_post_carousel_widget' );
}
add_action( 'widgets_init', 'wpnetbase_pc_carousel_load_widget' );