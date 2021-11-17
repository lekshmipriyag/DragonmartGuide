<div class="wrap" id="wpnetbase"> 
    <div class="item">
      <?php 
        $o = new wpnetbaseColorPicker("imagebg_1","Test background", 'rgba(255, 255, 0, 0.6)');
      ?>
    </div>
    <div class="item">
      <?php 
        $o = new wpnetbaseColorPicker("imagebg_2","Test background", 'rgba(255, 0, 0, 0.6)');
      ?>
    </div>
    <div class="item">
    <?php       
      $o = new wpnetbaseBoxShadowMini("inputshadow_1", "Search input field Shadow", '');
    ?>
    </div>
    <div class="item">
    <?php       
      $o = new wpnetbaseTextShadowMini("inputshadow_44", "Shadow", 'text-shadow:1px 2px 3px #123123;');
    ?>
    </div>
    <div class="item">
    <?php       
      $o = new wpnetbaseFontMini("titlefont_1", "Results title link font", "font-weight:normal;font-family:'Arial', Helvetica, sans-serif;color:#adadad;font-size:12px;line-height:15px;");
    ?>
    </div>
    <div class="item">
    <?php       
      $o = new wpnetbaseNumericUnit("numericunit", "Test",
        array(
          'units'=>array(
            'px'=>'px',
            'em'=>'em'
           ),
           'value'=>'123px'
        )
      );
    ?>
    </div>
</div>