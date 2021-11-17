<div class="item">
    <?php
    $o = new wpnetbaseCustomSelect("shortcode_op", __("What to do with shortcodes in results content?", "nbt-ajax-search"), array(
        'selects'=>array(
            array("option"=>"Remove them, keep the content", "value" => "remove"),
            array("option"=>"Execute them (can by really slow)", "value" => "execute")
        ),
        'value'=>$sd['shortcode_op']
    ));
    $params[$o->getName()] = $o->getData();
    ?>
    <p class="descMsg">
        <?php echo __("Removing shortcode is usually much faster, especially if you have many of them within posts.", "nbt-ajax-search"); ?>
    </p>
</div>
<div class="item">
    <?php
    $o = new wpnetbaseCustomFSelect("titlefield", __("Title Field", "nbt-ajax-search"), array(
        'selects'=>$sd['titlefield_def'],
        'value'=>$sd['titlefield']
    ));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpnetbaseCustomFSelect("descriptionfield", __("Description Field", "nbt-ajax-search"), array(
        'selects'=>$sd['descriptionfield_def'],
        'value'=>$sd['descriptionfield']
    ));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpnetbaseCategories("excludecategories", __("Exclude categories", "nbt-ajax-search"), $sd['excludecategories']);
    $params[$o->getName()] = $o->getData();
    $params['selected-'.$o->getName()] = $o->getSelected();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpnetbaseTextarea("excludeposts", __("Exclude Posts by ID's (comma separated post ID-s)", "nbt-ajax-search"), $sd['excludeposts']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
	<?php
	$o = new wpnetbaseTextarea("exclude_term_ids", __("Exclude Terms by ID (comma separated term ID-s)", "nbt-ajax-search"), $sd['exclude_term_ids']);
	$params[$o->getName()] = $o->getData();
	?>
	<p class="descMsg">
		<?php echo __("Use this field to exclude any taxonomy term (tags, product categorories etc..)", "nbt-ajax-search"); ?>
	</p>
</div>
<div class="item<?php echo class_exists('SitePress') ? "" : " hiddend"; ?>">
    <?php
    $o = new wpnetbaseYesNo("wpml_compatibility", __("WPML compatibility", "nbt-ajax-search"), $sd['wpml_compatibility']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item<?php echo function_exists("pll_current_language") ? "" : " hiddend"; ?>">
    <?php
    $o = new wpnetbaseYesNo("polylang_compatibility", __("Polylang compatibility", "nbt-ajax-search"), $sd['polylang_compatibility']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <input type="hidden" name='asl_submit' value=1 />
    <input name="submit_asl" type="submit" value="Save options!" />
</div>