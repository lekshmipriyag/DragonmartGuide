<div class="item">
    <?php
    $o = new wpnetbaseYesNo("show_frontend_search_settings", __("Show search settings on the frontend?", "nbt-ajax-search"), $sd['show_frontend_search_settings']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item" style="text-align:center;">
    <?php _e("The default values of the checkboxes on the frontend are the values set above.", "nbt-ajax-search"); ?>
</div>
<div class="item">
    <?php
    $o = new wpnetbaseYesNo("showexactmatches", __("Show exact matches selector?", "nbt-ajax-search"), $sd['showexactmatches']);
    $params[$o->getName()] = $o->getData();
    $o = new wpnetbaseText("exactmatchestext", "Text", $sd['exactmatchestext']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpnetbaseYesNo("showsearchinposts", __("Show search in posts selector?", "nbt-ajax-search"), $sd['showsearchinposts']);
    $params[$o->getName()] = $o->getData();
    $o = new wpnetbaseText("searchinpoststext", "Text", $sd['searchinpoststext']);
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item">
    <?php
    $o = new wpnetbaseYesNo("showsearchinpages", __("Show search in pages selector?", "nbt-ajax-search"), $sd['showsearchinpages']);
    $params[$o->getName()] = $o->getData();
    $o = new wpnetbaseText("searchinpagestext", "Text", $sd['searchinpagestext']);
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item">
    <?php
    $o = new wpnetbaseYesNo("showsearchintitle", __("Show search in title selector?", "nbt-ajax-search"), $sd['showsearchintitle']);
    $params[$o->getName()] = $o->getData();
    $o = new wpnetbaseText("searchintitletext", "Text", $sd['searchintitletext']);
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item">
    <?php
    $o = new wpnetbaseYesNo("showsearchincontent", __("Show search in content selector?", "nbt-ajax-search"), $sd['showsearchincontent']);
    $params[$o->getName()] = $o->getData();
    $o = new wpnetbaseText("searchincontenttext", "Text", $sd['searchincontenttext']);
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item"><?php
    $o = new wpnetbaseCustomPostTypesEditable("showcustomtypes", __("Show search in custom post types selectors", "nbt-ajax-search"), $sd['showcustomtypes']);
    $params[$o->getName()] = $o->getData();
    $params['selected-'.$o->getName()] = $o->getSelected();
    ?></div>
<div class="item">
    <p class='infoMsg'><?php _e("Nor recommended if you have more than 500 categories! (the HTML output will get too big)", "nbt-ajax-search"); ?></p>
    <?php
    $o = new wpnetbaseYesNo("showsearchincategories", __("Show the categories selectors?", "nbt-ajax-search"), $sd['showsearchincategories']);
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item">
    <?php
    $o = new wpnetbaseYesNo("showuncategorised", __("Show the uncategorised category?", "nbt-ajax-search"), $sd['showuncategorised']);
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item"><?php
    $o = new wpnetbaseCategories("exsearchincategories", __("Select which categories exclude", "nbt-ajax-search"), $sd['exsearchincategories']);
    $params[$o->getName()] = $o->getData();
    $params['selected-'.$o->getName()] = $o->getSelected();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpnetbaseText("exsearchincategoriestext", __("Categories filter box header text", "nbt-ajax-search"), $sd['exsearchincategoriestext']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <input type="hidden" name='asl_submit' value=1 />
    <input name="submit_asl" type="submit" value="<?php _e("Save options!", "nbt-ajax-search"); ?>" />
</div>