<?php
/*
 * @package Devsunshine_Plugin
 * @version 1.0.1
 */

namespace Vnlab\Gutbcontent\Inc\Base;

if( !class_exists('Deactivator') ) {

class Deactivator
{

  public function __construct()
  {

  }

  public static function deactivate()
  {
    flush_rewrite_rules();
  }
}

} // if(! class_exists('Deactivator') ) {