<?php
/*
 * @package Devsunshine_Plugin
 * @version 1.0.1
 */

namespace Vnlab\Gutbcontent\Inc\Api;

/* Act as an interface to tap setting APIs */

Class SettingsApi {

  public array $admin_pages = array();
  public array $admin_subpages = array();

  public array $settings = array();
  public array $sections = array();
  public array $fields = array();

  public function register(){
    /* 1. Register if the admin page or admin subpages are not empty
     * - This register method will be called in different locations.
     * */
    if( !empty($this->admin_pages || !empty($this->admin_subpages) ) ){
      add_action( 'admin_menu', array( $this, 'addAdminMenu' ) );
    }

    if( !empty($this->settings) ){
      add_action( 'admin_init', array($this, 'registerCustomFields') );
    }
  }

  /* Add admin pages ~ method addPages in tutorials */
  public function addAdminPages( array $pages ): static {
    $this->admin_pages = $pages;

    return $this;
  }

  public function addSubPages( array $pages) : static{
    // Update the subpages
    // $this->admin_subpages = $pages;
    $this->admin_subpages = array_merge( $this->admin_subpages, $pages );

    return $this;
  }

  public function withSubPage( string $title = null ): static {
    if( empty($this->admin_pages) ){
      return $this;
    }
    // The 1st item in $this->admin_pages is parent page
    // Grab the parent page/root page
    $admin_page = $this->admin_pages[0];

    /*
    * The parent_slug of a sub page must be menu_slug of admin page
    **/
    $sub_pages = array(
      array(
        'parent_slug'     => $admin_page['menu_slug'],
        'page_title'      => $admin_page['page_title'],
        'menu_title'      => ($title) ? $title : $admin_page['menu_title'],
        'capability'      => $admin_page['capability'],
        'menu_slug'       => $admin_page['menu_slug'],
        'callback'        => function(){echo '<h3> Devsunshine plugin sub pages </h3>';},
      ),
    );

    $this->admin_subpages = $sub_pages;

    return $this;
  }

  public function addAdminMenu(){

    // 1. Add all "main admin setting page" menu:
    foreach( $this->admin_pages as $page ){
      add_menu_page(
        $page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'],
        $page['callback'], $page['icon_url'],$page['position']
      );
    }// endforeach

    // 2. Add all "sub - admin setting page" menu:
    foreach( $this->admin_subpages as $page ){
      add_submenu_page(
        $page['parent_slug'], $page['page_title'], $page['menu_title'], $page['capability'],
        $page['menu_slug'], $page['callback']
      );
    }// endforeach
  }

  public function setSettings( array $settings): static
  {
    $this->settings = $settings;

    return $this;
  }

  public function setSections( array $sections): static {
    $this->sections = $sections;

    return $this;
  }

  public function setFields( array $fields) : static {
    $this->fields = $fields;

    return $this;
  }

  public function registerCustomFields(){
    /* 1. Register fields . Total 20 custom fields to handle users activities (even more)
    $setting['callback'] ?? '') ~ isset(setting['callback']) ? setting['callback] : ''; */
    // 1.1. Register setting
    foreach($this->settings as $setting){
      register_setting( $setting['option_group'], $setting['option_name'], ($setting['callback'] ?? '') );
    }

    // 1.2. Add settings section
    foreach($this->sections as $section){
      add_settings_section($section['id'], $section['title'], ($section['callback'] ?? ''), $section['page']);
    }
    // 1.3. Add settings field
    foreach($this->fields as $field){
      add_settings_field($field['id'], $field['title'], ($field['callback'] ?? ''), $field['page'],
        $field['section'], ($field['args'] ?? ''));
    }

  }




}
