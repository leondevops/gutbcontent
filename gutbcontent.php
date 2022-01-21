<?php
/*
 * @package gutbcontent_plugin
 * @version 1.0.1
 */


use Vnlab\Gutbcontent\Inc\Base\Activator as PluginActivator;
use Vnlab\Gutbcontent\Inc\Base\Deactivator as PluginDeactivator;
use Vnlab\Gutbcontent\Inc\Init as PluginInit;

/*
Plugin Name: Gutbcontent
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: A brief description of the Plugin.
Version: 1.0
Author: leon
Author URI: http://URI_Of_The_Plugin_Author
License: A "Slug" license name e.g. GPL2
*/

/* 1. Validate the proper access of plugin */
// defined('ABS_PATH') return false ???
defined('ABSPATH') or die('ABS_PATH is not defined. You are not authenticated to use this plugin');

if(!function_exists('add_action')){
  echo '<h5>You are not authenticated to use this plugin</h5>';
  exit;
}

/* 2. Define plugin global variables use across the current plugin (Devsunshine plugin scope)
 * PLUGIN_PATH: C:\WebPlatform\apache24\htdocs\vnlabwin\wp-content\plugins\devsunshine-plugin/ *
 * PLUGIN_URL: http://vnlabwin.local.info/wp-content/plugins/devsunshine-plugin/
 * PLUGIN: devsunshine-plugin/devsunshine-plugin.php (plugin basename)
 * **/

define('GUTBCONTENT_PLUGIN_PATH', plugin_dir_path(__FILE__)); //OK
define('GUTBCONTENT_PLUGIN_URL', plugin_dir_url(__FILE__)); //OK
define('GUTBCONTENT_PLUGIN', plugin_basename(__FILE__)); //OK

/* 3. Include autoloader of Composer
* - This will also include all custom resources loaded by Composer
* + The Composer load all custom resources using PSR-4 autoload
*/

if( file_exists( dirname(__FILE__).'/vendor/autoload.php' ) ){
  require_once( dirname(__FILE__).'/vendor/autoload.php' );
}

//require('include/Init.php');

/* 4. Register activation hooks, deactivation hooks for the current plugin */
function activate_gutbcontent_plugin(){
  //Vnlab\Gutbcontent\Inc\Base\Activator::activate();
  PluginActivator::activate();
}
register_activation_hook(__FILE__, 'activate_gutbcontent_plugin');


function deactivate_gutbcontent_plugin(){
  //Vnlab\Gutbcontent\Inc\Base\Deactivator::deactivate();
  PluginDeactivator::deactivate();
}
register_deactivation_hook(__FILE__, 'deactivate_gutbcontent_plugin');

/** 5. Start initialize all plugins services if exists the Init class files **/

if( class_exists('Vnlab\\Gutbcontent\\Inc\\Init') ){
  //Vnlab\Gutbcontent\Inc\Init::register_services();
  PluginInit::register_services();
}