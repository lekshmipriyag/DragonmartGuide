<?php
/* Prevent direct access */
defined('ABSPATH') or die("You can't access this file directly.");

$com_options = wd_asl()->o['asl_compatibility'];

if (ASL_DEMO) $_POST = null;
?>

<div id="wpnetbase" class='wpnetbase wrap'>
    <div class="wpnetbase-box">

        <?php ob_start(); ?>


        <fieldset>
            <legend>CSS and JS compatibility</legend>

            <div class="item">
                <?php
                $o = new wpnetbaseCustomSelect("js_source", "Javascript source", array(
                        'selects'   => array(
                            array('option' => 'Non minified', 'value' => 'nomin'),
                            /*array('option' => 'Minified', 'value' => 'min'),
                            array('option' => 'Non-minified scoped', 'value' => 'nomin-scoped'),
                            array('option' => 'Minified scoped', 'value' => 'min-scoped'),*/
                        ),
                        'value'     => $com_options['js_source']
                    )
                );
                $params[$o->getName()] = $o->getData();
                ?>
                
            </div>
            <div class="item">
                <?php
                $o = new wpnetbaseCustomSelect("js_init", "Javascript init method", array(
                        'selects'=>array(
                            array('option'=>'Dynamic (default)', 'value'=>'dynamic'),
                            array('option'=>'Blocking', 'value'=>'blocking')
                        ),
                        'value'=>$com_options['js_init']
                    )
                );
                $params[$o->getName()] = $o->getData();
                ?>
                <p class="descMsg">
                    Try to choose <strong>Blocking</strong> if the search bar is not responding to anything.
                </p>
            </div>
            <div class="item">
                <?php $o = new wpnetbaseYesNo("detect_ajax", "Try to re-initialize if the page was loaded via ajax?",
                    $com_options['detect_ajax']
                ); ?>
                <p class='descMsg'>Will try to re-initialize the plugin in case an AJAX page loader is used, like Polylang language switcher etc..</p>
            </div>
            <div class="item">
                <?php
                $o = new wpnetbaseCustomSelect("load_mcustom_js", "Load the scrollbar script?", array(
                        'selects'=>array(
                            array('option'=>'Yes', 'value'=>'yes'),
                            array('option'=>'No', 'value'=>'no')
                        ),
                        'value'=>$com_options['load_mcustom_js']
                    )
                );
                $params[$o->getName()] = $o->getData();
                ?>
                <p class='descMsg'>
                <ul>
                    <li>When set to <strong>No</strong>, the custom scrollbar will <strong>not be used at all</strong>.</li>
                </ul>
                </p>
            </div>

        </fieldset>
        <fieldset>
            
            <div class="item">
                <?php
                $o = new wpnetbaseCustomSelect("db_force_case", "Force case", array(
                        'selects'=> array(
                            array('option' => 'None', 'value' => 'none'),
                            array('option' => 'Sensitivity', 'value' => 'sensitivity'),
                            array('option' => 'InSensitivity', 'value' => 'insensitivity')
                        ),
                        'value'=>$com_options['db_force_case']
                    )
                );
                $params[$o->getName()] = $o->getData();
                ?>
            </div>
            <div class="item">
                <?php $o = new wpnetbaseYesNo("db_force_unicode", "Force unicode search",
                    $com_options['db_force_unicode']
                ); ?>
                <p class='descMsg'>Will try to force unicode character conversion on the search phrase.</p>
            </div>
            <div class="item">
                <?php $o = new wpnetbaseYesNo("db_force_utf8_like", "Force utf8 on LIKE operations",
                    $com_options['db_force_utf8_like']
                ); ?>
                <p class='descMsg'>Will try to force utf8 conversion on all LIKE operations in the WHERE and HAVING clauses.</p>
            </div>

        </fieldset>

        <?php $_r = ob_get_clean(); ?>


        <?php

        // Compatibility stuff
        $updated = false;
        if ( isset($_POST) && isset($_POST['asl_compatibility']) ) {
            $values = array(
                // CSS and JS
                "js_source" => $_POST['js_source'],
                "js_init" => $_POST['js_init'],
                "load_mcustom_js" => $_POST['load_mcustom_js'],
                "detect_ajax" => $_POST['detect_ajax'],
                // Query options
                "db_force_case" => $_POST['db_force_case'],
                "db_force_unicode" => $_POST['db_force_unicode'],
                "db_force_utf8_like" => $_POST['db_force_utf8_like']
            );
            update_option('asl_compatibility', $values);
            $updated = true;
        }

        ?>

        <div class='wpnetbase-slider'>

            <?php if ($updated): ?>
                <div class='successMsg'>Search compatibility settings successfuly updated!</div><?php endif; ?>

            <?php if (ASL_DEMO): ?>
                <p class="infoMsg">DEMO MODE ENABLED - Please note, that these options are read-only</p>
            <?php endif; ?>

            <div id="content" class='tabscontent'>

                <!-- Compatibility form -->
                <form name='compatibility' method='post'>

                    <?php print $_r; ?>

                    <div class="item">
                        <input type='submit' class='submit' value='Save options'/>
                    </div>
                    <input type='hidden' name='asl_compatibility' value='1'/>
                </form>

            </div>
        </div>
    </div>
</div>