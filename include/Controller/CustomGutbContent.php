<?php


namespace Vnlab\Gutbcontent\Inc\Controller;

use Vnlab\Gutbcontent\Inc\Api\Callbacks\AdminCallbacks;
use Vnlab\Gutbcontent\Inc\Base\BaseController;
use Vnlab\Gutbcontent\Inc\Api\SettingsApi;

class CustomGutbContent extends BaseController
{
  public array $subpages;
  public SettingsApi $settings;
  public AdminCallbacks $callbacks;

  public function __construct(){
    parent::__construct();
  }

  public function register(){
    //echo '<h3>'.var_dump($this->settingPageManagers).'</h3>';
    $pluginDbValue = get_option( 'gutbcontent_plugin' );
    $pageId = 'gutbcontent_block_manager';
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

    // 3. Register custom Gutenberg blocks from plugin
    // $this->registerCTABlockBackendResources();
    // $this->registerCTABlockFrontendResources();
    $this->registerCTABlockResources();
  }

  /* === Register the subpages in WordPress Admin setting pages === */
  public function setSubpages(){
    /**
     * Parent slug is the menu slug of $this->page
     */
    $this->subpages = array(
      array(
        'parent_slug'     => 'gutbcontent_plugin',
        'page_title'      => 'Gutenberg Content Manager',
        'menu_title'      => 'GutbContent Block Manager',
        'capability'      => 'manage_options',
        'menu_slug'       => 'gutbcontent_block',
        'callback'        => array($this->callbacks, 'adminCustomGutbContent'),
      ),
    );

  }

  /* Manually define custom Gutenberg block from here */
  
  /* 1. CTA block - custom Call-To-Action Gutenberg Block */
  public function setupCustomCTABlockResource(){
    // 1. Backend scope - Gutenberg Editor resources
    // This also contain scripts to display at frontend
    wp_register_script(
      'gutbcontent-custom-cta-js',
      $this->pluginUrl.'assets/editor/js/gutbcontent-gutenberg-blocks.js',
      array('wp-blocks','wp-editor','wp-components'),
      '1.0.0', false
    );

    wp_register_style(
      'gutbcontent-custom-cta-css',
      $this->pluginUrl.'assets/editor/css/gutbcontent-gutenberg-blocks.css',
      array(),
      '1.0.0', 'all'
    );

    // 2. Frontend scope - resources for user view
    // 2.1. Frontend styles
    wp_enqueue_style(
      'gutbcontent-custom-cta-css-frontend',
      $this->pluginUrl.'/assets/frontend/css/gutbcontent-gutenberg-blocks.css',
      array(), '1.0.1', 'all'
    );

    // 2.2. Frontend scripts
    wp_enqueue_script(
      'gutbcontent-custom-cta-js-frontend',
      $this->pluginUrl.'/assets/frontend/js/gutbcontent-gutenberg-blocks.js',
      array('jquery'), '1.0.1', true
    );

    register_block_type(
      'gutbcontent/custom-cta',
      array(
        'editor_script' => 'gutbcontent-custom-cta-js',
        'editor_style'  => 'gutbcontent-custom-cta-css',
        'script'        => 'gutbcontent-custom-cta-js-frontend',
        'style'         => 'gutbcontent-custom-cta-css-frontend'
      )
    );    
    
  } 

  public function registerCTABlockResources() {
    add_action('init', array( $this, 'setupCustomCTABlockResource' ) );
    //add_action('enqueue_block_editor_assets', array( $this, 'setupCustomGutenbergBlocks' ) );
  }

  /* 2.  */
}