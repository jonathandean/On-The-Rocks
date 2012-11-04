<?php
  $hidden = false;
  $article_class_extra = '';
  if(in_category(get_otr_option('hidden_category'))){
    $hidden = true;
    if(get_otr_option('hidden_category_method') == 'hide'){
      $article_class_extra = 'hidden';
    }else if(get_otr_option('hidden_category_method') == 'collapse'){
      $article_class_extra = 'collapse';
    }
  }
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($article_class_extra); ?>>
  <header class="article">
    <h1><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
  </header>
  <?php if ( is_search() ) : // Only display Excerpts for Search ?>
    <div class="summary">
      <?php the_excerpt(); ?>
    </div>
  <?php else : ?>
    <div class="content">
      <?php the_content('continue reading...'); ?>
    </div>
  <?php endif; ?>
  <footer class="meta">
    <span class="author"><span>by</span> <?php the_author(); ?></span> <span class="date"><span>on</span> <?php the_time( get_option('date_format') ); ?></span> <span class="category"><span>in</span> <?php the_category(', ') ?></span> <span class="comments"><span>with</span>  <?php comments_popup_link(__('No comments', 'framework'), __('1 Comment', 'framework'), __('% Comments', 'framework')); ?></span> <?php edit_post_link( __('edit', 'framework'), '<span class="edit-post">[', ']</span>' ); ?><!--<a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink(); ?>" data-text="<?php bloginfo('name'); ?>: <?php the_title(); ?>," data-count="horizontal">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>-->
  </footer>
</article>