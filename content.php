<?php
  $otr_settings = get_option( 'otr_options', $otr_options );
  $hidden = false;
  $article_class_extra = '';
  if(in_category($otr_settings['hidden_category'])){
    $hidden = true;
    if($otr_settings['hidden_category_method'] == 'hide'){
      $article_class_extra = 'hidden';
    }else if($otr_settings['hidden_category_method'] == 'collapse'){
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
      <?php the_content('more...'); ?>
    </div>
  <?php endif; ?>
</article>