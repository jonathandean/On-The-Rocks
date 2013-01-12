<!DOCTYPE html> 
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]--> 
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]--> 
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]--> 
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]--> 
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta name="description" content="<?php bloginfo( 'description', 'display' ); ?>" />
  <meta name="author" content="Jonathan E. Dean">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  
  <title><?php
    /*
     * Print the <title> tag based on what is being viewed.
     */
    global $page, $paged;
  
    wp_title( '|', true, 'right' );
  
    // Add the blog name.
    bloginfo( 'name' );
  
    // Add the blog description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
      echo " | $site_description";
  
    // Add a page number if necessary:
    if ( $paged >= 2 || $page >= 2 )
      echo ' | ' . sprintf( __( 'Page %s', '' ), max( $paged, $page ) );

  ?></title>
  
  <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
  
  <?php
    if ( is_singular() && get_option( 'thread_comments' ) )
      wp_enqueue_script( 'comment-reply' );

    wp_head();

    if(otr_collapse_to_single()){
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
  ?>
</head>
<body <?php body_class(); ?>>
  <div id="page">
    <header class="main">
      <div class="container">
        <?php get_template_part( 'logo' ); ?>
        <?php get_template_part( 'navigation' ); ?>
      </div>
    </header>