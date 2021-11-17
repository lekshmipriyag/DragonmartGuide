<div class="item"><?php
    $o = new wpnetbaseCustomSelect("orderby_primary", __("Primary result ordering", "nbt-ajax-search"),
        array(
            'selects' => array(
                array('option' => 'Relevance', 'value' => 'relevance DESC'),
                array('option' => 'Title descending', 'value' => 'title DESC'),
                array('option' => 'Title ascending', 'value' => 'title ASC'),
                array('option' => 'Date descending', 'value' => 'date DESC'),
                array('option' => 'Date ascending', 'value' => 'date ASC')
            ),
            'value' => $sd['orderby_primary']
        ));
    $params[$o->getName()] = $o->getData();
    ?>
    <p class="descMsg"><?php __("This is the primary ordering. If two elements match the primary ordering criteria, the Secondary ordering is used below.", "nbt-ajax-search"); ?></p>
</div>
<div class="item"><?php
    $o = new wpnetbaseCustomSelect("orderby_secondary", __("Secondary result ordering", "nbt-ajax-search"),
        array(
            'selects' => array(
                array('option' => 'Relevance', 'value' => 'relevance DESC'),
                array('option' => 'Title descending', 'value' => 'title DESC'),
                array('option' => 'Title ascending', 'value' => 'title ASC'),
                array('option' => 'Date descending', 'value' => 'date DESC'),
                array('option' => 'Date ascending', 'value' => 'date ASC')
            ),
            'value' => $sd['orderby_secondary']
        ));
    $params[$o->getName()] = $o->getData();
    ?>
    <p class="descMsg"><?php __("For matching elements by primary ordering, this ordering is used.", "nbt-ajax-search"); ?></p>
</div>