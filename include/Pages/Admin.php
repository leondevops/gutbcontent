<?php
/*
 * @package Devsunshine_Plugin
 * @version 1.0.1
 */

namespace Vnlab\Gutbcontent\Inc\Pages;

//include_once(PLUGIN_URL.'troubleshoot/custom-theme-debugger.php');

use Vnlab\Gutbcontent\Inc\Base\BaseController;
use Vnlab\Gutbcontent\Inc\Api\SettingsApi;
use Vnlab\Gutbcontent\Inc\Api\Callbacks\AdminCallbacks;
use Vnlab\Gutbcontent\Inc\Api\Callbacks\AdminManagerCallbacks;

class Admin extends BaseController
{
  public SettingsApi $settings;
  public AdminCallbacks $callbacks;
  public AdminManagerCallbacks $callbacksManager;
  public array $pages;
  // public array $subpages;

  public function __construct(){
    parent::__construct();
  }

  public function register(){
    $this->settings = new SettingsApi();

    $this->callbacks = new AdminCallbacks();
    $this->callbacksManager = new AdminManagerCallbacks();

    $this->setPages();
    // $this->setSubpages();

    $this->setSettings();
    $this->setSections();
    $this->setFields();

    /** Prepare argument for "add page" method in setting APIs
      add_menu_page(
        $page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'],
        $page['callback'], $page['icon_url'],$page['position']
      );
    **/
    // Method chain
    // $this->settings->addAdminPages( $this->pages )->withSubPage('Dashboard')->addSubPages( $this->subpages )->register();
    $this->settings->addAdminPages( $this->pages )->withSubPage('Control Dashboard')->register();
  }


  /* === Register the main pages in WordPress Admin setting pages === */
  public function setPages(){
    $this->pages = array(
      array(
        'page_title'    => 'Gutbcontent Plugin',
        'menu_title'    => 'Gutbcontent',
        'capability'    => 'manage_options',
        'menu_slug'     => 'gutbcontent_plugin',
        'callback'      => array($this->callbacks, 'adminDashboard'),
        'icon_url'      => 'dashicons-welcome-write-blog',
        'position'      => 111,
      )
    );
  }

  /* === Register the subpages in WordPress Admin setting pages === */
/*  public function setSubpages(){
    // Parent slug is the menu slug of $this->page
    $this->subpages = array(
      array(
        'parent_slug'     => 'devsunshine_plugin',
        'page_title'      => 'Custom Post Types (CPT)',
        'menu_title'      => 'CPT',
        'capability'      => 'manage_options',
        'menu_slug'       => 'devsunshine_cpt',
        'callback'        => array($this->callbacks, 'adminCPT'),
      ),
      array(
        'parent_slug'     => 'devsunshine_plugin',
        'page_title'      => 'Custom Taxonomies',
        'menu_title'      => 'Taxonomies',
        'capability'      => 'manage_options',
        'menu_slug'       => 'devsunshine_taxonomies',
        'callback'        => array($this->callbacks, 'adminTaxonomies'),
      ),
      array(
        'parent_slug'     => 'devsunshine_plugin',
        'page_title'      => 'Custom Widgets',
        'menu_title'      => 'Widgets',
        'capability'      => 'manage_options',
        'menu_slug'       => 'devsunshine_widgets',
        'callback'        => array($this->callbacks, 'adminWidgets'),
      ),
    );
  }*/

  /* === Register the custom fields in admin setting pages === */
  public function setSettings(){

    /**
     * Devsunshine plugins features list:
    - Modular administration area
    1 - Custom Post Type (CPT) Manager
    2 - Custom Taxonomies Manager
    3 - Widget to Upload, Display media in sidebars (Media Widget Manager)
    4 - Post, Page Gallery integration (Media Gallery Manager)
    5 - Testimonial section (Testimonial Manager)
    + Comments in front-end
    + Approval administrations
    + Select which comments to be displayed
    6 - Custom template (Template Manager)
    7 - AJAX based login/registered system (Login Manager)
    8 - Membership protected area (Membership Manager)
    9 - Chat system (Chat Manager)
     * These 9 options in setting pages should be serialize with single option in WordPress database:
     * devsunshine-plugin
     **/

    $settingsArgs = array(
      array(
        'option_group'      => 'gutbcontent_plugin_settings',
        'option_name'       => 'gutbcontent_plugin',
        'callback'          => array($this->callbacksManager, 'checkboxSanitize'),
      )
    );

    $this->settings->setSettings( $settingsArgs );
  }

  public function setSections(){
    $sectionsArgs = array(
      array(
        'id'            => 'gutbcontent_admin_index',
        'title'         => 'Settings Manager',
        'callback'      => array($this->callbacksManager, 'gutbcontentSectionManager'),
        'page'          => 'gutbcontent_plugin'
      )
    );

    $this->settings->setSections( $sectionsArgs );
  }

  public function setFields(){

    /* The callback functions are to customize looks and feels  */
    $fieldsArgs = array();

    foreach($this->settingPageManagers as $pageManager){
      $fieldsArgs[] = array(
        'id'            => $pageManager->id,
        'title'         => sprintf('Activate %s', $pageManager->title),
        'callback'      => array($this->callbacksManager, 'displayCheckboxField'),
        'page'          => 'gutbcontent_plugin',
        'section'       => 'gutbcontent_admin_index',
        'args'          => array(
          'option_name'   => 'gutbcontent_plugin',
          'label_for'     => $pageManager->id,
          'class'         => sprintf('ui-toggle %s', $pageManager->classname),
        )
      );
    }

    $this->settings->setFields( $fieldsArgs );
  }

}