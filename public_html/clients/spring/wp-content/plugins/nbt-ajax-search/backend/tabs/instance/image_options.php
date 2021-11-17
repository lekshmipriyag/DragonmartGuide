<div class="item">
    <?php
    $option_name = "show_images";
    $option_desc = __("Show images in results?", "nbt-ajax-search");
    $o = new wpnetbaseYesNo($option_name, $option_desc,
        $sd[$option_name]);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $option_name = "image_width";
    $option_desc = __("Image width", "nbt-ajax-search");
    $o = new wpnetbaseTextSmall($option_name, $option_desc,
        $sd[$option_name]);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $option_name = "image_height";
    $option_desc = __("Image height", "nbt-ajax-search");
    $o = new wpnetbaseTextSmall($option_name, $option_desc,
        $sd[$option_name]);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<fieldset>
    <legend>Image source settings</legend>
    <div class="item">
        <?php
        $option_name = "image_source1";
        $option_desc = __("Primary image source", "nbt-ajax-search");
        $o = new wpnetbaseCustomSelect($option_name, $option_desc, array(
            'selects'=>$sd['image_sources'],
            'value'=>$sd[$option_name]
        ));
        $params[$o->getName()] = $o->getData();
        ?>
    </div>
    <div class="item">
        <?php
        $option_name = "image_source2";
        $option_desc = __("Alternative image source 1", "nbt-ajax-search");
        $o = new wpnetbaseCustomSelect($option_name, $option_desc, array(
            'selects'=>$sd['image_sources'],
            'value'=>$sd[$option_name]
        ));
        $params[$o->getName()] = $o->getData();
        ?>
    </div>
    <div class="item">
        <?php
        $option_name = "image_source3";
        $option_desc = __("Alternative image source 2", "nbt-ajax-search");
        $o = new wpnetbaseCustomSelect($option_name, $option_desc, array(
            'selects'=>$sd['image_sources'],
            'value'=>$sd[$option_name]
        ));
        $params[$o->getName()] = $o->getData();
        ?>
    </div>
    <div class="item">
        <?php
        $option_name = "image_source4";
        $option_desc = __("Alternative image source 3", "nbt-ajax-search");
        $o = new wpnetbaseCustomSelect($option_name, $option_desc, array(
            'selects'=>$sd['image_sources'],
            'value'=>$sd[$option_name]
        ));
        $params[$o->getName()] = $o->getData();
        ?>
    </div>
    <div class="item">
        <?php
        $option_name = "image_source5";
        $option_desc = __("Alternative image source 4", "nbt-ajax-search");
        $o = new wpnetbaseCustomSelect($option_name, $option_desc, array(
            'selects'=>$sd['image_sources'],
            'value'=>$sd[$option_name]
        ));
        $params[$o->getName()] = $o->getData();
        ?>
    </div>
    <div class="item">
        <?php
        $option_name = "image_default";
        $option_desc = __("Default image url", "nbt-ajax-search");
        $o = new wpnetbaseUpload($option_name, $option_desc,
            $sd[$option_name]);
        $params[$o->getName()] = $o->getData();
        ?>
    </div>
    <div class="item">
        <?php
        $option_name = "image_custom_field";
        $option_desc = __("Custom field containing the image", "nbt-ajax-search");
        $o = new wpnetbaseText($option_name, $option_desc,
            $sd[$option_name]);
        $params[$o->getName()] = $o->getData();
        ?>
    </div>
</fieldset>
<div class="item">
    <input type="hidden" name='asl_submit' value=1 />
    <input name="submit_asl" type="submit" value="<?php _e("Save options!", "nbt-ajax-search"); ?>" />
</div>