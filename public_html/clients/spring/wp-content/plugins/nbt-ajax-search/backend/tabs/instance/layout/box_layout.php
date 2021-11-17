<div class="item"><?php
    $o = new wpnetbaseTextSmall("box_width", __("Search Box width", "nbt-ajax-search"), $sd['box_width']);
    $params[$o->getName()] = $o->getData();
    ?>
    <p class="descMsg"><?php echo __("Include the unit as well, example: 10px or 1em or 90%", "nbt-ajax-search"); ?></p>
</div>
<div class="item">
    <?php
    $option_name = "box_margin";
    $option_desc = __("Search box margin", "nbt-ajax-search");
    $option_expl = __("Include the unit as well, example: 10px or 1em or 90%", "nbt-ajax-search");
    $o = new wpnetbaseFour($option_name, $option_desc,
        array(
            "desc" => $option_expl,
            "value" => $sd[$option_name]
        )
    );
    $params[$o->getName()] = $o->getData();
    ?>
</div>