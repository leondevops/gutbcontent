<?php
/*
 * @package gutbcontent_plugin
 * @version 1.0.1
 */
?>
<h1>GutbContent Administration Setting pages</h1>

<div class="wrap gutbcontent-admin-panel">
  <h1>Admin Main page - Dashboard</h1>
  <?php settings_errors();?>

  <ul class="nav nav-tabs">
    <li class="active">
      <a href="#tab-1">Manage Settings</a>
    </li>
    <li><a href="#tab-2">Updates</a></li>
    <li><a href="#tab-3">About</a></li>
  </ul>

  <div class="tab-content">
    <div id="tab-1" class="tab-pane active">
      <h3>Admin information panel</h3>

      <form method="post" action="options.php">
        <?php
        /* Display the setting group */

        // old value: devsunshine_options_group
        settings_fields('gutbcontent_plugin_settings');

        /* Input argument is the slug of the page that is registered **/
        do_settings_sections('gutbcontent_plugin');

        // Add submit button
        submit_button();
        ?>
      </form>
    </div><!--tab-1-->
    <div id="tab-2" class="tab-pane">
      <h3>Update panel</h3>
    </div><!--tab-2-->
    <div id="tab-3" class="tab-pane">
      <h3>About panel</h3>
    </div><!--tab-3-->
  </div><!--tab-content-->

</div>