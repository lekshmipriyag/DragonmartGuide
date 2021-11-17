<div class="item">
    <?php
    $o = new wpnetbaseText("defaultsearchtext", __("Placeholder text", "nbt-ajax-search"), $sd['defaultsearchtext']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpnetbaseYesNo("showmoreresults", __("Show 'More results..' text in the bottom of the search box?", "nbt-ajax-search"), $sd['showmoreresults']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpnetbaseText("showmoreresultstext", __("' Show more results..' text", "nbt-ajax-search"), $sd['showmoreresultstext']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpnetbaseYesNo("showauthor", __("Show author in results?", "nbt-ajax-search"), $sd['showauthor']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpnetbaseYesNo("showdate", __("Show date in results?", "nbt-ajax-search"), $sd['showdate']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpnetbaseYesNo("showdescription", __("Show description in results?", "nbt-ajax-search"), $sd['showdescription']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpnetbaseYesNo("description_context", __("Display the description context?", "nbt-ajax-search"), $sd['description_context']);
    $params[$o->getName()] = $o->getData();
    ?>
    <p class="descMsg">
        <?php echo __("Will display the description from around the search phrase, not from the beginning.", "nbt-ajax-search"); ?>
    </p>
</div>
<div class="item">
    <?php
    $o = new wpnetbaseTextSmall("descriptionlength", __("Description length", "nbt-ajax-search"), $sd['descriptionlength']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>