<?php
function register_menu() {
  register_nav_menu('primary-menu', __('Primary Menu'));
}
add_action('init', 'register_menu');
?>