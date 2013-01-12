<nav role="navigation">
  <?php if ( has_nav_menu( 'primary-menu' ) ) { /* if menu location 'primary-menu' exists then use custom menu */ ?>
  <?php wp_nav_menu( array( 'theme_location' => 'primary-menu') ); ?>
  <?php } else { /* else use wp_list_categories */ ?>
  <ul>
    <?php wp_list_pages(array('depth' => 1, 'title_li' => null)); ?>
  </ul>
  <?php } ?>
</nav>