<article id="post-<?php the_ID(); ?>" <?php post_class(extra_article_classes()); ?>>
  <header class="article">
    <h1><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
    <?php if(!is_page()) : ?>
      <p class="date"><span>on</span> <time datetime="<?php the_time('c'); ?>"><?php the_time( get_option('date_format') ); ?></time></p>
    <?php endif; // !is_page() ?>
  </header>
  <?php if ( is_search() ) : // Only display Excerpts for Search ?>
    <div class="summary">
      <?php the_excerpt(); ?>
    </div>
  <?php else : ?>
    <div class="content">
      <?php the_content('continue reading...'); ?>
    </div>
  <?php endif; // is_search() ?>
  <?php if(!is_page()) : ?>
    <footer class="meta">
      <cite class="author"><span>by</span> <?php the_author(); ?></cite>
      <time datetime="<?php the_time('c'); ?>" class="date"><span>on</span> <?php the_time( get_option('date_format') ); ?></time>
      <span class="category"><span>in</span> <?php the_category(', ') ?></span>
      <span class="comments"><span>with</span>  <?php comments_popup_link(__('No comments', 'framework'), __('1 Comment', 'framework'), __('% Comments', 'framework')); ?></span>
      <?php edit_post_link( __('edit', 'framework'), '<span class="edit-post">[', ']</span>' ); ?>
      <?php /* <a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink(); ?>" data-text="<?php bloginfo('name'); ?>: <?php the_title(); ?>," data-count="horizontal">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script> */ ?>
    </footer>
    <section class="comments">
      <article class="comments">
      <?php
        // If comments are open or we have at least one comment, load up the comment template
        if ( comments_open() || '0' != get_comments_number() )
          comments_template( '', true );
        ?>
      </article>
    </section>
  <?php endif; // !is_page() ?>
</article>