<?php


namespace Vnlab\Gutbcontent\Inc\Controller;


use Vnlab\Gutbcontent\Inc\Api\Callbacks\AdminCallbacks;
use Vnlab\Gutbcontent\Inc\Base\BaseController;
use Vnlab\Gutbcontent\Inc\Api\SettingsApi;
use Vnlab\Gutbcontent\Troubleshoot\PluginCustomDebugger;

class CustomTemplates extends BaseController
{
  public array $subpages;
  public SettingsApi $settings;
  public AdminCallbacks $callbacks;

  public array $customTemplates;
  public array $customTemplatesAbsPath;

  //public PluginCustomDebugger $debugger; 

  public function __construct(){
    parent::__construct();
    
    $this->customTemplatesAbsPath = array();
    // Init plugin debugger
    //$this->debugger = new PluginCustomDebugger();
  }

  public function register(){
    //echo '<h3>'.var_dump($this->settingPageManagers).'</h3>';
    $pluginDbValue = get_option( 'gutbcontent_plugin' );
    $pageId = 'templates_manager';
    // $activeStatus = isset($checkboxDbValue[$name]) ? ( $checkboxDbValue[$name] ? true : false ) : false;
    $activeStatus = isset($pluginDbValue[$pageId]) && $pluginDbValue[$pageId]; // Equivalent expression to the above

    // If not activated:
    if( !$activeStatus ){ return; }

    // 1. Initialize all relevant objects
    $this->settings = new SettingsApi();
    $this->callbacks = new AdminCallbacks();

    // 2.1. Prepare Admin setting sub-pages information
    $this->setSubpages();

    // 2.2. Add Custom Post Type admin setting pages under Devsunshine_plugin admin setting pages
    $this->settings->addSubPages( $this->subpages )->register();

    // 3. Setup the custom template, then register the custom template
    // 3.1. Setup the custom template
    $this->setCustomTemplates();
    // 3.2. Register the custom templates
    // Template for page
    add_filter('theme_page_templates', array($this, 'registerCustomTemplates' ));
    // Template for default post type - theme_{post_type}_templates 
    add_filter('theme_post_templates', array($this, 'registerCustomTemplates' ));
    // 3.3. Inject the custom templates to existing templates list
    add_filter('template_include', array($this, 'injectCustomTemplates' ));    

    // 4. Initialize additional resources for custom templates 
    add_action('after_setup_theme', array($this, 'registerPluginNavMenu'), 0 );
    //die();
  }

  /* === Register the subpages in WordPress Admin setting pages === */
  public function setSubpages(){
    /**
     * Parent slug is the menu slug of $this->page
     */
    $this->subpages = array(
      array(
        'parent_slug'     => 'gutbcontent_plugin',
        'page_title'      => 'Templates',
        'menu_title'      => 'Custom Templates Manager',
        'capability'      => 'manage_options',
        'menu_slug'       => 'gutbcontent_templates',
        'callback'        => array($this->callbacks, 'adminCustomTemplates'),
      ),
    );

  }

  /* Setup an array of custom page template */
  public function setCustomTemplates(){
    // Key: relative template path => value: Template name
    $this->customTemplates = array(
      'templates/page/template-scientific-post.php' => 'Gutbcontent scientific post template'
    );

    //$this->customTemplates = array();
  }

  /* public function setCustomTemplatesAbsPath(){
    //$this->customTemplatesAbsPath[] = $this->pluginPath.'templates/page/template-scientific-post.php';
    return $this->pluginPath.'templates/page/template-scientific-post.php';
  } */

  public function registerCustomTemplates( $availableTemplates ): array{    
    return array_merge($availableTemplates, $this->customTemplates);
  }

  public function injectCustomTemplates( $availableTemplates ): string {
    global $post;

    //$debugger = new Plugin_Custom_Debugger();
    //$this->debugger->write_log_simple('--> Template name is : ');
    // 1. Validate if actual post is calling the template:
    if( !$post ){
      return $availableTemplates;
    }

    // Skip using custom template if this is a front-page
    if( is_front_page() || is_home() ){
      return $availableTemplates;
    }
    
    // 2. Load the custom template to the front page - optional - working OK
    // but not useful in practical scenario
    /*if( is_front_page() ){
      $templateFile = $this->plugin_path.'templates/pages/devsunshine-frontpage.php';

      return file_exists( $templateFile ) ? $templateFile : $availableTemplates;
    }*/    

    // 3.
    // 3.1. Get the page template corresponding to each pages
    $templateName = get_post_meta($post->ID, '_wp_page_template', true);    
    // $this->debugger->write_log_simple('--> template name is :');
    // $this->debugger->write_log_simple($templateName);
    
    if( !isset( $this->customTemplates[ $templateName ] ) ){
      return $availableTemplates;
    }

    // 3.2. Load the custom template if file exists
    $templateFile = $this->pluginPath.$templateName; // Used to work
    //$templateFile = $templateName;

    return file_exists( $templateFile ) ? $templateFile : $availableTemplates;
  }

  function registerPluginNavMenu(){
    // 1. Register navigation menu location for a theme
    // 'gutbcontent_footer_menu'  => __('Gutbcontent Footer Menu', 'GutbContent Plugin'),
    register_nav_menus(
      array(
        'gutbcontent_primary_menu'  => __('Gutbcontent Navigation Menu', 'GutbContent Plugin'),        
      )
    );

    // 2. Register all navigation menu wp_get_nav_menus() to new menu location.
  }
}