<div class="item">
    <?php
    $o = new wpnetbaseYesNo("kw_highlight", __("Keyword highlighting", "nbt-ajax-search"), $sd['kw_highlight']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpnetbaseYesNo("kw_highlight_whole_words", __("Highlight whole words only?", "nbt-ajax-search"), $sd['kw_highlight_whole_words']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item"><?php
    $o = new wpnetbaseColorPicker("highlight_color", "Highlight text color", $sd['highlight_color']);
    $params[$o->getName()] = $o->getData();
    ?></div>
<div class="item"><?php
    $o = new wpnetbaseColorPicker("highlight_bg_color", "Highlight-text background color", $sd['highlight_bg_color']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>