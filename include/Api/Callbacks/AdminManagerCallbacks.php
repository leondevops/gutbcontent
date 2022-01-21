<?php
/*
 * @package Devsunshine_Plugin
 * @version 1.0.1
 */


namespace Vnlab\Gutbcontent\Inc\Api\Callbacks;

use Vnlab\Gutbcontent\Inc\Base\BaseController;
use Vnlab\Gutbcontent\troubleshoot\Plugin_Custom_Debugger;


class AdminManagerCallbacks extends BaseController {

  // For debugging purpose
  //public Plugin_Custom_Debugger $debugger;

  public function __construct(){
    parent::__construct();

    //$this->debugger = new Plugin_Custom_Debugger();
  }

  /*Sample input:
  * Input:  ["cpt_manager"] => 1; ["taxonomies_manager"]=>1; ["gallery_manager"]=>1 ... (only item set before)
  * Output: All items with boolean. If isset => true; if not set => false
  * ["cpt_manager"]=> true ; ["taxonomies_manager"]=> false;  ["gallery_manager"]=> true ...
  */
  public function checkboxSanitize($input): array
  {
    // Validate whether the checkbox is checked or not: true or false
    // return filter_var($input, FILTER_SANITIZE_NUMBER_INT); // filter number
    //return isset($input);
    $output = array();

    foreach($this->settingPageManagers as $pageManager){
      $output[$pageManager->id] = isset($input[$pageManager->id]) ;
    }

    //$this->debugger->write_log_general($input);
    //$this->debugger->write_log_general($output);

    return $output;
  }

  public function gutbcontentSectionManager(){
    echo 'Manage the sections & features of the Gutbcontent plugin';
  }

  public function displayCheckboxField( $args ){
    $name = $args['label_for'];
    $classes = $args['class'];
    // $checkbox = get_option($name) ? 'checked' : ''; // OK
    //$option_name = get_option( $args['option_name'] ); // as tutorial ?
    $option_name = $args['option_name'];
    /* 1 - Array of items with key (string) - value (boolean)
     *  ["cpt_manager"]=> true ; ["taxonomies_manager"]=> false;  ["gallery_manager"]=> true
     ***/
    $checkboxDbValue = get_option( $option_name );
    // $checkboxDbStatus = isset($checkboxDbValue[$name]) ? ( $checkboxDbValue[$name] ? true : false ) : false;
    $checkboxDbStatus = isset($checkboxDbValue[$name]) && $checkboxDbValue[$name]; // Equivalent expression to the above
    $checkbox = $checkboxDbStatus ? 'checked' : '';
    //$checkbox = $checkboxDbValue[$name] ? 'checked' : ''; // OK

    $displayName = sprintf('%s[%s]',$option_name, $name); // display: devsunshine_plugin[cpt_manager]
    //$checkStatus = get_option($name) ? 'checked' : 'unchecked';
    echo <<<HDSTR
    <div class="{$classes}">
        <input type="checkbox" name="{$displayName}" value="1" class="{$classes}" $checkbox>
        <label class="item-checkbox-label" for="{$name}">
          <div></div>
        </label>
    </div>
    HDSTR;

  }

}