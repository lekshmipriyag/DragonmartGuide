<?php
/************************************************************************/
/* @category 	Multi cms with multi permissions 						*/
/* @package 	Shop listing portal 									*/
/* @author 		Original Author Raja Ram R <rajaram234r@gmail.com>		*/
/* @author 		Another Author Farook <mohamedfarooks@gmail.com> 		*/
/* @copyright 	2016 - 2017 ewebeye.com 								*/
/* @license 	Raja Ram R 												*/
/* @since 		This file available since 2.10 							*/
/* @date 		Created date 03/07/2017 								*/
/* @modify 		Latest modified date 02/10/2017 						*/
/* @code 		PHP 5.7 												*/
/************************************************************************/
?>
<?php

//initialize the session
if ( !isset( $_SESSION ) ) {
	session_start();
}

/* ---------- common functions --------------------*/
//$timezone = $_SESSION['comData']['timesone'];
if ( function_exists( 'date_default_timezone_set' ) )date_default_timezone_set( 'Asia/Dubai' );
$national_date_time_24 = date( 'Y-m-d H:i:s' );
$_SESSION[ 'now' ] = $national_date_time_24;
/* ---------- common functions --------------------*/
?>
<?php
function limit_text($text, $limit) {
      if (str_word_count($text, 0) > $limit) {
          $words = str_word_count($text, 2);
          $pos = array_keys($words);
          $text = substr($text, 0, $pos[$limit]) . '...';
      }
      return $text;
    }

?>
