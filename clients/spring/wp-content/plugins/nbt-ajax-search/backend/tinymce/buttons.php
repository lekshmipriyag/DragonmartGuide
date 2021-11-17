<?php
return;
// Hooks your functions into the correct filters
add_action('admin_head', 'wpnetbase_asl_add_mce_button');
function wpnetbase_asl_add_mce_button() {
    // check user permissions
    if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
        return;
    }
    // check if WYSIWYG is enabled
    if ( 'true' == get_user_option( 'rich_editing' ) ) {
        add_filter( 'mce_external_plugins', 'wpnetbase_asl_add_tinymce_plugin' );
        add_filter( 'mce_buttons', 'wpnetbase_asl_register_mce_button' );
    }
}
add_action('admin_head', 'wpnetbase_asl_add_mce_button');

// Declare script for new button
function wpnetbase_asl_add_tinymce_plugin( $plugin_array ) {
    $plugin_array['wpnetbase_asl_mce_button'] = plugins_url()."/nbt-ajax-search/backend/tinymce/buttons.js";
    return $plugin_array;
}

// Register new button in the editor
function wpnetbase_asl_register_mce_button( $buttons ) {
    array_push( $buttons, 'wpnetbase_asl_mce_button' );
    return $buttons;
}

// Generate the buttons JS variable
add_action('admin_head', 'wpnetbase_asl_mce_generate_variable');
function wpnetbase_asl_mce_generate_variable($settings) {
    global $wpdb;
    $asl_instances = $wpdb->get_results("SELECT * FROM ".$wpdb->base_prefix."ajaxsearchlite", ARRAY_A);
    $menu_items = array();
    $menu_result_items = array();
    if (is_array($asl_instances)) {
      foreach ($asl_instances as $x => $instance) {
          $id = $instance['id'];
          $menu_items[] = "{text: 'Search $id (".preg_replace("/[^\w\d ]/ui", '', $instance['name']).")',onclick: function() {editor.insertContent('[wpnetbase_ajaxsearch id=$id]');}}";
          $menu_result_items[] = "{text: 'Results $id (".preg_replace("/[^\w\d ]/ui", '', $instance['name']).")',onclick: function() {editor.insertContent('[wpnetbase_ajaxsearch_results id=$id element=div]');}}";
      }
    }
    ?>
    
    <?php if (count($menu_items)>0): ?>
    <?php $menu_items = implode(", ", $menu_items); ?>
    <?php $menu_result_items = implode(", ", $menu_result_items); ?>
        <script type="text/javascript">
        wpnetbase_asl_mce_button_menu = "<?php echo $menu_items; ?>";
        wpnetbase_asl_res_mce_button_menu = "<?php echo $menu_result_items; ?>";
    </script>
<?php endif;
    return $settings;
}
?>