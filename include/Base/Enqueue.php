<?php
/*
 * @package Devsunshine_Plugin
 * @version 1.0.1
 */

namespace Vnlab\Gutbcontent\Inc\Base;


class Enqueue extends BaseController
{
  public function register(){
    // Enqueue the scripts in admin setting pages - using admin_enqueue_scripts hook
    add_action('admin_enqueue_scripts', array($this, 'enqueue_styles_scripts') );
  }

  function enqueue_styles_scripts(){
    /* 1. Include the pure CSS & Vanilla JS */
    // 1. CSS
    wp_enqueue_style(
      'gutbcontent-admin-style',$this->pluginUrl.'/assets/admin/css/gutbcontent-admin.css',
      array(), '1.0.1', 'all'
    );

    wp_enqueue_style('dashicons');

    // 2. JS
    // De-register the default WordPress JQuery (old version)
    //wp_deregister_script('jquery'); // Must enqueue alternate JQuery

    // 2.1. Register external jQuery (for newer versions)
    //wp_register_script('jquery', $this->pluginUrl.'/assets/js/prelib/jquery.min.js',
    //  false, '3.6.0', true);

    //wp_enqueue_script('jquery');

    // 2.2. Media Uploader scripts
    wp_enqueue_script('media-upload');
    wp_enqueue_media(); // Register all stuffs of WordPress Media Uploader

    // Register the custom script
    wp_enqueue_script(
      'gutbcontent-admin-script',$this->pluginUrl.'/assets/admin/js/gutbcontent-admin.js',
      array('jquery'), '1.0.1', true
    );

    /* 2. Include the minified version (will produce when the development process is done) */
    /*// 1. CSS
    wp_enqueue_style(
      'devsunshine-admin-style',$this->plugin_url.'/assets/css/devsunshine-admin.min.css',
      array(), '1.0.1', 'all'
    );

    // 2. JS
    wp_enqueue_script(
      'devsunshine-admin-script',$this->plugin_url.'/assets/js/devsunshine-admin.min.js',
      array('jquery'), '1.0.1', true
    );*/
  }

  public function getAllWpRegisteredStyles(){
    global $wp_styles;
    $enqueued_styles = array();

    foreach( $wp_styles->queue as $handle ) {
      $enqueued_styles[] = $wp_styles->registered[$handle]->src;
    }

    return $enqueued_styles;
  }

  public function getAllWpRegisteredScripts(){
    global $wp_scripts;

    $enqueued_scripts = array();
    foreach( $wp_scripts->queue as $handle ) {
      $enqueued_scripts[] = $wp_scripts->registered[$handle]->src;
    }

    return $enqueued_scripts;
  }
}