<?php
$themes = array(
    /*array('option'=>'Simple Red', 'value'=>'simple-red'),
    array('option'=>'Simple Blue', 'value'=>'simple-blue'),
    array('option'=>'Simple Grey', 'value'=>'simple-grey'),
    array('option'=>'Classic Blue', 'value'=>'classic-blue'),
    array('option'=>'Curvy Black', 'value'=>'curvy-black'),
    array('option'=>'Curvy Red', 'value'=>'curvy-red'),
    array('option'=>'Curvy Blue', 'value'=>'curvy-blue'),*/
    array('option'=>'Underline White', 'value'=>'underline')
);
?>
<div class="item">
    <?php
    $o = new wpnetbaseCustomSelect("theme", __("Theme", "nbt-ajax-search"), array(
        'selects'=>$themes,
        'value'=>$sd['theme']
    ));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpnetbaseYesNo("override_search_form", __("Try to replace the theme search with Ajax Search form?", "nbt-ajax-search"),
        $sd["override_search_form"]);
    $params[$o->getName()] = $o->getData();
    ?>
    <p class="descMsg"><?php echo __("Works with most themes, which use the searchform.php theme file to display their search forms.", "nbt-ajax-search"); ?></p>
</div>
<?php if ( class_exists("WooCommerce") ): ?>
<div class="item">
    <?php
    $o = new wpnetbaseYesNo("override_woo_search_form", __("Try to replace the WooCommerce search with Ajax Search form?", "nbt-ajax-search"),
        $sd["override_woo_search_form"]);
    $params[$o->getName()] = $o->getData();
    ?>
    <p class="descMsg"><?php echo __("Works with most themes, which use the searchform.php theme file to display their search forms.", "nbt-ajax-search"); ?></p>
</div>
<?php endif; ?>
<div class="item">
    <?php
    $o = new wpnetbaseYesNo("searchinposts", __("Search in posts?", "nbt-ajax-search"),
        $sd["searchinposts"]);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpnetbaseYesNo("searchinpages", __("Search in pages?", "nbt-ajax-search"),
        $sd['searchinpages']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpnetbaseCustomPostTypes("customtypes", __("Search in custom post types", "nbt-ajax-search"),
        $sd['customtypes']);
    $params[$o->getName()] = $o->getData();
    $params['selected-'.$o->getName()] = $o->getSelected();
    ?></div>
<div class="item">
    <?php
    $o = new wpnetbaseYesNo("searchintitle", __("Search in title?", "nbt-ajax-search"),
        $sd['searchintitle']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpnetbaseYesNo("searchincontent", __("Search in content?", "nbt-ajax-search"),
        $sd['searchincontent']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpnetbaseYesNo("searchinexcerpt", __("Search in post excerpts?", "nbt-ajax-search"),
        $sd['searchinexcerpt']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpnetbaseYesNo("search_in_permalinks", __("Search in permalinks?", "nbt-ajax-search"),
        $sd['search_in_permalinks']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpnetbaseYesNo("search_all_cf", __("Search all custom fields?", "nbt-ajax-search"),
        $sd['search_all_cf']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpnetbaseCustomFields("customfields", __("..or search in selected custom fields?", "nbt-ajax-search"),
        $sd['customfields']);
    $params[$o->getName()] = $o->getData();
    $params['selected-'.$o->getName()] = $o->getSelected();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpnetbaseYesNo("exactonly", __("Show exact matches only?", "nbt-ajax-search"),
        $sd['exactonly']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpnetbaseYesNo("searchinterms", __("Search in terms? (categories, tags)", "nbt-ajax-search"),
        $sd['searchinterms']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>