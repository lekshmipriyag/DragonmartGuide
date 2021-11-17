<?php
$widget_title =  wp_kses_post($instance['widget_title']);
$tabs_selection =  wp_kses_post($instance['tabs_selection']);
?>

<?php if ($widget_title) { ?>
    <h3 class="widget-title">
        <span><?php echo $widget_title ?></span>
    </h3>
<?php } ?>


<?php if($tabs_selection == 'horizontal'): ?>

<!-- tungpk bootstrap tabs -->
<div class="tab-so-widgets-bundle">    
    <ul class="nav nav-pills">

        <?php $ntitle=0;   
        
         $tabname=$instance['tab_name'];

        foreach( $instance['repeater'] as $i => $repeater ) : 
            if($ntitle==0){
                echo '<li class="active">';
            }else{
                echo '<li>';
            }
            ?>
            <?php
            echo '<a data-toggle="pill" href="#tab'.$tabname.$ntitle.'">';
                echo $repeater['tab_title']; ?>
            </a>

        </li>        
        <?php $ntitle ++;
         endforeach; ?>
    </ul> <!-- / tabs -->

    <div class="tab-content">
        
        <?php $ncontent=0;
        foreach( $instance['repeater'] as $i => $repeater ) : 

            if($ncontent==0){
                echo '<div id="tab'.$tabname.$ncontent.'" class="tab-pane fade in active">';
            }
            else{
                    echo '<div id="tab'.$tabname.$ncontent.'" class="tab-pane fade">';
                }
             echo $repeater['tab_content'] ?>

        </div> <!-- / tabs_item -->

        <?php $ncontent ++; endforeach; ?>

    </div> <!-- / tab_content -->
</div> <!-- / tab -->



<?php elseif($tabs_selection == 'vertical'): ?>

    <div class="soua-tab vertical">

        <ul class="soua-tabs ">
            <?php foreach( $instance['repeater'] as $i => $repeater ) : ?>
                <li><a href="#"> <?php echo $repeater['tab_title']; ?></a></li>
            <?php endforeach; ?>
        </ul> <!-- / tabs -->

        <div class="tab_content">
            <?php foreach( $instance['repeater'] as $i => $repeater ) : ?>
                <div class="tabs_item">
                    <p><?php echo $repeater['tab_content'] ?></p>
                </div> <!-- / tabs_item -->
            <?php endforeach; ?>

        </div> <!-- / tab_content -->
    </div> <!-- / tab -->
    <?php elseif($tabs_selection == 'accordion'): ?>
    
	    <div class="soua-main">	
	        
	            <?php foreach( $instance['repeater'] as $i => $repeater ) : ?>
	            <div class="soua-accordion">
	            
	                <a href="#" class="soua-accordion-title"> <?php echo $repeater['tab_title']; ?></a>
	                <div class="soua-accordion-content" style="display:none;"><?php echo $repeater['tab_content'] ?></div>
	            </div>
	            <?php endforeach; ?>
	       
	    </div> <!-- / tab -->    
    
<?php endif; ?>