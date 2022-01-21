<?php
/*
 * @package Devsunshine_Plugin
 * @version 1.0.1
 */

namespace Vnlab\Gutbcontent\Inc\Controller;

use Vnlab\Gutbcontent\Inc\Api\Callbacks\AdminCallbacks;
use Vnlab\Gutbcontent\Inc\Base\BaseController;
use Vnlab\Gutbcontent\Inc\Api\SettingsApi;
//use Vnlab\Gutbcontent\Inc\Api\Widgets\MediaWidget;


class CustomWidgets extends BaseController
{
  public array $subpages;
  public SettingsApi $settings;
  public AdminCallbacks $callbacks;

  public function __construct(){
    parent::__construct();

  }

  public function register(){
    $pluginDbValue = get_option( 'gutbcontent_plugin' );
    $pageId = 'widgets_manager';
    // $activeStatus = isset($checkboxDbValue[$name]) ? ( $checkboxDbValue[$name] ? true : false ) : false;
    $activeStatus = isset($pluginDbValue[$pageId]) && $pluginDbValue[$pageId]; // Equivalent expression to the above

    // If not activated:
    if( !$activeStatus ){ return; }

    // Initialize the custom Widget manually
    //$mediaWidget = new MediaWidget();
    //$mediaWidget->register();

    // 1. Initialize all relevant objects
    $this->settings = new SettingsApi();
    $this->callbacks = new AdminCallbacks();

    // 2.1. Prepare Admin setting sub-pages information
    $this->setSubpages();

    // 2.2. Add Custom Post Type admin setting pages under Devsunshine_plugin admin setting pages
    $this->settings->addSubPages( $this->subpages )->register();
  }

  /* === Register the subpages in WordPress Admin setting pages === */
  public function setSubpages(){

    $this->subpages = array(
      array(
        'parent_slug'     => 'gutbcontent_plugin',
        'page_title'      => 'Widgets',
        'menu_title'      => 'Widgets Manager',
        'capability'      => 'manage_options',
        'menu_slug'       => 'gutbcontent_widgets',
        'callback'        => array($this->callbacks, 'adminCustomWidgets'),
      ),
    );

  }


}