<?php
  /* Always have wp_footer() just before the closing </body>
   * tag of your theme, or you will break many plugins, which
   * generally use this hook to reference JavaScript files.
   */

  wp_footer();
?>
  <footer class="main">
    <!-- You may remove the credits to me but I do greatly appreciate it if you keep them :) Thanks! ~Jonathan Dean -->
    <p>&copy; <?php echo date( 'Y' ); ?> <?php bloginfo('name'); ?>. Powered by <a href="http://wordpress.org">WordPress</a> and the <a href="https://github.com/jonathandean/On-The-Rocks">On The Rocks</a> theme by <a href="http://jonathandean.com">Jonathan Dean</a>.</p>
  </footer>
  </div><?php /* #page */ ?>
</body>
</html>