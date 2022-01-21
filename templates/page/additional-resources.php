<?php
  /*
   * =======================================
   * I. Enqueue Bootstrap 5
   * - Enqueue Bootstrap 5 CSS at the last, right before custom themes
   * =======================================
   * get_template_directory_uri() : http://vnlabwin.local.info/wp-content/themes/blocksy
   * Validated the template receive CSS format.
   * */

global $wp_scripts;
$gutbcontentPluginUrl = plugin_dir_url( dirname(__FILE__ , 2) );

// 1. Include CSS bootstrap.min.css &
function enqueuePluginStyles(){
  // 1. Enqueue Bootstrap CSS  CSS: bootstrap.min.css
  wp_enqueue_style('gutbcontent-library-styles',
    plugin_dir_url( dirname(__FILE__ , 2) ).'/assets/library/css/gutbcontent-prerequisite.css',
    array(), '5.1.3', 'all');

  // 2. Enqueue custom CSS:
}
add_action('wp_enqueue_scripts', 'enqueuePluginStyles','990');

// 2. Include JS bootstrap.bundle.min.js
// jQuery is jquery obtained from WordPress
function enqueuePluginScript() {
  wp_enqueue_script('gutbcontent-library-scripts',
    plugin_dir_url( dirname(__FILE__ , 2) ).'/assets/library/js/gutbcontent-prerequisite.js',
    array(), '5.1.3', true);

  // 2. Enqueue custom JS:
}
// Add action hook to include CSS & JS files
add_action('wp_enqueue_scripts', 'enqueuePluginScript',1);


/*
 * =======================================
 * 2. Enqueue custom CSS JS for custom format of default post type
 * =======================================
 * */

/*
 * =======================================
 * 2.1. If the post template is template-post-science.php
 * =======================================
 * */
if(is_page_template('templates/page/template-scientific-post.php')):
  // 1. Register custom CSS
  function template_post_science_style_enqueue(){
    wp_enqueue_style('template-scientific-post-styles',
    plugin_dir_url( dirname(__FILE__ , 2) ) . '/assets/page/css/template-scientific-post.css',
      array(), '1.0', 'all');
  }
  add_action('wp_enqueue_scripts', 'template_post_science_style_enqueue','991');

  // 2. Register custom JS
  function template_post_science_script_enqueue() {
    wp_enqueue_script('template-scientific-post-scripts',
    plugin_dir_url( dirname(__FILE__ , 2) ).'/assets/page/js/template-scientific-post.js',
      array(), '1.0', true);
  }
  // Add action hook to include CSS & JS files
  // $customJsOrder = sizeof($wp_scripts->queue) + 1;
  add_action('wp_enqueue_scripts', 'template_post_science_script_enqueue', 2);
endif;


/*
 * =======================================
 * II. Add additional features on wp_nav_menu
 * =======================================
 * get_template_directory_uri() : http://vnlabwin.local.info/wp-content/themes/blocksy
 *
 * */

/*
function add_additional_class_on_li($classes, $item, $args) {
  if(isset($args->add_li_class)) {
    $classes[] = $args->add_li_class;
  }
  return $classes;
}
add_filter('nav_menu_css_class', 'add_additional_class_on_li', 1, 3);

function add_menu_link_class( $atts, $item, $args ) {
  if (property_exists($args, 'link_class')) {
    $atts['class'] = $args->link_class;
  }
  return $atts;
}
add_filter( 'nav_menu_link_attributes', 'add_menu_link_class', 1, 3 );*/




