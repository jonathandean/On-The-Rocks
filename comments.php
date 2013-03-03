<?php
/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
  return;
?>

<div id="comments" class="comments-area">

  <?php // You can start editing here -- including this comment! ?>

  <?php if ( have_comments() ) : ?>
    <h2 class="comments-title">
      <?php
        printf( _n( '1 Comment', '%1s Comments', get_comments_number()), get_comments_number() );
      ?>
    </h2>

    <ol class="commentlist">
      <?php wp_list_comments( array( 'callback' => 'otr_comment', 'style' => 'ol' ) ); ?>
    </ol><!-- .commentlist -->

    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
    <nav id="comment-nav-below" class="navigation" role="navigation">
      <h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'twentytwelve' ); ?></h1>
      <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'twentytwelve' ) ); ?></div>
      <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'twentytwelve' ) ); ?></div>
    </nav>
    <?php endif; // check for comment navigation ?>

  <?php // If comments are closed and there are comments, let's leave a little note.
    elseif ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
  ?>
    <p class="nocomments"><?php _e( 'Comments are closed.', 'twentytwelve' ); ?></p>
  <?php endif; ?>

  <?php comment_form(); ?>

</div><!-- #comments .comments-area -->