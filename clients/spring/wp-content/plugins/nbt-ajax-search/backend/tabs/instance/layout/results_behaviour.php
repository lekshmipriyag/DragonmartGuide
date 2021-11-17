<div class="item">
    <?php
    $o = new wpnetbaseYesNo("scroll_to_results", __("Sroll the window to the result list?", "nbt-ajax-search"), $sd['scroll_to_results']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpnetbaseYesNo("resultareaclickable", __("Make the whole result area clickable?", "nbt-ajax-search"), $sd['resultareaclickable']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpnetbaseYesNo("close_on_document_click", __("Close result list on document click?", "nbt-ajax-search"), $sd['close_on_document_click']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpnetbaseYesNo("show_close_icon", __("Show the close icon?", "nbt-ajax-search"), $sd['show_close_icon']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpnetbaseText("noresultstext", __("No results text", "nbt-ajax-search"), $sd['noresultstext']);
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item"><?php
    $o = new wpnetbaseText("didyoumeantext", __("Did you mean text", "nbt-ajax-search"), $sd['didyoumeantext']);
    $params[$o->getName()] = $o->getData();
    ?></div>