<?php
/* Use a menu for the primary navigation */
function otr_register_menu() {
  register_nav_menu('primary-menu', __('Primary Menu'));
}
add_action('init', 'otr_register_menu');

/* Theme settings */
require_once ( get_stylesheet_directory() . '/theme-options.php' );
?>