<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <header class="article">
    <h1><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
  </header>
</article>