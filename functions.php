<?php
/* Use a menu for the primary navigation */
function otr_register_menu() {
  register_nav_menu('primary-menu', __('Primary Menu'));
}
add_action('init', 'otr_register_menu');

/* Theme settings */
require_once ( get_stylesheet_directory() . '/theme-options.php' );

$otr_settings = null;
function get_otr_option($name){
  global $otr_settings;
  if(!isset($otr_settings)){
    $otr_settings = get_option( 'otr_options', $otr_options );
  }
  return $otr_settings[$name];
}

function otr_collapse_to_single(){
  if(get_otr_option('collapse_to_single') === true || get_otr_option('collapse_to_single') === 'true'){
    return true;
  }else{
    return false;
  }
}
?>