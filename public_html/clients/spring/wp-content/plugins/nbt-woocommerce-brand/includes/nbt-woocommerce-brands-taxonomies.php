<?php
/**
 * Handles taxonomies in admin
 *
 * @class    Nbt_WC_Brands_Taxonomies
 * @version  1.0.0
 * @package  Nbt-Woocommerce-Brands/Admin
 * @category Class
 * @author   NetbaseTeam
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!class_exists('Nbt_WC_Brands_Taxonomies')) :

    class Nbt_WC_Brands_Taxonomies {

        public function __construct() {
            $this->init_hooks();
        }

        /**
         * Initializes WordPress hooks
         */
        public function init_hooks() {
            add_action('woocommerce_register_taxonomy', array($this, 'nbt_taxonomy_brand'));

            // Add admin script
            add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));

            // Add form
            add_action('product_brand_add_form_fields', array($this, 'add_brand_fields'));
            add_action('product_brand_edit_form_fields', array($this, 'edit_brand_fields'), 10);
            add_action('created_term', array($this, 'save_brand_fields'), 10, 3);
            add_action('edit_term', array($this, 'save_brand_fields'), 10, 3);

            // Add columns
            add_filter('manage_edit-product_brand_columns', array($this, 'product_brand_columns'));
            add_filter('manage_product_brand_custom_column', array($this, 'product_brand_column'), 10, 3);

            // Maintain hierarchy of terms
            add_filter('wp_terms_checklist_args', array($this, 'disable_checked_ontop'));
        }

        public function nbt_taxonomy_brand() {
            $permalinks = get_option('woocommerce_permalinks');
            register_taxonomy('product_brand', apply_filters('woocommerce_taxonomy_objects_product_brand', array('product')), apply_filters('woocommerce_taxonomy_args_product_brand', array(
                'hierarchical' => true,
                'update_count_callback' => '_wc_term_recount',
                'label' => __('Brands', 'nbt-woocommerce-brands'),
                'labels' => array(
                    'name' => __('Brands', 'nbt-woocommerce-brands'),
                    'singular_name' => __('Brand', 'nbt-woocommerce-brands'),
                    'menu_name' => _x('Brands', 'Admin menu name', 'nbt-woocommerce-brands'),
                    'search_items' => __('Search Brands', 'nbt-woocommerce-brands'),
                    'all_items' => __('All Brands', 'nbt-woocommerce-brands'),
                    'parent_item' => __('Parent Brand', 'nbt-woocommerce-brands'),
                    'parent_item_colon' => __('Parent Brand:', 'nbt-woocommerce-brands'),
                    'edit_item' => __('Edit Brand', 'nbt-woocommerce-brands'),
                    'update_item' => __('Update Brand', 'nbt-woocommerce-brands'),
                    'add_new_item' => __('Add New Brand', 'nbt-woocommerce-brands'),
                    'new_item_name' => __('New Brand Name', 'nbt-woocommerce-brands'),
                    'not_found' => __('No Brand found', 'nbt-woocommerce-brands'),
                ),
                'show_ui' => true,
                'query_var' => true,
                'capabilities' => array(
                    'manage_terms' => 'manage_product_terms',
                    'edit_terms' => 'edit_product_terms',
                    'delete_terms' => 'delete_product_terms',
                    'assign_terms' => 'assign_product_terms',
                ),
                'show_admin_column' => true,
                'rewrite' => array(
                    'slug' => empty($permalinks['brand_base']) ? _x('brand', 'slug', 'nbt-woocommerce-brands') : $permalinks['brand_base'],
                    'with_front' => false,
                    'hierarchical' => true,
                ),
                    ))
            );
        }

        /**
         * Add script for media upload
         */
        public function admin_scripts() {
            wp_enqueue_media();
        }

        /**
         * Add brand thumbnail fields.
         */
        public function add_brand_fields() {
            ?>
            <div class="form-field term-featured-wrap">
                <label for="brand_url"><?php _e('Custom URL', 'nbt-woocommerce-brands'); ?></label>
                <input id="brand_url" name="brand_url" class="postform" type="text"/>
            </div>
            <div class="form-field term-featured-wrap">
                <label for="brand_featured"><?php _e('Featured', 'nbt-woocommerce-brands'); ?></label>
                <input id="brand_featured" name="brand_featured" class="postform" type="checkbox"/>
            </div>
            <div class="form-field term-thumbnail-wrap">
                <label><?php _e('Thumbnail', 'nbt-woocommerce-brands'); ?></label>
                <div id="product_brand_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url(wc_placeholder_img_src()); ?>" width="60px" height="60px" /></div>
                <div style="line-height: 60px;">
                    <input type="hidden" id="product_brand_thumbnail_id" name="product_brand_thumbnail_id" />
                    <button type="button" class="upload_image_button button"><?php _e('Upload/Add image', 'nbt-woocommerce-brands'); ?></button>
                    <button type="button" class="remove_image_button button"><?php _e('Remove image', 'nbt-woocommerce-brands'); ?></button>
                </div>
                <script type="text/javascript">

                    // Only show the "remove image" button when needed
                    if (!jQuery('#product_brand_thumbnail_id').val()) {
                        jQuery('.remove_image_button').hide();
                    }

                    // Uploading files
                    var file_frame;

                    jQuery(document).on('click', '.upload_image_button', function (event) {

                        event.preventDefault();

                        // If the media frame already exists, reopen it.
                        if (file_frame) {
                            file_frame.open();
                            return;
                        }
                        console.log(file_frame);
                        // Create the media frame.
                        file_frame = wp.media.frames.downloadable_file = wp.media({
                            title: '<?php _e("Choose an image", 'nbt-woocommerce-brands'); ?>',
                            button: {
                                text: '<?php _e("Use image", 'nbt-woocommerce-brands'); ?>'
                            },
                            multiple: false
                        });

                        // When an image is selected, run a callback.
                        file_frame.on('select', function () {
                            var attachment = file_frame.state().get('selection').first().toJSON();

                            jQuery('#product_brand_thumbnail_id').val(attachment.id);
                            jQuery('#product_brand_thumbnail').find('img').attr('src', attachment.sizes.thumbnail.url);
                            jQuery('.remove_image_button').show();
                        });

                        // Finally, open the modal.
                        file_frame.open();
                    });

                    jQuery(document).on('click', '.remove_image_button', function () {
                        jQuery('#product_brand_thumbnail').find('img').attr('src', '<?php echo esc_js(wc_placeholder_img_src()); ?>');
                        jQuery('#product_brand_thumbnail_id').val('');
                        jQuery('.remove_image_button').hide();
                        return false;
                    });

                    jQuery(document).ajaxComplete(function (event, request, options) {
                        if (request && 4 === request.readyState && 200 === request.status
                                && options.data && 0 <= options.data.indexOf('action=add-tag')) {

                            var res = wpAjax.parseAjaxResponse(request.responseXML, 'ajax-response');
                            if (!res || res.errors) {
                                return;
                            }
                            // Clear Thumbnail fields on submit
                            jQuery('#product_brand_thumbnail').find('img').attr('src', '<?php echo esc_js(wc_placeholder_img_src()); ?>');
                            jQuery('#product_brand_thumbnail_id').val('');
                            jQuery('.remove_image_button').hide();

                            return;
                        }
                    });

                </script>
                <div class="clear"></div>
            </div>
            <div class="form-field term-banner-wrap">
                <label><?php _e('Banner', 'nbt-woocommerce-brands'); ?></label>
                <div id="product_brand_banner" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url(wc_placeholder_img_src()); ?>" width="60px" height="60px" /></div>
                <div style="line-height: 60px;">
                    <input type="hidden" id="product_brand_banner_id" name="product_brand_banner_id" />
                    <button type="button" class="upload_banner_button button"><?php _e('Upload/Add banner', 'nbt-woocommerce-brands'); ?></button>
                    <button type="button" class="remove_banner_button button"><?php _e('Remove banner', 'nbt-woocommerce-brands'); ?></button>
                </div>
                <script type="text/javascript">

                    // Only show the "remove image" button when needed
                    if (!jQuery('#product_brand_banner_id').val()) {
                        jQuery('.remove_banner_button').hide();
                    }

                    // Uploading files
                    var file_frame2;

                    jQuery(document).on('click', '.upload_banner_button', function (event) {

                        event.preventDefault();

                        // If the media frame already exists, reopen it.
                        if (file_frame2) {
                            file_frame2.open();
                            return;
                        }
                        // alert(file_frame2);
                        // Create the media frame.
                        file_frame2 = wp.media.frames.downloadable_file = wp.media({
                            title: '<?php _e("Choose an image", 'nbt-woocommerce-brands'); ?>',
                            button: {
                                text: '<?php _e("Use image", 'nbt-woocommerce-brands'); ?>'
                            },
                            multiple: false
                        });

                        // When an image is selected, run a callback.
                        file_frame2.on('select', function () {
                            var attachment = file_frame2.state().get('selection').first().toJSON();

                            jQuery('#product_brand_banner_id').val(attachment.id);
                            jQuery('#product_brand_banner').find('img').attr('src', attachment.sizes.thumbnail.url);
                            jQuery('.remove_banner_button').show();
                        });

                        // Finally, open the modal.
                        file_frame2.open();
                    });

                    jQuery(document).on('click', '.remove_banner_button', function () {
                        jQuery('#product_brand_banner').find('img').attr('src', '<?php echo esc_js(wc_placeholder_img_src()); ?>');
                        jQuery('#product_brand_banner_id').val('');
                        jQuery('.remove_banner_button').hide();
                        return false;
                    });

                    jQuery(document).ajaxComplete(function (event, request, options) {
                        if (request && 4 === request.readyState && 200 === request.status
                                && options.data && 0 <= options.data.indexOf('action=add-tag')) {

                            var res = wpAjax.parseAjaxResponse(request.responseXML, 'ajax-response');
                            if (!res || res.errors) {
                                return;
                            }
                            // Clear Thumbnail fields on submit
                            jQuery('#product_brand_banner').find('img').attr('src', '<?php echo esc_js(wc_placeholder_img_src()); ?>');
                            jQuery('#product_brand_banner_id').val('');
                            jQuery('.remove_banner_button').hide();

                            return;
                        }
                    });

                </script>
                <div class="clear"></div>
            </div>
            <div class="form-field term-status-wrap">
                <label for="brand_status"><?php _e('Publish', 'nbt-woocommerce-brands'); ?></label>
                <input id="brand_status" name="brand_status" class="postform" type="checkbox"/>
            </div>
            <?php
        }

        /**
         * Edit brand thumbnail field.
         *
         * @param mixed $term Term (brand) being edited
         */
        public function edit_brand_fields($term) {

            $brand_featured = get_woocommerce_term_meta($term->term_id, 'brand_featured', true);
            $brand_status = get_woocommerce_term_meta($term->term_id, 'brand_status', true);
            $thumbnail_id = absint(get_woocommerce_term_meta($term->term_id, 'thumbnail_id', true));

            $brand_url = get_woocommerce_term_meta($term->term_id, 'brand_url', true);

            if ($thumbnail_id) {
                $image = wp_get_attachment_thumb_url($thumbnail_id);
            } else {
                $image = wc_placeholder_img_src();
            }

            $banner_id = absint(get_woocommerce_term_meta($term->term_id, 'banner_id', true));

            if ($banner_id) {
                $banner = wp_get_attachment_thumb_url($banner_id);
            } else {
                $banner = wc_placeholder_img_src();
            }
            ?>
            <tr class="form-field">
                <th scope="row" valign="top"><label><?php _e('Url', 'nbt-woocommerce-brands'); ?></label></th>
                <td><input id="brand_url" name="brand_url" class="postform" type="text" value="<?php echo $brand_url; ?>"></td>
            </tr>
            <tr class="form-field">
                <th scope="row" valign="top"><label><?php _e('Featured', 'nbt-woocommerce-brands'); ?></label></th>
                <td>
                    <input id="brand_featured" name="brand_featured" type="checkbox" <?php checked($brand_featured, 1); ?>/>
                </td>
            </tr>
            <tr class="form-field">
                <th scope="row" valign="top"><label><?php _e('Thumbnail', 'nbt-woocommerce-brands'); ?></label></th>
                <td>
                    <div id="product_brand_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url($image); ?>" width="60px" height="60px" /></div>
                    <div style="line-height: 60px;">
                        <input type="hidden" id="product_brand_thumbnail_id" name="product_brand_thumbnail_id" value="<?php echo $thumbnail_id; ?>" />
                        <button type="button" class="upload_image_button button"><?php _e('Upload/Add image', 'nbt-woocommerce-brands'); ?></button>
                        <button type="button" class="remove_image_button button"><?php _e('Remove image', 'nbt-woocommerce-brands'); ?></button>
                    </div>
                    <script type="text/javascript">

                        // Only show the "remove image" button when needed
                        if ('0' === jQuery('#product_brand_thumbnail_id').val()) {
                            jQuery('.remove_image_button').hide();
                        }

                        // Uploading files
                        var file_frame;

                        jQuery(document).on('click', '.upload_image_button', function (event) {

                            event.preventDefault();

                            // If the media frame already exists, reopen it.
                            if (file_frame) {
                                file_frame.open();
                                return;
                            }

                            // Create the media frame.
                            file_frame = wp.media.frames.downloadable_file = wp.media({
                                title: '<?php _e("Choose an image", 'nbt-woocommerce-brands'); ?>',
                                button: {
                                    text: '<?php _e("Use image", 'nbt-woocommerce-brands'); ?>'
                                },
                                multiple: false
                            });

                            // When an image is selected, run a callback.
                            file_frame.on('select', function () {
                                var attachment = file_frame.state().get('selection').first().toJSON();

                                jQuery('#product_brand_thumbnail_id').val(attachment.id);
                                jQuery('#product_brand_thumbnail').find('img').attr('src', attachment.sizes.thumbnail.url);
                                jQuery('.remove_image_button').show();
                            });

                            // Finally, open the modal.
                            file_frame.open();
                        });

                        jQuery(document).on('click', '.remove_image_button', function () {
                            jQuery('#product_brand_thumbnail').find('img').attr('src', '<?php echo esc_js(wc_placeholder_img_src()); ?>');
                            jQuery('#product_brand_thumbnail_id').val('');
                            jQuery('.remove_image_button').hide();
                            return false;
                        });

                    </script>
                    <div class="clear"></div>
                </td>
            </tr>
            <tr class="form-field">
                <th scope="row" valign="top"><label><?php _e('Banner', 'nbt-woocommerce-brands'); ?></label></th>
                <td>
                    <div id="product_brand_banner" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url($banner); ?>" width="60px" height="60px" /></div>
                    <div style="line-height: 60px;">
                        <input type="hidden" id="product_brand_banner_id" name="product_brand_banner_id" value="<?php echo $banner_id; ?>" />
                        <button type="button" class="upload_banner_button button"><?php _e('Upload/Add banner', 'nbt-woocommerce-brands'); ?></button>
                        <button type="button" class="remove_banner_button button"><?php _e('Remove banner', 'nbt-woocommerce-brands'); ?></button>
                    </div>
                    <script type="text/javascript">

                        // Only show the "remove image" button when needed
                        if ('0' === jQuery('#product_brand_banner_id').val()) {
                            jQuery('.remove_banner_button').hide();
                        }

                        // Uploading files
                        var file_frame2;

                        jQuery(document).on('click', '.upload_banner_button', function (event) {

                            event.preventDefault();

                            // If the media frame already exists, reopen it.
                            if (file_frame2) {
                                file_frame2.open();
                                return;
                            }

                            // Create the media frame.
                            file_frame2 = wp.media.frames.downloadable_file = wp.media({
                                title: '<?php _e("Choose an image", 'nbt-woocommerce-brands'); ?>',
                                button: {
                                    text: '<?php _e("Use image", 'nbt-woocommerce-brands'); ?>'
                                },
                                multiple: false
                            });

                            // When an image is selected, run a callback.
                            file_frame2.on('select', function () {
                                var attachment = file_frame2.state().get('selection').first().toJSON();

                                jQuery('#product_brand_banner_id').val(attachment.id);
                                jQuery('#product_brand_banner').find('img').attr('src', attachment.sizes.thumbnail.url);
                                jQuery('.remove_banner_button').show();
                            });

                            // Finally, open the modal.
                            file_frame2.open();
                        });

                        jQuery(document).on('click', '.remove_banner_button', function () {
                            jQuery('#product_brand_banner').find('img').attr('src', '<?php echo esc_js(wc_placeholder_img_src()); ?>');
                            jQuery('#product_brand_banner_id').val('');
                            jQuery('.remove_banner_button').hide();
                            // Clear Display type field on submit
                            jQuery('#brand_featured').val('');
                            return false;
                        });

                    </script>
                    <div class="clear"></div>
                </td>
            </tr>
            <tr class="form-field">
                <th scope="row" valign="top"><label><?php _e('Publish', 'nbt-woocommerce-brands'); ?></label></th>
                <td>
                    <input id="brand_status" name="brand_status" type="checkbox" <?php checked($brand_status, 1); ?>/>
                </td>
            </tr>
            <?php
        }

        /**
         * save_brand_fields function.
         *
         * @param mixed $term_id Term ID being saved
         * @param mixed $tt_id
         * @param string $taxonomy
         */
        public function save_brand_fields($term_id, $tt_id = '', $taxonomy = '') {

            if (isset($_POST['brand_url']) && 'product_brand' === $taxonomy) {
                update_woocommerce_term_meta($term_id, 'brand_url', esc_attr($_POST['brand_url']));
            }

            if (isset($_POST['brand_featured']) && 'product_brand' === $taxonomy) {
                update_woocommerce_term_meta($term_id, 'brand_featured', 1);
            }

            if (isset($_POST['brand_status']) && 'product_brand' === $taxonomy) {
                update_woocommerce_term_meta($term_id, 'brand_status', 1);
            }

            if (isset($_POST['product_brand_thumbnail_id']) && 'product_brand' === $taxonomy) {
                update_woocommerce_term_meta($term_id, 'thumbnail_id', absint($_POST['product_brand_thumbnail_id']));
            }

            if (isset($_POST['product_brand_banner_id']) && 'product_brand' === $taxonomy) {
                update_woocommerce_term_meta($term_id, 'banner_id', absint($_POST['product_brand_banner_id']));
            }
        }

        /**
         * Thumbnail column added to brand admin.
         *
         * @param mixed $columns
         * @return array
         */
        public function product_brand_columns($columns) {
            $new_columns = array();

            if (isset($columns['cb'])) {
                $new_columns['cb'] = $columns['cb'];
                unset($columns['cb']);
            }

            $new_columns['thumb'] = __('Thumbnail', 'nbt-woocommerce-brands');

            $new_columns['name'] = __('Name', 'nbt-woocommerce-brands');

            $new_columns['banner'] = __('Banner', 'nbt-woocommerce-brands');

            //$new_columns['description'] = __('Description', 'nbt-woocommerce-brands');
            unset($columns['description']);

            $new_columns['slug'] = __('Slug', 'nbt-woocommerce-brands');

            $new_columns['featured'] = __('Featured', 'nbt-woocommerce-brands');

            $new_columns['url'] = __('Url', 'nbt-woocommerce-brands');

            $new_columns['status'] = __('Status', 'nbt-woocommerce-brands');

            return array_merge($new_columns, $columns);
        }

        /**
         * Thumbnail column value added to brand admin.
         *
         * @param string $columns
         * @param string $column
         * @param int $id
         * @return array
         */
        public function product_brand_column($columns, $column, $id) {

            if ('thumb' == $column) {

                $thumbnail_id = get_woocommerce_term_meta($id, 'thumbnail_id', true);

                if ($thumbnail_id) {
                    $image = wp_get_attachment_thumb_url($thumbnail_id);
                } else {
                    $image = wc_placeholder_img_src();
                }

                // Prevent esc_url from breaking spaces in urls for image embeds
                // Ref: https://core.trac.wordpress.org/ticket/23605
                $image = str_replace(' ', '%10', $image);

                $columns .= '<img src="' . esc_url($image) . '" alt="' . esc_attr__('Thumbnail', 'nbt-woocommerce-brands') . '" class="wp-post-image" height="48" width="48" />';
            }

            if ('status' == $column) {
                $status = get_woocommerce_term_meta($id, 'brand_status', true);
                if ($status == "1")
                    $columns.= 'Publish';
                else
                    $columns.= 'Unpublish';
            }

            if ('featured' == $column) {
                $featured = get_woocommerce_term_meta($id, 'brand_featured', true);
                if ($featured == "1")
                    $columns.= 'Yes';
                else
                    $columns.= 'No';
            }

            if ('banner' == $column) {

                $banner_id = get_woocommerce_term_meta($id, 'banner_id', true);

                if ($banner_id) {
                    $banner = wp_get_attachment_thumb_url($banner_id);
                } else {
                    $banner = wc_placeholder_img_src();
                }

                // Prevent esc_url from breaking spaces in urls for image embeds
                // Ref: https://core.trac.wordpress.org/ticket/23605
                $banner = str_replace(' ', '%10', $banner);

                $columns .= '<img src="' . esc_url($banner) . '" alt="' . esc_attr__('Banner', 'nbt-woocommerce-brands') . '" class="wp-post-banner" height="48" width="48" />';
            }

            if ('url' == $column)
                $columns.= get_woocommerce_term_meta($id, 'brand_url', true);


            return $columns;
        }

        /**
         * Maintain term hierarchy when editing a product.
         *
         * @param  array $args
         * @return array
         */
        public function disable_checked_ontop($args) {
            if (!empty($args['taxonomy']) && 'product_brand' === $args['taxonomy']) {
                $args['checked_ontop'] = false;
            }
            return $args;
        }

    }

    new Nbt_WC_Brands_Taxonomies();    
    
endif;
