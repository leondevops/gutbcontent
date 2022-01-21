<?php
/*
 * @package Devsunshine_Plugin
 * @version 1.0.1
 */
namespace Vnlab\Gutbcontent\Inc\Base;

if( !class_exists('Activator') ) {

class Activator {

  public function __construct(){

  }

  public static function activate(){

    flush_rewrite_rules();

    /* Update default value at database for plugin */
    $defaultSettingManager = array(
      'gutbcontent_block_manager' => false,
      'shortcode_manager'         => false,
      'widgets_manager'           => false,
      'templates_manager'         => true,
    );

    if( ! get_option( 'gutbcontent_plugin' ) ){
      update_option('gutbcontent_plugin', $defaultSettingManager);
    }

  }
}

} // if(! class_exists('Activator') )
