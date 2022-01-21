<?php
/*
 * @package Devsunshine_Plugin
 * @version 1.0.1
 */


namespace Vnlab\Gutbcontent\Inc\Base;


class SettingsLinks extends BaseController
{
  // For debug
  //public $debugger;

  public function __construct(){
    parent::__construct();

    // For debug
    /*include_once($this->plugin_path.'troubleshoot/plugin-custom-debugger.php');
    $this->debugger = new \Plugin_Custom_Debugger();*/
  }

  public function register(){
    // $this->debugger->write_log_general($this->plugin);
    add_filter( "plugin_action_links_$this->plugin", array( $this, 'addPluginSettingLink' ) );
  }

  /* Create new links from given links (as input arguments) */
  function addPluginSettingLink( $links ){
    $settingLink = '<a href="admin.php?page=gutbcontent_plugin">Settings</a>';
    // Attach the settings links to the end of links array
    array_push($links, $settingLink);

    return $links;
  }
}