<?php
/*
 * @package Devsunshine_Plugin
 * @version 1.0.1
 */

namespace Vnlab\Gutbcontent\Inc\Api\Callbacks;


use Vnlab\Gutbcontent\Inc\Base\BaseController;

class AdminCallbacks extends BaseController{

  public function adminDashboard(){
    require_once( "$this->pluginPath/templates/admin/admin.php" );
  }

  public function adminCustomGutbContent(){
    require_once( "$this->pluginPath/templates/admin/custom-gutbcontent.php" );
  }

  public function adminCustomShortcode(){
    require_once( "$this->pluginPath/templates/admin/custom-shortcode.php" );
  }

  public function adminCustomWidgets(){
    require_once( "$this->pluginPath/templates/admin/custom-widgets.php" );
  }

  public function adminCustomTemplates(){
    require_once( "$this->pluginPath/templates/admin/custom-templates.php" );
  }


  /** In case modifying something before parsing to Admin setting pages

   **/
  public function gutbcontentOptionsGroup( $input ){
    return $input;
  }

  public function gutbcontentAdminSection($input)
  {
    echo '<p>This is gutbcontent Admin Section </p> ';
  }

  public function gutbcontentTextExample(){
    $value = esc_attr( get_option( 'text_example' ) );

    echo <<<HDSTR
    <input type="text" class="regular-text" name="text-example"
           value="{$value}" placeholder="Enter your sample text here !">
    HDSTR;
  }

  public function gutbcontentFirstNameDisplay(){
    $value = esc_attr( get_option( 'first_name' ) );

    echo <<<HDSTR
    <input type="text" class="regular-text" name="first-name"
           value="{$value}" placeholder="First Name">
    HDSTR;
  }

}


