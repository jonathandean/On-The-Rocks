<?php

// Credit: http://www.onedesigns.com/tutorials/how-to-create-a-wordpress-theme-options-page

// Default options values
$otr_options = array(
  'hidden_category' => 0,
  'hidden_category_method' => 'filter'
);

if ( is_admin() ) : // Load only if we are viewing an admin page

function otr_register_settings() {
  // Register settings and call sanitation functions
  register_setting( 'otr_theme_options', 'otr_options', 'otr_validate_options' );
}

add_action( 'admin_init', 'otr_register_settings' );

// Store categories in array
$otr_categories[0] = array(
  'value' => 0,
  'label' => 'None'
);
$otr_cats = get_categories(); $i = 1;
foreach( $otr_cats as $otr_cat ) :
  $otr_categories[$otr_cat->cat_ID] = array(
    'value' => $otr_cat->cat_ID,
    'label' => $otr_cat->cat_name
  );
  $i++;
endforeach;

// Store layouts views in array
$otr_hidden_category_methods = array(
  'filter' => array(
    'value' => 'filter',
    'label' => 'Filter from the loop (never loaded in the page)'
  ),
  'collapse' => array(
    'value' => 'collapse',
    'label' => 'Show in a special collapsed view (available for search engine indexing)'
  ),
  'hide' => array(
    'value' => 'hide',
    'label' => 'Load in the loop but hide via CSS (available for search engine indexing, pagination may seem odd as they will count toward the item count but not be visible)'
  ),
);

function otr_theme_options() {
  // Add theme options page to the addmin menu
  add_theme_page( 'Theme Options', 'Theme Options', 'edit_theme_options', 'theme_options', 'otr_theme_options_page' );
}

add_action( 'admin_menu', 'otr_theme_options' );

// Function to generate options page
function otr_theme_options_page() {
  global $otr_options, $otr_categories, $otr_hidden_category_methods;

  if ( ! isset( $_REQUEST['updated'] ) )
    $_REQUEST['updated'] = false; // This checks whether the form has just been submitted. ?>

  <div class="wrap">

  <?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Theme Options' ) . "</h2>";
  // This shows the page's name and an icon if one has been provided ?>

  <?php if ( false !== $_REQUEST['updated'] ) : ?>
  <div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
  <?php endif; // If the form has just been submitted, this shows the notification ?>

  <form method="post" action="options.php">

  <?php $settings = get_option( 'otr_options', $otr_options ); ?>
  
  <?php settings_fields( 'otr_theme_options' );
  /* This function outputs some hidden fields required by the form,
  including a nonce, a unique number used to ensure the form has been submitted from the admin page
  and not somewhere else, very important for security */ ?>

  <table class="form-table"><!-- Grab a hot cup of coffee, yes we're using tables! -->

  <tr valign="top"><th scope="row"><label for="hidden_category">Hidden Category</label></th>
  <td>
  <select id="hidden_category" name="otr_options[hidden_category]">
  <?php
  foreach ( $otr_categories as $category ) :
    $label = $category['label'];
    $selected = '';
    if ( $category['value'] == $settings['hidden_category'] )
      $selected = 'selected="selected"';
    echo '<option style="padding-right: 10px;" value="' . esc_attr( $category['value'] ) . '" ' . $selected . '>' . $label . '</option>';
  endforeach;
  ?>
  </select>
  </td>
  </tr>
  
  <tr valign="top"><th scope="row">Hidden Category Method</th>
    <td>
    <?php foreach( $otr_hidden_category_methods as $hidden_method ) : ?>
    <input type="radio" id="<?php echo $hidden_method['value']; ?>" name="otr_options[hidden_category_method]" value="<?php esc_attr_e( $hidden_method['value'] ); ?>" <?php checked( $settings['hidden_category_method'], $hidden_method['value'] ); ?> />
    <label for="<?php echo $hidden_method['value']; ?>"><?php echo $hidden_method['label']; ?></label><br />
    <?php endforeach; ?>
    </td>
  </tr>

  </table>

  <p class="submit"><input type="submit" class="button-primary" value="Save Options" /></p>

  </form>

  </div>

  <?php
}

function otr_validate_options( $input ) {
  global $otr_options, $otr_categories, $otr_layouts;

  $settings = get_option( 'otr_options', $otr_options );
  
  // We select the previous value of the field, to restore it in case an invalid entry has been given
  $prev = $settings['hidden_category'];
  // We verify if the given value exists in the categories array
  if ( !array_key_exists( $input['hidden_category'], $otr_categories ) )
    $input['hidden_category'] = $prev;
  
  return $input;
}

endif;  // is_admin()