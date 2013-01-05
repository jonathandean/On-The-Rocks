<?php
/* Use a menu for the primary navigation */
if ( ! function_exists( 'otr_register_menu' ) ) :
function otr_register_menu() {
  register_nav_menu('primary-menu', __('Primary Menu'));
}
endif;
add_action('init', 'otr_register_menu');

/* Theme settings */
if ( ! function_exists( 'load_theme_options' ) ) {
  function load_theme_options() {
    require_once ( get_stylesheet_directory() . '/theme-options.php' );
  }
}
add_action('init', 'load_theme_options');

if ( ! function_exists( 'get_otr_option' ) ) {
  function get_otr_option($name){
    if(!isset($GLOBALS['otr_settings'])){
      $GLOBALS['otr_settings'] = get_option( 'otr_options', $GLOBALS['otr_options'] );
    }
    return $GLOBALS['otr_settings'][$name];
  }
}

if ( ! function_exists( 'load_svg_to_png_js' ) ) {
  function load_svg_to_png_js() {
  ?>

  <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/svg_to_png.jquery.js"></script>
  <?php
  }
}
add_action( 'wp_head', 'load_svg_to_png_js' );

if ( ! function_exists( 'otr_collapse_to_single' ) ) {
  function otr_collapse_to_single(){
    if(get_otr_option('hidden_category_method') === 'collapse' && (get_otr_option('collapse_to_single') === true || get_otr_option('collapse_to_single') === 'true')){
      return true;
    }else{
      return false;
    }
  }
}

if ( ! function_exists( 'use_home_page_sidebar' ) ) {
  function use_home_page_sidebar(){
    if(get_otr_option('home_page_sidebar') === true || get_otr_option('home_page_sidebar') === 'true'){
      return true;
    }else{
      return false;
    }
  }
}

if ( ! function_exists( 'otr_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this in a child theme without modifying the comments template
 * simply create your own otr_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function otr_comment( $comment, $args, $depth ) {
  $GLOBALS['comment'] = $comment;
  switch ( $comment->comment_type ) :
    case 'pingback' :
    case 'trackback' :
    // Display trackbacks differently than normal comments.
  ?>
  <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
    <p><?php _e( 'Pingback:', 'framework' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'framework' ), '<span class="edit-link">', '</span>' ); ?></p>
  <?php
      break;
    default :
    // Proceed with normal comments.
    global $post;
  ?>
  <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
    <article id="comment-<?php comment_ID(); ?>" class="comment">
      <header class="comment-meta comment-author vcard">
        <?php
          echo get_avatar( $comment, 44 );
          printf( '<cite class="fn">%1$s %2$s</cite>',
            get_comment_author_link(),
            // If current post author is also comment author, make it known visually.
            ( $comment->user_id === $post->post_author ) ? '<span class="post-author"> ' . __( 'Post author', 'framework' ) . '</span>' : ''
          );
          printf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
            esc_url( get_comment_link( $comment->comment_ID ) ),
            get_comment_time( 'c' ),
            /* translators: 1: date, 2: time */
            sprintf( __( '%1$s at %2$s', 'framework' ), get_comment_date(), get_comment_time() )
          );
        ?>
      </header><!-- .comment-meta -->

      <?php if ( '0' == $comment->comment_approved ) : ?>
        <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'framework' ); ?></p>
      <?php endif; ?>

      <section class="comment-content comment">
        <?php comment_text(); ?>
        <?php edit_comment_link( __( 'Edit', 'framework' ), '<p class="edit-link">', '</p>' ); ?>
      </section><!-- .comment-content -->

      <div class="reply">
        <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', 'framework' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
      </div><!-- .reply -->
    </article><!-- #comment-## -->
  <?php
    break;
  endswitch; // end comment_type check
}
endif;
?>