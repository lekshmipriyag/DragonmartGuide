<div class="item">
    <?php
    $o = new wpnetbaseCustomSelect("keyword_logic", __("Keyword (phrase) logic?", "nbt-ajax-search"), array(
        'selects'=>array(
            array("option" => "OR", "value" => "OR"),
            array("option" => "AND", "value" => "AND")
        ),
        'value'=>$sd['keyword_logic']
    ));
    $params[$o->getName()] = $o->getData();
    ?>
    <div class="descMsg">This determines if the result should match either of the entered phrases (OR logic) or all of the entered phrases (AND logic).</div>
</div>
<!-- <div class="item"> -->
    <?php
    //$o = new wpnetbaseYesNo("triggeronclick", __("Trigger search when clicking on search icon?", "nbt-ajax-search"),
      //  $sd['triggeronclick']);
    //$params[$o->getName()] = $o->getData();
    ?>
<!-- </div> -->
<div class="item">
    <?php
    $o = new wpnetbaseYesNo("trigger_on_facet_change", __("Trigger search on facet change?", "nbt-ajax-search"),
        $sd['trigger_on_facet_change']);
    $params[$o->getName()] = $o->getData();
    ?>
    <p class="descMsg"><?php echo __("Will trigger a search when the user clicks on a checkbox on the front-end.", "nbt-ajax-search"); ?></p>
</div>
<div class="item">
    <?php
    $o = new wpnetbaseYesNo("redirectonclick", __("Redirect to search results page when clicking on search icon?", "nbt-ajax-search"),
        $sd['redirectonclick']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpnetbaseYesNo("triggerontype", __("Trigger search when typing?", "nbt-ajax-search"),
        $sd['triggerontype']);
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpnetbaseTextSmall("charcount", __("Minimal character count to trigger search", "nbt-ajax-search"),
        $sd['charcount'], array(array("func" => "ctype_digit", "op" => "eq", "val" => true)));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpnetbaseTextSmall("maxresults", __("Max. results", "nbt-ajax-search"), $sd['maxresults'], array(array("func" => "ctype_digit", "op" => "eq", "val" => true)));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpnetbaseYesNo("description_context", __("Display the description context?", "nbt-ajax-search"),
        $sd['description_context']);
    $params[$o->getName()] = $o->getData();
    ?>
    <p class="descMsg"><?php __("Will display the description from around the search phrase, not from the beginning.", "nbt-ajax-search"); ?></p>
</div>
<div class="item"><?php
    $o = new wpnetbaseTextSmall("itemscount", __("Results box viewport (in item numbers)", "nbt-ajax-search"), $sd['itemscount'], array(array("func" => "ctype_digit", "op" => "eq", "val" => true)));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item item-flex-nogrow">
    <?php
    $o = new wpnetbaseYesNo("redirectonclick", __("Redirect when clicking on search icon?", "nbt-ajax-search"),
        $sd['redirectonclick']);
    $params[$o->getName()] = $o->getData();
    ?>
    <?php
    $o = new wpnetbaseCustomSelect("redirect_click_to", __(" and redirect to", "nbt-ajax-search"),
        array(
            'selects' => array(
                array("option" => __("Results page", "nbt-ajax-search"), "value" => "results_page"),
                array("option" => __("First matching result", "nbt-ajax-search"), "value" => "first_result")
            ),
            'value' => $sd['redirect_click_to']
        ));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item item-flex-nogrow item-conditional">
    <?php
    $o = new wpnetbaseYesNo("redirect_on_enter", __("Redirect when hitting the return key?", "nbt-ajax-search"),
        $sd['redirect_on_enter']);
    $params[$o->getName()] = $o->getData();
    ?>
    <?php
    $o = new wpnetbaseCustomSelect("redirect_enter_to", __(" and redirect to", "nbt-ajax-search"),
        array(
            'selects' => array(
                array("option" => __("Results page", "nbt-ajax-search"), "value" => "results_page"),
                array("option" => __("First matching result", "nbt-ajax-search"), "value" => "first_result")
            ),
            'value' => $sd['redirect_enter_to']
        ));
    $params[$o->getName()] = $o->getData();
    ?>
</div>
<div class="item">
    <?php
    $o = new wpnetbaseYesNo("override_default_results", __("Override the default WordPress search results?", "nbt-ajax-search"),
        $sd['override_default_results']);
    $params[$o->getName()] = $o->getData();
    ?>
    <p class="descMsg"><?php echo __("Might not work with some Themes.", "nbt-ajax-search"); ?></p>
</div>