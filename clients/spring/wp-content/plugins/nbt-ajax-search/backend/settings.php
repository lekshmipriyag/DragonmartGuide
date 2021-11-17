<?php
$params = array();
$messages = "";

$inst = wd_asl()->instances->get(0);
$sd = &$inst['data'];
//var_dump($_sd);
$_def = get_option('asl_defaults');
$_dk = 'asl_defaults';
?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=470596109688127&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<div id="wpnetbase" class='wpnetbase wrap'>
    <?php if (ASL_DEBUG == 1): ?>
        <p class='infoMsg'>Debug mode is on!</p>
    <?php endif; ?>

    <?php if (wd_asl()->o['asl_performance']['use_custom_ajax_handler'] == 1): ?>
        <p class='noticeMsgBox'>AJAX SEARCH NOTICE: The custom ajax handler is enabled. In case you experience issues, please
            <a href='<?php echo get_admin_url() . "admin.php?page=nbt-ajax-search/backend/performance_options.php"; ?>'>turn it off.</a></p>
    <?php endif; ?>


    <?php ob_start(); ?>
    <div class="wpnetbase-box">

            <label class="shortcode"><?php _e("Search shortcode:", "nbt-ajax-search"); ?></label>
            <input type="text" class="shortcode" value="[wpnetbase_ajaxsearch]"
                   readonly="readonly"/>
            <label class="shortcode"><?php _e("Search shortcode for templates:", "nbt-ajax-search"); ?></label>
            <input type="text" class="shortcode"
                   value="&lt;?php echo do_shortcode('[wpnetbase_ajaxsearch]'); ?&gt;"
                   readonly="readonly"/>
    </div>
    <div class="wpnetbase-box">

        {--messages--}

        <form action='' method='POST' name='asl_data'>
            <ul id="tabs" class='tabs'>
                <li><a tabid="1" class='current general'><?php _e("General Options", "nbt-ajax-search"); ?></a></li>
                <li><a tabid="2" class='multisite'><?php _e("Image Options", "nbt-ajax-search"); ?></a></li>
                <li><a tabid="3" class='frontend'><?php _e("Frontend Options", "nbt-ajax-search"); ?></a></li>
                <li><a tabid="4" class='layout'><?php _e("Layout options", "nbt-ajax-search"); ?></a></li>
                <li><a tabid="7" class='advanced'><?php _e("Advanced", "nbt-ajax-search"); ?></a></li>
            </ul>
            <div id="content" class='tabscontent'>
                <div tabid="1">
                    <fieldset>
                        <legend><?php _e("Genearal Options", "nbt-ajax-search"); ?></legend>

                        <?php include(ASL_PATH . "backend/tabs/instance/general_options.php"); ?>

                    </fieldset>
                </div>
                <div tabid="2">
                    <fieldset>
                        <legend><?php _e("Image Options", "nbt-ajax-search"); ?></legend>

                        <?php include(ASL_PATH . "backend/tabs/instance/image_options.php"); ?>

                    </fieldset>
                </div>
                <div tabid="3">
                    <fieldset>
                        <legend><?php _e("Frontend Search Settings", "nbt-ajax-search"); ?></legend>

                        <?php include(ASL_PATH . "backend/tabs/instance/frontend_options.php"); ?>

                    </fieldset>
                </div>
                <div tabid="4">
                    <fieldset>
                        <legend><?php _e("Layout Options", "nbt-ajax-search"); ?></legend>

                        <?php include(ASL_PATH . "backend/tabs/instance/layout_options.php"); ?>

                    </fieldset>
                </div>
                <div tabid="7">
                    <fieldset>
                        <legend><?php _e("Advanced Options", "nbt-ajax-search"); ?></legend>

                        <?php include(ASL_PATH . "backend/tabs/instance/advanced_options.php"); ?>

                    </fieldset>
                </div>
            </div>
            <input type="hidden" name="sett_tabid" id="sett_tabid" value="1" />
        </form>
    </div>
    <?php $output = ob_get_clean(); ?>
    <?php
    if (isset($_POST['submit_asl'])) {

        $params = wpnetbase_parse_params($_POST);
        $_asl_options = array_merge($sd, $params);

        wd_asl()->instances->update(0, $_asl_options);
        // Force instance data to the debug storage
        wd_asl()->debug->pushData(
            $_asl_options,
            'asl_options', true
        );

        $messages .= "<div class='infoMsg'>" . __("Ajax Search settings saved!", "nbt-ajax-search") . "</div>";
    }
    echo str_replace("{--messages--}", $messages, $output);
    ?>
</div>
<?php wp_enqueue_script('wd_asl_search_instance', plugin_dir_url(__FILE__) . 'settings/assets/search_instance.js', array('jquery'), ASL_CURR_VER_STRING, true); ?>