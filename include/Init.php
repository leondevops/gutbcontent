<?php

namespace Vnlab\Gutbcontent\Inc;

//require_once('autoloader-gutbcontent.php'); // OK

final class Init
{

  /**
   * Loop through the classes:
   * - Initialize an instance for each dedicated classname
   * - Call register() method if it exists
   * return an array Full list of classes
   *
   * @noinspection PhpMissingReturnTypeInspection
   */
  public static function register_services()
  {
    foreach(self::get_services() as $class){
      // Initialize an object of registered class
      $service = self::instantiate( $class );

      if( method_exists($service, 'register') ){
        $service->register();
      }
    }
  }

  public static function get_services(): array  {
    /* Return an array of dedicated class names */
    return array(
      Pages\Admin::class,
      Base\Enqueue::class,
      Base\SettingsLinks::class,
      Controller\CustomGutbContent::class,
      Controller\CustomWidgets::class,
      Controller\CustomShortcode::class,
      Controller\CustomTemplates::class,
    );
  }

  /* Initialize an object of each registered service.
     * @param class $class : class names from the services array
     * @return return an instance of the parsing class
     * ***/
  private static function instantiate( $class ){
    return new $class();
  }

}