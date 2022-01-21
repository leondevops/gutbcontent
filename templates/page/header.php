<!doctype html>

<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<!-- Enable bootstrap -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title> Scienctific post format (Post type) <?php bloginfo('name');?> <?php wp_title(' | '); ?> </title>
	<meta name="description" content="<?php bloginfo('description'); ?>">

  <!-- The file functions.php has already called in advance -->
  <!-- 1. Load additional resources -  -->
  <!-- 1.1. Load the custom external css & JS files for specific template -->
  <?php
    //$gutbcontentPluginUrl = plugin_dir_url( dirname(__FILE__, 4) );
    require_once('additional-resources.php');
    /* echo sprintf(
      '<link rel="stylesheet" href="%s" type="text/css"/>',
      $gutbcontentPluginUrl.'assets/page/css/template-scientific-post.css'
    ); */
    
    //require_once('../../Include/Helper/GutbcontentMenuWalker.php');
    require_once('helper/GutbcontentMenuWalker.php'); // troubleshooting
    //require_once('helper/NavigationMenuWalker.php'); // OK
    //use GutbcontentMenuWalker as GutbcontentMenuWalker;
  ?>

  <!-- 1.2. Load the local CSS files -->
  <?php wp_head(); ?>
  <?php
    /**Include custom resources for specific template here **/

    ?>
  <!-- check current page template -->
  <?php
  /* Debug information
    global $template;
    echo basename($template);
    echo var_dump(is_page_template('page-custom-layout.php'));
   * */
  ?>

</head>


<body>

<header>

  <nav class="navbar navbar-expand navbar-light" style="background-color:#C0C0C0;">
    <div class="container-fluid">
      <div class="row">
        <div class="col-xs-9 col-sm-9 custom-nav-menu">
          <div class="navbar-brand">
            <!-- Load custom logo -->
            <?php
            if ( function_exists( 'the_custom_logo' ) ) {
              the_custom_logo();
            }
            ?>
          </div>

          <!-- Load the navigation menu -->
          <!--wp_nav_menu() will grab the 1st item in menu list - alphabetical order  -->
          <!-- original method: wp_nav_menu(array('theme_location'=>'primary')); -->
          <div class="collapse navbar-collapse navbar-left main-nav-menu-scientific">

            <?php

            // 2. Displaying nav menu using custom walker-nav-menu-custom.php

            /***
             * $menuInitResult = wp_nav_menu();    // Using default wp_nav_menu is OK. But only for 1 child
             * Fallback method: calling to wp_page_menu - create a menu
             * currently calling to fallback argument - the current menu does not exist
             ***/

            $customWalkerObject = new GutbcontentMenuWalker();
            
            // It is mandatory to use gutbcontent_primary_menu location 
            //wp_nav_menu(); main-nav-menu-1
            wp_nav_menu( 
              array(
                'menu'              => 'gutbcontent-main-navigation-menu',
                'theme_location'    => 'gutbcontent_primary_menu',
                'depth'             =>  3,
                'container'         =>  false,
                'menu_class'        => 'nav navbar-nav gutbcontent-main-menu-wrapper',
                'fallback_cb'       => 'NavigationMenuWalker::fallback',                
                'walker'            =>  $customWalkerObject
              )
            );              

            ?>
          </div>

        </div> <!-- End of main navigation menu - Bootstrap column -->

        <div class="col-xs-3 col-sm-3 custom-search-box">

          <div class="search-form-container" id="SearchFormContainerScience">
            <form role="search" method="get" action="<?php echo home_url('/'); ?>">
              <input type="search" class="form-control" placeholder="Search"
                     value="<?php echo get_search_query(); ?> " name="s" title="Search"/>

            </form>
          </div>

          <div class="open-search menu-item nav-item">
            <a><i class="bi bi-search">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                  <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg>
              </i>
            </a>
          </div>

        </div> <!-- End of custom search box-->
      </div> <!-- end of row div -->
    </div><!-- End of container fluid -->
  </nav>

<!--
  <h3> ===== Start debugging area ======= </h3>
  <p> all registered menus is : <?php /* var_dump(get_registered_nav_menus()); */?> </p>
   <p> wp_get_nav_menu() main-nav-menu-1 is : <?php var_dump(wp_get_nav_menus()); ?> </p>
  -->
 
  <?php

    /*require_once('helper/custom-template-debugger.php');
    $templateDebugger = new Custom_Template_Debugger();
    $templateDebugger->custom_template_write_log($customWalkerObject->createdMenuItemLi);*/

  ?>

  <!-- No need to close file. The footer.php will close the file. -->

</header>


