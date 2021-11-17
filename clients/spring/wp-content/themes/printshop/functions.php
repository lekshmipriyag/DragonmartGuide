<?php
/**
 * Printshop functions and definitions
 *
 * @package Netbase
 */

/**
 * Define theme constants
 */
if ( ! defined( 'PRINTSHOP_THEME_URL' ) ) {
	define( 'PRINTSHOP_THEME_URL', get_template_directory() );
}
$theme_data  = wp_get_theme();
if ( $theme_data->exists() ) {
	if ( ! defined( 'PRINTSHOP_THEME_NAME' ) ) {
		define( 'PRINTSHOP_THEME_NAME', $theme_data->get( 'Name' ) );
	}
	if ( ! defined( 'PRINTSHOP_THEME_VERSION' ) ) {
		define( 'PRINTSHOP_THEME_VERSION', $theme_data->get( 'Version' ) );
	}
}
	

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 800; /* pixels */
}

if ( ! function_exists('printshop_setup') ) :

function printshop_setup() {

	$language_folder = PRINTSHOP_THEME_URL . '/languages';
	load_theme_textdomain( 'printshop', $language_folder );
	add_theme_support( 'custom-background' );
	add_theme_support( 'custom-header' );

	add_theme_support( 'automatic-feed-links' );
	
	add_theme_support( 'title-tag' );

	add_filter( 'widget_text', 'do_shortcode' );

	add_theme_support( 'post-thumbnails' );
	
	add_image_size( 'printshop-medium-thumb', 600, 300, true );
	add_image_size( 'printshop-sidebar-blog', 100, 100, array('center', 'center') );
	
	
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'printshop' ),
		'footer' => esc_html__( 'Footer', 'printshop' ),
		) );

	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
		) );

	add_post_type_support('page', 'excerpt');

}
endif;
add_action( 'after_setup_theme', 'printshop_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function printshop_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Blog Sidebar', 'printshop' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__('Sidebar in the blog pages', 'printshop'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar( array(
		'name'          => esc_html__( 'Page Sidebar', 'printshop' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__('Sidebar for pages', 'printshop'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'WooCommerce Sidebar', 'printshop' ),
		'id'            => 'sidebar-woo',
		'description'   => esc_html__('Sidebar for WooCommerce pages', 'printshop'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 1', 'printshop' ),
		'id'            => 'footer-1',
		'description'   => printshop_sidebar_desc( 'footer-1' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 2', 'printshop' ),
		'id'            => 'footer-2',
		'description'   => printshop_sidebar_desc( 'footer-2' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 3', 'printshop' ),
		'id'            => 'footer-3',
		'description'   => printshop_sidebar_desc( 'footer-3' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 4', 'printshop' ),
		'id'            => 'footer-4',
		'description'   => printshop_sidebar_desc( 'footer-4' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer bottom', 'printshop' ),
		'id'            => 'footer-bottom',
		'description'   => printshop_sidebar_desc( 'footer-4' ),
		'before_widget' => '<aside id="%1$s" class="footer_parallax widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Header Currency Switcher', 'printshop' ),
		'id'            => 'header-cs',
		'description'   => esc_html__( 'Widget area for currency switcher only' ),
		'before_widget' => '<div id="%1$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	
}
add_action( 'widgets_init', 'printshop_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function printshop_scripts() {
	global $printshop_option;	
	
	wp_enqueue_style( 'printshop-compare', get_template_directory_uri() .'/woocommerce/compare.css', 'all' );	
	wp_enqueue_style( 'printshop-style-home', get_template_directory_uri() .'/style.css', 'all' );
	wp_style_add_data( 'printshop-style-home', 'rtl', 'replace' );
	
	$is_fixed_header = array('fixed_header' => $printshop_option['header_fixed']);
	wp_localize_script('jquery','header_fixed_setting', $is_fixed_header);

	wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/assets/js/modernizr.min.js', array(), '2.6.2', true );
	wp_enqueue_script( 'printshop-libs', get_template_directory_uri() . '/assets/js/libs.js', array(), '', true );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array(), '1.0.0', true );
	if(is_product()) {
		wp_enqueue_script( 'product-zoom', get_template_directory_uri() . '/assets/js/jquery.elevateZoom-3.0.8.min.js', array('jquery'), '1.0.0', true );
	}
	wp_enqueue_script( 'printshop-theme', get_template_directory_uri() . '/assets/js/theme.js', array(), '', true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'printshop_scripts' );

/**
 *  Editor Style
 */
function printshop_add_editor_styles() {
	add_editor_style( 'assets/css/editor-style.css' );
}
add_action( 'admin_init', 'printshop_add_editor_styles' );

/**
 * Theme Options
 */
if ( !isset( $redux_demo ) ) {
	require_once( trailingslashit(get_template_directory()) . '/inc/options-config.php' );
}

/**
 * Recomend plugins via TGM activation class
 */
require_once( trailingslashit(get_template_directory()) . '/inc/tgm/plugin-activation.php' );

/**
 * Custom template tags for this theme.
 */
require_once( trailingslashit(get_template_directory()) . '/inc/template-tags.php' );

/**
 * Custom functions that act independently of the theme templates.
 */
require_once( trailingslashit(get_template_directory()) . '/inc/extras.php' );
require get_template_directory() . '/inc/class.woocommerce-advanced-reviews.php';

/**
 * The theme fully support WooCommerce, Awesome huh?.
 */
add_theme_support( 'woocommerce' );
require_once( trailingslashit(get_template_directory()) . '/inc/woo-config.php' );

/*
* Recent post
*/

class printshop_recent_posts extends WP_Widget {
	function __construct() {
		parent::__construct(
			'netbase-recent-posts',
			'Recent Post Thumbnail',
			array( 'description' => 'List Recent Post', )
			);
	}
	public function widget($args, $instance) {
		extract($args);
		$title = apply_filters( 'widget_title', $instance['title'] );
		$number = $instance['number'];
		printf("%s", $before_widget) ;
		printf("%s", $before_title) ;
		if ( ! empty ( $title ) ) {
			printf("%s", $title) ;
		}
		printf("%s", $after_title) ;		
		$args = array (
			'posts_per_page' => $number,
			);
		$neatly_posts = new WP_Query($args);
		if( $neatly_posts->have_posts() ) {
			echo '<ul>';
			while( $neatly_posts->have_posts() ) : $neatly_posts->the_post(); ?>
			<li>
				<div class="post-thumb"><a href="<?php the_permalink(); ?>"><?php echo the_post_thumbnail('printshop-sidebar-blog'); ?></a></div>
				<div class="post-thumb-info">
					<p class="post-info-top"><a href="<?php the_permalink(); ?>"><?php echo the_title(); ?></a></p>
					<?php
					if ( has_excerpt() ){
						echo '<p class="post-info-excerpt">';
						echo wp_trim_words( get_the_excerpt(), 10, '...' ); 
						echo '</p>';
					}
					?>					
					<a class="post-info-readmore" href="<?php the_permalink(); ?>"><?php esc_html_e('Read More', 'printshop')?></a>
				</div>
			</li>
			<?php endwhile;
			echo '</ul>';
		}
		wp_reset_postdata();
		printf("%s", $after_widget) ;		
}
public function form( $instance ) {
	$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Recent Post', 'printshop' );
	if (isset( $instance['number' ] ) ) {
		$number = $instance['number'];
	} else { $number = '5'; }
	?>
	<p>
		<label for="<?php echo esc_html($this->get_field_id('title')); ?>"><?php esc_html__('Title:', 'printshop'); ?></label>
		<input class="widefat" id="<?php echo esc_html($this->get_field_id('title')); ?>" name="<?php echo esc_html($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
	</p>
	<p><em><?php esc_html_e('Use the following options to customize the display.', 'printshop'); ?></em></p>
	<p style="border-bottom:4px double #eee;padding: 0 0 10px;">
		<label for="<?php echo esc_html($this->get_field_id( 'number' )); ?>"><?php esc_html_e('Number of posts:', 'printshop');?></label>
		<input id="<?php echo esc_html($this->get_field_id( 'number')); ?>" name="<?php echo esc_html($this->get_field_name( 'number' )); ?>" value="<?php echo esc_attr($number); ?>" type="number" style="width:100%;" /><br>
	</p>
	<?php }
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = strip_tags($new_instance['number']);
		return $instance;
	}
}

function printshop_register_recent_posts() {
	register_widget( 'printshop_recent_posts' );
}
add_action( 'widgets_init', 'printshop_register_recent_posts' );

remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 9;' ), 20 );

add_filter('loop_shop_columns', 'printshop_loop_columns');
if (!function_exists('printshop_loop_columns')) {
 function printshop_loop_columns() {
  return 3; 
 }
}

function printshop_search_filter($query) {
    	if( $query->is_admin ) {
    		return $query;
    	}	
	if( $query->is_search ) {
		$query->set( 'post__not_in' , array( 2537,2129, 2128, 2209 ) ); // Page ID
	}
	return $query;
}
add_filter('pre_get_posts','printshop_search_filter');

function printshop_get_redux_options() {
	global $printshop_option;
	return $printshop_option;
}

if ( in_array( 'siteorigin-panels/siteorigin-panels.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )
{

	function printshop_custom_row_style_fields($fields) {
		$fields['nbparallax'] = array(
			'name'        => esc_html__('Printshop Parallax', 'printshop'),
			'type'        => 'checkbox',
			'group'       => 'design',
			'description' => esc_html__('If enabled, the background image will have a parallax effect.custom by netbaseteam', 'printshop'),
			'priority'    => 8,
		);

		return $fields;
	}

	add_filter( 'siteorigin_panels_row_style_fields', 'printshop_custom_row_style_fields' );

	function printshop_custom_row_style_attributes($attributes, $args ) {
		if( !empty( $args['nbparallax'] ) ) {
			array_push($attributes['class'], 'nbparallax');
		}

		return $attributes;
	}

	add_filter('siteorigin_panels_row_style_attributes', 'printshop_custom_row_style_attributes', 10, 2);

}


function printshop_register_topbar_menu() {
  register_nav_menu('printshop-topbar-menu',esc_html__( 'Topbar Menu','printshop' ));
  if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2 );
  }
  if ( class_exists('ReduxFrameworkPlugin') ) {
    remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );    
  }
}
add_action( 'init', 'printshop_register_topbar_menu' );

function printshop_nbt_get_import_files() {
    return array(
        array(
            'import_file_name'             => 'Demo Print Cards',
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/import-files/demo-content.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/import-files/printcards/widgets.wie',
            'local_import_redux'           => array(
                array(
                  'file_path'   => trailingslashit( get_template_directory() ) . 'inc/import-files/printcards/theme-options.json',
                  'option_name' => 'printshop_options',
                ),
              ),
            'import_preview_image_url'     => 'http://netbaseteam.com/wordpress/theme/import_preview_img/printcards.png',
            'import_notice'                => esc_html__( 'Print Cards demo data', 'printshop' ),
        ),
        array(
            'import_file_name'             => 'Demo Print Parallax',
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/import-files/demo-content.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/import-files/print-parallax/widgets.wie',
            'local_import_redux'           => array(
                array(
                  'file_path'   => trailingslashit( get_template_directory() ) . 'inc/import-files/print-parallax/theme-options.json',
                  'option_name' => 'printshop_options',
                ),
              ),
            'import_preview_image_url'     => 'http://netbaseteam.com/wordpress/theme/import_preview_img/print-parallax.png',
            'import_notice'                => esc_html__( 'Print Parallax demo data', 'printshop' ),
        ),
        array(
            'import_file_name'             => 'Demo Print Slider',
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/import-files/demo-content.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/import-files/print-slider/widgets.wie',
            'local_import_redux'           => array(
                array(
                  'file_path'   => trailingslashit( get_template_directory() ) . 'inc/import-files/print-slider/theme-options.json',
                  'option_name' => 'printshop_options',
                ),
              ),
            'import_preview_image_url'     => 'http://netbaseteam.com/wordpress/theme/import_preview_img/print-slider.png',
            'import_notice'                => esc_html__( 'Print Slider demo data', 'printshop' ),
        ),

        /*boxed*/
        array(
            'import_file_name'             => 'Demo Print Boxed',
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/import-files/demo-content.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/import-files/print-boxed/widgets.wie',
            'local_import_redux'           => array(
                array(
                  'file_path'   => trailingslashit( get_template_directory() ) . 'inc/import-files/print-boxed/theme-options.json',
                  'option_name' => 'printshop_options',
                ),
              ),
            'import_preview_image_url'     => 'http://demo7.cmsmart.net/wordpress/tfprint/plugins/print-boxed.png',
            'import_notice'                => esc_html__( 'Print Slider demo data', 'printshop' ),
        ),
        array(
            'import_file_name'             => 'Demo Print Fullbox',
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/import-files/demo-content.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/import-files/print-fullboxed/widgets.wie',
            'local_import_redux'           => array(
                array(
                  'file_path'   => trailingslashit( get_template_directory() ) . 'inc/import-files/print-fullboxed/theme-options.json',
                  'option_name' => 'printshop_options',
                ),
              ),
            'import_preview_image_url'     => 'http://demo7.cmsmart.net/wordpress/tfprint/plugins/print-fullboxed.png',
            'import_notice'                => esc_html__( 'Print Slider demo data', 'printshop' ),
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'printshop_nbt_get_import_files' );

function printshop_nbt_after_import( $selected_import ) {

    if ( 'Demo Print Cards' === $selected_import['import_file_name'] ) {
    	$page = get_page_by_title( 'Home printshop cards');
        if ( isset( $page->ID ) ) {
            update_option( 'page_on_front', $page->ID );
            update_option( 'show_on_front', 'page' );
        }
    }

    if ( 'Demo Print Parallax' === $selected_import['import_file_name'] ) {
    	$page = get_page_by_title( 'home printshop parallax');
        if ( isset( $page->ID ) ) {
            update_option( 'page_on_front', $page->ID );
            update_option( 'show_on_front', 'page' );
        }
    }

    if ( 'Demo Print Slider' === $selected_import['import_file_name'] ) {
    	$page = get_page_by_title( 'home printshop slider');
        if ( isset( $page->ID ) ) {
            update_option( 'page_on_front', $page->ID );
            update_option( 'show_on_front', 'page' );
        }
    }

    if ( 'Demo Print Boxed' === $selected_import['import_file_name'] ) {
    	$page = get_page_by_title( 'home printshop boxed 1');
        if ( isset( $page->ID ) ) {
            update_option( 'page_on_front', $page->ID );
            update_option( 'show_on_front', 'page' );
        }
    }

    if ( 'Demo Print Fullbox' === $selected_import['import_file_name'] ) {
    	$page = get_page_by_title( 'home printshop boxed 10');
        if ( isset( $page->ID ) ) {
            update_option( 'page_on_front', $page->ID );
            update_option( 'show_on_front', 'page' );
        }
    }

    $primary_menu = get_term_by('name', 'main-menu', 'nav_menu');
    set_theme_mod( 'nav_menu_locations', array(
            'primary' => $primary_menu->term_id,
        )
    );

    $page = get_page_by_title( 'Home printshop cards');
    if ( isset( $page->ID ) ) {
        update_option( 'page_on_front', $page->ID );
        update_option( 'show_on_front', 'page' );
    }

    $page = get_page_by_title( 'home printshop boxed 1');
    if ( isset( $page->ID ) ) {
        update_option( 'page_on_front', $page->ID );
        update_option( 'show_on_front', 'page' );
    }

    $page = get_page_by_title( 'home printshop boxed 10');
    if ( isset( $page->ID ) ) {
        update_option( 'page_on_front', $page->ID );
        update_option( 'show_on_front', 'page' );
    }

    if ( class_exists( 'RevSlider' ) ) {
        $slider_array = array(
           get_template_directory() .'/inc/import-files/printcards/homecards.zip',
           get_template_directory() .'/inc/import-files/print-slider/homslider.zip',
           get_template_directory() .'/inc/import-files/print-boxed/slider-boxed1.zip',
           get_template_directory() .'/inc/import-files/print-fullboxed/home_boxed.zip',
        );

        $slider = new RevSlider();

        foreach($slider_array as $filepath){
            $slider->importSliderFromPost(true,true,$filepath);
        }

        echo 'Slider processed';
    }
    
}
add_action( 'pt-ocdi/after_import', 'printshop_nbt_after_import' );

function printshop_plugin_intro_text( $default_text ) {
    $default_text .= '<ul>
	<li>We recommend you to have a clean and fresh database if you had installed any demo before</li>
	<li>Please use this plugin to reset your database: <a href="https://wordpress.org/plugins/wordpress-database-reset/">WordPress Database Reset</a></li>
</ul>';

    return $default_text;
}
add_filter( 'pt-ocdi/plugin_intro_text', 'printshop_plugin_intro_text' );

/* Metabox Manage Sidebars per posts/page*/

if( !function_exists('printshop_sidebar_box') ):
function printshop_sidebar_box($post) {

    global $post;
    global $wp_registered_sidebars ;
    //$sidebar_name   = get_post_meta($post->ID, 'sidebar_select', true);
    $sidebar_option = get_post_meta($post->ID, 'sidebar_option', true);
    
    $sidebar_values = array(   'sidebar-default'=>'Default', 
                               'right-sidebar'=>'Right Sidebar',
                               'left-sidebar'=>'Left Sidebar',
                               'no-sidebar'=>'No Sidebar', 
                               'full-screen'=>'Full Screen');
    
    $option         = '';    
    
    foreach ($sidebar_values as $key=>$value) {
        $option.='<option value="' . $key . '"';
        if ($key == $sidebar_option) {
            $option.=' selected="selected"';
        }
        $option.='>' . $value . '</option>';
    }

    print '   
    <p class="meta-options"><label for="sidebar_option">'.__('Page Layout ( Set the page layout, inherit from Theme Option by default ) ','printshop').' </label><br />
        <select id="sidebar_option" name="sidebar_option" style="width: 200px;">
        ' . $option . '
        </select>
    </p>';
        
}
endif; // end   printshop_sidebar_box  

if( !function_exists('printshop_sidebar_meta') ):

function printshop_sidebar_meta() {
global $post;  
	// add_meta_box('wpestate-sidebar-post',  __('Sidebar Settings',  'printshop'), 'printshop_sidebar_box', 'post');
    add_meta_box('printshop-sidebar-page', __('Page Settings',  'printshop'), 'printshop_sidebar_box', 'page');
}
endif;

add_action('add_meta_boxes', 'printshop_sidebar_meta');
add_action('save_post', 'printshop_save_postdata', 1, 2);

/*Saving of custom data*/

if( !function_exists('printshop_save_postdata') ):
function printshop_save_postdata($post_id) {
    global $post;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    ///////////////////////////////////// Check permissions   
    if(isset($_POST['post_type'])){       
            if ('page' == $_POST['post_type'] or 'post' == $_POST['post_type']) {
                if (!current_user_can('edit_page', $post_id))
                    return;
            }
            else {
                if (!current_user_can('edit_post', $post_id))
                    return;
            }
    }
     
    $allowed_keys=array(
        'sidebar_option'
        
    );
   
    foreach ($_POST as $key => $value) {
        if( !is_array ($value) ){
           
            if (in_array ($key, $allowed_keys)) {
                $postmeta = wp_filter_kses( $value ); 
                update_post_meta($post_id, sanitize_key($key), $postmeta );
            }
        }       
    }
    
}
endif; // end   printshop_save_postdata  


remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
add_action( 'woocommerce_shop_loop_item_title', 'action_woocommerce_shop_loop_item_title', 10 );
function action_woocommerce_shop_loop_item_title(  ) { 
    echo '<h3>' . get_the_title() . '</h3>';
}

add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );
