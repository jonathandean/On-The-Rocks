<?php

// Credit: http://www.onedesigns.com/tutorials/how-to-create-a-wordpress-theme-options-page

// Default options values
$GLOBALS['otr_options'] = array(
  'hidden_category' => 0,
  'hidden_category_method' => 'filter',
  'collapse_to_single' => 'true',
  'collapse_to_single_label' => 'tweet',
  'collapse_to_single_label_plural' => 'tweets',
  'use_sidebar' => 'true',
  'summaries_on_homepage' => 'true',
  'indent_paragraphs' => 'false',
  'indent_paragraphs_except_first' => 'false',
);

if ( is_admin() ) : // Load only if we are viewing an admin page

function otr_register_settings() {
  // Register settings and call sanitation functions
  register_setting( 'otr_theme_options', 'otr_options', 'otr_validate_options' );
}

add_action( 'admin_init', 'otr_register_settings' );

// Store categories in array
  $GLOBALS['otr_categories'][0] = array(
  'value' => 0,
  'label' => 'None'
);
$otr_cats = get_categories(); $i = 1;
foreach( $otr_cats as $otr_cat ){
  $GLOBALS['otr_categories'][$otr_cat->cat_ID] = array(
    'value' => $otr_cat->cat_ID,
    'label' => $otr_cat->cat_name
  );
  $i++;
}
// Store layouts views in array
  $GLOBALS['otr_hidden_category_methods'] = array(
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
    'label' => 'Load in the loop but hide via CSS (content is available in the markup to work with but pagination may seem odd as they will count toward the item count but not be visible)'
  ),
);

function otr_theme_options() {
  // Add theme options page to the admin menu
  add_theme_page( 'Theme Options', 'Theme Options', 'edit_theme_options', 'theme_options', 'otr_theme_options_page' );
}

add_action( 'admin_menu', 'otr_theme_options' );

// Function to generate options page
function otr_theme_options_page() {

  if ( ! isset( $_REQUEST['updated'] ) )
    $_REQUEST['updated'] = false; // This checks whether the form has just been submitted. ?>

  <div class="wrap">

  <?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Theme Options' ) . "</h2>";
  // This shows the page's name and an icon if one has been provided ?>

  <?php if ( false !== $_REQUEST['updated'] ) : ?>
  <div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
  <?php endif; // If the form has just been submitted, this shows the notification ?>

  <form method="post" action="options.php">

  <?php $settings = get_option( 'otr_options', $GLOBALS['otr_options'] ); ?>
  
  <?php settings_fields( 'otr_theme_options' );
  /* This function outputs some hidden fields required by the form,
  including a nonce, a unique number used to ensure the form has been submitted from the admin page
  and not somewhere else, very important for security */ ?>

  <style type="text/css">
    table.otr-theme-options th{
      font-weight: bold;
    }
    table.otr-theme-options table th{
      border-left: 5px solid #eee;
      padding-left: 30px;
    }
    table.otr-theme-options table table th{
      font-weight: normal;
    }
    table.otr-theme-options th.method{
      width: 60px;
    }
  </style>

  <table class="form-table otr-theme-options">

  <tr valign="top"><th scope="row"><label for="hidden_category">Hidden Category</label></th>
    <td>
      <select id="hidden_category" name="otr_options[hidden_category]">
      <?php
        foreach ( $GLOBALS['otr_categories'] as $category ) :
          $label = $category['label'];
          $selected = '';
          if ( $category['value'] == $settings['hidden_category'] )
            $selected = 'selected="selected"';
          echo '<option style="padding-right: 10px;" value="' . esc_attr( $category['value'] ) . '" ' . $selected . '>' . $label . '</option>';
        endforeach;
      ?>
      </select>
      <table>
        <tr valign="top"><th scope="row" class="method">Method</th>
          <td>
            <?php foreach( $GLOBALS['otr_hidden_category_methods'] as $hidden_method ) : ?>
            <input type="radio" id="<?php echo $hidden_method['value']; ?>" name="otr_options[hidden_category_method]" value="<?php esc_attr_e( $hidden_method['value'] ); ?>" <?php checked( $settings['hidden_category_method'], $hidden_method['value'] ); ?> />
            <label for="<?php echo $hidden_method['value']; ?>"><?php echo $hidden_method['label']; ?></label><br />
            <?php if($hidden_method['value'] === 'collapse') : ?>
              <table>

                <tr valign="top"><th scope="row">Collapsed to a single post (uses JavaScript)</th>
                  <td>
                    <input type="radio" id="single_true" name="otr_options[collapse_to_single]" value="true" <?php checked( $settings['collapse_to_single'], 'true' ); ?> />
                    <label for="single_true">True</label><br />
                    <input type="radio" id="single_false" name="otr_options[collapse_to_single]" value="false" <?php checked( $settings['collapse_to_single'], 'false' ); ?> />
                    <label for="single_true">False</label><br />
                  </td>
                </tr>

                <tr valign="top"><th scope="row">Collapse to single labels</th>
                  <td>
                    <label for="collapse_to_single_label" style="width: 60px; display: inline-block;">Singular</label> <input type="text" id="collapse_to_single_label" name="otr_options[collapse_to_single_label]" value="<?php echo $settings['collapse_to_single_label']; ?>" /> <em>Example: "tweet" displays as "Show 1 hidden tweet"</em><br />
                    <label for="collapse_to_single_label_plural" style="width: 60px; display: inline-block;">Plural</label> <input type="text" id="collapse_to_single_label_plural" name="otr_options[collapse_to_single_label_plural]" value="<?php echo $settings['collapse_to_single_label_plural']; ?>" /> <em>Example: "tweets" displays as "Show 2 hidden tweets"</em>
                  </td>
                </tr>
              </table>
              <?php endif; ?>
            <?php endforeach; ?>
          </td>
        </tr>
      </table>
    </td>
  </tr>

  <tr valign="top"><th scope="row">Use summaries on homepage</th>
    <td>
      <input type="radio" id="summaries_on_homepage_true" name="otr_options[summaries_on_homepage]" value="true" <?php checked( $settings['summaries_on_homepage'], 'true' ); ?> />
      <label for="summaries_on_homepage_true">True <em>(Must still use the "more" tag separator when adding posts)</em></label><br />
      <input type="radio" id="summaries_on_homepage_false" name="otr_options[summaries_on_homepage]" value="false" <?php checked( $settings['summaries_on_homepage'], 'false' ); ?> />
      <label for="summaries_on_homepage_false">False</label><br />
    </td>
  </tr>

  <tr valign="top"><th scope="row">Use sidebar</th>
    <td>
      <input type="radio" id="use_sidebar_true" name="otr_options[use_sidebar]" value="true" <?php checked( $settings['use_sidebar'], 'true' ); ?> />
      <label for="use_sidebar_true">True</label><br />
      <input type="radio" id="use_sidebar_false" name="otr_options[use_sidebar]" value="false" <?php checked( $settings['use_sidebar'], 'false' ); ?> />
      <label for="use_sidebar_false">False</label><br />
    </td>
  </tr>


  <tr valign="top"><th scope="row">Indent paragraphs</th>
    <td>
      <input type="radio" id="indent_paragraphs_true" name="otr_options[indent_paragraphs]" value="true" <?php checked( $settings['indent_paragraphs'], 'true' ); ?> />
      <label for="indent_paragraphs_true">True</label><br />
      <input type="radio" id="indent_paragraphs_false" name="otr_options[indent_paragraphs]" value="false" <?php checked( $settings['indent_paragraphs'], 'false' ); ?> />
      <label for="indent_paragraphs_false">False</label><br />
      <?php if(indent_paragraphs()) : ?>
      <table>

        <tr valign="top"><th scope="row">Don't indent the first paragraph of a group (uses JavaScript)</th>
          <td>
            <input type="radio" id="indent_paragraphs_except_first_true" name="otr_options[indent_paragraphs_except_first]" value="true" <?php checked( $settings['indent_paragraphs_except_first'], 'true' ); ?> />
            <label for="indent_paragraphs_except_first_true">True</label><br />
            <input type="radio" id="indent_paragraphs_except_first_false" name="otr_options[indent_paragraphs_except_first]" value="false" <?php checked( $settings['indent_paragraphs_except_first'], 'false' ); ?> />
            <label for="indent_paragraphs_except_first_true">False</label><br />
          </td>
        </tr>

      </table>
      <?php endif; ?>
    </td>
  </tr>

  </table>

  <p class="submit"><input type="submit" class="button-primary" value="Save Options" /></p>

  </form>

  </div>

  <?php
}

function otr_validate_options( $input ) {

  $settings = get_option( 'otr_options', $GLOBALS['otr_options'] );
  
  // We select the previous value of the field, to restore it in case an invalid entry has been given
  $prev = $settings['hidden_category'];
  // We verify if the given value exists in the categories array
  if ( !array_key_exists( $input['hidden_category'], $GLOBALS['otr_categories'] ) )
    $input['hidden_category'] = $prev;
  
  return $input;
}

endif;  // is_admin()