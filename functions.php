<?php
// Register a sidebar

register_sidebar(array(
  'name' => __( 'Right Column' ),
  'description' => __( 'Widgets in this area will be shown on the right-hand side.' ),
  'before_title' => '<h2>',
  'after_title' => '</h2>'
));

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

if ( ! function_exists( 'load_svg_fallback_jquery' ) ) {
  function load_svg_fallback_jquery() {
  ?>

  <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/svg_fallback.jquery.js"></script>
  <?php
  }
}
add_action( 'wp_head', 'load_svg_fallback_jquery' );

if ( ! function_exists( 'load_svg_fallback_js' ) ) {
  function load_svg_fallback_js() {
  ?>

  <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/svg_fallback.js"></script>
  <?php
  }
}
// Not using this version, using the jQuery version defined above. Left here in case you prefer to un-register that action and register this one instead in your Child Theme
// See the README for how to do this in your Child Theme
// add_action( 'wp_footer', 'load_svg_fallback_js' );


if ( ! function_exists( 'otr_collapse_to_single' ) ) {
  function otr_collapse_to_single(){
    if(get_otr_option('hidden_category_method') === 'collapse' && (get_otr_option('collapse_to_single') === true || get_otr_option('collapse_to_single') === 'true')){
      return true;
    }else{
      return false;
    }
  }
}

if ( ! function_exists( 'load_otr_collapse_to_single_js' ) ) {
  function load_otr_collapse_to_single_js() {
    ?>

  <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/otr_collapse.js"></script>
  <script type="text/javascript">
    var otr_c = new OTR.Collapse({
      otr_cts_label: "<?php echo get_otr_option('collapse_to_single_label'); ?>",
      otr_cts_label_plural: "<?php echo get_otr_option('collapse_to_single_label_plural'); ?>"
    });
    jQuery(function(){
      otr_c.setup();
    });
  </script>
  <?php
  }
}
if(otr_collapse_to_single()){
  add_action( 'wp_head', 'load_otr_collapse_to_single_js' );
}

if ( ! function_exists( 'use_sidebar' ) ) {
  function use_sidebar(){
    if(get_otr_option('use_sidebar') === true || get_otr_option('use_sidebar') === 'true'){
      return true;
    }else{
      return false;
    }
  }
}

if ( ! function_exists( 'use_summaries_on_homepage' ) ) {
  function use_summaries_on_homepage(){
    if(get_otr_option('summaries_on_homepage') === true || get_otr_option('summaries_on_homepage') === 'true'){
      return true;
    }else{
      return false;
    }
  }
}

if ( ! function_exists( 'indent_paragraphs' ) ) {
  function indent_paragraphs(){
    if(get_otr_option('indent_paragraphs') === true || get_otr_option('indent_paragraphs') === 'true'){
      return true;
    }else{
      return false;
    }
  }
}

if ( ! function_exists( 'indent_paragraphs_except_first' ) ) {
  function indent_paragraphs_except_first(){
    if(get_otr_option('indent_paragraphs_except_first') === true || get_otr_option('indent_paragraphs_except_first') === 'true'){
      return true && indent_paragraphs();
    }else{
      return false;
    }
  }
}

if ( ! function_exists( 'load_p_first_js' ) ) {
  function load_p_first_js() {
    ?>

  <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/p.first.js"></script>
  <?php
  }
}
// Only needed when the indent paragraphs and indent paragraphs except first theme options are on
if (indent_paragraphs_except_first()) {
  add_action( 'wp_footer', 'load_p_first_js' );
}

if ( ! function_exists( 'get_category_link_by_name' ) ) {
  function get_category_link_by_name( $name ){
    $cat_id = get_cat_ID( $name );
    if ( $cat_id ) {
      return esc_url( get_category_link( $cat_id ) );
    } else {
      return '';
    }
  }
}

if ( ! function_exists( 'extra_body_classes' ) ) {
  function extra_body_classes(){
    $classes = array();
    if(indent_paragraphs()) {
      array_push($classes, 'indent-paragraphs');
    }
    if(indent_paragraphs_except_first()) {
      array_push($classes, 'indent-paragraphs-except-first');
    }
    return $classes;
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
      <div class="avatar">
        <?php echo get_avatar( $comment, 160 ); ?>
        <?php echo ( $comment->user_id === $post->post_author ) ? '<span class="post-author">' . __( 'Post author', 'framework' ) . '</span>' : ''; ?>
      </div>
      <div class="content">
        <header class="comment-meta comment-author vcard">
          <?php
            echo '<div class="author-time">';
            printf( '<cite class="fn">%1$s</cite>',
              get_comment_author_link()
            );
            printf( '<time pubdate datetime="%1$s">%2$s</time></a>',
              get_comment_time( 'c' ),
              /* translators: 1: date, 2: time */
              sprintf( __( '%1$s at %2$s', 'framework' ), get_comment_date(), get_comment_time() )
            );
            echo '</div>'; // .author-time
          ?>
        </header><?php /* .comment-meta */ ?>

        <?php if ( '0' == $comment->comment_approved ) : ?>
          <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'framework' ); ?></p>
        <?php endif; ?>

        <section class="comment-content comment">
          <?php comment_text(); ?>
        </section><?php /* .comment-content */ ?>

        <footer>
          <div class="actions">
            <?php edit_comment_link( __( 'Edit', 'framework' ), '<div class="edit">', '</div>' ); ?>
            <div class="reply">
              <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'framework' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
            </div>
            <div class="link">
              <?php
                printf( '<a href="%1$s">Link to this comment</a>',
                  esc_url( get_comment_link( $comment->comment_ID ) )
                );
              ?>
            </div>
          </div>
        </footer>

      </div><?php /* .content */ ?>
    </article><?php /* #comment-## */ ?>
  <?php
    break;
  endswitch; // end comment_type check
}
endif;
?>