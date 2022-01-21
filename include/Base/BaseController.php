<?php

/*
 * @package Devsunshine_Plugin
 * @version 1.0.1
 */

namespace Vnlab\Gutbcontent\Inc\Base;

use Vnlab\Gutbcontent\Inc\Pages\Admin\SettingsManagerPage;

class BaseController
{
  public string $pluginPath;
  public string $pluginUrl;
  public string $plugin;

  public array $settingPageManagers = array();



  /* 3. Define several global variables use across the current plugin (Devsunshine plugin scope)
 * PLUGIN_PATH: C:\WebPlatform\apache24\htdocs\vnlabwin\wp-content\plugins\devsunshine-plugin/ *
 * PLUGIN_URL: http://vnlabwin.local.info/wp-content/plugins/devsunshine-plugin/
 * PLUGIN: devsunshine-plugin/devsunshine-plugin.php (plugin basename)
 * **/
  public function __construct(){
    $this->pluginPath = plugin_dir_path( dirname(__FILE__ , 2) );
    $this->pluginUrl = plugin_dir_url( dirname(__FILE__ , 2) );
    $this->plugin = plugin_basename( dirname(__FILE__ , 3).'/gutbcontent.php' );

    $this->settingPageManagers = array(
      SettingsManagerPage::createObj('gutbcontent_block_manager', 'Custom Gutenberg Content Manager','gutbcontent-block-manager'),
      SettingsManagerPage::createObj('shortcode_manager', 'Custom Shortcode Manager','gutbcontent-shortcode-manager'),
      SettingsManagerPage::createObj('widgets_manager', 'Custom Widgets Manager', 'gutbcontent-widgets-manager'),
      SettingsManagerPage::createObj('templates_manager','Custom Templates Manager','gutbcontent-templates-manager'),
    );

  }

}