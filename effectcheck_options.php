<?php
// create custom plugin settings menu
add_action('admin_menu', 'effectcheck_create_menu');

/* hook into WP events */
function effectcheck_create_menu() {
  //create new top-level menu
  add_menu_page('EffectCheck Sentiment Plugin Settings', '&nbsp;<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Settings', 'administrator', __FILE__, 
                'effectcheck_settings_page', plugins_url('logo.png', __FILE__));
  //call register settings function
  add_action( 'admin_init', 'register_effectcheck_settings' );
}

function register_effectcheck_settings() {
  //register our settings
  register_setting( 'effectcheck-settings-group', 'effectcheck_username' );
  register_setting( 'effectcheck-settings-group', 'effectcheck_password' );
}

function effectcheck_settings_page() {
?>
<div class="wrap">
  <h2>EffectCheck Sentiment Detector Plugin</h2>
  <form method="post" action="options.php">
    <?php settings_fields( 'effectcheck-settings-group' ); ?>

    <div>
      Check the sentiment of your writing to better target your audience.  
      With EffectCheck, you will be able to quickly tell if the tone of your post is sad, happy, or compassionate.
      <br/>
      <br/>
      <br/>If you don't have an account yet, please sign up at <a href="http://effectcheck.com"/>EffectCheck.com</a>
    </div>
        
    <table class="form-table">
      <tr valign="top">
      <th scope="row">Your EffectCheck API Username</th>
      <td><input type="text" name="effectcheck_username" value="<?php echo get_option('effectcheck_username'); ?>" /></td>
      </tr>
   
      <tr valign="top">
      <th scope="row">Password</th>
      <td><input type="text" name="effectcheck_password" value="<?php echo get_option('effectcheck_password'); ?>" /></td>
      </tr>
    </table>
    <p class="submit">
      <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>
    
    <hr/>
    <div style="float: right;">
      Powered By <a href="http://effectcheck.com"><img align="middle" src="<?= plugins_url('logo.png', __FILE__) ?>"/></a>
      <br/>
      Pluginized by <a href="http://alexle.net">Alex Le</a>.<br/>
      (C) 2011 <a href="http://marrily.com">Marrily</a> - The Best Wedding Planner.
    </div>
    <div style="clear:both"></div>
  </form>
</div>
<?php } ?>