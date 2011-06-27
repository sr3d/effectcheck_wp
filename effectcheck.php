<?php
/**
 * @package EffectCheck_WP
 * @version 0.1
 */
/*
Plugin Name: Effect Check for Writer
Plugin URI: http://marrily.com
Description: Hackathon to use EffectCheck API for WP writer to quickly check the tone of their writing
Author: Alex Le
Version: 0.1
Author URI: http://marrily.com
*/


function effectcheck_custom_box() {
  add_meta_box( 'effectcheck', __('EffectCheck Sentiment Detector', 'effectcheck'), 'effectcheck_meta_box', 'post', 'normal');
  add_meta_box( 'effectcheck', __('EffectCheck Sentiment Detector', 'effectcheck'), 'effectcheck_meta_box', 'page', 'normal');

};

/* Render the HTML for the Meta box in WP write/edit screen */
function effectcheck_meta_box() {
  include 'effectcheck_metabox.php';
};


if( WP_ADMIN ) {
  /* Register the metabox in the New/Edit page */
  add_action( 'add_meta_boxes', 'effectcheck_custom_box' ); 
  
  /* Ajax handler to integrate with EffectCheck's API */
  include 'effectcheck_ajax.php';
  
  /* Register the Options page so user can set the API credentials */
  include 'effectcheck_options.php';  
};

?>
